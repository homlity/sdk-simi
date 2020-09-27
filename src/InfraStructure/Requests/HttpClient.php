<?php


namespace Codwelt\SIMI\SDK\InfraStructure\Requests;

use Codwelt\SIMI\SDK\InfraStructure\Responses\ResponseRepository;

/**
 * Class HttpClient
 * @package Codwelt\SIMI\SDK\InfraStructure\Requests
 * @author Juan Diaz <iam@furiosojack.com>
 */
abstract class HttpClient
{

    protected static $METHOD_METHOD_GET = "GET";
    protected static $REQUEST_METHOD_POST = "POST";

    /**
     * Es el valor del token a usar
     * @var string
     */
    protected $token;

    /**
     * @var
     */
    protected $urlBase;

    /**
     * @var
     */
    protected $method;


    /**
     * @var
     */
    protected $endPoint;


    /**
     * HttpClient constructor.
     * @param $token
     */
    public function __construct($token)
    {
        $this->token = $token;
        $this->urlBase  = "http://simi-api.com/ApiSimiweb/response/";
        $this->method = self::$METHOD_METHOD_GET;
    }


    /**
     * Se encarga de hace el envio de la peticion
     * recibe la url y devuelve el contenido raw de la peticion
     * @param $url
     * @return bool|string
     */
    protected function send()
    {

        $url = $this->urlBase.$this->endPoint;
        if(filter_var($url,FILTER_VALIDATE_URL) === FALSE){
            throw new \Exception("Url Invalida");
        }
        $ch = curl_init();
        $auth ='Authorization:'.$this->token;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_USERPWD, $auth);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    /**
     * Es el metodo que se debe definir para escoger el metodo a usar
     * @return ResponseRepository
     */
    public abstract function ejecutar(array $parameters = []):ResponseRepository;




}