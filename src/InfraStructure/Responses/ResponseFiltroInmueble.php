<?php


namespace Codwelt\SIMI\SDK\InfraStructure\Responses;

/**
 * Class ResponseFiltroInmueble
 * @package Codwelt\SIMI\SDK\InfraStructure\Responses
 * @author Juan Diaz <iam@furiosojack.com>
 */
class ResponseFiltroInmueble extends ResponseRepository
{

    public function inmuebles()
    {
        if($this->isSuccess()){
            return $this->responseArray["Inmuebles"];
        }
        return [];
    }

    public function paginacion()
    {
        if($this->isSuccess()){
            return $this->responseArray["datosGrales"];
        }
        return null;
    }
}