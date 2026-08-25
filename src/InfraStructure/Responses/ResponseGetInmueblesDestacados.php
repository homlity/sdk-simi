<?php


namespace Homlity\SIMI\SDK\InfraStructure\Responses;

/**
 * Class ResponseGetInmueblesDestacados
 * @package Homlity\SIMI\SDK\InfraStructure\Responses
 * @author Juan Diaz <iam@furiosojack.com>
 */
class ResponseGetInmueblesDestacados extends ResponseRepository
{
    private $inmueblesRAW;
    private $paginacionRaw;

    public function __construct(string $responderaw)
    {
        parent::__construct($responderaw);
        if($this->isSuccess()){
            $this->paginacionRaw = $this->responseArray["infoAdd"];
            $response = $this->responseArray;
            unset($response["infoAdd"]);
            $this->inmueblesRAW = $response;
        }
    }

    /**
     * Devuelve el array de inmuebles destacados
     * @return array|null
     */
    public function inmuebles()
    {
        if($this->isSuccess()){
            return $this->inmueblesRAW;
        }

    }

    /**
     * @return array|null
     */
    public function paginacion()
    {
        if($this->isSuccess()){
            return $this->paginacionRaw;
        }
    }

}