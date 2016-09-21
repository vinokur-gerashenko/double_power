<?php

namespace Framework\Database\Engine;


use Framework\Exception\DataBaseException;

class MysqlEngine extends AbstractDbEngine
{
    public function __construct()
    {
        parent::__construct();
        $this->connection = new \mysqli(
            $this->dbConfig['host'],
            $this->dbConfig['user'],
            $this->dbConfig['password'],
            $this->dbConfig['database']
        );
        if (mysqli_connect_errno()) {
            throw new DataBaseException('Unable to connect to database server!');
        }
    }

    public function selectQuery($query)
    {
        $result = $this->connection->query($query);

        return $result->fetch_assoc();
    }


    public function query($query)
    {
        return $this->connection->query($query);
    }
}