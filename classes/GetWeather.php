<?php

class GetWeather
{
  public function __invoke(string $url): string|bool
  {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Headers: Content-Type");
    header('Content-type: application/json');

    $weatherCache = Cache::get($_GET['location']);

    if (!is_null($weatherCache)) {
      header('Content-type: application/json');
      return $weatherCache;
    }

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if (!$response) $response = 'Curl error: ' . curl_error($ch);

    $responseCode = intval(curl_getinfo($ch, CURLINFO_RESPONSE_CODE));

    if ($responseCode !== 200) {
      header(StatusCode::getHeader($responseCode));
    } else {
      Cache::set($_GET['location'], $response);
    }

    curl_close($ch);

    return $response;
  }
}
