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

    public function descripcion()
    {
        return $this->caracteristicaRaw["Descripcion"];
    }

}