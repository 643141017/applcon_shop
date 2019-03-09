<?php

use Phalcon\Loader;

// Load constants
require 'constants.php';

(new Loader)
    ->registerNamespaces([
        'Applcon\Forms' => ROOT_DIR . '/core/common/forms/',
        'Applcon\Tools' => ROOT_DIR . '/core/common/tools/',
        'Applcon\Common' => ROOT_DIR . '/core/common/',
        'Applcon\Models' => ROOT_DIR . '/core/common/models/',
        'Applcon\Factory' => ROOT_DIR . '/core/common/factory',
        'Applcon\Library' => ROOT_DIR . '/core/common/library/',
        'Applcon\Validators' => ROOT_DIR . '/core/common/validators/',
        'Applcon\Controllers' => ROOT_DIR . '/core/common/controllers/',
    ])
    ->registerFiles([
        __DIR__ . '/helpers.php',
    ])
    ->register();

// Register The Composer Auto Loader
require ROOT_DIR . '/vendor/autoload.php';
