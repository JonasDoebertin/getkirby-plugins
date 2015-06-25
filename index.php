<?php

define('DS', DIRECTORY_SEPARATOR);

/*
    Load dependencies
 */
require __DIR__ . DS .'vendor' . DS . 'autoload.php';

/*
    Load Kirby core and boot up the cms
 */
require __DIR__ . DS . 'kirby' . DS . 'bootstrap.php';

if (file_exists(__DIR__ . DS . 'site.php')) {
    require __DIR__ . DS . 'site.php';
} else {
    $kirby = kirby();
}

echo $kirby->launch();
