<?php

namespace Framework\Database\Engine;


use Framework\Services\Service;

abstract class AbstractDbEngine implements DBEngineInterface
{


    protected $dbConfig;

    protected $connection;

    public function __construct()
    {
        $this->dbConfig = Service::get('config')['db'];
    }

    public function select($tableName, array $displayParams, array $searchParams = array())
    {
        $sql = "SELECT {$this->prepareDisplayParams($displayParams)} FROM $tableName";

        if (count($searchParams)) {
            $sql .= " WHERE {$this->prepareSearchParams($searchParams)}";
        }

        return $this->selectQuery($sql);
    }

    public function insert($tableName, array $insertParams)
    {
        $readyParams = $this->prepareInsertParams($insertParams);
        $sql = "INSERT INTO $tableName ({$readyParams['readyKeys']}) VALUES ({$readyParams['readyValues']})";
        return $this->query($sql);
    }

    public function delete($tableName, array $searchParams)
    {
        // TODO: Implement delete() method.
    }

    public function update($tableName, array $searchParams, array $updateParams)
    {
        // TODO: Implement update() method.
    }

    abstract public function query($query);
    abstract public function selectQuery($query);

    protected function cleanParams(array $params)
    {
        return $params;
    }

    protected function prepareDisplayParams(array $params)
    {
        return implode(', ', $params);
    }

    protected function prepareSearchParams(array $searchParams)
    {
        $searchParams = $this->cleanParams($searchParams);

        $readyParams = '';
        foreach ($searchParams as $key => $value) {
            $readyParams .= " $key=$value AND ";
        }

        return chop($readyParams, 'AND ');
    }

    protected function prepareInsertParams(array $params)
    {
        $params = $this->cleanParams($params);
        $keys = [];
        $values = [];
        foreach ($params as $key => $value) {
            $keys[] = $key;
            $values[] = $value;
        }
        return [
            'readyKeys'   => implode(', ', $keys),
            'readyValues' => implode(', ', $values)
        ];
    }
}