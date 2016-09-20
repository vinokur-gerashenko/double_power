<?php

namespace Framework\Services;

class Service {
    private static $instance;
    private static $services = array();

    public static function getInstance() {
        if(empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function set($name, $value) {
        if( !isset( self::$services[$name])) {
            self::$services[$name] = $value;
        }
    }

    public static function get($name) {
        return self::$services[$name];
    }

    private function __construct() { /* close */ }
    private function __clone() { /* close */ }
}