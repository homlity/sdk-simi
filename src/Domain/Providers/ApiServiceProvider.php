<?php
namespace Codwelt\SIMI\SDK\Domain\Providers;

use Codwelt\SIMI\SDK\Domain\API\ApiFachadaRepository;
use Codwelt\SIMI\SDK\InfraStructure\API\ApiFachada;

use Codwelt\SIMI\SDK\InfraStructure\Providers\Repository\TokenServiceProviderRespository;

/**
 * Class ApiServiceProvider
 * @package Codwelt\SIMI\SDK\InfraStructure\Providers
 * @author Juan Diaz <iam@furiosojack.com>
 */
class ApiServiceProvider
{
    /**
     * @var TokenServiceProviderRespository
     */
    private $tokenProvider;

    /*
     *
     */
    private $api;

    private static $instance;

    public static function build()
    {
        if(self::$instance == null){
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @param TokenServiceProviderRespository $tokenServiceProviderRespository
     */
    public function setTokenProvider(TokenServiceProviderRespository  $tokenServiceProviderRespository)
    {
        $this->tokenProvider = $tokenServiceProviderRespository;
    }


    /**
     * @return ApiFachadaRepository
     * @throws \Exception
     */
    public function getAPI(): ApiFachadaRepository
    {
        if($this->tokenProvider == null){
            throw new \Exception("No a seteado el Proveedor del token por favor use le metodo setTokenProvider 
            con una instancia de la interfaz  Codwelt\SIMI\SDK\InfraStructure\Providers\Repository\TokenServiceProviderRespository" );
        }
        if($this->api == null){
            $this->api = new ApiFachada($this->tokenProvider->getToken());
        }
        return $this->api;
    }

}