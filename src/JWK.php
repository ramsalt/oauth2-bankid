<?php


namespace BankID\OAuth2\Client;

use Firebase\JWT\JWK as FirebaseJWK;
use GuzzleHttp\Client;

class JWK extends FirebaseJWK {

  public static function getKeys(Endpoints $endpoints) {
    $url = $endpoints->getJwkUrl();
    $http = new Client([
      'verify'  => TRUE,
      'timeout' => 15,
      // Security consideration: prevent Guzzle from using environment variables o configure the outbound proxy.
      'proxy'   => ['http' => NULL, 'https' => NULL, 'no' => []],
    ]);
    $keys_string = (string) $http->get($url)->getBody()->getContents();
    return self::parseKeySet(
      json_decode($keys_string, TRUE, 512, JSON_THROW_ON_ERROR)
    );
  }
}
