<?php

require_once(__DIR__.'/../vendor/autoload.php');

$config = require_once(__DIR__.'/../App/config/config.php');
/**
 * output the error message depending on mode
 */

if ($config['mode'] === 'dev') {
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
}
else if ($config['mode'] === 'prod') {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
}

$app = new Framework\Application($config);

//$app->run();