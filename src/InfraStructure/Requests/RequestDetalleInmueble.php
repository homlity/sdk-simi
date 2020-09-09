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
    protected $responseClass = ResponseDetalleInmueble::class;

    /**
     * @param string $url
     * @return ResponseRepository
     * @throws \Exception
     */
    public function ejecutar(string $url): ResponseRepository
    {
        parent::sendGet($url);
    }
}