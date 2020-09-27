<?php


namespace Codwelt\SIMI\SDK\Tests\InsfraStructure;

use Codwelt\SIMI\SDK\InfraStructure\API\ApiFachada;
use Codwelt\SIMI\SDK\Tests\TestCase;

/**
 * Class RequestTest
 * @package Codwelt\SIMI\SDK\Tests\InsfraStructure
 * @author Juan Diaz <iam@furiosojack.com>
 */
class RequestHTTPTest extends TestCase
{

    public function test_checkToken()
    {

        $api = new ApiFachada(getenv("token-simi"));
        $inmuebles = $api->getInmuebles();
        $this->assertIsArray($inmuebles);
    }

    public function test_getDepartamentos()
    {
        $api = new ApiFachada(getenv("token-simi"));
        $departamentos = $api->getDepartamentos();

        $this->assertIsArray($departamentos);
    }

    public function test_getCiudades()
    {
        $api = new ApiFachada(getenv("token-simi"));
        $ciudades = $api->getCiudades("11012");
        $this->assertIsArray($ciudades);
    }

    public function test_getBarrios()
    {
        $api = new ApiFachada(getenv("token-simi"));
        $barrios = $api->getBarrios("25960");
        $this->assertIsArray($barrios);
    }

}