<?php
namespace Codwelt\SIMI\SDK\InfraStructure\API;
use Codwelt\SIMI\SDK\InfraStructure\Modelos\InmuebleDetail;
use Codwelt\SIMI\SDK\InfraStructure\Modelos\InmueblePreview;
use Codwelt\SIMI\SDK\InfraStructure\Modelos\PaginadorPreview;
use Codwelt\SIMI\SDK\InfraStructure\Requests\RequestDetalleInmueble;
use Codwelt\SIMI\SDK\InfraStructure\Requests\RequestFiltroInmuebles;

/**
 * Clase encargada de servir como intermediario entre la logica de negocio y los inmuebles
 * Class ApiV1
 * @package Codwelt\SIMI\SDK\InfraStructure\API
 * @author Juan Diaz <iam@furiosojack.com>
 */
class ApiFachada
{

    /**
     * @var
     */
    private $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * Devuelve el token del api
     * @return string
     */
    public function getToken()
    {
        return $this->token;
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

        $url = "v2.1.1/filtroInmueble".$valores;

        $request = new RequestFiltroInmuebles($this->token);
        $response = $request->ejecutar($url);
        $inmuebles = array();
        $paginador = null;

        if($response->isSuccess()) {
            $inmueblesRaw = $response->inmuebles();
            foreach ($inmueblesRaw as $inmueble){
                $inmuebles[] = new InmueblePreview($inmueble);
            }
            $paginador = new PaginadorPreview($response->paginacion());
        }
        return [
            "inmuebles" =>$inmuebles,
            "paginador" => $paginador
        ];
    }


    /**
     * Devuelve una instancia del objeto de detalle inmueble
     * o null si no existe
     * @param $codigoInmueble
     * @return InmuebleDetail | null
     * @throws \Exception
     */
    public function getDetalleInmueble($codigoInmueble)
    {
        $url = "v2/inmueble/codInmueble/".$codigoInmueble;

        $request = new RequestDetalleInmueble($this->token);
        $response = $request->ejecutar($url);

        if($response->isSuccess()){
            return new InmuebleDetail($response->getBody());
        }
        return null;

    }





}