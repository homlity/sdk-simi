<?php


namespace Codwelt\SIMI\SDK\InfraStructure\Modelos;

/**
 * Class ASesor
 * @package Codwelt\SIMI\SDK\InfraStructure\Modelos
 * @author Juan Diaz <iam@furiosojack.com>
 */
class Asesor
{
    private $departamentoRaw;

    public function __construct(array $departamentoRaw)
    {
        $this->departamentoRaw = $departamentoRaw;
    }

    public function nombre()
    {
        return $this->departamentoRaw["nombre"];
    }

    public function id()
    {
        return $this->departamentoRaw["id"];
    }
}