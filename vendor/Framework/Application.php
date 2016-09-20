<?php
namespace Framework;


use Framework\Database\DataBase;
use Framework\Services\Service;
use Framework\Services\Session;

class Application {

    public static $config;
    public static $router;

    function __construct($config) {

        self::$config = $config;
        self::$config['app_path'] = realpath(__DIR__ . '/../../');
        $service = Service::getInstance();

        $session = new Session();
        $service::set('session', $session);
        $service::set('config', self::$config);

        //self::$router = Router::getInstance();
    }

    public function run()
    {
        DataBase::getConnection()->select('table', array());

    }
}