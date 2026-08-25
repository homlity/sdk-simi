<?php


namespace Homlity\SIMI\SDK\Domain\API;

use Homlity\SIMI\SDK\InfraStructure\Modelos\InmuebleDetail;

/**
 * Class ApiFachadaRepository
 * @package Homlity\SIMI\SDK\InfraStructure\API\Repository
 * @author Juan Diaz <iam@furiosojack.com>
 */
abstract class ApiFachadaRepository
{

    /**
     * @var
     */
    protected $token;

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
    public abstract function getInmuebles(array $filters = array());

    /**
     * Devuelve una instancia del objeto de detalle inmueble
     * o null si no existe
     * @param $codigoInmueble
     * @return InmuebleDetail | null
     * @throws \Exception
     */
    public abstract function getDetalleInmueble($codigoInmueble);

    /**
     * Devuelve todos los departamentos de la inmobiliaria
     * un array de objetos Departamento
     * @return array
     * @throws \Exception
     */
    public abstract function getDepartamentos();

    /**
     * @param $idDepartamento
     * @return array
     * @throws \Exception
     */
    public abstract function getCiudades($idDepartamento);

    /**
     * @param $idCiudad
     * @return array
     * @throws \Exception
     */
    public abstract function getBarrios($idCiudad);


    /**
     * Devuelve le listado de inmuebles detacados
     * @param array $filtros
     * @return array
     * @throws \Exception
     */
    public abstract function getInmueblesDestacados(array $filtros = []);


    public abstract function getAsesores(array $filtros = []);

    public abstract function getTiposInmueble();

    public abstract function getGestionesInmueble();



}