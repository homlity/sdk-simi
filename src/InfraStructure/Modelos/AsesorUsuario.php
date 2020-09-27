<?php


namespace Codwelt\SIMI\SDK\InfraStructure\Modelos;

use Codwelt\SIMI\SDK\InfraStructure\Modelos\Repository\AsesorRepository;

/**
 * Class UsuarioAsesor
 * @package Codwelt\SIMI\SDK\InfraStructure\Modelos
 * @author Juan Diaz <iam@furiosojack.com>
 */
class AsesorUsuario extends AsesorRepository
{

    public function nombre()
    {
        return $this->asesorRaw["nombreUser"];
    }

    public function celular()
    {
        return $this->asesorRaw["celularUser"];
    }

    public function foto()
    {
        return $this->asesorRaw["fotoUser"];
    }

    public function email()
    {
        return $this->asesorRaw["correoUser"];
    }
}