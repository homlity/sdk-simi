<?php


namespace Homlity\SIMI\SDK\InfraStructure\Modelos;

/**
 * Class CaracteristicaExterna
 * @package Homlity\SIMI\SDK\Domain\Modelos
 * @author Juan Diaz <iam@furiosojack.com>
 */
class CaracteristicaExterna
{

    private $carecteristicaRaw;

    public function __construct(array $carecteristicaRaw)
    {
        $this->carecteristicaRaw = $carecteristicaRaw;
    }

    public function id()
    {
        return $this->carecteristicaRaw["idcaracteristica"];
    }

    public function descripcion()
    {
        return $this->carecteristicaRaw["Descripcion"];
    }

    public function cantidad()
    {
        return $this->carecteristicaRaw["cantidad"];
    }

    public function observacion()
    {
        return $this->carecteristicaRaw["obser_det"];
    }
}