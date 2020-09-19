<?php


namespace Codwelt\SIMI\SDK\InfraStructure\Modelos;

/**
 * Class CaracteristicaAlrededores
 * @package Codwelt\SIMI\SDK\Domain\Modelos
 * @author Juan Diaz <iam@furiosojack.com>
 */
class CaracteristicaAlrededores
{

    private $caracteristicaRaw;

    public function __construct(array $caracteristicaRaw)
    {
        $this->caracteristicaRaw = $caracteristicaRaw;
    }

    public function cantidad()
    {
        return $this->caracteristicaRaw["cantidad"];
    }

    public function descripcion()
    {
        return $this->caracteristicaRaw["Descripcion"];
    }
}