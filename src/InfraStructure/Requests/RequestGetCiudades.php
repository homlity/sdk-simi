<?php


namespace Codwelt\SIMI\SDK\InfraStructure\Requests;

use Codwelt\SIMI\SDK\InfraStructure\Responses\ResponseGetCiudades;
use Codwelt\SIMI\SDK\InfraStructure\Responses\ResponseRepository;

/**
 * Class RequestGetCiudades
 * @package Codwelt\SIMI\SDK\InfraStructure\Requests
 * @author Juan Diaz <iam@furiosojack.com>
 */
class RequestGetCiudades extends HttpClient
{

    /**
     * @param array $parameters
     * @return ResponseGetCiudades
     * @throws \Exception
     */
    public function ejecutar(array $parameters): ResponseRepository
    {
        if(empty($parameters["idDepartamento"])){
            throw new \Exception("El id del departemento es necesario para obtener las ciudades");
        }
        $this->endPoint = "v2/ciudad/idDepartamento/".$parameters["idDepartamento"];
        return new ResponseGetCiudades($this->send());
    }
}