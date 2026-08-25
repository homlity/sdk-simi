<?php
namespace Homlity\SIMI\SDK\Tests\InsfraStructure;
use Homlity\SIMI\SDK\InfraStructure\API\ApiFachada;
use Homlity\SIMI\SDK\InfraStructure\Requests\RequestEstadoInmuebles;
use Homlity\SIMI\SDK\Tests\TestCase;

/**
 * Class RequestTest
 * @package Homlity\SIMI\SDK\Tests\InsfraStructure
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

    public function test_inmueblesDestacados()
    {
        $api = new ApiFachada(getenv("token-simi"));
        $barrios = $api->getInmueblesDestacados();

        $this->assertIsArray($barrios);
    }

    public function test_asesores()
    {
        $api = new ApiFachada(getenv("token-simi"));
        $asesores = $api->getAsesores();
        $this->assertIsArray($asesores["asesores"]);
    }

    public function test_tipoInmueble()
    {
        $api = new ApiFachada(getenv("token-simi"));
        $tiposINmueble = $api->getTiposInmueble();
        $this->assertIsArray($tiposINmueble);
    }

    public function test_gestionInmueble()
    {
        $api = new ApiFachada(getenv("token-simi"));
        $tiposGestion = $api->getGestionesInmueble();
        var_dump($tiposGestion);
    }

    public function test_request_estadoInmuebles()
    {

        $request = new RequestEstadoInmuebles(getenv("token-simi"));


        $estado = 2;
        $gestion = 2;

        $respuesta = $request->ejecutar([
            "estado" => $estado,
            "gestion" => $gestion
        ]);

        $url = "https://api.simicrm.app/crm/inmuebles?estado=".$estado."&gestion=".$gestion;



        $this->assertEquals($url,$request->getUrlConstruida());

        $this->assertTrue($respuesta->isSuccess());

       // $this->assertIsArray($respuesta);

        var_dump($respuesta->getBody());
    }

    public function test_request_detalle_inmueble_admon_incluida()
    {

        $api = new ApiFachada(getenv("token-simi"));
        $inmueble = $api->getDetalleInmueble(getenv("property-detail-code"));
        var_dump($inmueble->administracionIncluida());
    }

    public function test_request_detalle_inmueble_get_asesor()
    {

        $api = new ApiFachada(getenv("token-simi"));
        $inmueble = $api->getDetalleInmueble(getenv("property-detail-code"));
        
        $asesor = $inmueble->asesor();
        var_dump($asesor);
        $this->assertNotEmpty($asesor->nombre());
        $this->assertNotEmpty($asesor->celular());
        $this->assertNotEmpty($asesor->email());
    }


}