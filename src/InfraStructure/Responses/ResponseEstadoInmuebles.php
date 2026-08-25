<?php


namespace Homlity\SIMI\SDK\InfraStructure\Responses;

/**
 * Class ResponseEstadoInmueble
 * @package Homlity\SIMI\SDK\InfraStructure\Responses
 * @author Don Juanc.Developer Instagram <@donjuanc.developer>
 */
class ResponseEstadoInmuebles extends ResponseRepository
{

    public function isSuccess(): bool
    {
        if(!$this->isBodySuccess()){
            return false;
        }
        if(isset($this->responseArray["status_code"])){
            return false;
        }

        if(!isset($this->responseArray["data"])){
            return false;
        }
        return true;
    }

}