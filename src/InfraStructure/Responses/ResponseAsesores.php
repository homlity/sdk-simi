<?php


namespace Codwelt\SIMI\SDK\InfraStructure\Responses;

/**
 * Class ResponseAsesores
 * @package Codwelt\SIMI\SDK\InfraStructure\Responses
 * @author Juan Diaz <iam@furiosojack.com>
 */
class ResponseAsesores extends ResponseRepository
{

    /**
     * @return array|null
     */
    public function asesores()
    {
        if($this->isSuccess()){
            return $this->responseArray["listAsesor"];
        }
    }

    public function paginacion()
    {
        if($this->isSuccess()){
            return $this->responseArray["datosGrales"];
        }
    }
}