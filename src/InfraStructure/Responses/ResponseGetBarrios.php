<?php


namespace Homlity\SIMI\SDK\InfraStructure\Responses;

/**
 * Class ResponseGetBarrios
 * @package Homlity\SIMI\SDK\InfraStructure\Responses
 * @author Juan Diaz <iam@furiosojack.com>
 */
class ResponseGetBarrios extends ResponseRepository
{
    /**
     * @return array|null
     */
    public function barrios()
    {
        if($this->isSuccess()){
            return $this->responseArray;
        }
    }

}