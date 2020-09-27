<?php


namespace Codwelt\SIMI\SDK\InfraStructure\Modelos;

use Codwelt\SIMI\SDK\InfraStructure\Modelos\Repository\AsesorRepository;

/**
 * Esta clase es definida para contener al asesor que sale del detalle inmueble
 * Class ASesor
 * @package Codwelt\SIMI\SDK\InfraStructure\Modelos
 * @author Juan Diaz <iam@furiosojack.com>
 */
class AsesorDetalleInmueble extends AsesorRepository
{

    public function nombre()
    {
        return $this->asesorRaw["ntercero"];
    }

    public function celular()
    {
        return $this->asesorRaw["celular"];
    }

    public function foto()
    {
        return $this->asesorRaw["FotoAsesor"];
    }

    public function email()
    {
        return $this->asesorRaw["correo"];
    }
}