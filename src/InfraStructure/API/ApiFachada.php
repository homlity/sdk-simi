<?php
namespace Codwelt\SIMI\SDK\InfraStructure\API;

use Codwelt\SIMI\SDK\Domain\API\ApiFachadaRepository;
use Codwelt\SIMI\SDK\InfraStructure\Modelos\AsesorDetalleInmueble;
use Codwelt\SIMI\SDK\InfraStructure\Modelos\AsesorUsuario;
use Codwelt\SIMI\SDK\InfraStructure\Modelos\Barrio;
use Codwelt\SIMI\SDK\InfraStructure\Modelos\Ciudad;
use Codwelt\SIMI\SDK\InfraStructure\Modelos\Departamento;
use Codwelt\SIMI\SDK\InfraStructure\Modelos\GestionInmueble;
use Codwelt\SIMI\SDK\InfraStructure\Modelos\InmuebleDetail;
use Codwelt\SIMI\SDK\InfraStructure\Modelos\InmueblePreview;
use Codwelt\SIMI\SDK\InfraStructure\Modelos\PaginadorAsesores;
use Codwelt\SIMI\SDK\InfraStructure\Modelos\PaginadorInmueblePreview;
use Codwelt\SIMI\SDK\InfraStructure\Modelos\TipoInmueble;
use Codwelt\SIMI\SDK\InfraStructure\Requests\RequestAsesores;
use Codwelt\SIMI\SDK\InfraStructure\Requests\RequestDetalleInmueble;
use Codwelt\SIMI\SDK\InfraStructure\Requests\RequestFiltroInmuebles;
use Codwelt\SIMI\SDK\InfraStructure\Requests\RequestGetBarrios;
use Codwelt\SIMI\SDK\InfraStructure\Requests\RequestGetCiudades;
use Codwelt\SIMI\SDK\InfraStructure\Requests\RequestGetDepartamentos;
use Codwelt\SIMI\SDK\InfraStructure\Requests\RequestGetGestionInmueble;
use Codwelt\SIMI\SDK\InfraStructure\Requests\RequestGetInmueblesDestacados;
use Codwelt\SIMI\SDK\InfraStructure\Requests\RequestTipoInmueble;

/**
 * Clase encargada de servir como intermediario entre la logica de negocio y los inmuebles
 * Class ApiV1
 * @package Codwelt\SIMI\SDK\InfraStructure\API
 * @author Juan Diaz <iam@furiosojack.com>
 */
class ApiFachada extends ApiFachadaRepository
{



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
            $paginador = new PaginadorInmueblePreview($response->paginacion());
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

    /**
     * @param $idDepartamento
     * @return array
     * @throws \Exception
     */
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

    /**
     * @param $idCiudad
     * @return array
     * @throws \Exception
     */
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


    /**
     * Devuelve le listado de inmuebles detacados
     * @param array $filtros
     * @return array
     * @throws \Exception
     */
    public function getInmueblesDestacados(array $filtros = [])
    {
        $request = new RequestGetInmueblesDestacados($this->token);
        $response = $request->ejecutar($filtros);

        $inmuebles = [];
        $paginador = null;
        if($response->isSuccess()){
            foreach ($response->inmuebles() as $inmueble){
                $inmuebles[] = new InmueblePreview($inmueble);
            }
            $paginador = new PaginadorInmueblePreview($response->paginacion());
        }

        return array(
            "inmuebles" => $inmuebles,
            "paginador" => $paginador
        );
    }


    public function getAsesores(array $filtros = [])
    {
        $request = new RequestAsesores($this->token);
        $response = $request->ejecutar($filtros);

        $asesores = [];
        $paginador = null;
        if($response->isSuccess()){
            foreach ($response->asesores() as $asesor){
                $asesores[] = new AsesorUsuario($asesor);
            }
            $paginador = new PaginadorAsesores($response->paginacion());
        }

        return [
            "asesores" => $asesores,
            "paginador" => $paginador
        ];
    }

    public function getTiposInmueble()
    {
        $request = new RequestTipoInmueble($this->token);
        $response = $request->ejecutar([]);


        $tipos = [];
        if($response->isSuccess()){
            foreach ($response->tiposInmueble() as $tipo){
                $tipos[] = new TipoInmueble($tipo);
            }
        }

        return $tipos;
    }

    public function getGestionesInmueble()
    {
        $request = new RequestGetGestionInmueble($this->token);
        $response = $request->ejecutar([]);

        $gestions  = [];
        if($response->isSuccess()){
            foreach ($response->gestiones() as $gestion){
                $gestions[] = new GestionInmueble($gestion);
            }
        }
        return $gestions;
    }


}