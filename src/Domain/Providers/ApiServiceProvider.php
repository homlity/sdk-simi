<?php
namespace Codwelt\SIMI\SDK\Domain\Providers;

use Codwelt\SIMI\SDK\Domain\API\ApiFachadaRepository;
use Codwelt\SIMI\SDK\InfraStructure\API\ApiFachada;



/**
 * Class ApiServiceProvider
 * @package Codwelt\SIMI\SDK\InfraStructure\Providers
 * @author Juan Diaz <iam@furiosojack.com>
 */
class ApiServiceProvider extends ApiServiceProviderRepository
{


    public function establerApi()
    {
        $this->api = new ApiFachada($this->tokenProvider->getToken());
    }
}