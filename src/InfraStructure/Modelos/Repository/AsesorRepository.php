<?php
namespace Codwelt\SIMI\SDK\InfraStructure\Modelos\Repository;

/**
 * Class AsesorRepository
 * @package Codwelt\SIMI\SDK\InfraStructure\Modelos\Repository
 * @author Juan Diaz <iam@furiosojack.com>
 */
abstract class AsesorRepository
{
    protected $asesorRaw;

    public function __construct(array  $asesorRaw)
    {
        $this->asesorRaw = $asesorRaw;
    }

    public abstract function nombre();

    public abstract function celular();

    public abstract function foto();

    public abstract function email();
}