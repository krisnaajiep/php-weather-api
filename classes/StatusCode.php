<?php

class StatusCode
{
  public static function getHeader(int $responseCode): string
  {
    $message = self::getMessage($responseCode);
    $statusCodeHeader = "HTTP/1.1 $responseCode";
    if (!is_null($message)) $statusCodeHeader .= " $message";
    return $statusCodeHeader;
  }

  public static function getMessage(int $responseCode): string
  {
    $statusMessages = [
      400 => 'Bad Request',
      401 => 'Unauthorized',
      400 => 'Bad Request',
      404 => 'Not Found',
      429 => 'Too Many Request',
      500 => 'Internal Server Error',
    ];

    return array_key_exists($responseCode, $statusMessages)
      ? $statusMessages[$responseCode]
      : null;
  }
}
