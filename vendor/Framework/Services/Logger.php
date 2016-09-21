<?php

namespace Framework\Services;

class Logger {

    public function addLog($log, $logLevel = 'info') {

        $path = Service::get('config')['app_path'] . '/tmp/log.txt';
        $time = date("m.d.y H:i:s");

        file_put_contents($path, $time . ' / ' . $logLevel . ' / ' . $log . "\n", FILE_APPEND);
    }
}