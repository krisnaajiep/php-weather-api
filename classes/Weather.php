<?php

class Weather
{
  public function get(array $params, RateLimiter $rateLimiter): string|bool
  {
    $date1 = date('Y-m-d');

    if (!$rateLimiter("rate-limit:{$_SERVER['REMOTE_ADDR']}", 3, 60)) {
      header($this->getStatusCodeHeader(429));
      return 'Too many API requests:Please wait a moment before making more requests.';
    }

    if (!isset($params['location'])) {
      header($this->getStatusCodeHeader(400));
      return 'Bad API Request:A location must be specified';
    }

    $weatherCache = Cache::get($params['location']);

    if (!is_null($weatherCache)) {
      header('Content-type: application/json');
      return $weatherCache;
    }

    $url = "https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/{$params['location']}/$date1?key={$_ENV['API_KEY']}&include=days";

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if (!$response) $response = 'Curl error: ' . curl_error($ch);

    $responseCode = intval(curl_getinfo($ch, CURLINFO_RESPONSE_CODE));

    if ($responseCode !== 200) {
      header($this->getStatusCodeHeader($responseCode));
    } else {
      Cache::set($params['location'], $response);
    }

    curl_close($ch);

    header('Content-type: application/json');

    return $response;
  }

  private function getStatusCodeHeader(int $responseCode): string
  {
    $message = $this->getStatusCode($responseCode);
    $statusCodeHeader = "HTTP/1.1 $responseCode";
    if (!is_null($message)) $statusCodeHeader .= " $message";
    return $statusCodeHeader;
  }

  private function getStatusCode(int $responeCode): string|null
  {
    $statusMessages = [
      400 => 'Bad Request',
      401 => 'Unauthorized',
      400 => 'Bad Request',
      404 => 'Not Found',
      429 => 'Too Many Request',
      500 => 'Internal Server Error',
    ];

    return array_key_exists($responeCode, $statusMessages)
      ? $statusMessages[$responeCode]
      : null;
  }
}
