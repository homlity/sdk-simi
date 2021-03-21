<?php


namespace Codwelt\SIMI\SDK\InfraStructure\Modelos;

/**
 * Class GestionInmueble
 * @package Codwelt\SIMI\SDK\InfraStructure\Modelos
 * @author Juan Diaz <iam@furiosojack.com>
 */
class GestionInmueble implements \JsonSerializable
{

    protected $gestionRaw ;


    public function __construct(array $gestionRaw)
    {
        $this->gestionRaw = $gestionRaw;
    }

    public function id()
    {
        return $this->gestionRaw["idGestion"];
    }

    public function nombre()
    {
        return $this->gestionRaw["Nombre"];
    }


    public function jsonSerialize()
    {
        return $this->gestionRaw;
    }
}