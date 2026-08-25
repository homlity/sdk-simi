<?php
/**
 * Homlity — SDK SIMI · Ejemplo 5: bloque "También te puede interesar"
 * https://homlity.com/desarrolladores/
 *
 *     php examples/05-inmuebles-similares.php 503-4848
 *
 * ObtenedorInmueblesSimilaresService busca inmuebles de la misma zona, tipo y
 * gestión, y descarta el inmueble original del resultado.
 */

require __DIR__ . '/00-bootstrap.php';

use Codwelt\SIMI\SDK\Application\ObtenedorInmueblesSimilaresService;
use Codwelt\SIMI\SDK\Application\ObtenedorUrlFichaInmuebleService;

$api = simi_api();

$codigo = $argv[1] ?? null;
if ($codigo === null) {
    $primeros = $api->getInmuebles(['total' => 1])['inmuebles'];
    if (!$primeros) {
        exit("No hay inmuebles disponibles para probar.\n");
    }
    $codigo = $primeros[0]->identificacion();
}

$servicio  = new ObtenedorInmueblesSimilaresService($api);
$urlFicha  = new ObtenedorUrlFichaInmuebleService();

// Opción A: a partir del código (hace la consulta del detalle internamente).
$similares = $servicio->obtenerConCodigo($codigo);

titulo('Similares a ' . $codigo . ' (' . count($similares) . ')');
foreach ($similares as $inmueble) {
    printf("  %-12s %-45s\n", $inmueble->identificacion(), $inmueble->nombre());
    printf("               ficha: %s\n", $urlFicha->getUrl($inmueble));
}

// Opción B: si ya tienes el detalle cargado, evitas una petición extra.
// El servicio pide $cantidad y devuelve hasta $cantidad - 1, porque reserva un
// espacio para descartar el inmueble original: pide uno más de los que quieras.
$detalle = $api->getDetalleInmueble($codigo);
if ($detalle !== null) {
    $cuatro = $servicio->obtener($detalle, 5);
    titulo('Similares con el detalle ya cargado (' . count($cuatro) . ')');
    foreach ($cuatro as $inmueble) {
        printf("  %-12s %s\n", $inmueble->identificacion(), $inmueble->nombre());
    }
}
