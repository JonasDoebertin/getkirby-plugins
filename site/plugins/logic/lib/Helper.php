<?php

namespace jdpowered\GetKirbyPlugins\Logic;

use Url;
use V;

class Helper
{
    /**
     * RegEx to validate repository urls.
     */
    const TEST_REPOURL_REGEX = '/https?:\/\/github\.com\/[\w-]+\/[\w-]+(?:\/$|\.git$|$)/i';

    /**
     * RegEx to extract user and repo information from repository urls.
     */
    const EXTRACT_INFO_REGEX = '/https?:\/\/github\.com\/(?P<user>[\w-]+)\/(?P<repo>[\w-]+)/i';

    /**
     * Check if a repository url is valid.
     *
     * @method isValidRepository
     * @param  string $repoUrl
     * @return boolean
     */
    public static function isValidRepository($repoUrl)
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
     * Extract user and repository name from github.com repository url.
     *
     * @method extract
     * @since  1.0.0
     * @param  string $repoUrl
     * @return array|boolean
     */
    public static function extract($repoUrl)
    {
        // Validate url
        if (!self::isValidRepository($repoUrl)) {
            return false;
        }

        // Execute regular expression
        $matches = array();
        if (preg_match(self::EXTRACT_INFO_REGEX, $repoUrl, $matches) !== 1) {
            return false;
        }

        // Validate matches
        if (!isset($matches['user']) or !isset($matches['repo'])) {
            return false;
        }

        // Build transfer array
        return array(
            'user' => $matches['user'],
            'repo' => $matches['repo'],
        );
    }

}
