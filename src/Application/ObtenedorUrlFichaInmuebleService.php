<?php


namespace Codwelt\SIMI\SDK\Application;

use Codwelt\SIMI\SDK\InfraStructure\Modelos\InmueblePreview;

/**
 * Class ObtenedorUrlFichaInmuebleService
 * @package Codwelt\SIMI\SDK\Application
 * @author Juan Diaz <iam@furiosojack.com>
 */
class ObtenedorUrlFichaInmuebleService
{

    public function getUrl(InmueblePreview $inmueblePreview)
    {
        return "https://simicrm.app/mcomercialweb/fichas_tecnicas/fichatec3.php?reg=".$inmueblePreview->identificacion();
    }

}