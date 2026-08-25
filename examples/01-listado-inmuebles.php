<?php
/**
 * Homlity — SDK SIMI · Ejemplo 1: listado de inmuebles con filtros y paginación
 * https://homlity.com/desarrolladores/
 */

require __DIR__ . '/00-bootstrap.php';

use Codwelt\SIMI\SDK\Application\Models\PaginatorHTML;

$api = simi_api();

// --- Filtros -----------------------------------------------------------------
// Solo se permiten las claves de la lista blanca del SDK; cualquier otra lanza
// una excepción "Filtro (x) no esta permitido en APISIMI".
$filtros = [
    'total'  => 6,   // registros por página
    'limite' => 1,   // página solicitada
    // 'ciudad'  => 1,
    // 'tipoInm' => 1,
    // 'tipOper' => 2,
    // 'valmin'  => 200000000,
    // 'valmax'  => 600000000,
    // 'alcobas' => 3,
];

try {
    $resultado = $api->getInmuebles($filtros);
} catch (\Exception $e) {
    fwrite(STDERR, '[SIMI] ' . $e->getMessage() . PHP_EOL);
    exit(1);
}

$inmuebles = $resultado['inmuebles'];
$paginador = $resultado['paginador'];

titulo('Inmuebles encontrados: ' . count($inmuebles));

foreach ($inmuebles as $inmueble) {
    printf(
        "%-12s %-45s %s\n",
        $inmueble->identificacion(),
        $inmueble->nombre(),
        $inmueble->enArriendo()
            ? '$ ' . $inmueble->valorArriendo() . ' /mes'
            : '$ ' . $inmueble->valorVenta()
    );
    printf(
        "             %s alcobas · %s baños · %s m² · estrato %s\n",
        $inmueble->alcobas(),
        $inmueble->baños(),
        $inmueble->areaConstruida(),
        $inmueble->estrato()
    );
    printf("             %s\n\n", $inmueble->fotoPortada());
}

// --- Paginación --------------------------------------------------------------
// El paginador es null cuando la petición no fue exitosa: verifícalo siempre.
if ($paginador !== null) {
    titulo('Paginación');
    printf("Página actual : %d\n", $paginador->paginaActual());
    printf("Total registros: %d\n", $paginador->totalInmuebles());
    printf("Por página     : %d\n", $paginador->totalPorPagina());

    if ($paginador->totalPorPagina() > 0) {
        $html = new PaginatorHTML(
            $paginador->totalInmuebles(),
            $paginador->totalPorPagina(),
            $paginador->paginaActual(),
            '/inmuebles?page=' . PaginatorHTML::NUM_PLACEHOLDER
        );
        $html->setMaxPagesToShow(7);

        echo PHP_EOL . "HTML de la paginación:" . PHP_EOL;
        echo $html->toHtml() . PHP_EOL;
    }
}
