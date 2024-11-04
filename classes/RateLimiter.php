<?php

class RateLimiter
{
  public function __invoke(string $key, int $limit, int $seconds): bool
  {
    $value = Cache::get($key);

    if (!is_null($value) && intval($value) >= $limit) return false;

    Cache::incr($key);
    if (is_null($value)) Cache::expire($key, $seconds, 'NX');

    return true;
  }
}
