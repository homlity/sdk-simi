<?php


namespace Codwelt\SIMI\SDK\InfraStructure\Requests;

use Codwelt\SIMI\SDK\InfraStructure\Responses\ResponseDetalleInmueble;
use Codwelt\SIMI\SDK\InfraStructure\Responses\ResponseRepository;

/**
 * Class RequestDetalleInmueble
 * @package Codwelt\SIMI\SDK\InfraStructure\Requests
 * @author Juan Diaz <iam@furiosojack.com>
 */
class RequestDetalleInmueble extends HttpClient
{


    /**
     * @param string $url
     * @return ResponseDetalleInmueble
     * @throws \Exception
     */
    public function ejecutar(array $parameters = []): ResponseRepository
    {
        if(empty($parameters["codigo"])){
            throw new \Exception("El codigo del inmueble es requerido para obtener el detalle del inmueble");
        }

        $this->endPoint = "v2/inmueble/codInmueble/".$parameters["codigo"];
        return new ResponseDetalleInmueble($this->send());
    }
}