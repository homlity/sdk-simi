<?php
namespace Homlity\SIMI\SDK\InfraStructure\Requests;

use Homlity\SIMI\SDK\InfraStructure\Responses\ResponseGetInmueblesDestacados;
use Homlity\SIMI\SDK\InfraStructure\Responses\ResponseRepository;

/**
 * Class RequestGetInmueblesDestacados
 * @package Homlity\SIMI\SDK\InfraStructure\Requests
 * @author Juan Diaz <iam@furiosojack.com>
 */
class RequestGetInmueblesDestacados extends HttpClient
{

    /**
     * @param array $parameters
     * @return ResponseGetInmueblesDestacados
     * @throws \Exception
     */
    public function ejecutar(array $parameters = []): ResponseRepository
    {
        $permitidos = array(
            //limites
            "limite",
            "total"
        );


        foreach ($parameters as $filter => $value){

            if(!in_array($filter,$permitidos)){
                throw new \Exception("Filtro ($filter) no esta permitido en APISIMI");
            }
        }
        $url = "v21/inmueblesDestacados";
        $valores = "";
        foreach ($parameters as $filtroK => $value){
            $valores =  $valores. "/".$filtroK . "/" .$value;
        }
        $this->endPoint = $url . $valores;

        return new ResponseGetInmueblesDestacados($this->send());

    }
}