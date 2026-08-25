<?php


namespace Homlity\SIMI\SDK\InfraStructure\Responses;

/**
 * Class ResponseDetalleInmueble
 * @package Homlity\SIMI\SDK\InfraStructure\Responses
 * @author Juan Diaz <iam@furiosojack.com>
 */
class ResponseDetalleInmueble extends ResponseRepository
{

    public function isSuccess():bool
    {
        $parent = parent::isSuccess();
        if(!$parent){
            return false;
        }
        if(is_array($this->responseArray)){
            return count($this->responseArray) > 3;
        }
        return false;
    }

    /**
     * Devuelve la informacion del inmueble
     * @return array
     */
    public function inmueble()
    {
        if($this->isSuccess()){
            $response = $this->responseArray;
            return $response["infoAdd"];
        }
    }


}