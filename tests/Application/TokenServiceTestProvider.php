<?php


namespace Codwelt\SIMI\SDK\Tests\Application;

use Codwelt\SIMI\SDK\Domain\Providers\TokenServiceProviderRespository;

/**
 * Class TokenServiceTestProvider
 * @package Codwelt\SIMI\SDK\Tests\Application
 * @author Juan Diaz <iam@furiosojack.com>
 */
class TokenServiceTestProvider implements TokenServiceProviderRespository
{

    public function getToken(): string
    {
        return getenv("token-simi");
    }

}