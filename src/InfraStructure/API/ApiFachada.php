<?php


namespace Codwelt\SIMI\SDK\InfraStructure\API;

use Codwelt\SIMI\SDK\InfraStructure\Modelos\InmueblePreview;
use Codwelt\SIMI\SDK\InfraStructure\Requests\RequestFiltroInmuebles;

/**
 * Class ApiV1
 * @package Codwelt\SIMI\SDK\InfraStructure\API
 * @author Juan Diaz <iam@furiosojack.com>
 */
class ApiFachada
{
    /**
     * @var
     */
    private $urlBase;

    /**
     * @var
     */
    private $token;

    public function __construct(string $token)
    {
        $this->token = $token;
        $this->urlBase = "http://simi-api.com/ApiSimiweb/response/";
    }


    /**
     * Devuelve un array de inmueble Preview
     * @param array $filters
     * @return array
     * @throws \Exception
     */
    public function getInmuebles(array $filters = array())
    {
        $permitidos = array(
            "departamento",
            "ciudad",
            "zona",
            "barrio",
            "tipoInm",
            "tipOper",
            "areamin",
            "areamax",
            "valmin",
            "valmax",
            "banios",
            "garajes",
            "alcobas",
            //ordenar
            "order",
            "campo",
            //limites
            "limite",
            "cantidad"
        );

        foreach ($filters as $filter => $value){

            if(!in_array($filter,$permitidos)){
                throw new \Exception("Filtro ($filter) no esta permitido en APISIMI");
            }
        }

        $default = [
            "cantidad" => 30,
            "limite" => 1
        ];

        $filtros = array_merge($default,$filters);


        $valores = "";

        foreach ($filtros as $filtroK => $value){
            $valores =  $valores. "/".$filtroK . "/" .$value;
        }

        $url = $this->urlBase."v2.1.1/filtroInmueble".$valores;

        $request = new RequestFiltroInmuebles($this->token);
        $response = $request->ejecutar($url);
        $inmuebles = array();

        if($response->isSuccess()) {
            $inmueblesRaw = $response->inmueble();
            foreach ($inmueblesRaw as $inmueble){
                $inmuebles[] = new InmueblePreview($inmueble);
            }
        }
        return $inmuebles;
    }





}