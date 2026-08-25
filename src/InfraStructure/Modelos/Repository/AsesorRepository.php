<?php
namespace Homlity\SIMI\SDK\InfraStructure\Modelos\Repository;

/**
 * Class AsesorRepository
 * @package Homlity\SIMI\SDK\InfraStructure\Modelos\Repository
 * @author Juan Diaz <iam@furiosojack.com>
 */
abstract class AsesorRepository
{
    protected $asesorRaw;

    public function __construct(array  $asesorRaw)
    {
        $this->asesorRaw = $asesorRaw;
    }

    public function raw(): array
    {
        return is_array($this->asesorRaw) ? $this->asesorRaw : [];
    }

    public function id(): string
    {
        foreach (['id', 'idUser', 'codigo', 'ntercero', 'external_id'] as $key) {
            if (!empty($this->asesorRaw[$key])) {
                return (string) $this->asesorRaw[$key];
            }
        }

        return '';
    }

    abstract public function nombre();

    abstract public function celular();

    abstract public function foto();

    abstract public function email();
}