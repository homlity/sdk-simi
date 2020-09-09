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

    /**
     * Es el valor del token a usar
     * @var string
     */
    protected $token;

    /**
     * @var
     */
    protected $method;

    /**
     * Es la clase usara para devolver el response
     * @var ResponseRepository
     */
    protected $responseClass;


    /**
     * HttpClient constructor.
     * @param $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }


    /**
     * Se encarga de hace el envio de la peticion
     * recibe la url y devuelve el contenido raw de la peticion
     * @param $url
     * @return bool|string
     */
    protected function send($url)
    {
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
     * Envia la peticion recibe la url y devuelve una instancia
     * de un response repository
     * @param string $url
     * @return string
     * @throws \Exception
     */
    protected function sendPost(string $url):string
    {
        if(filter_var($url,FILTER_VALIDATE_URL) === FALSE){
            throw new \Exception("Url Invalida");
        }
        $this->method = "POST";
        return $this->send($url);
    }

    /**
     * Hace una peticion get recibe una url y devuelve una instancia de un
     * objectio responseReposiitroy
     * @param string $url
     * @return string
     * @throws \Exception
     */
    protected function sendGet(string $url):string
    {
        if(filter_var($url,FILTER_VALIDATE_URL) === FALSE){
            throw new \Exception("Url Invalida");
        }
        $this->method = "GET";
        $resultRaw = $this->send($url);
        return $resultRaw;
    }

    /**
     * Es el metodo que se debe definir para escoger el metodo a usar
     * @return ResponseRepository
     */
    public abstract function ejecutar(string $url):ResponseRepository;

}