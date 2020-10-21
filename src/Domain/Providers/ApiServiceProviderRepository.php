<?php


namespace Codwelt\SIMI\SDK\Domain\Providers;

use Codwelt\SIMI\SDK\Domain\API\ApiFachadaRepository;

/**
 * Class ApiServiceProviderRepository
 * @package Codwelt\SIMI\SDK\Domain\Providers
 * @author Juan Diaz <iam@furiosojack.com>
 */
abstract class ApiServiceProviderRepository
{

    /**
     * @var TokenServiceProviderRespository
     */
    protected $tokenProvider;

    /**
     * @var ApiFachadaRepository
     */
    protected $api;


    private static $instance;


    /**
     * @return static
     */
    public static function build()
    {
        if(self::$instance == null){
            self::$instance = new static();
        }
        return self::$instance;
    }

    /**
     * @param TokenServiceProviderRespository $tokenServiceProviderRespository
     */
    public function setTokenProvider(TokenServiceProviderRespository  $tokenServiceProviderRespository)
    {
        $this->tokenProvider = $tokenServiceProviderRespository;
        $this->validarToken();
        $this->establerApi();
    }

    /**
     * Se lanza Exception si el token es invalido
     * @throws \Exception
     */
    private function validarToken()
    {
        if(!preg_match("/^([A-Za-z0-9]{40})-([0-9]*)$/",$this->tokenProvider->getToken())){
            throw new \Exception("El token es invalido");
        }

    }
    public abstract function establerApi();

    /**
     * @return
     */
    public function getAPi()
    {
        if($this->tokenProvider == null){
            throw new \Exception("No a seteado el Proveedor del token por favor use le metodo setTokenProvider 
            con una instancia de la interfaz  Codwelt\SIMI\SDK\InfraStructure\Providers\Repository\TokenServiceProviderRespository" );
        }

        return $this->api;
    }




}