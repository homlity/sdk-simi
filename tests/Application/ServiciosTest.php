<?php


namespace Homlity\SIMI\SDK\Tests\Application;

use Homlity\SIMI\SDK\Application\ObtenedorInmueblesSimilaresService;
use Homlity\SIMI\SDK\Domain\Providers\ApiServiceProvider;

use Homlity\SIMI\SDK\Tests\TestCase;

/**
 * Class ServiciosTest
 * @package Homlity\SIMI\SDK\Tests\Application
 * @author Juan Diaz <iam@furiosojack.com>
 */
class ServiciosTest extends TestCase
{


    public function test_InmublesSimilares()
    {
        $apiServiceProvider = ApiServiceProvider::build();
        $apiServiceProvider->setTokenProvider(new TokenServiceTestProvider());

        $obtenedorINmuebles = new ObtenedorInmueblesSimilaresService($apiServiceProvider->getAPI());

        $inmueblles = $obtenedorINmuebles->obtenerConCodigo("613-354");

      $this->assertIsArray($inmueblles);
    }
    

}

