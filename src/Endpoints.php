<?php


namespace BankID\OAuth2\Client;


class Endpoints {

  /**
   * @inheritDoc
   */
  public function __construct(array $configuration) {
    $this->config = $configuration;
    if (!$this->isValid()) {
      throw new \RuntimeException(
        'Could not create new object from invalid configuration'
      );
    }
  }

  protected function isValid(): bool {
    $c = $this->config;
    $hasAllRequiredKeys = isset(
      $c['authorization_endpoint'],
      $c['token_endpoint'],
      $c['token_introspection_endpoint'],
      $c['userinfo_endpoint'],
      $c['jwks_uri'],
      $c['introspection_endpoint'],
    );
    // TODO: Improve the validation beyond the simple 'isset' check
    return $hasAllRequiredKeys;
  }

  public function getAuthorizationEndpoint(): string {
    return $this->config['authorization_endpoint'];
  }

  public function getTokenEndpoint(): string {
    return $this->config['token_endpoint'];
  }

  public function getTokenIntrospectionEndpoint(): string {
    return $this->config['token_introspection_endpoint'];
  }

  public function getIntrospectionEndpoint(): string {
    return $this->config['introspection_endpoint'];
  }

  public function getUserInfoEndpoint(): string {
    return $this->config['userinfo_endpoint'];
  }

  public function getJwkUrl(): string {
    return $this->config['jwks_uri'];
  }
}
