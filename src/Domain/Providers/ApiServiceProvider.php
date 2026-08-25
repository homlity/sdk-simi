<?php
namespace Homlity\SIMI\SDK\Domain\Providers;

use Homlity\SIMI\SDK\Domain\API\ApiFachadaRepository;
use Homlity\SIMI\SDK\InfraStructure\API\ApiFachada;



/**
 * Class ApiServiceProvider
 * @package Homlity\SIMI\SDK\InfraStructure\Providers
 * @author Juan Diaz <iam@furiosojack.com>
 */
class ApiServiceProvider extends ApiServiceProviderRepository
{


    public function establerApi()
    {
        $this->api = new ApiFachada($this->tokenProvider->getToken());
    }
}