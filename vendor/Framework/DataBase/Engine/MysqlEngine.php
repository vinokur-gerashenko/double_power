<?php

namespace Framework\Database\Engine;



class MysqlEngine extends AbstractDbEngine
{
    public function __construct()
    {
        parent::__construct();
        echo $this->host;
    }


}