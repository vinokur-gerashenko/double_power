<?php

namespace Framework\Services;

abstract class AbstractService {
    protected static $instance;

    public static function getInstance() {
        if(empty(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    protected function __construct() { /* close */ }
    protected function __clone() { /* close */ }
}