<?php

function weather(string $location): string|true
{
  header('Content-type: application/json');

  $base_url = $_ENV['API_BASE_URL'];
  $key = $_ENV['API_KEY'];
  $url = "$base_url$location?key=$key&include=days";

  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec($ch);

  if (!$response) $response = 'Curl error: ' . curl_error($ch);
  $response_code = intval(curl_getinfo($ch, CURLINFO_RESPONSE_CODE));
  if ($response_code !== 200) header("HTTP/1.1 $response_code");

  curl_close($ch);

  return $response;
}
