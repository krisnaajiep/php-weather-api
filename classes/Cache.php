<?php

use Predis\Client;

class Cache
{
  private static $client;

  public static function init()
  {
    self::$client = new Client([
      'scheme' => 'tcp',
      'host' => $_ENV['REDIS_HOST'],
      'port' => $_ENV['REDIS_PORT'],
      'password' => $_ENV['REDIS_PASSWORD'],
      'database' => $_ENV['REDIS_CACHE_DB']
    ]);
  }

  public static function set(string $key, $value)
  {
    self::init();
    self::$client->set($key, $value, 'EX', (3600 * 12));
  }

  public static function get(string $key): string|null
  {
    self::init();
    return self::$client->get($key);
  }

  public static function incr(string $key): int
  {
    self::init();
    return self::$client->incr($key);
  }

  public static function expire(string $key, int $seconds, string $expireOption = ''): int
  {
    self::init();
    return self::$client->expire($key, $seconds, $expireOption);
  }
}
