<?php


namespace Homlity\SIMI\SDK\InfraStructure\Modelos;

/**
 * Class PaginadorAsesores
 * @package Homlity\SIMI\SDK\InfraStructure\Modelos
 * @author Juan Diaz <iam@furiosojack.com>
 */
class PaginadorAsesores
{
    protected $paginadorRaw;

    public function __construct(array $paginadorRaw)
    {
        $this->paginadorRaw = $paginadorRaw;
    }

    public function paginaActual()
    {
        return (int)$this->paginadorRaw["pagina_actual"];
    }

    public function numeroPaginaFin()
    {
        return (int)$this->paginadorRaw["fin"];
    }

    public function numeroPaginaInicio()
    {
        return (int)$this->paginadorRaw["inicio"];
    }
    /**
     * NUmero total de inmuebles en la pagina actual
     * @return mixed
     */
    public function total()
    {
        return (int)$this->paginadorRaw["totalAsesores"];
    }

    public function totalPorPagina()
    {
        return (int)$this->paginadorRaw["mostrarPagina"];
    }

}