<?php


namespace Codwelt\SIMI\SDK\InfraStructure\Responses;

/**
 * Class ResponseGetDepartamentos
 * @package Codwelt\SIMI\SDK\InfraStructure\Responses
 * @author Juan Diaz <iam@furiosojack.com>
 */
class ResponseGetDepartamentos extends ResponseRepository
{

    /**
     * @return array|null
     */
    public function departamentos()
    {

        if($this->isSuccess()){
            return $this->responseArray;
        }
    }

}