<?php


namespace Codwelt\SIMI\SDK\InfraStructure\Requests;

use Codwelt\SIMI\SDK\InfraStructure\Responses\ResponseGetDepartamentos;
use Codwelt\SIMI\SDK\InfraStructure\Responses\ResponseRepository;

/**
 * Class RequestGetDepartamentos
 * @package Codwelt\SIMI\SDK\InfraStructure\Requests
 * @author Juan Diaz <iam@furiosojack.com>
 */
class RequestGetDepartamentos extends HttpClient
{

    /**
     * @param string $endPoint
     * @return ResponseGetDepartamentos
     * @throws \Exception
     */
    public function ejecutar(string $endPoint): ResponseRepository
    {
        return new ResponseGetDepartamentos($this->sendGet($endPoint));
    }
}