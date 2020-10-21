<?php
namespace Codwelt\SIMI\SDK\InfraStructure\Modelos;

/**
 * Class Departamento
 * @package Codwelt\SIMI\SDK\Domain\Modelos
 * @author Juan Diaz <iam@furiosojack.com>
 */
class Departamento implements \JsonSerializable
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

    public function jsonSerialize()
    {
       return [
         "nombre" => $this->departamentoRaw["nombre"],
         "id" => $this->departamentoRaw["id"]
       ];
    }
}