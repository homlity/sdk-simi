<?php


namespace Homlity\SIMI\SDK\InfraStructure\Responses;

/**
 * Class ResponseTipoInmueble
 * @package Homlity\SIMI\SDK\InfraStructure\Responses
 * @author Juan Diaz <iam@furiosojack.com>
 */
class ResponseTipoInmueble extends ResponseRepository
{

    /**
     * @return array|null
     */
    public function tiposInmueble()
    {
        if($this->isSuccess()){
            return $this->responseArray;
        }
    }

}