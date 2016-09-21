<?php
namespace Framework;


use Framework\Services\Service;
use Framework\Services\Session;
use Framework\Router\Router;

class Application {

    public static $config;
    public static $router;

    function __construct($config) {

        self::$config = $config;
        self::$config['app_path'] = realpath(__DIR__ . '/../../');
        $session = new Session();
        $service = Service::getInstance();
        $service::set('session', $session);
        $service::set('config', self::$config);

        self::$router = Router::getInstance();
    }
}