<?php

namespace jdpowered\GetKirbyPlugins\Logic;

use Cache;
use HTMLPurifier;
use HTMLPurifier_Config;
use jdpowered\GetKirbyPlugins\Logic\Helper;
use jdpowered\GetKirbyPlugins\Logic\Structures\Info;
use jdpowered\GetKirbyPlugins\Logic\Structures\Release;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Parsedown;
use Url;
use V;

class Fetcher
{



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
                'cache_dir' => kirby()->roots()->cache() . DS . 'github-client',
                'timeout'   => 3,
            ))
        );
        $this->client->authenticate(
            getenv('GITHUB_USERNAME'),
            getenv('GITHUB_TOKEN'),
            \Github\Client::AUTH_HTTP_PASSWORD
        );

        // Set up cache
        $this->cache = Cache::setup('File', array(
            'root' => kirby()->roots()->cache() . DS . 'fetcher',
        ));

        // Set up logger
        $this->logger = new Logger('log');
        $this->logger->pushHandler(new RotatingFileHandler(
            kirby()->roots()->site() . DS . 'logs' . DS . 'fetcher.log',
            14,
            Logger::WARNING
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
    *                               FRONTEND API                               *
    \**************************************************************************/

    public function cached($metric, $repoUrl)
    {
        // Extract user and repo info
        $info = Helper::extract($repoUrl);
        if ($info === false) {
            return false;
        }
        $user = $info['user'];
        $repo = $info['repo'];

        // Check for stored data, return if available
        $id = $this->generateCacheId($user, $repo, $metric);
        if (($data = $this->loadFromCache($id)) !== null) {
            return $data;
        }

        return false;
    }

    /**************************************************************************\
    *                               BACKEND API                                *
    \**************************************************************************/

    public function preload($user, $repo)
    {
        // Process each metric
        foreach (['release', 'info'] as $metric) {

            // Check age of stored data
            $id = $this->generateCacheId($user, $repo, $metric);
            if ($this->getCacheAge($id) >= (15 * 60)) {

                // Delegate to specific fetcher method
                $this->logger->addInfo('Updating ' .$metric. ' info for [' . $user . '/' . $repo . ']...');
                $data = $this->fetch($user, $repo, $metric);

                // Cache data
                $this->saveToCache($id, $data);
            }
        }

        return true;
    }

    protected function fetch($user, $repo, $metric)
    {
        switch ($metric) {
            case 'release':
                return $this->fetchRelease($user, $repo);
            case 'info':
                return $this->fetchInfo($user, $repo);
            default:
                return false;
        }
    }

    /**
     * Get the latest release from Github.
     *
     * @method release
     * @since  1.0.0
     * @param  string $repoUrl
     * @return string|boolean
     */
    protected function fetchRelease($user, $repo)
    {
        try {
            // Fetch from API and build transfer object
            $result = $this->client->api('repo')->releases()->latest($user, $repo);
            $release = new Release($result['tag_name'], strtotime($result['published_at']));

            // Log event
            $this->logger->addInfo('Updated release info for [' . $user . '/' . $repo . ']');
        }
        catch (\Exception $e) {
            // Catch unsuccessful API requests
            $release = false;

            // Log event
            $this->logger->addWarning('Failed to update release info for [' . $user . '/' . $repo . ']', ['message' => $e->getMessage()]);
        }

        return $release;
    }

    public function fetchInfo($user, $repo)
    {
        try {
            // Fetch from API
            $result = $this->client->api('repo')->contents()->show($user, $repo, 'PLUGIN_INFO.md');

            // Decode & render markdown and build transfer object
            $markdown = base64_decode($result['content']);
            $info = new Info($this->render($markdown));

            // Log event
            $this->logger->addInfo('Updated info text for [' . $user . '/' . $repo . ']');
        }
        catch (\Exception $e) {
            // Catch unsuccessful API requests
            $info = false;

            // Log event
            $this->logger->addWarning('Failed to update info text for [' . $user . '/' . $repo . ']', ['message' => $e->getMessage()]);
        }

        return $info;
    }

    /**************************************************************************\
    *                                 INTERNAL                                 *
    \**************************************************************************/

    /**
     * Generate a cache ID based on repo, user & metric.
     *
     * @method generateCacheId
     * @param  string $user
     * @param  string $repo
     * @param  string $metric
     * @return string
     */
    protected function generateCacheId($user, $repo, $metric)
    {
        return md5($user . $repo . $metric);
    }

    /**
     * Try to load data from cache.
     *
     * @method loadFromCache
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
     * @param  string $id
     * @param  mixed  $payload
     */
    protected function saveToCache($id, $payload)
    {
        $this->cache->set($id, $payload, null);
    }

    protected function getCacheAge($id)
    {
        $created = $this->cache->created($id);
        return (time() - $created);
    }

    /**
     * Clean up and render markdown code.
     *
     * @method render
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
        $config->set('Cache.SerializerPath', kirby()->roots()->cache() . DS . 'html-purifier');

        $purifier = new HTMLPurifier($config);
        $safe = $purifier->purify($unsafe);

        return $safe;
    }

    /**
     * Change header levels so that only header 4, 5 & 6 are used.
     *
     * @method modifyHeaderLevels
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
