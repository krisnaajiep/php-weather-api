<?php

function weather(string $location): string|true
{
  header('Content-type: application/json');

  $cache = Cache::get($location);

  if (!is_null($cache)) {
    header('Content-type: application/json');
    return $cache;
  }

  $base_url = $_ENV['API_BASE_URL'];
  $key = $_ENV['API_KEY'];
  $url = "$base_url$location?key=$key&include=days";

  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec($ch);

  if (!$response) $response = 'Curl error: ' . curl_error($ch);
  $response_code = intval(curl_getinfo($ch, CURLINFO_RESPONSE_CODE));
  if ($response_code !== 200) {
    header("HTTP/1.1 $response_code");
  } else {
    Cache::set($location, $response);
  }

  curl_close($ch);

  return $response;
}

function rateLimit(string $key, int $limit, int $seconds): bool
{
  $value = Cache::get($key);

  if (!is_null($value) && intval($value) >= $limit) return false;

  Cache::incr($key);
  if (is_null($value)) Cache::expire($key, $seconds, 'NX');

  return true;
}
