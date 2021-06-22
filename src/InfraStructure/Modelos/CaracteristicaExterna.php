<?php


namespace Codwelt\SIMI\SDK\InfraStructure\Modelos;

/**
 * Class CaracteristicaExterna
 * @package Codwelt\SIMI\SDK\Domain\Modelos
 * @author Juan Diaz <iam@furiosojack.com>
 */
class CaracteristicaExterna
{

    private $carecteristicaRaw;

    public function __construct(array $carecteristicaRaw)
    {
        $this->carecteristicaRaw = $carecteristicaRaw;
    }

    public function descripcion()
    {
        return $this->carecteristicaRaw["Descripcion"];
    }

    public function cantidad()
    {
        return $this->carecteristicaRaw["cantidad"];
    }
}