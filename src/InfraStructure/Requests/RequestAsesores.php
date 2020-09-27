<?php


namespace Codwelt\SIMI\SDK\InfraStructure\Requests;

use Codwelt\SIMI\SDK\InfraStructure\Responses\ResponseAsesores;
use Codwelt\SIMI\SDK\InfraStructure\Responses\ResponseRepository;

/**
 * Class RequestAsesores
 * @package Codwelt\SIMI\SDK\InfraStructure\Requests
 * @author Juan Diaz <iam@furiosojack.com>
 */
class RequestAsesores extends HttpClient
{

    /**
     * @param array $parameters
     * @return ResponseAsesores
     * @throws \Exception
     */
    public function ejecutar(array $parameters = []): ResponseRepository
    {
        $url = "usuarios";

        $permitidos = [
            "limite",
            "cantidad",
            "asesor"
        ];
        foreach ($parameters as $filter => $value){

            if(!in_array($filter,$permitidos)){
                throw new \Exception("Filtro ($filter) no esta permitido en APISIMI");
            }
        }

        $default = [
            "cantidad" => 30,
            "limite" => 1
        ];

        $filtros = array_merge($default,$parameters);
        $valores = "";

        foreach ($filtros as $filtroK => $value){
            $valores =  $valores. "/".$filtroK . "/" .$value;
        }


        $this->endPoint = $url.$valores;


        return new ResponseAsesores($this->send());
    }
}