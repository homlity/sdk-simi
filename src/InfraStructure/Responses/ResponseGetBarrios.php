<?php


namespace Codwelt\SIMI\SDK\InfraStructure\Responses;

/**
 * Class ResponseGetBarrios
 * @package Codwelt\SIMI\SDK\InfraStructure\Responses
 * @author Juan Diaz <iam@furiosojack.com>
 */
class ResponseGetBarrios extends ResponseRepository
{
    public function barrios()
    {
        if($this->isSuccess()){
            return $this->responseArray;
        }
    }

}