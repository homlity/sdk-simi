<?php


namespace Codwelt\SIMI\SDK\InfraStructure\Requests;

use Codwelt\SIMI\SDK\InfraStructure\Responses\ResponseFiltroInmueble;

/**
 * Es la peticion que se engenera para solicitar los inmuebles
 * Class RequestFiltroInmuebles
 * @package Codwelt\SIMI\SDK\InfraStructure\Requests
 * @author Juan Diaz <iam@furiosojack.com>
 */
class RequestFiltroInmuebles extends HttpClient
{
    /**
     * @var string
     */
    protected $responseClass = ResponseFiltroInmueble::class;

}