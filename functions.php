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

  curl_close($ch);

  return $response;
}
