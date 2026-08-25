<?php


namespace Homlity\SIMI\SDK\InfraStructure\Requests;

use Homlity\SIMI\SDK\InfraStructure\Responses\ResponseRepository;
use Homlity\SIMI\SDK\InfraStructure\Responses\ResponseTipoInmueble;

/**
 * Class RequestTipoInmueble
 * @package Homlity\SIMI\SDK\InfraStructure\Requests
 * @author Juan Diaz <iam@furiosojack.com>
 */
class RequestTipoInmueble extends HttpClient
{

    /**
     * @param array $parameters
     * @return ResponseTipoInmueble
     * @throws \Exception
     */
    public function ejecutar(array $parameters = []): ResponseRepository
    {
        $this->endPoint = "v2/tipoInmuebles/unique/1";

        return new ResponseTipoInmueble($this->send());
    }
}