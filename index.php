<?php

require_once 'vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();
$dotenv->required(['API_BASE_URL', 'API_KEY', 'REDIS_HOST', 'REDIS_USERNAME', 'REDIS_PASSWORD', 'REDIS_PORT', 'REDIS_CACHE_DB']);

spl_autoload_register(function ($class) {
  include 'classes/' . $class . '.php';
});

$executed = new RateLimiter();

if (!$executed("rate-limit:{$_SERVER['REMOTE_ADDR']}", 60, 60)) {
  header(StatusCode::getHeader(429));
  echo 'Too many API requests:Please wait a moment before making more requests.';
  exit;
}

if (!isset($_GET['location'])) {
  header(StatusCode::getHeader(400));
  echo 'Bad API Request:A location must be specified';
  exit;
}

echo (new GetWeather())("{$_ENV['API_BASE_URL']}{$_GET['location']}?key={$_ENV['API_KEY']}");
