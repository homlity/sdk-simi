<?php


namespace Codwelt\SIMI\SDK\InfraStructure\Modelos;

/**
 * Class InmueblePreview
 * @package Codwelt\SIMI\SDK\InfraStructure\Modelos
 * @author Juan Diaz <iam@furiosojack.com>
 */
class InmueblePreview
{
    protected $jsonRAW;

    public function __construct(array $jsonRAW)
    {
        $this->jsonRAW = $jsonRAW;
    }

    public function identificacion()
    {
        return $this->jsonRAW["Codigo_Inmueble"];
    }

    public function alcobas()
    {
        return $this->jsonRAW["Alcobas"];
    }

    public function baños()
    {
        return $this->jsonRAW["banios"];
    }

    public function garaje()
    {
        return $this->jsonRAW["garaje"];
    }

    public function zona()
    {
        return $this->jsonRAW["Zona"];
    }

    public function barrio()
    {
        return $this->jsonRAW["Barrio"];
    }

    public function ciudad()
    {
        return $this->jsonRAW["Ciudad"];
    }

    public function departamento()
    {
        return $this->jsonRAW["Departamento"];
    }

    public function estado()
    {
        return $this->jsonRAW["idEstado"];
    }

    public function estrato()
    {
        return $this->jsonRAW["Estrato"];
    }

    public function tipoInmueble()
    {
        return $this->jsonRAW["Tipo_Inmueble"];
    }

    public function valorVenta()
    {
        $valor = preg_replace('/[^0-9]+/', '', $this->jsonRAW["Venta"]);
        return number_format($valor,0, ',', '.');
    }

    public function valorArriendo()
    {

        $valor = preg_replace('/[^0-9]+/', '', $this->jsonRAW["Canon"]);
        return number_format($valor,0, ',', '.');

    }

    public function descripcion()
    {
        return $this->jsonRAW["descripcionlarga"];
    }

    public function areaConstruida()
    {
        return $this->jsonRAW["AreaConstruida"];
    }

    public function areaLote()
    {
        return $this->jsonRAW["AreaLote"];
    }

    public function latitud()
    {
        return $this->jsonRAW["latitud"];
    }

    public function longitud()
    {
        return $this->jsonRAW["longitud"];
    }

    public function edad()
    {
        return $this->jsonRAW["EdadInmueble"];
    }

    public function fotoPortada()
    {
        return $this->jsonRAW["foto1"];
    }

    public function logo()
    {
        return $this->jsonRAW["logo"];
    }

    public function gestion()
    {
        return $this->jsonRAW["Gestion"];
    }

    public function idGestion()
    {
        return $this->jsonRAW["idGestion"];
    }

    public function foto360()
    {
        return $this->jsonRAW["foto360"];
    }


    public function enAriendo()
    {
        $gestionMIn = strtolower($this->gestion());
        return $gestionMIn == "arriendo";
    }

    public function enArriendoVenta()
    {
        $gestionMIn = strtolower($this->gestion());
        return $gestionMIn == "arriendo/venta";
    }

}