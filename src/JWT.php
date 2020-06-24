<?php


namespace BankID\OAuth2\Client;

use Firebase\JWT\JWT as FirebaseJWT;

class JWT extends FirebaseJWT {

  /** @var string Default algorythm. */
  public const DEFAULT_ALG = 'RS256';

  /**
   * @inheritDoc
   */
  public static function decodeForBankId(string $jwt, Endpoints $endpoints): array {
    return (array) self::decode($jwt, JWK::getKeys($endpoints), [self::DEFAULT_ALG]);
  }


}
