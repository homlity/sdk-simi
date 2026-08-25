<?php


namespace Homlity\SIMI\SDK\InfraStructure\Requests;

use Homlity\SIMI\SDK\InfraStructure\Responses\ResponseGetDepartamentos;
use Homlity\SIMI\SDK\InfraStructure\Responses\ResponseRepository;

/**
 * Class RequestGetDepartamentos
 * @package Homlity\SIMI\SDK\InfraStructure\Requests
 * @author Juan Diaz <iam@furiosojack.com>
 */
class RequestGetDepartamentos extends HttpClient
{

    /**
     * @param array $parameters
     * @return ResponseGetDepartamentos
     * @throws \Exception
     */
    public function ejecutar(array $parameters = []): ResponseRepository
    {
        $this->endPoint = "v2/departamento";
        return new ResponseGetDepartamentos($this->send());
    }
}