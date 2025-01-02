<?php

use Predis\Client;


/**
 * Class Cache
 * Provides a simple wrapper around Redis for caching operations.
 * Uses Predis\Client for Redis connection and operations.
 */
class Cache
{
  /**
   * @var Client|null Redis client instance.
   */
  private static $client;

  /**
   * Initializes the Redis client using configuration from environment variables.
   * This method is called internally by other methods to ensure the client is ready.
   *
   * @return void
   */
  private static function init()
  {
    self::$client = new Client([
      'scheme' => 'tcp', // Connection scheme (TCP protocol)
      'host' => $_ENV['REDIS_HOST'], // Redis server host
      'port' => $_ENV['REDIS_PORT'], // Redis server port
      'password' => $_ENV['REDIS_PASSWORD'], // Redis password
      'database' => $_ENV['REDIS_CACHE_DB'] // Database index for caching
    ]);
  }

  /**
   * Stores a key-value pair in Redis with a default expiration time.
   *
   * @param string $key   The cache key.
   * @param mixed $value The value to store.
   * @return void
   */
  public static function set(string $key, $value)
  {
    self::init();
    self::$client->set($key, $value, 'EX', (3600 * 12));
  }

  /**
   * Retrieves the value of a given key from Redis.
   *
   * @param string $key The cache key to retrieve.
   * @return string|null The value associated with the key, or null if not found.
   */
  public static function get(string $key): string|null
  {
    self::init();
    return self::$client->get($key);
  }

  /**
   * Increments the value of a key by 1 in Redis.
   *
   * @param string $key The key to increment.
   * @return int The new value after incrementing.
   */
  public static function incr(string $key): int
  {
    self::init();
    return self::$client->incr($key);
  }

  /**
   * Sets the expiration time for a key in Redis.
   *
   * @param string $key          The key to set expiration for.
   * @param int    $seconds      The expiration time in seconds.
   * @param string $expireOption Optional expiration flag (e.g., 'NX').
   * @return int Returns 1 if the expiration was set successfully, 0 otherwise.
   */
  public static function expire(string $key, int $seconds, string $expireOption = ''): int
  {
    self::init();
    return self::$client->expire($key, $seconds, $expireOption);
  }
}
