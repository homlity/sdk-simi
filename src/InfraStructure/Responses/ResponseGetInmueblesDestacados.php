<?php


namespace Codwelt\SIMI\SDK\InfraStructure\Responses;

/**
 * Class ResponseGetInmueblesDestacados
 * @package Codwelt\SIMI\SDK\InfraStructure\Responses
 * @author Juan Diaz <iam@furiosojack.com>
 */
class ResponseGetInmueblesDestacados extends ResponseRepository
{
    private $inmueblesRAW;
    private $paginacionRaw;

    public function __construct(string $responderaw)
    {
        parent::__construct($responderaw);
        $this->paginacionRaw = $this->responseArray["infoAdd"];
        $response = $this->responseArray;
        unset($response["infoAdd"]);
        $this->inmueblesRAW = $response;
    }

    /**
     * Devuelve el array de inmuebles destacados
     * @return array
     */
    public function inmuebles()
    {
        return $this->inmueblesRAW;
    }

    /**
     * @return array
     */
    public function paginacion()
    {
        return $this->paginacionRaw;
    }

}