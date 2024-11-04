<?php

require_once 'vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();
$dotenv->required(['API_KEY', 'REDIS_HOST', 'REDIS_USERNAME', 'REDIS_PASSWORD', 'REDIS_PORT', 'REDIS_CACHE_DB']);

spl_autoload_register(static function ($class) {
  include 'classes/' . $class . '.php';
});

$weather = new Weather();

echo $weather->get($_GET, new RateLimiter());
