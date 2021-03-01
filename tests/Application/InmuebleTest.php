<?php


namespace Codwelt\SIMI\SDK\Tests\Application;

use Codwelt\SIMI\SDK\Domain\Providers\ApiServiceProvider;
use Codwelt\SIMI\SDK\InfraStructure\Modelos\InmuebleDetail;
use Codwelt\SIMI\SDK\Tests\TestCase;

/**
 * Class InmuebleTest
 * @package Codwelt\SIMI\SDK\Tests\Application
 * @author Juan Diaz <iam@furiosojack.com>
 */
class InmuebleTest extends TestCase
{

    public function test_inmueble_detalle_metodos()
    {

        $apiServiceProvider = ApiServiceProvider::build();
        $apiServiceProvider->setTokenProvider(new TokenServiceTestProvider());

        $api = $apiServiceProvider->getAPi();
        $inmueble = $api->getDetalleInmueble("58-1539");

        $this->assertInstanceOf(InmuebleDetail::class,$inmueble);


        $idTipoInmueble = $inmueble->idTipoInmueble();
        $this->assertIsNumeric($idTipoInmueble);
    }

    public function test_filtro_inmuebles_metodos()
    {
        $apiServiceProvider = ApiServiceProvider::build();
        $apiServiceProvider->setTokenProvider(new TokenServiceTestProvider());
        $api = $apiServiceProvider->getAPi();
        $inmuebles = $api->getInmuebles();

        foreach ($inmuebles["inmuebles"] as $inmueble){
            try {
                $inmueble->idTipoInmueble();
            }catch (\Exception $exception){
                var_dump($inmueble);
            }

        }
    }



}