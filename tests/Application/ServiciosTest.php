<?php


namespace Codwelt\SIMI\SDK\Tests\Application;

use Codwelt\SIMI\SDK\Application\ObtenedorInmueblesSimilaresService;
use Codwelt\SIMI\SDK\Domain\Providers\ApiServiceProvider;
use Codwelt\SIMI\SDK\Domain\Providers\TokenServiceProviderRespository;
use Codwelt\SIMI\SDK\Tests\TestCase;

/**
 * Class ServiciosTest
 * @package Codwelt\SIMI\SDK\Tests\Application
 * @author Juan Diaz <iam@furiosojack.com>
 */
class ServiciosTest extends TestCase
{

    public function __construct(string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

    }

    public function test_InmublesSimilares()
    {
        $apiServiceProvider = ApiServiceProvider::build();
        $apiServiceProvider->setTokenProvider(new TokenServiceTestProvider());

        $obtenedorINmuebles = new ObtenedorInmueblesSimilaresService($apiServiceProvider->getAPI());

        $inmueblles = $obtenedorINmuebles->obtenerConCodigo("613-354");

      $this->assertIsArray($inmueblles);
    }
    

}


class TokenServiceTestProvider implements TokenServiceProviderRespository
{

    public function getToken(): string
    {
       return getenv("token-simi");
    }
}