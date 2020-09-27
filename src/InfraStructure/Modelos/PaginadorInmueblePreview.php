<?php
namespace Codwelt\SIMI\SDK\InfraStructure\Modelos;

/**
 * Class Paginador
 * @package Codwelt\SIMI\SDK\InfraStructure\Modelos
 * @author Juan Diaz <iam@furiosojack.com>
 */
class PaginadorInmueblePreview
{
    private $paginacionArray;

    /**
     * PaginadorInmueblesSimi constructor.
     * @param $paginacionRaw
     */
    public function __construct($paginacionRaw)
    {
        $this->paginacionArray = $paginacionRaw;
    }

    public function paginaActual()
    {
        return (int)$this->paginacionArray["pagina_actual"];
    }

    public function numeroPaginaFin()
    {
        return (int)$this->paginacionArray["fin"];
    }

    public function numeroPaginaInicio()
    {
        return (int)$this->paginacionArray["inicio"];
    }

    public function numeroPorPagina()
    {
        return (int)$this->paginacionArray["totalPagina"];
    }

    /**
     * NUmero total de inmuebles en la pagina actual
     * @return mixed
     */
    public function totalInmuebles()
    {
        return (int)$this->paginacionArray["totalInmuebles"];
    }

    public function totalPorPagina()
    {
        return (int)$this->paginacionArray["totalPagina"];
    }

}