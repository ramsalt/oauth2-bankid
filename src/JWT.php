<?php


namespace BankID\OAuth2\Client;

use Firebase\JWT\JWT as FirebaseJWT;

class JWT extends FirebaseJWT {

  /**
   * @inheritDoc
   */
  public static $leeway = 30;

  /** @var string Default algorythm. */
  public const DEFAULT_ALG = 'RS256';

  /**
   * @inheritDoc
   */
  public static function decodeForBankId(string $jwt, Endpoints $endpoints, int $leeway = NULL): array {
    if ($leeway !== NULL) {
      self::$leeway = $leeway;
    }
    return (array) self::decode($jwt, JWK::getKeys($endpoints), [self::DEFAULT_ALG]);
  }

}
