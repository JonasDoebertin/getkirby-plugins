<?php

/**
 * Environment
 *
 * @package   Kirby CMS
 * @author    Jonas Döbertin <hello@jd-powered.net>
 * @link      http://jd-powered.net
 * @copyright Jonas Döbertin
 * @license   MIT
 */
class Environment {

    protected static $detected = null;

    /**
     * Smart Environment Detection
     *
     * Try to detect the current application environment by checking
     *     [1] the environment variables
     *     [2] the configuration
     *
     * @since 1.0.0
     *
     * @return string
     */
    public static function detectEnvironment()
    {
        /*
            [1] Check environment variables
         */
        static::$detected = getenv('environment');

        /*
            [2] Check configuration files
         */
        if(static::$detected === false)
        {
            static::$detected = c::get('environment', false);
        }
    }

    /**
     * Get the detected environment
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public static function get()
    {
        if(static::$detected === null)
        {
            static::detectEnvironment();
        }

        return static::$detected;
    }

    /**
     * Check for given environment
     *
     * @since 1.0.0
     *
     * @param  string  $environment
     * @return bool
     */
    public static function is($environment)
    {
        return static::get() === $environment;
    }

    /**
     * Shorthand: Check for production environment
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public static function isProduction()
    {
        return static::is('production');
    }

    /**
     * Shorthand: Check for testing environment
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public static function isTesting()
    {
        return static::is('testing');
    }

    /**
     * Shorthand: Check for staging environment
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public static function isStaging()
    {
        return static::is('staging');
    }

    /**
     * Shorthand: Check for local environment
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public static function isLocal()
    {
        return static::is('local');
    }

}
