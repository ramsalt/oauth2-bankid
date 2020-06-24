<?php


namespace BankID\OAuth2\Client\Token;

use BankID\OAuth2\Client\Endpoints;
use BankID\OAuth2\Client\JWT;
use League\OAuth2\Client\Token\AccessToken as LeagueAccessToken;

class AccessToken extends LeagueAccessToken {

  /**
   * @var \BankID\OAuth2\Client\Endpoints
   */
  protected $endpoints;

  /**
   * @inheritDoc
   * @noinspection PhpOptionalBeforeRequiredParametersInspection
   */
  public function __construct(array $options = [], Endpoints $endpoints) {
    parent::__construct($options);
    $this->endpoints = $endpoints;
  }


  public function getIdToken(): ?IdToken {
    if (!isset($this->values['id_token'])) {
      return NULL;
    }
    if (!isset($this->values['id_token_decoded'])) {
      $decoded_token = JWT::decodeForBankId(
        $this->values['id_token'],
        $this->endpoints
      );
      $this->values['id_token_decoded'] = new IdToken($decoded_token);
    }

    return $this->values['id_token_decoded'] ?? NULL;
  }

}
