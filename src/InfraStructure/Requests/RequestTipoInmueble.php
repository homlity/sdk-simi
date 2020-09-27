<?php


namespace Codwelt\SIMI\SDK\InfraStructure\Requests;

use Codwelt\SIMI\SDK\InfraStructure\Responses\ResponseRepository;
use Codwelt\SIMI\SDK\InfraStructure\Responses\ResponseTipoInmueble;

/**
 * Class RequestTipoInmueble
 * @package Codwelt\SIMI\SDK\InfraStructure\Requests
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