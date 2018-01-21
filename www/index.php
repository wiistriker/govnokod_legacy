<?php

if (isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'govnokod.im') !== false) {
    $uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';

    header('Location: http://govnokod.ru' . $uri);
    exit;
}

require_once '../config.php';

if (DEBUG_MODE) {
    ini_set('display_errors', 1);
	error_reporting(E_ALL);
}

if (file_exists(__DIR__ . '/ban.php')) {
    $ban_ips = include __DIR__ . '/ban.php';

    if (isset($_SERVER['REMOTE_ADDR']) && in_array($_SERVER['REMOTE_ADDR'], $ban_ips)) {
        //$log_file = systemConfig::$pathToTemp . '/banned/' . date('Ymd') . '.txt';
        //file_put_contents($log_file, date('H:i:s') . ': ' . $_SERVER['REMOTE_ADDR'] . "\r\n", FILE_APPEND);

        header('HTTP/1.1 500 Internal Server Error');
        exit;
    }
}

if (isset($_SERVER['HTTP_USER_AGENT']) && $_SERVER['HTTP_USER_AGENT'] === 'Go-http-client/1.1') {
    header('HTTP/1.1 500 Internal Server Error');
    exit;
}

require_once systemConfig::$pathToSystem . '/index.php';
require_once '../application.php';

$application = new application();
$application->run();