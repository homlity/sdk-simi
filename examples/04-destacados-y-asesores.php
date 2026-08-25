<?php
/**
 * Homlity — SDK SIMI · Ejemplo 4: destacados para el home y equipo de asesores
 * https://homlity.com/desarrolladores/
 */

require __DIR__ . '/00-bootstrap.php';

$api = simi_api();

// --- Destacados: solo acepta los filtros "limite" y "total" ------------------
$destacados = $api->getInmueblesDestacados(['total' => 6, 'limite' => 1]);

titulo('Inmuebles destacados (' . count($destacados['inmuebles']) . ')');
foreach ($destacados['inmuebles'] as $inmueble) {
    printf(
        "  %-12s %-45s $ %s\n",
        $inmueble->identificacion(),
        $inmueble->nombre(),
        $inmueble->enArriendo() ? $inmueble->valorArriendo() : $inmueble->valorVenta()
    );
}

// --- Asesores: filtros permitidos "limite", "cantidad" y "asesor" ------------
$resultado = $api->getAsesores(['cantidad' => 10, 'limite' => 1]);

titulo('Asesores (' . count($resultado['asesores']) . ')');
foreach ($resultado['asesores'] as $asesor) {
    printf("  [%s] %-30s %-18s %s\n",
        $asesor->id(), $asesor->nombre(), $asesor->celular(), $asesor->email());
}

if ($resultado['paginador'] !== null) {
    printf("\nTotal de asesores: %d (página %d, %d por página)\n",
        $resultado['paginador']->total(),
        $resultado['paginador']->paginaActual(),
        $resultado['paginador']->totalPorPagina()
    );
}
