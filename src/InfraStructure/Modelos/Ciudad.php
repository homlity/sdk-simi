<?php


namespace Codwelt\SIMI\SDK\InfraStructure\Modelos;

/**
 * Class Ciudad
 * @package Codwelt\SIMI\SDK\Domain\Modelos
 * @author Juan Diaz <iam@furiosojack.com>
 */
class Ciudad
{
    private $dataRaw;

    public function __construct(array $data)
    {
        $this->dataRaw = $data;
    }

    public function nombre()
    {
        return $this->dataRaw["nombre"];
    }

    public function id()
    {
        return $this->dataRaw["id"];
    }
}