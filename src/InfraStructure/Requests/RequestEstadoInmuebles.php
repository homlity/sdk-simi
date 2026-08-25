<?php


namespace Homlity\SIMI\SDK\InfraStructure\Requests;

use Homlity\SIMI\SDK\InfraStructure\Responses\ResponseEstadoInmuebles;
use Homlity\SIMI\SDK\InfraStructure\Responses\ResponseRepository;

/**
 * Class RequestEstadoInmueble
 * @package Homlity\SIMI\SDK\InfraStructure\Requests
 * @author Don Juanc.Developer Instagram <@donjuanc.developer>
 */
class RequestEstadoInmuebles extends HttpClient
{
    protected $urlBase = "https://api.simicrm.app/crm/";
    protected $endPoint = "inmuebles";
    protected $method = "GET";

    protected function send()
    {
        $url = $this->getUrlConstruida();
        if(filter_var($url,FILTER_VALIDATE_URL) === FALSE){
            throw new \Exception("Url Invalida");
        }
        $ch = curl_init();
        $headers = array(
            'Accept:application/vnd.apisimi.v3+json',
            'Content-Type:application/json',
            'token:'.$this->token
        );
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public function ejecutar(array $parameters = []): ResponseRepository
    {
        if(empty($parameters["estado"])){
            throw new \Exception("El codigo del inmueble es requerido para obtener el detalle del inmueble");
        }

        $this->endPoint .= "?". http_build_query($parameters);

        return new ResponseEstadoInmuebles($this->send());
    }
}