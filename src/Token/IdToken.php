<?php


namespace BankID\OAuth2\Client\Token;


class IdToken extends \ArrayObject {

  public function getSubjectIdentifier() {
    return $this['sub'];
  }

  public function getBankIdSubjectIdentifier(): ?string {
    return $this['bankid_altsub'] ?? NULL;
  }

  public function getNationalIdSubjectIdentifier(): ?string {
    return $this['nnin_altsub'] ?? NULL;
  }

  public function getBirthdate(): \DateTimeImmutable {
    return \DateTimeImmutable::createFromFormat('Y-m-d', $this['birthdate']);
  }

  public function getBirthdateISO8601(): string {
    return $this['birthdate'];
  }

  public function getFirstName(): string {
    return $this['given_name'];
  }

  public function getLastName(): string {
    return $this['family_name'];
  }

  public function getName(): string {
    return $this['name'];
  }

  /**
   * @return string
   *  BID = BankID or BIM = BankID Mobile
   */
  public function getAuthenticationMethodReference(): string {
    return $this['amr'];
  }

  // TODO
  private $_example = [
    'jti'                => '12345677-7faa-4398-9db9-5cc61c83f07f',
    'exp'                => 1092998702,
    'nbf'                => 0,
    'iat'                => 1592998402,
    'iss'                => 'https://oidc-current.bankidapis.no/auth/realms/current',
    'aud'                => 'something-bankid-current',
    'sub'                => '12ab875c-db09-406b-bec1-630409737ca9',
    'typ'                => 'ID',
    'azp'                => 'something-bankid-current',
    'auth_time'          => 1492998402,
    'session_state'      => '0000808d-e8c6-41ce-ba96-8fb171a4a6be',
    'name'               => 'MyName WithSurname',
    'given_name'         => 'MyName',
    'family_name'        => 'WithSurname',
    'birthdate'          => '1913-06-21',
    'updated_at'         => 1292982190000,
    'acr'                => 'urn:bankid:bid;LOA=4',
    'nnin_altsub'        => '21061322059',
    'amr'                => 'BID',
    'bankid_altsub'      => '9578-6000-4-470125',
    'originator'         => 'CN=BankID - TestBank1 - Bank CA 3,OU=123456789,O=TestBank1 AS,C=NO;OrginatorId=9980;OriginatorName=BINAS;OriginatorId=9980',
    'additionalCertInfo' => [
      'certValidFrom'         => 1492982190000,
      'serialNumber'          => '1347530',
      'keyAlgorithm'          => 'RSA',
      'keySize'               => '2048',
      'policyOid'             => '2.16.578.1.16.1.12.1.1',
      'monetaryLimitAmount'   => '100000',
      'certQualified'         => TRUE,
      'monetaryLimitCurrency' => 'NOK',
      'certValidTo'           => 1656054190000,
      'versionNumber'         => '3',
      'subjectName'           => 'CN=WithName\\, MyName,O=TestBank1 AS,C=NO,SERIALNUMBER=9578-6000-4-470125',
    ],
  ];
}
