<?php


namespace BankID\OAuth2\Client\Provider;


use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class BankIdUser implements ResourceOwnerInterface {

  /**
   * @var array
   */
  protected $response;

  /**
   * @var string
   */
  protected $idFieldName;

  /**
   * @param array $response
   * @param string $idFieldName
   */
  public function __construct(array $response, string $idFieldName = 'sub')
  {
    $this->response = $response;
    $this->idFieldName = $idFieldName;
    if (empty($this->response[$idFieldName])) {
      throw new \InvalidArgumentException(
        'Could not create a valid ResourceOwner object: Missing Identifier field.'
      );
    }
  }

  /**
   * Returns the identifier of the authorized resource owner.
   *
   * @return mixed
   */
  public function getId()
  {
    return $this->response[$this->idFieldName];
  }

  /**
   * Returns the raw resource owner response.
   *
   * @return array
   */
  public function toArray()
  {
    return $this->response;
  }

  public function getIssuer() {
    return $this->response['iss'];
  }

  public function getSubjectIdentifier() {
    return $this->response['sub'];
  }

  public function getLastUpdateTimestamp(): int {
    return $this->response['updated_at'];
  }

  public function getFirstName(): string {
    return $this->response['given_name'];
  }

  public function getLastName(): string {
    return $this->response['family_name'];
  }

  public function getName(): string {
    return $this->response['name'];
  }

  public function getBirthdate(): \DateTimeImmutable {
    return \DateTimeImmutable::createFromFormat('Y-m-d', $this->response['birthdate']);
  }

  public function getBirthdateISO8601(): string {
    return $this->response['birthdate'];
  }

  /**
   * Requires scope 'email'.
   *
   * @return string|null
   */
  public function getEmail(): ?string {
    return $this->response['email'] ?? NULL;
  }

  /**
   * Requires scope 'nnin'.
   *
   * @return string|null
   */
  public function getNationalId(): ?string {
    return $this->response['nnin'] ?? NULL;
  }

  /**
   * Requires scope 'phone'.
   *
   * @return string|null
   */
  public function getTelephone(): ?string {
    return $this->response['phone_number'] ?? NULL;
  }

  /**
   * Requires scope 'address'.
   *
   * @example Returned data:
   * @code
   * array(
   *  'formatted' => 'Full address string',
   *  'street_address' => 'Street address from',
   *  'locality' => 'Norwegian "poststed"',
   *  'region' => '',
   *  'postal_code' => 'Norwegian "postnummer"',
   *  'country' => '',
   * );
   * @endcode
   *
   * @return array|null
   */
  public function getAddress(): ?array {
    return $this->response['address'] ?? NULL;
  }
}
