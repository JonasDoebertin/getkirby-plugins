<?php

namespace jdpowered\Github;

use Cache;
use HTMLPurifier;
use HTMLPurifier_Config;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Parsedown;
use Url;
use V;

class Fetcher
{

    const TEST_REPOURL_REGEX = '/https?:\/\/github\.com\/[\w-]+\/[\w-]+(?:\/$|\.git$|$)/i';

    const EXTRACT_INFO_REGEX = '/https?:\/\/github\.com\/(?P<user>[\w-]+)\/(?P<repo>[\w-]+)/i';

    const CACHE_LIFETIME = 60;

    /**
     * The *singleton* instance of this class.
     * @var Fetcher
     */
    protected static $instance;

    /**
     * GitHub API Client.
     * @var \Github\Client
     */
    protected $client;

    /**
     * Instance of logger class.
     * @var
     */
    protected $logger;

    /**
     * Protected constructor to prevent creating a new instance of the
     * *Singleton* via the `new` operator from outside of this class.
     */
    protected function __construct()
    {
        // Set up API client
        $this->client = new \Github\Client(
            new \Github\HttpClient\CachedHttpClient(array(
                'cache_dir' => kirby()->roots()->cache() . DS . 'github-api-client',
                'timeout'   => 3,
            ))
        );

        // Set up cache
        $this->cache = Cache::setup('File', array(
            'root' => kirby()->roots()->cache() . DS . 'github-fetcher-cache',
        ));

        // Set up logger
        $this->logger = new Logger('log');
        $this->logger->pushHandler(new RotatingFileHandler(
            kirby()->roots()->site() . DS . 'logs' . DS . 'fetcher.log',
            14
        ));
    }

    /**************************************************************************\
    *                            SINGLETON PATTERN                             *
    \**************************************************************************/

    /**
     * Returns the *Singleton* instance of this class.
     *
     * @return Singleton The *Singleton* instance.
     */
    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }



    /**
     * Private clone method to prevent cloning of the instance of the
     * *Singleton* instance.
     *
     * @return void
     */
    private function __clone() {}

    /**
     * Private unserialize method to prevent unserializing of the *Singleton*
     * instance.
     *
     * @return void
     */
    private function __wakeup() {}

    /**************************************************************************\
    *                                PUBLIC API                                *
    \**************************************************************************/

    /**
     * Get the latest release from Github.
     *
     * @method release
     * @since  1.0.0
     * @param  string $repoUrl
     * @return string|boolean
     */
    public function release($repoUrl)
    {
        // extract user and repo info
        $info = $this->extract($repoUrl);
        if ($info === false) {
            return false;
        }
        $user = $info['user'];
        $repo = $info['repo'];

        // check for stored data, return if available
        $id = md5($user . $repo . 'release');
        if (($release = $this->loadFromCache($id)) !== null) {
            return $release;
        }

        // fetch from API, return false if unsuccessful
        // TODO: use push queue to update data
        try {
            $this->client->clearHeaders();
            $result = $this->client->api('repo')->releases()->latest($user, $repo);
            $release = (isset($result['tag_name'])) ? $result['tag_name'] : false;
            $this->logger->addInfo('[' . $user . '/' . $repo . '] Updated releases');
        }
        catch (\Exception $e) {
            $release = false;
            $this->logger->addWarning('[' . $user . '/' . $repo . '] Failed to updated releases');
        }

        // save to cache
        $this->saveToCache($id, $release);

        return $release;
    }

    public function info($repoUrl)
    {
        // extract user and repo info
        $info = $this->extract($repoUrl);
        if ($info === false) {
            return false;
        }
        $user = $info['user'];
        $repo = $info['repo'];

        // check for stored data, return if available
        $id = md5($user . $repo . 'info');
        if (($info = $this->loadFromCache($id)) !== null) {
            return $info;
        }

        // fetch from API, return false if unsuccessful
        try {
            $this->client->clearHeaders();
            $result = $this->client->api('repo')->contents()->show($user, $repo, 'PLUGIN_INFO.md');
            $markdown = (isset($result['content'])) ? base64_decode($result['content']) : false;
            // render return markdown
            $info = $this->render($markdown);
            $this->logger->addInfo('[' . $user . '/' . $repo . '] Updated info');
        }
        catch (\Exception $e) {
            $info = false;
            $this->logger->addWarning('[' . $user . '/' . $repo . '] Failed to updated info');
        }

        // save to cache
        $this->saveToCache($id, $info);

        return $info;
    }

    /**************************************************************************\
    *                                 INTERNAL                                 *
    \**************************************************************************/

    /**
     * Extract user and repository name from github.com repository url.
     *
     * @method extract
     * @since  1.0.0
     * @param  string $repoUrl
     * @return array|boolean
     */
    protected function extract($repoUrl)
    {
        // validate url
        if (!$this->isValidRepository($repoUrl)) {
            return false;
        }

        // execute regular expression
        $matches = array();
        if (preg_match(self::EXTRACT_INFO_REGEX, $repoUrl, $matches) !== 1) {
            return false;
        }

        //validate matches
        if (!isset($matches['user']) or !isset($matches['repo'])) {
            return false;
        }

        return array(
            'user' => $matches['user'],
            'repo' => $matches['repo'],
        );
    }

    /**
     * Check if a given url is a valid github.com repository url.
     *
     * @method isValidRepository
     * @since  1.0.0
     * @param  string  $repoUrl
     * @return boolean
     */
    protected function isValidRepository($repoUrl)
    {
        // is valid url?
        if (!V::url($repoUrl)) {
            return false;
        }

        // is github.com link url?
        if (Url::host($repoUrl) !== 'github.com') {
            return false;
        }

        // is actual repo root url?
        if (preg_match(self::TEST_REPOURL_REGEX, $repoUrl) !== 1) {
            return false;
        }

        return true;
    }

    /**
     * Try to load data from cache.
     *
     * @method loadFromCache
     * @since  1.0.0
     * @param  string $id
     * @return mixed
     */
    protected function loadFromCache($id)
    {
        return $this->cache->get($id, null);
    }

    /**
     * Save data to cache.
     *
     * @method saveToCache
     * @since  1.0.0
     * @param  string $id
     * @param  mixed  $payload
     */
    protected function saveToCache($id, $payload)
    {
        $this->cache->set($id, $payload, self::CACHE_LIFETIME);
    }

    /**
     * Clean up and render markdown code.
     *
     * @method render
     * @since  1.0.0
     * @param  string $markdown
     * @return string
     */
    protected function render($markdown)
    {
        // modify/correct header levels
        $markdown = $this->modifyHeaderLevels($markdown);

        // render markdown
        $unsafe = Parsedown::instance()->text($markdown);

        // purify html
        $config = HTMLPurifier_Config::createDefault();
        $config->set('URI.Host', Url::host(site()->url()));
        $config->set('HTML.Allowed', 'a[href|target|rel|id],strong,b,em,i,strike,pre,code[class],p,ol,ul,li,br,h1,h2,h3,h4,h5,h6,img[src|alt],blockquote');
        $config->set('HTML.Nofollow', true);
        $config->set('Attr.AllowedRel', 'nofollow');

        $purifier = new HTMLPurifier($config);
        $safe = $purifier->purify($unsafe);

        return $safe;
    }

    /**
     * Change header levels so that only header 4, 5 & 6 are used.
     *
     * @method modifyHeaderLevels
     * @since  1.0.0
     * @param  string $markdown
     * @return string
     */
    protected function modifyHeaderLevels($markdown)
    {
        // find used header levels
        $usedLevels = array();
        for ($level = 1; $level <= 6; $level++) {
            $usedLevels[$level] = $this->isHeaderLevelUsed($markdown, $level);
        }

        // set proper header levels
        $next = 4;
        foreach ($usedLevels as $level => $used) {
            if ($used) {
                $markdown = $this->replaceHeaderLevel($markdown, $level, $next);
                $next++;
            }
        }

        return $markdown;
    }

    /**
     * Check if a header level is used in the markdown code.
     *
     * @method isHeaderLevelUsed
     * @since  1.0.0
     * @param  string  $markdown
     * @param  integer $level
     * @return boolean
     */
    protected function isHeaderLevelUsed($markdown, $level)
    {
        return (preg_match('/(^|[^#])#{' . $level . '}[^#]/m', $markdown) === 1);
    }

    /**
     * Replace a header level with another one.
     *
     * @method replaceHeaderLevel
     * @since  1.0.0
     * @param  string  $haystack
     * @param  integer $needle
     * @param  integer $replacement
     * @return string
     */
    protected function replaceHeaderLevel($haystack, $needle, $replacement)
    {
        return preg_replace('/(?<!#)#{' . $needle . '}(?!#)/m', str_pad('', $replacement, '#'), $haystack);
    }

}
