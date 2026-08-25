<?php
/**
 * Homlity — SDK SIMI · Ejemplo 3: catálogos para armar un buscador
 * https://homlity.com/desarrolladores/
 *
 * Departamento → Ciudad → Barrio, además de tipos de inmueble y gestiones.
 * Todos los modelos de catálogo implementan JsonSerializable, así que puedes
 * devolverlos tal cual desde un endpoint JSON de tu aplicación.
 */

require __DIR__ . '/00-bootstrap.php';

$api = simi_api();

// --- Departamentos -----------------------------------------------------------
$departamentos = $api->getDepartamentos();
titulo('Departamentos con inventario (' . count($departamentos) . ')');
foreach ($departamentos as $departamento) {
    printf("  [%s] %s\n", $departamento->id(), $departamento->nombre());
}

if (!$departamentos) {
    exit("Sin departamentos: revisa el token o la disponibilidad del API.\n");
}

// --- Ciudades del primer departamento ----------------------------------------
$idDepartamento = $departamentos[0]->id();
$ciudades = $api->getCiudades($idDepartamento);

titulo('Ciudades de ' . $departamentos[0]->nombre() . ' (' . count($ciudades) . ')');
foreach ($ciudades as $ciudad) {
    printf("  [%s] %s\n", $ciudad->id(), $ciudad->nombre());
}

// --- Barrios de la primera ciudad --------------------------------------------
if ($ciudades) {
    $barrios = $api->getBarrios($ciudades[0]->id());
    titulo('Barrios de ' . $ciudades[0]->nombre() . ' (' . count($barrios) . ')');
    foreach (array_slice($barrios, 0, 20) as $barrio) {
        printf("  [%s] %s\n", $barrio->id(), $barrio->nombre());
    }
}

// --- Tipos de inmueble -------------------------------------------------------
titulo('Tipos de inmueble');
foreach ($api->getTiposInmueble() as $tipo) {
    printf("  [%s] %-25s %s inmuebles\n", $tipo->id(), $tipo->nombre(), $tipo->totalInmuebles());
}

// --- Gestiones (el id se usa en el filtro tipOper) ----------------------------
titulo('Gestiones / operaciones');
foreach ($api->getGestionesInmueble() as $gestion) {
    printf("  [%s] %s   → filtro tipOper=%s\n", $gestion->id(), $gestion->nombre(), $gestion->id());
}

// --- Salida JSON lista para el frontend --------------------------------------
titulo('JSON para el frontend');
echo json_encode([
    'departamentos' => $departamentos,
    'ciudades'      => $ciudades,
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . PHP_EOL;
