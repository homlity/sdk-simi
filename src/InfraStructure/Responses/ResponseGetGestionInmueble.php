<?php


namespace Homlity\SIMI\SDK\InfraStructure\Responses;

/**
 * Class ResponseGetGestionInmueble
 * @package Homlity\SIMI\SDK\InfraStructure\Responses
 * @author Juan Diaz <iam@furiosojack.com>
 */
class ResponseGetGestionInmueble extends ResponseRepository
{
    /**
     * @return array|null
     */
    public function gestiones()
    {
        if($this->isSuccess()){
            return $this->responseArray;
        }
    }
}