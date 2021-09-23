<?php


namespace BankID\OAuth2\Client;

use GuzzleHttp\Client;

class Environments {

  public const ENV_PROD = 'prod';

  public const ENV_STAGE = 'current';

  public const ENV_TEST = 'preprod';

  protected static $env_conf = [];

  public static function getEndpoints(string $environment = self::ENV_PROD): ?Endpoints {
    if (!isset(self::$env_conf[$environment])) {
      if (!self::isValidEnvName($environment)) {
        throw new \InvalidArgumentException("Environment not supported.");
      }

      $url = self::getOpenidConfigurationUrl($environment);
      $http = new Client(
        [
          'verify'  => TRUE,
          'timeout' => 15,
          // Security consideration: prevent Guzzle from using environment variables o configure the outbound proxy.
          'proxy'   => ['http' => NULL, 'https' => NULL, 'no' => []],
        ]
      );
      $config = (string) $http->get($url)->getBody()->getContents();
      self::$env_conf[$environment] = new Endpoints(
        json_decode($config, TRUE, 512, JSON_THROW_ON_ERROR)
      );
    }

    return self::$env_conf[$environment];
  }

  /**
   * Returns the base URL for an enviroment's OpenID configuration.
   *
   * @param string $environment
   *   One of the self::ENV_* constants.
   *
   * @return string
   */
  protected static function getOpenidConfigurationUrl(string $environment): string {
    $env_prefix = ($environment === self::ENV_PROD) ? '' : ".{$environment}";
    return "https://auth{$env_prefix}.bankid.no/auth/realms/{$environment}/.well-known/openid-configuration";
  }

  /**
   * Checks if an environemtn is supported.
   *
   * @param string $environment
   *
   * @return bool
   */
  protected static function isValidEnvName(string $environment): bool {
    if ($environment === self::ENV_PROD) {
      return true;
    }
    if ($environment === self::ENV_STAGE) {
      return true;
    }
    if ($environment === self::ENV_TEST) {
      return true;
    }

    return false;
  }
}
