<?php
/**
 * Homlity — SDK SIMI · Ejemplo 7: decorador con caché en disco
 * https://homlity.com/desarrolladores/
 *
 * El API de SIMI es la parte lenta de cualquier página que lo consuma.
 * Como los servicios del SDK dependen de la abstracción ApiFachadaRepository,
 * puedes envolver la fachada real en un decorador con caché sin cambiar nada
 * más de tu código.
 */

require __DIR__ . '/00-bootstrap.php';

use Homlity\SIMI\SDK\Application\ObtenedorInmueblesSimilaresService;
use Homlity\SIMI\SDK\Domain\API\ApiFachadaRepository;

class ApiSimiConCache extends ApiFachadaRepository
{
    /** @var ApiFachadaRepository */
    private $inner;
    /** @var string */
    private $dir;
    /** @var int */
    private $ttl;

    public function __construct(ApiFachadaRepository $inner, string $dir, int $ttl = 600)
    {
        parent::__construct($inner->getToken());
        $this->inner = $inner;
        $this->dir   = $dir;
        $this->ttl   = $ttl;

        if (!is_dir($this->dir)) {
            mkdir($this->dir, 0775, true);
        }
    }

    private function recordar(string $clave, callable $fn, ?int $ttl = null)
    {
        $ttl     = $ttl ?? $this->ttl;
        $archivo = $this->dir . '/' . md5($clave) . '.cache';

        if (is_file($archivo) && (time() - filemtime($archivo)) < $ttl) {
            return unserialize(file_get_contents($archivo));
        }

        $valor = $fn();
        file_put_contents($archivo, serialize($valor));

        return $valor;
    }

    // Listados: TTL corto, el inventario cambia a diario.
    public function getInmuebles(array $filters = [])
    {
        return $this->recordar('inmuebles' . serialize($filters),
            function () use ($filters) { return $this->inner->getInmuebles($filters); }, 600);
    }

    public function getDetalleInmueble($codigoInmueble)
    {
        return $this->recordar('detalle' . $codigoInmueble,
            function () use ($codigoInmueble) { return $this->inner->getDetalleInmueble($codigoInmueble); }, 1800);
    }

    public function getInmueblesDestacados(array $filtros = [])
    {
        return $this->recordar('destacados' . serialize($filtros),
            function () use ($filtros) { return $this->inner->getInmueblesDestacados($filtros); }, 900);
    }

    public function getAsesores(array $filtros = [])
    {
        return $this->recordar('asesores' . serialize($filtros),
            function () use ($filtros) { return $this->inner->getAsesores($filtros); }, 3600);
    }

    // Catálogos: TTL largo, cambian muy poco.
    public function getDepartamentos()
    {
        return $this->recordar('departamentos',
            function () { return $this->inner->getDepartamentos(); }, 86400);
    }

    public function getCiudades($idDepartamento)
    {
        return $this->recordar('ciudades' . $idDepartamento,
            function () use ($idDepartamento) { return $this->inner->getCiudades($idDepartamento); }, 86400);
    }

    public function getBarrios($idCiudad)
    {
        return $this->recordar('barrios' . $idCiudad,
            function () use ($idCiudad) { return $this->inner->getBarrios($idCiudad); }, 86400);
    }

    public function getTiposInmueble()
    {
        return $this->recordar('tipos',
            function () { return $this->inner->getTiposInmueble(); }, 43200);
    }

    public function getGestionesInmueble()
    {
        return $this->recordar('gestiones',
            function () { return $this->inner->getGestionesInmueble(); }, 86400);
    }
}

// --- Uso ---------------------------------------------------------------------
$api = new ApiSimiConCache(simi_api(), sys_get_temp_dir() . '/simi-cache');

$inicio = microtime(true);
$api->getDepartamentos();
printf("Primera llamada (red)   : %.3f s\n", microtime(true) - $inicio);

$inicio = microtime(true);
$api->getDepartamentos();
printf("Segunda llamada (caché) : %.3f s\n", microtime(true) - $inicio);

// Los servicios de aplicación funcionan igual con la versión cacheada,
// porque reciben la abstracción ApiFachadaRepository.
$servicio = new ObtenedorInmueblesSimilaresService($api);
titulo('El decorador es transparente para los servicios del SDK');
echo get_class($servicio) . " recibió " . get_class($api) . PHP_EOL;
