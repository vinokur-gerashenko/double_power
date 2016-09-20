<?php

namespace Framework\Database;


use Framework\Database\Engine\DBEngineInterface;
use Framework\Exception\DataBaseException;
use Framework\Services\Service;

class DataBase
{
    /**
     * @var DBEngineInterface
     */
    private static $connection;


    /**
     * @return DBEngineInterface
     * @throws DataBaseException
     */
    public static function getConnection()
    {
        if (empty(self::$connection)) {
            $engine = Service::get('config')['db']['engine'];
            $engineClassName = 'Framework\\Database\\Engine\\' . ucfirst(strtolower($engine)) . 'Engine';
            if (!class_exists($engineClassName) || !file_exists(__DIR__ . '/../../' . $engineClassName . '.php')) {
                throw new DataBaseException($engine . ' type of database engine is not exists!');
            }

            $engineObj = new $engineClassName();

            if (!$engineObj instanceof DBEngineInterface) {
                throw new DataBaseException('Database engine must implements ' . DBEngineInterface::class . '!');
            }
            self::$connection = $engineObj;
        }
        return self::$connection;
    }



    /**
     * DataBase constructor.
     */
    private function __construct()
    {

    }
}