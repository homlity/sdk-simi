<?php


namespace Codwelt\SIMI\SDK\Application;

use Codwelt\SIMI\SDK\Domain\API\ApiFachadaRepository;
use Codwelt\SIMI\SDK\InfraStructure\Modelos\InmuebleDetail;
use Codwelt\SIMI\SDK\Domain\Providers\ApiServiceProvider;
use Codwelt\SIMI\SDK\InfraStructure\Requests\RequestDetalleInmueble;

/**
 * Class ObtenedorInmueblesSimilaresService
 * @package Codwelt\SIMI\SDK\Application
 * @author Juan Diaz <iam@furiosojack.com>
 */
class ObtenedorInmueblesSimilaresService
{

    private $api;

    public function __construct(ApiFachadaRepository $api)
    {
        $this->api = $api;
    }

    /**
     * Devuelve la lista de inmuebles
     * @return array
     * @param InmuebleDetail $inmuebleDetail
     */
    public function obtener(InmuebleDetail $inmuebleDetail,int $cantidad = 4)
    {
        $inmueblesSimilares = $this->api->getInmuebles(array(
            "zona" => $inmuebleDetail->idZona(),
            "tipoInm" => $inmuebleDetail->idTipoInmueble(),
            "tipOper" => $inmuebleDetail->idGestion(),
            "total" => $cantidad
        ));

        $inmueblesSimilares = $inmueblesSimilares["inmuebles"];
        //AHora se elimina de ese array de inmuebles el inmueble que es el que se envia como detalle
        $inmueblesSimilares = array_filter($inmueblesSimilares,function($inmuebleDestacado) use($inmuebleDetail){
            return $inmuebleDetail->identificacion() != $inmuebleDestacado->identificacion();
        });

        $inmueblesSimilares = array_slice($inmueblesSimilares,0,($cantidad-1));
        return $inmueblesSimilares;
    }

    /**
     * @param string $codigoInmueble
     * @return array
     * @throws \Exception
     */
    public function obtenerConCodigo($codigoInmueble)
    {
        $detalleInmueble =$this->api->getDetalleInmueble($codigoInmueble);

        if($detalleInmueble == null){
            //para no generar excepcion mejor devolver nada
            return [];
        }

        return $this->obtener($detalleInmueble);

    }

}