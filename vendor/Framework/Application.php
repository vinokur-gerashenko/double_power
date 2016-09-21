<?php
namespace Framework;


use Framework\Database\DataBase;
use Framework\Database\Engine\MysqlEngine;
use Framework\Exception\DataBaseException;
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
        /*var_dump(DataBase::getConnection()->select('posts', ['id', 'title'],[
            'id' => 2,
            'title' => 'Title',
        ]));*/
        var_dump(DataBase::getConnection()->insert('posts', [
            'title' => 'New Post',
            'content' => 'Some content',
            'date' => (new \DateTime())->format('Y-m-d H:i:s'),
        ]));

    }
}