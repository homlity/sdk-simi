<?php


namespace Codwelt\SIMI\SDK\InfraStructure\Modelos;

/**
 * Class InmuebleDetail
 * @package Codwelt\SIMI\SDK\InfraStructure\Modelos
 * @author Juan Diaz <iam@furiosojack.com>
 */
class InmuebleDetail extends InmueblePreview
{
    private $caracteristicasExtenas =[];
    private $caracteristicasInternas = [];
    private $caracteristicasAlrededores =[];
    private $asesor;


    public function identificacion()
    {
        return $this->jsonRAW["idInm"];
    }

    public function alcobas()
    {
        return $this->jsonRAW["alcobas"];
    }

    public function baños()
    {
        return $this->jsonRAW["banos"];
    }

    public function garaje()
    {
        return $this->jsonRAW["garaje"];
    }

    public function zona()
    {
        return $this->jsonRAW["zona"];
    }

    public function barrio()
    {
        return $this->jsonRAW["barrio"];
    }

    public function barrioId()
    {
        return $this->jsonRAW["IdBarrio"];
    }
    public function ciudad()
    {
        return $this->jsonRAW["ciudad"];
    }

    public function ciudadId()
    {
        return $this->jsonRAW["IdCiudad"];
    }

    public function departamentoId()
    {
        return $this->jsonRAW["IdDepartamento"];
    }

    public function departamento()
    {
        return $this->jsonRAW["depto"];
    }

    public function IdLocalidad()
    {
        return $this->jsonRAW["IdLocalidad"];
    }

    public function nlocalidad()
    {
        return $this->jsonRAW["nlocalidad"];
    }

    public function estado()
    {
        return $this->jsonRAW["idEstadoInmueble"];
    }

    public function estrato()
    {
        return $this->jsonRAW["Estrato"];
    }

    public function tipoInmueble()
    {
        return $this->jsonRAW["Tipo_Inmueble"];
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


    public function gestion()
    {
        return $this->jsonRAW["Gestion"];
    }


    public function fotos()
    {
        return $this->jsonRAW["fotos"];
    }

    public function caracterisitcasInternas()
    {
        if($this->caracteristicasInternas == null){
            $this->caracteristicasInternas = array();

            foreach ($this->jsonRAW["caracteristicasInternas"] as $caracteristicasExterna){
                $this->caracteristicasInternas[] = new CaracteristicaInterna($caracteristicasExterna);
            }

        }

        return $this->caracteristicasInternas;

    }

    public function caracteristicasExternas()
    {
        if($this->caracteristicasExtenas == null){
            $this->caracteristicasExtenas = array();
            foreach ($this->jsonRAW["caracteristicasExternas"] as $caracteristicasExterna){
                $this->caracteristicasExtenas[] = new CaracteristicaExterna($caracteristicasExterna);
            }
        }
        return $this->caracteristicasExtenas;
    }

    public function caracteristicasAlrededores()
    {
        if($this->caracteristicasAlrededores == null){
            $this->caracteristicasAlrededores = array();
            foreach ($this->jsonRAW["caracteristicasAlrededores"] as $caracteristicasAlrededore){
                $this->caracteristicasAlrededores[] = new CaracteristicaAlrededores($caracteristicasAlrededore);
            }
        }
        return $this->caracteristicasAlrededores;
    }

    /**
     * Devuelve el numero de caracteristicas en un numero detenermiado de columnas
     * @param int $nColumnas
     * @return array
     */
    public function caracteristicasPorColumnas(int $nColumnas = 3)
    {
        $todas = array();
        $todas = array_merge($todas,$this->caracteristicasAlrededores());
        $todas = array_merge($todas,$this->caracteristicasExternas());
        $todas = array_merge($todas,$this->caracterisitcasInternas());
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


    public function caracteristicas()
    {
        $todas = array();
        $todas = array_merge($todas,$this->caracteristicasAlrededores());
        $todas = array_merge($todas,$this->caracteristicasExternas());
        $todas = array_merge($todas,$this->caracterisitcasInternas());
        return $todas;
    }

    public function asesor()
    {
        if($this->asesor == null){
            $asesorRaw = reset($this->jsonRAW["asesor"]);
            if($asesorRaw !== FALSE && is_array($asesorRaw)){
                return new AsesorDetalleInmueble($asesorRaw);
            }
        }
        return $this->asesor;

    }


    public function idZona()
    {
        return $this->jsonRAW["IdZona"];
    }

    public function idTipoInmueble()
    {
        return $this->jsonRAW["IdTpInm"];
    }

    public function idGestion()
    {
        return $this->jsonRAW["IdGestion"];
    }

    public function idSede()
    {
        return $this->jsonRAW["sede"];
    }

    public function video()
    {
        $urlVideo = $this->jsonRAW["video"];
        if(!$urlVideo){
            return null;
        }
        
        $queryString = parse_url($urlVideo);

        return "https://".$queryString["host"]. preg_replace('#/+#', '/', $queryString["path"]);
    }


    public function fotos360()
    {
        return $this->jsonRAW["fotos360"];
    }

    public function fotoPortada()
    {
        return $this->fotos()[0]["foto"];
    }

    public function direccion()
    {
        if(isset($this->jsonRAW['Direccion'])) {
            return $this->jsonRAW["Direccion"];
        }
        return null;
    }



    public function valorVenta(bool $format = true)
    {
        $valor = preg_replace('/[^0-9]+/', '', $this->jsonRAW["ValorVenta"]);
        if($format){
            return number_format($valor,0, ',', '.');
        }
        return $valor;

    }

    public function valorArriendo(bool $format = true)
    {

        $valor = preg_replace('/[^0-9]+/', '', $this->jsonRAW["ValorCanon"]);
        if($format){
            return number_format($valor,0, ',', '.');
        }
        return $valor;

    }

    /**
     * Indica si tiene o no administracion incluida
     * @return bool
     */
    public function administracionIncluida():bool
    {
        if(isset($this->jsonRAW["AdmonIncluida"]) && $this->jsonRAW["AdmonIncluida"] == '1') {
            return true;
        }

        return false;
    }


}