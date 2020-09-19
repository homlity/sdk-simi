<?php


namespace Codwelt\SIMI\SDK\InfraStructure\Modelos;

/**
 * Class Barrio
 * @package Codwelt\SIMI\SDK\Domain\Modelos
 * @author Juan Diaz <iam@furiosojack.com>
 */
class Barrio
{


    private $barrioRaw;

    public function __construct($barrioRaw)
    {
        $this->barrioRaw = $barrioRaw;
    }

    public function id()
    {
        return $this->barrioRaw["id"];
    }

    public function nombre()
    {
        return $this->barrioRaw["nombre"];
    }

}