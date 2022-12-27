<?php

namespace App\Auth\Model;

use App\Models\User as ModelsUser;
use Laravel\Passport\Bridge\AccessToken as PassportAccessToken;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Key;
use League\OAuth2\Server\CryptKey;
use DateTimeImmutable;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Hmac\Sha256;

class AccessToken extends PassportAccessToken {

  private $privateKey;

  public function convertToJWT(CryptKey $privateKey) {
    $user = ModelsUser::find($this->getUserIdentifier());
    $now = new DateTimeImmutable();
    $config = Configuration::forSymmetricSigner(new Sha256(), InMemory::plainText('testing'));
    $builder = $config->builder();

    $builder->permittedFor($this->getClient()->getIdentifier())
      ->identifiedBy($this->getIdentifier(), true)
      ->issuedAt($now)
      ->canOnlyBeUsedAfter($now)
      ->expiresAt($now->modify('+1 minute'))
      ->relatedTo($this->getUserIdentifier())
      ->withClaim('scopes', [])
      ->withClaim('id', $user->id)
      ->withClaim('name', $user->name)
      ->withClaim('email', $user->email);
    return $builder
      ->getToken($config->signer(), $config->signingKey());
    /* ->getToken(new Sha256(), new Key($privateKey->getKeyPath(), $privateKey->getPassPhrase())); */
  }

  public function setPrivateKey(CryptKey $privateKey) {
    $this->privateKey = $privateKey;
  }

  public function __toString() {
    return (string) $this->convertToJWT($this->privateKey);
  }
}
