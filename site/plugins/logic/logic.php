<?php

define('LOGIC_BASE_DIR', __DIR__);

require_once 'autoload.php';

if (!function_exists('fetch')) {
    function fetch() {
        return \jdpowered\GetKirbyPlugins\Logic\Fetcher::getInstance();
    }
}

if (!function_exists('schedule')) {
    function schedule() {
        return \jdpowered\GetKirbyPlugins\Logic\Scheduler::getInstance();
    }
}
