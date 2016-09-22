<?php

namespace Framework\Exception;

use Framework\Services\Service;
use Framework\Services\Logger;

class MainException extends \Exception {
    protected $type = 'info'; // default type of exception
    private $logger;

    public function __construct($message, $code = null) {
        $this->logger = Service::get('logger' );
        $this->logger->addLog(__CLASS__ . ': ' . $message, $this->type);
        parent::__construct($message, $code);
    }
}