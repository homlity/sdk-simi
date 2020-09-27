<?php


namespace Codwelt\SIMI\SDK\InfraStructure\Requests;

use Codwelt\SIMI\SDK\InfraStructure\Responses\ResponseGetGestionInmueble;
use Codwelt\SIMI\SDK\InfraStructure\Responses\ResponseRepository;

/**
 * Class RequestGetGestionInmueble
 * @package Codwelt\SIMI\SDK\InfraStructure\Requests
 * @author Juan Diaz <iam@furiosojack.com>
 */
class RequestGetGestionInmueble extends HttpClient
{

    /**
     * @param array $parameters
     * @return ResponseGetGestionInmueble
     * @throws \Exception
     */
    public function ejecutar(array $parameters = []): ResponseRepository
    {
        $this->endPoint = "gestion";
        return new ResponseGetGestionInmueble($this->send());
    }
}