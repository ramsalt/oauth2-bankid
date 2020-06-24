<?php


namespace BankID\OAuth2\Client\Provider;

use BankID\OAuth2\Client\Environments;
use BankID\OAuth2\Client\JWT;
use BankID\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Grant\AbstractGrant;
use League\OAuth2\Client\Provider\GenericProvider;
use League\OAuth2\Client\Token\AccessToken as LeagueAccessToken;
use Psr\Http\Message\ResponseInterface;

class BankIdProvider extends GenericProvider {

  /**
   * @var \BankID\OAuth2\Client\Endpoints
   */
  protected $endpoints;

  public static function createForEnvironment(
    string $environment,
    array $options = []
  ): BankIdProvider {
    $options['endpoints'] = Environments::getEndpoints($environment);
    return new static($options);
  }

  /**
   * @inheritDoc
   */
  protected function getRequiredOptions() {
    return [
      'endpoints',
    ];
  }

  /**
   * @inheritDoc
   */
  public function getBaseAuthorizationUrl() {
    return $this->endpoints->getAuthorizationEndpoint();
  }

  /**
   * @inheritDoc
   */
  public function getBaseAccessTokenUrl(array $params) {
    return $this->endpoints->getTokenEndpoint();
  }

  /**
   * @inheritDoc
   */
  public function getResourceOwnerDetailsUrl(LeagueAccessToken $token) {
    return $this->endpoints->getUserInfoEndpoint();
  }

  /**
   * @inheritDoc
   */
  protected function createAccessToken(array $response, AbstractGrant $grant): AccessToken {
    // Create BankID AccessToken rather then the default one.
    return new AccessToken($response, $this->endpoints);
  }

  /**
   * @inheritDoc
   */
  protected function parseResponse(ResponseInterface $response) {
    $content = (string) $response->getBody();
    $type = $this->getContentType($response);

    // Handle responses which are JWT signed/encoded.
    if (strpos($type, 'application/jwt') !== false) {
      return JWT::decodeForBankId($content, $this->endpoints);
    }

    // Rewind the body stream.
    $response->getBody()->rewind();
    // Let the parent do the standard work.
    return parent::parseResponse($response);
  }

  /**
   * @inheritDoc
   */
  protected function getScopeSeparator() {
    return ' ';
  }

}
