<?php
/**
 * Homlity — SDK SIMI · Ejemplo 2: ficha de detalle completa
 * https://homlity.com/desarrolladores/
 *
 *     php examples/02-detalle-inmueble.php 503-4848
 */

require __DIR__ . '/00-bootstrap.php';

$api = simi_api();

$codigo = $argv[1] ?? null;

// Si no se pasa un código, se toma el primero del listado.
if ($codigo === null) {
    $primeros = $api->getInmuebles(['total' => 1])['inmuebles'];
    if (!$primeros) {
        exit("No hay inmuebles disponibles para probar.\n");
    }
    $codigo = $primeros[0]->identificacion();
    echo "Sin código en los argumentos; se usa: $codigo\n";
}

$detalle = $api->getDetalleInmueble($codigo);

// getDetalleInmueble devuelve null cuando el inmueble no existe o el API falló.
if ($detalle === null) {
    exit("Inmueble $codigo no disponible.\n");
}

titulo($detalle->nombre());

printf("Dirección     : %s\n", $detalle->direccion() ?? '(no publicada)');
printf("Ubicación     : %s / %s / %s / %s\n",
    $detalle->departamento(), $detalle->ciudad(), $detalle->zona(), $detalle->barrio());
printf("Ids ubicación : depto=%s ciudad=%s barrio=%s zona=%s\n",
    $detalle->departamentoId(), $detalle->ciudadId(), $detalle->barrioId(), $detalle->idZona());
printf("Gestión       : %s (id %s)\n", $detalle->gestion(), $detalle->idGestion());
printf("Tipo          : %s (id %s)\n", $detalle->tipoInmueble(), $detalle->idTipoInmueble());
printf("Área const.   : %s m²   ·   Área lote: %s m²\n", $detalle->areaConstruida(), $detalle->areaLote());
printf("Alcobas       : %s   Baños: %s   Garajes: %s   Estrato: %s\n",
    $detalle->alcobas(), $detalle->baños(), $detalle->garaje(), $detalle->estrato());
printf("Venta         : $ %s\n", $detalle->valorVenta());
printf("Arriendo      : $ %s\n", $detalle->valorArriendo());
printf("Admón incluida: %s\n", $detalle->administracionIncluida() ? 'sí' : 'no');
printf("Coordenadas   : %s, %s\n", $detalle->latitud(), $detalle->longitud());

// --- Multimedia --------------------------------------------------------------
// fotoPortada() asume que existe al menos una foto: valida antes de usarla.
$fotos = $detalle->fotos() ?: [];
titulo('Fotos (' . count($fotos) . ')');
foreach (array_slice($fotos, 0, 5) as $foto) {
    echo ' - ' . $foto['foto'] . PHP_EOL;
}

if ($detalle->video()) {
    echo PHP_EOL . 'Video: ' . $detalle->video() . PHP_EOL;
}

$fotos360 = $detalle->fotos360();
if (!empty($fotos360)) {
    echo 'Recorridos 360: ' . count($fotos360) . PHP_EOL;
}

// --- Características ---------------------------------------------------------
titulo('Características en 3 columnas');
foreach ($detalle->caracteristicasPorColumnas(3) as $n => $columna) {
    echo "Columna " . ($n + 1) . ":\n";
    foreach ($columna as $c) {
        printf("  · %s (%s) %s\n", $c->descripcion(), $c->cantidad(), $c->observacion());
    }
}

// --- Asesor ------------------------------------------------------------------
$asesor = $detalle->asesor();
if ($asesor !== null) {
    titulo('Asesor asignado');
    printf("%s\n%s\n%s\n%s\n", $asesor->nombre(), $asesor->celular(), $asesor->email(), $asesor->foto());
}

// --- Descripción -------------------------------------------------------------
titulo('Descripción');
echo wordwrap((string) $detalle->descripcion(), 70) . PHP_EOL;
