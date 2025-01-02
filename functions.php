<?php

/**
 * Fetches weather data for a given location.
 * Uses caching to minimize API requests and improve performance.
 *
 * @param string $location The location for which weather data is requested.
 * @return string|true JSON response from the weather API or cached data.
 */
function weather(string $location): string|true
{
  header('Content-type: application/json');  // Set response content type as JSON

  // Check if the data is already cached
  $cache = Cache::get($location);

  if (!is_null($cache)) {
    header('Content-type: application/json'); // Reconfirm JSON response type
    return $cache; // Return cached response
  }

  // Build the API request URL
  $base_url = $_ENV['API_BASE_URL']; // Base URL of the Visual Crossing's API
  $key = $_ENV['API_KEY']; // API key for authentication
  $url = "$base_url$location?key=$key&include=days";

  // Initialize cURL for API request
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec($ch);

  // Handle cURL errors
  if (!$response) $response = 'Curl error: ' . curl_error($ch);

  // Get the response code and set appropriate HTTP header
  $response_code = intval(curl_getinfo($ch, CURLINFO_RESPONSE_CODE));
  if ($response_code !== 200) {
    header("HTTP/1.1 $response_code"); // Forward the response code
  } else {
    Cache::set($location, $response); // Cache successful API response
  }

  curl_close($ch); // Close cURL session

  return $response;
}

/**
 * Implements rate limiting for a given key.
 * Prevents excessive operations or API calls within a specified time window.
 *
 * @param string $key The unique identifier for rate-limiting (e.g., user or IP).
 * @param int $limit The maximum number of allowed requests within the time window.
 * @param int $seconds The duration of the time window in seconds.
 * @return bool Returns true if the request is allowed, false if the limit is exceeded.
 */
function rateLimit(string $key, int $limit, int $seconds): bool
{
  // Retrieve the current request count from cache
  $value = Cache::get($key);

  // If the limit is exceeded, deny the request
  if (!is_null($value) && intval($value) >= $limit) return false;

  // Increment the request count
  Cache::incr($key);

  // Set expiration for the key if it is a new entry
  if (is_null($value)) Cache::expire($key, $seconds, 'NX');

  return true; // Allow the request
}
