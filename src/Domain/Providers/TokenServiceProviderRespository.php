<?php
namespace Codwelt\SIMI\SDK\Domain\Providers;

/**
 * Class ApiServiceProviderRespository
 * @package Codwelt\SIMI\SDK\InfraStructure\Providers\Repository
 * @author Juan Diaz <iam@furiosojack.com>
 */
interface TokenServiceProviderRespository
{
    /**
     * Devuelve el token
     * @return string
     */
    public function getToken():string;

}