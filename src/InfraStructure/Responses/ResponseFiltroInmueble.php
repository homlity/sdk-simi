<?php


namespace Codwelt\SIMI\SDK\InfraStructure\Responses;

/**
 * Class ResponseFiltroInmueble
 * @package Codwelt\SIMI\SDK\InfraStructure\Responses
 * @author Juan Diaz <iam@furiosojack.com>
 */
class ResponseFiltroInmueble extends ResponseRepository
{



    /**
     * Devuelve la lista de inmuebles
     * @return array|null
     */
    public function inmuebles()
    {
        if($this->isSuccess()){

            return $this->responseArray["Inmuebles"];
        }
    }

    /**
     * @return array|null
     */
    public function paginacion()
    {
        if($this->isSuccess()){
            return $this->responseArray["datosGrales"];
        }
    }

    /**
     * Devuelve la descripcion de la peticion
     * @return string
     */
    public function descripcion()
    {
        if($this->isSuccess()){
            return $this->responseArray["description"];
        }
        return "";
    }
}