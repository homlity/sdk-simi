<?php


namespace Codwelt\SIMI\SDK\Domain\ModelRepository;

use Codwelt\SIMI\SDK\InfraStructure\Modelos\InmuebleDetail;
use Codwelt\SIMI\SDK\InfraStructure\Modelos\InmueblePreview;

/**
 * Class Inmueble
 * @package Codwelt\SIMI\SDK\Domain\ModelRepository
 * @author Juan Diaz <iam@furiosojack.com>
 */
class Inmueble
{
    /**
     * @var InmueblePreview | InmuebleDetail
     */
    private $inmueble;

    public function __construct($inmueble)
    {
        $this->inmueble = $inmueble;
    }

    /**
     * Devuelve el nombre del inmueble
     * @return string
     */
    public function nombre()
    {
        return ucfirst(strtolower($this->inmueble->tipoInmueble() . " - " .
            $this->inmueble->barrio() .
            $this->inmueble->ciudad()
        ));
    }


    public function enAriendo()
    {
        $gestionMIn = strtolower($this->inmueble->gestion());
        return $gestionMIn == "arriendo";
    }

    public function enArriendoVenta()
    {
        $gestionMIn = strtolower($this->inmueble->gestion());
        return $gestionMIn == "arriendo/venta";
    }


    public function valorVenta()
    {
        $valor = preg_replace('/[^0-9]+/', '', $this->inmueble->valorVenta());
        return number_format($valor,0, ',', '.');
    }

    public function valorArriendo()
    {

        $valor = preg_replace('/[^0-9]+/', '', $this->inmueble->valorVenta());
        return number_format($valor,0, ',', '.');

    }


    /**
     * Devuelve el numero de caracteristicas en un numero detenermiado de columnas
     * @param int $nColumnas
     * @return array
     */
    public function caracteristicasPorColumnas(int $nColumnas = 3)
    {
        $todas = array();
        $todas = array_merge($todas,$this->inmueble->caracteristicasAlrededores());
        $todas = array_merge($todas,$this->inmueble->caracteristicasExternas());
        $todas = array_merge($todas,$this->inmueble->caracterisitcasInternas());
        $columnas = array();
        $columnaActual = -1;

        $totalCaracteristicas = count($todas);
        $nItems = (int)($totalCaracteristicas / $nColumnas);
        for($i = 1; $i <= $totalCaracteristicas; $i++){
            $iReal = $i - 1; //ES la variable de recorreido menos uno ya que se require el uno para obtener
            //su residuo
            if(($i % $nItems) == 1){
                $columnaActual++;
                $columnas[$columnaActual] = array();
            }
            $columnas[$columnaActual][]  = $todas[$iReal];
        }

        return $columnas;
    }


}