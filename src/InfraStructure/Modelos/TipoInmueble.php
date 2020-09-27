<?php


namespace Codwelt\SIMI\SDK\InfraStructure\Modelos;

/**
 * Class TipoInmueble
 * @package Codwelt\SIMI\SDK\InfraStructure\Modelos
 * @author Juan Diaz <iam@furiosojack.com>
 */
class TipoInmueble
{

    protected $tipoRaw;

    public function __construct(array $tipoRaw)
    {
        $this->tipoRaw = $tipoRaw;
    }

    public function id()
    {
        return $this->tipoRaw["idTipoInm"];
    }

    public function Nombre()
    {
        return $this->tipoRaw["Nombre"];
    }

    public function totalInmuebles()
    {
        return $this->tipoRaw["totalInmuebles"];
    }


}