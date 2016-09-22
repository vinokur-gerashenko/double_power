<?php

namespace Framework\Services;

use Framework\Exception\ServiceException;

class Service extends AbstractService {
    private static $services = array();
    private static $prefix = 'Framework\\Services\\';

    public static function get($service) {
        $service = self::$prefix . ucfirst(strtolower($service));

        if (class_exists($service)) {
            return $service::getInstance();
        }
        else {
            throw new ServiceException('Service: ' . $service . ' does not exists.');
        }
    }
}