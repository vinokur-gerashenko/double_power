<?php

namespace Framework\Database\Engine;



use Framework\Services\Service;

class AbstractDbEngine implements DBEngineInterface
{
    protected $host;

    protected $userName;

    protected $password;

    protected $dbName;

    public function __construct()
    {
        $dbConfig = Service::get('config')['db'];

        $this->host = $dbConfig['host'];

        $this->userName = $dbConfig['user_name'];

        $this->password = $dbConfig['password'];

        $this->dbName = $dbConfig['db_name'];
    }

    public static function select($tableName, array $displayParams, array $searchParams = array())
    {
        // TODO: Implement select() method.
    }

    public static function insert($tableName, array $insertParams)
    {
        // TODO: Implement insert() method.
    }

    public static function delete($tableName, array $searchParams)
    {
        // TODO: Implement delete() method.
    }

    public static function update($tableName, array $searchParams, array $updateParams)
    {
        // TODO: Implement update() method.
    }

    public static function query($query)
    {
        // TODO: Implement query() method.
    }
}