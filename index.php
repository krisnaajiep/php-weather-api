<?php

require_once 'vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

require_once 'Cache.php';
require_once 'functions.php';

echo weather($_GET['location']);
