<?php


namespace Homlity\SIMI\SDK\Tests\Application;

use Homlity\SIMI\SDK\Domain\Providers\TokenServiceProviderRespository;

/**
 * Class TokenServiceTestProvider
 * @package Homlity\SIMI\SDK\Tests\Application
 * @author Juan Diaz <iam@furiosojack.com>
 */
class TokenServiceTestProvider implements TokenServiceProviderRespository
{

    public function getToken(): string
    {
        return getenv("token-simi");
    }

}