<?php


namespace Homlity\SIMI\SDK\Tests\InsfraStructure;

use Homlity\SIMI\SDK\InfraStructure\API\ApiFachada;
use Homlity\SIMI\SDK\Tests\TestCase;

/**
 * Class ApiFachadaTets
 * @package Homlity\SIMI\SDK\Tests\InsfraStructure
 * @author Juan Diaz <iam@furiosojack.com>
 */
class ApiFachadaTest extends TestCase
{

    public function test_checkToken()
    {
        $api = new ApiFachada("123456");

        $this->assertEquals("123456",$api->getToken());
    }

}