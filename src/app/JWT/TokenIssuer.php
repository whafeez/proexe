<?php
namespace App\JWT;
use Lcobucci\JWT\Token\Builder;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\Configuration;

/**
 * 
 */
class TokenIssuer
{

    private Configuration $configuration;
    
    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }
    
    public function issueToken(){
      $token = $this->configuration->builder()
                      // Configures the issuer (iss claim)
                      ->issuedBy('http://example.com')
                      ->withClaim('uid', 1)
                      ->withHeader('foo', 'bar')
                      ->getToken($this->configuration->signer(), $this->configuration->signingKey());
      return $token->toString();
        }
}
