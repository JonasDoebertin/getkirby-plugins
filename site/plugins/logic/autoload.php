<?php

/**
 * Register custom autoloader
 *
 * @since 1.0.0
 */
spl_autoload_register(function ($class) {
    // Setup namespace prefix and base directory
    $prefix = 'jdpowered\\GetKirbyPlugins\\Logic\\';
    $baseDir = LOGIC_BASE_DIR . DS . 'lib' . DS;

    // Go to next autoloader, if the class doesn't belong to our prefix
    $length = strlen($prefix);
    if (strncmp($prefix, $class, $length) !== 0) {
        return;
    }

    // Generate file path for given class
    $relativeClass = substr($class, $length);
    $file = $baseDir . str_replace('\\', DS, $relativeClass) . '.php';

    // Require the class file
    if (file_exists($file)) {
        require $file;
    }
});
