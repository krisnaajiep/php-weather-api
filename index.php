<?php

require_once 'vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

require_once 'Cache.php';
require_once 'functions.php';

$executed = rateLimit("rate-limit:{$_SERVER['REMOTE_ADDR']}", 60, 60);

if (!$executed) {
  header('HTTP/1.1 429');
  echo 'Too many API requests:Please wait a moment before making more requests.';
  exit;
}

if (!isset($_GET['location'])) {
  header('HTTP/1.1 400');
  echo 'Bad API Request:A location must be specified';
  exit;
}

echo weather($_GET['location']);
