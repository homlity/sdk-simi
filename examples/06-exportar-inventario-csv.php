<?php
/**
 * Homlity — SDK SIMI · Ejemplo 6: exportar todo el inventario a CSV
 * https://homlity.com/desarrolladores/
 *
 *     php examples/06-exportar-inventario-csv.php > inventario.csv
 *
 * Recorre todas las páginas del listado. Útil para feeds hacia portales
 * externos, migraciones o auditorías del inventario.
 */

require __DIR__ . '/00-bootstrap.php';

$api = simi_api();

$porPagina = 50;
$pagina    = 1;
$salida    = fopen('php://stdout', 'w');

fputcsv($salida, [
    'codigo', 'tipo', 'gestion', 'departamento', 'ciudad', 'barrio',
    'valor_venta', 'valor_arriendo', 'area_construida', 'alcobas', 'banos',
    'garajes', 'estrato', 'latitud', 'longitud', 'foto_portada',
]);

$exportados = 0;

do {
    try {
        $resultado = $api->getInmuebles(['total' => $porPagina, 'limite' => $pagina]);
    } catch (\Exception $e) {
        fwrite(STDERR, '[SIMI] ' . $e->getMessage() . PHP_EOL);
        break;
    }

    foreach ($resultado['inmuebles'] as $inmueble) {
        fputcsv($salida, [
            $inmueble->identificacion(),
            $inmueble->tipoInmueble(),
            $inmueble->gestion(),
            $inmueble->departamento(),
            $inmueble->ciudad(),
            $inmueble->barrio(),
            // false → valor numérico sin formato, ideal para hojas de cálculo
            $inmueble->valorVenta(false),
            $inmueble->valorArriendo(false),
            $inmueble->areaConstruida(),
            $inmueble->alcobas(),
            $inmueble->baños(),
            $inmueble->garaje(),
            $inmueble->estrato(),
            $inmueble->latitud(),
            $inmueble->longitud(),
            $inmueble->fotoPortada(),
        ]);
        $exportados++;
    }

    $paginador = $resultado['paginador'];
    $hayMas = $paginador !== null
        && $exportados < $paginador->totalInmuebles()
        && count($resultado['inmuebles']) > 0;

    $pagina++;
    usleep(200000);   // 200 ms entre páginas: no satures el API
} while ($hayMas);

fclose($salida);
fwrite(STDERR, "Exportados $exportados inmuebles.\n");
