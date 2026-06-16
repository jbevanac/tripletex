<?php

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->safeLoad();

if (file_exists(__DIR__ . '/../.env.local')) {
    $dotenv = Dotenv\Dotenv::createMutable(__DIR__ . '/..', '.env.local');
    $dotenv->load();
}

define('URL', $_ENV['TRIPLETEX_URL']);
define('CONSUMER_TOKEN', $_ENV['TRIPLETEX_CONSUMER_TOKEN']);
define('EMPLOYEE_TOKEN', $_ENV['TRIPLETEX_EMPLOYEE_TOKEN']);
define('CACHE_DIR', dirname(__DIR__) . '/' . ltrim($_ENV['TRIPLETEX_CACHE_DIR'] ?? 'var/cache', '/'));
define('WEBHOOK_TARGET_URL', $_ENV['TRIPLETEX_WEBHOOK_TARGET_URL'] ?? '');
