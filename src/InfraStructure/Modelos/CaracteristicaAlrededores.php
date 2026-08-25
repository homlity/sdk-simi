<?php


namespace Homlity\SIMI\SDK\InfraStructure\Modelos;

/**
 * Class CaracteristicaAlrededores
 * @package Homlity\SIMI\SDK\Domain\Modelos
 * @author Juan Diaz <iam@furiosojack.com>
 */
class CaracteristicaAlrededores
{

    private $caracteristicaRaw;

    public function __construct(array $caracteristicaRaw)
    {
        $this->caracteristicaRaw = $caracteristicaRaw;
    }

    public function id()
    {
        return $this->caracteristicaRaw["idcaracteristica"];
    }

    public function cantidad()
    {
        return $this->caracteristicaRaw["cantidad"];
    }

    public function descripcion()
    {
        return $this->caracteristicaRaw["Descripcion"];
    }

    public function observacion()
    {
        return $this->caracteristicaRaw["obser_det"];
    }
}