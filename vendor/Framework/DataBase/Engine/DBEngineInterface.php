<?php

namespace Framework\Database\Engine;


interface DBEngineInterface
{
    public static function select($tableName, array $displayParams, array $searchParams = array());

    public static function insert($tableName, array $insertParams);

    public static function delete($tableName, array $searchParams);

    public static function update($tableName, array $searchParams, array $updateParams);

    public static function query($query);

}