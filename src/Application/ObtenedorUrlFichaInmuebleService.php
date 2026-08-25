<?php


namespace Homlity\SIMI\SDK\Application;

use Homlity\SIMI\SDK\InfraStructure\Modelos\InmueblePreview;

/**
 * Class ObtenedorUrlFichaInmuebleService
 * @package Homlity\SIMI\SDK\Application
 * @author Juan Diaz <iam@furiosojack.com>
 */
class ObtenedorUrlFichaInmuebleService
{

    public function getUrl(InmueblePreview $inmueblePreview)
    {
        return "https://simicrm.app/mcomercialweb/fichas_tecnicas/fichatec3.php?reg=".$inmueblePreview->identificacion();
    }

}