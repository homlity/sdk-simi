<?php
namespace Codwelt\SIMI\SDK\InfraStructure\API;
use Codwelt\SIMI\SDK\InfraStructure\Modelos\Barrio;
use Codwelt\SIMI\SDK\InfraStructure\Modelos\Ciudad;
use Codwelt\SIMI\SDK\InfraStructure\Modelos\Departamento;
use Codwelt\SIMI\SDK\InfraStructure\Modelos\InmuebleDetail;
use Codwelt\SIMI\SDK\InfraStructure\Modelos\InmueblePreview;
use Codwelt\SIMI\SDK\InfraStructure\Modelos\PaginadorPreview;
use Codwelt\SIMI\SDK\InfraStructure\Requests\RequestDetalleInmueble;
use Codwelt\SIMI\SDK\InfraStructure\Requests\RequestFiltroInmuebles;
use Codwelt\SIMI\SDK\InfraStructure\Requests\RequestGetBarrios;
use Codwelt\SIMI\SDK\InfraStructure\Requests\RequestGetCiudades;
use Codwelt\SIMI\SDK\InfraStructure\Requests\RequestGetDepartamentos;

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
        $request = new RequestFiltroInmuebles($this->token);
        $response = $request->ejecutar($filters);
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
        $request = new RequestDetalleInmueble($this->token);
        $response = $request->ejecutar([
            "codigo" => $codigoInmueble
        ]);
        if($response->isSuccess()){
            return new InmuebleDetail($response->getBody());
        }
        return null;

    }

    /**
     * Devuelve todos los departamentos de la inmobiliaria
     * un array de objetos Departamento
     * @return array
     * @throws \Exception
     */
    public function getDepartamentos()
    {
        $request = new RequestGetDepartamentos($this->token);
        $response = $request->ejecutar([]);

        $deparmentosArray = $response->departamentos();

        $deparmentos = [];
        foreach ($deparmentosArray as $departamento){
            $deparmentos[] = new Departamento($departamento);
        }
        return $deparmentos;
    }

    public function getCiudades($idDepartamento)
    {
        $request = new RequestGetCiudades($this->token);
        $response = $request->ejecutar([
            "idDepartamento" => $idDepartamento
        ]);

        $ciudadesArray = $response->ciudades();

        $ciudades = array();

        foreach ($ciudadesArray as $ciudad){
            $ciudades[] = new Ciudad($ciudad);
        }

        return $ciudades;
    }

    public function getBarrios($idCiudad)
    {
        $request = new RequestGetBarrios($this->token);
        $response = $request->ejecutar([
            "idCiudad" => $idCiudad
        ]);

        $barriosArray = $response->barrios();

        $barrios = array();

        foreach ($barriosArray as $barrio){
            $barrios[] = new Barrio($barrio);
        }

        return $barrios;
    }







}