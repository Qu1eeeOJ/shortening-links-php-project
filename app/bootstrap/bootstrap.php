<?php

/*
 * Bootstrap by qu1eeeoj
 */

// Application launch
define('SHORT_URL_START', microtime(true));

// Defining constants
define('ROOT', dirname(dirname(__DIR__)));
define('APP', ROOT . '/app');

// The connection of the autoloader classes
require APP . '/autoloader.php';

// Enabling functions
require_once 'functions.php';

// The connection configuration of the application
$app = require_once APP . '/config/app.php';
$shorter = require_once APP . '/config/shorter.php';

// Creating the application hierarchy
$app = (object) [
    'app' => (object) [
        // If you need to create a single instance of the method, paste it here
    ],
    'conf' => (object) [
        // Access to all configs that you use in the app
        'app' => $app,
        'shorter' => $shorter
    ]
];

// Creating an instance of the application and entering the hierarchy there
$app = new App\Vendor\Application\Application($app);

// Getting a ready-made application
$app = app($app);

// Returning the app
return $app;