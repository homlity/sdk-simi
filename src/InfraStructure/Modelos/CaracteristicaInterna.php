<?php


namespace Codwelt\SIMI\SDK\InfraStructure\Modelos;

/**
 * Class CaracteristicaInterna
 * @package Codwelt\SIMI\SDK\InfraStructure\Modelos
 * @author Juan Diaz <iam@furiosojack.com>
 */
class CaracteristicaInterna
{
    public $caracteristicaRaw;

    public function __construct(array $caracteristicaRaw)
    {
        $this->caracteristicaRaw = $caracteristicaRaw;
    }

    public function id()
    {
        return $this->caracteristicaRaw["idcaracteristica"];
    }
    
    public function descripcion()
    {
        return $this->caracteristicaRaw["Descripcion"];
    }

    public function cantidad()
    {
        return $this->caracteristicaRaw["cantidad"];
    }

    public function observacion()
    {
        return $this->caracteristicaRaw["obser_det"];
    }

}