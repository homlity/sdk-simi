<?php
namespace Codwelt\SIMI\SDK\Domain\Providers;

use Codwelt\SIMI\SDK\Domain\API\ApiModelRepositoryFachada;

/**
 * Class ApiModelRepositoryServiceProvider
 * @package Codwelt\SIMI\SDK\Domain\Providers
 * @author Juan Diaz <iam@furiosojack.com>
 */
class ApiModelRepositoryServiceProvider extends ApiServiceProviderRepository
{

    public function establerApi()
    {
        return $this->api = new ApiModelRepositoryFachada($this->tokenProvider->getToken());
    }
}