<?php

function weather(string $location): string|true
{
  header('Content-type: application/json');

  $url = "https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/$location?key=FQ6A4QTDNJRP348RQXG5RT325&include=days";

  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec($ch);

  if (!$response) $response = 'Curl error: ' . curl_error($ch);

  curl_close($ch);

  return $response;
}
