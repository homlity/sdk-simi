<?php


namespace Homlity\SIMI\SDK\InfraStructure\Modelos;

/**
 * Class Ciudad
 * @package Homlity\SIMI\SDK\Domain\Modelos
 * @author Juan Diaz <iam@furiosojack.com>
 */
class Ciudad implements \JsonSerializable
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

    public function jsonSerialize()
    {
       return $this->dataRaw;
    }
}