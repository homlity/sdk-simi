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
     * @return array
     */
    public function inmuebles()
    {

        if($this->isSuccess()){

            return $this->responseArray["Inmuebles"];
        }
        return [];
    }

    /**
     * @return array|null
     */
    public function paginacion()
    {
        if($this->isSuccess()){
            return $this->responseArray["datosGrales"];
        }
        return null;
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