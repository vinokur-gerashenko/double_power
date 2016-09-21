<?php

namespace Framework\Database\Engine;


interface DBEngineInterface
{
    public function select($tableName, array $displayParams, array $searchParams = array());

    public function insert($tableName, array $insertParams);

    public function delete($tableName, array $searchParams);

    public function update($tableName, array $searchParams, array $updateParams);

    public function query($query);

}