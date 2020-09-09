<?php


namespace Codwelt\SIMI\SDK\InfraStructure\Responses;

/**
 * Clase abstracta de la que tiene que extender todos los responses
 * Class ResponseRepository
 * @package Codwelt\SIMI\SDK\InfraStructure\Responses
 * @author Juan Diaz <iam@furiosojack.com>
 */
abstract class ResponseRepository
{
    /**
     *
     * @var string|null
     */
    private $responseRaw;

    /**
     * Es el contenido del body en forma de aray
     * @var array|null
     */
    protected $responseArray;

    /**
     * @param string $responderaw
     */
    public function __contruct(string $responderaw)
    {
        $this->responseRaw = $responderaw;
        $this->responseArray = json_encode($this->responseRaw,true);
    }

    /**
     * Se encarga de validar si el body tiene una estructura ARRAY  valida
     * @return bool
     */
    public function isBodySuccess()
    {
        if(empty($this->responseRaw) && is_array($this->responseArray)){
            return false;
        }
        return true;
    }

    /**
     * Se encarga validar y devuelve si la transaccion fue satisfactoria
     * @return bool
     */
    public function isSuccess():bool
    {
        if(!$this->isBodySuccess()){
            return false;
        }
        return !isset($this->responseArray["status"]) || $this->responseArray["status"]  == 200;
    }

    /**
     * Devuelve el contenido del body
     * @return array|null
     */
    public function getBody()
    {
        return $this->responseArray;
    }

}