<?php

namespace jdpowered\GetKirbyPlugins\Logic\Structures;

class Release
{
    /**
     * Version.
     * @var string
     */
    public $version;

    /**
     * Release date.
     * @var integer
     */
    public $timestamp;

    /**
     * Constructur.
     *
     * @method __construct
     * @param  string  $version
     * @param  integer $timestamp
     */
    public function __construct($version, $timestamp)
    {
        $this->version   = $version;
        $this->timestamp = $timestamp;
    }

}
