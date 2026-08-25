<?php


namespace Homlity\SIMI\SDK\InfraStructure\Responses;

/**
 * Class ResponseGetCiudades
 * @package Homlity\SIMI\SDK\InfraStructure\Responses
 * @author Juan Diaz <iam@furiosojack.com>
 */
class ResponseGetCiudades extends ResponseRepository
{

    /**
     * @return array|null
     */
    public function ciudades()
    {
        if($this->isSuccess()){
            return $this->responseArray;
        }
    }

}