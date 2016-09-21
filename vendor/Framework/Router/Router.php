<?php

namespace Framework\Router;

use Framework\Services\Service;
use Framework\Exception\RouterException;

class Router {
    private static $instance;
    private static $map = array();
    private static $routePath = '/tmp/routes.json';

    public static function getInstance() {
        if(empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    //public function addRoutes($routing_map) {
    //    self::$map = $routing_map;
    //}

    private function writeRoutes($routingMap) {
        $jsonMap = json_encode($routingMap);

        $fp = fopen(self::$routePath, 'w');
        fwrite($fp, $jsonMap);
        fclose($fp);
        chmod(self::$routePath, 0766);
        $fp = fopen(self::$routePath, 'r');
        $js = fread($fp, filesize(self::$routePath));
        fclose($fp);
        $arr = json_decode($js, true);
        echo '<pre>'; var_dump($arr);
    }

    private function __construct() {

        self::$routePath = Service::get('config')['app_path'];
        $env    = Service::get('config')['mode'];
        $engine = isset(Service::get('config')['routing_engine']) ? Service::get('config')['routing_engine'] : null;
        $routes = null;

        if($env == 'prod') {
            $routes = $this->getRoutes();
        }

        if (is_null($routes)) {
            $routingConfigMap = Service::get('config')['routes'];

            $additional_routes = array();
            if (!is_null($engine)) {
                $class = ucfirst(strtolower($engine)) . 'Parser';
                if (class_exists($class) && $class instanceof RouterParseInterface) {
                    $additional_routes = $class::getRoutes();
                }
                else {
                    throw new RouterException('Engine: ' . $engine . ' does not exists or class: ' . $class .
                    ' does not implements RouterParseInterface.');
                }
            }

            $routingMap = array_merge($routingConfigMap, $additional_routes);

            if ($env == 'prod') {
                $this->writeRoutes($routingMap);
            }
            self::$map = $routingMap;
        }
        else {
            self::$map = $routes;
        }
    }

    private function getRoutes() {
        if (file_exists(realpath(self::$routePath))) {
            $jsonRoutes = file_get_contents(realpath(self::$routePath));
            $routes = json_decode($jsonRoutes, true);
            if(!empty($routes)) {
                return $routes;
            }
        }
        return null;
    }

    public function parseRoute($url){
        if(!preg_match('~/$~', $url)) {
            $url .= '/';
        }

        $route_found = null;
        foreach(self::$map as $name => $route){
            $patternInfo = $this->prepare($route);
            $route_found =array();
            $methodMatch = true;
            if (isset($route['_requirements']['_method'])) {
                $methodMatch = $_SERVER['REQUEST_METHOD'] === $route['_requirements']['_method'];
            }

            if(preg_match($patternInfo['pattern'], $url, $params) && $methodMatch){
                $route_found = $route;
                $route_found['_name'] = $name;

                if(!empty($patternInfo['paramsNames'])) {

                    $route_found['params'] = array();
                    $i = 1;
                    foreach($patternInfo['paramsNames'] as $name) {
                        $route_found['params'][$name] = $params[$i];
                        $i++;
                    }
                }
                break;
            }
        }
        return $route_found;
    }

    private function prepare($route){
        $paramsNames = array();
        $pattern = $route['pattern'];

        if(!preg_match('~/$~', $pattern)) { // resulting in an overall view
            $pattern .= '/';
        }

        if(preg_match_all('~\{([\w\d_]+)\}~', $route['pattern'], $matches)) { // finding url includes
            $paramsNames = $matches[1]; // get inclusion array

            if (!empty($matches[1])) {
                foreach ($matches[1] as $param) {
                    if (!empty($route['_requirements'][$param])) { // replase includes by regexp
                        $pattern = preg_replace('~\{' . $param . '\}~Ui', '(' . $route['_requirements'][$param] . ')', $pattern);
                    } else {
                        $pattern = preg_replace('~\{' . $param . '\}~Ui', '([\w\d_]+)', $pattern);
                    }
                }
            }
        }

        $pattern = '~^'. $pattern.'$~';
        return array('pattern' => $pattern, 'paramsNames' => $paramsNames);
    }

    public function generateRoute($name, $data = array()) {
        foreach (self::$map as $rName => $route) {
            if($name == $rName) {
                if (!empty($data)) {
                    $paramNames = $this->prepare($route)['paramsNames'];
                    foreach ($data as $param =>$value) {
                        $path = preg_replace('~\{' . $param . '\}~Ui', $value, $route['pattern']);
                    }
                } else {
                    $path = $route['pattern'];
                }
                return $path;
            }
        }
        return '/';
    }
}