<p align="center">
  <a href="https://homlity.com/desarrolladores/">
    <img src="https://homlity.com/wp-content/uploads/2026/08/Diseno-sin-titulo-1-e1787507729419-1024x338.webp" alt="Homlity para desarrolladores" width="420">
  </a>
</p>

<h1 align="center">SDK SIMI para PHP</h1>

<p align="center">
  Cliente PHP oficial mantenido por <a href="https://homlity.com/">Homlity</a> para consumir el API de
  <strong>SIMI</strong> (CRM inmobiliario) desde cualquier proyecto PHP, Laravel o WordPress.
</p>

<p align="center">
  <a href="https://homlity.com/">🏠 homlity.com</a> ·
  <a href="https://homlity.com/desarrolladores/">👩‍💻 Portal de desarrolladores</a> ·
  <a href="https://github.com/homlity/sdk-simi">📦 GitHub</a> ·
  <a href="CHANGELOG.md">📝 Changelog</a>
</p>

---

> 📘 **¿Prefieres leerlo como página web?** El repositorio incluye una versión navegable con el
> mismo contenido en [`docs/index.html`](docs/index.html) (autocontenida, lista para GitHub Pages).
> Los ejemplos ejecutables están en [`examples/`](examples/).

---

## Tabla de contenido

1. [¿Qué es este SDK y para qué sirve?](#1-qué-es-este-sdk-y-para-qué-sirve)
2. [Requisitos](#2-requisitos)
3. [Instalación](#3-instalación)
4. [El token de SIMI](#4-el-token-de-simi)
5. [Primeros pasos (Quickstart)](#5-primeros-pasos-quickstart)
6. [Arquitectura del SDK](#6-arquitectura-del-sdk)
7. [Referencia del API (`ApiFachada`)](#7-referencia-del-api-apifachada)
8. [Filtros disponibles](#8-filtros-disponibles)
9. [Referencia de modelos](#9-referencia-de-modelos)
10. [Servicios de aplicación](#10-servicios-de-aplicación)
11. [Paginación](#11-paginación)
12. [Recetas y ejemplos completos](#12-recetas-y-ejemplos-completos)
13. [Integración con Laravel](#13-integración-con-laravel)
14. [Integración con WordPress](#14-integración-con-wordpress)
15. [Rendimiento y caché](#15-rendimiento-y-caché)
16. [Manejo de errores](#16-manejo-de-errores)
17. [Advertencias y comportamientos a tener en cuenta](#17-advertencias-y-comportamientos-a-tener-en-cuenta)
18. [Pruebas](#18-pruebas)
19. [Versionado y contribución](#19-versionado-y-contribución)
20. [Soporte](#20-soporte)
21. [Licencia](#21-licencia)

---

## 1. ¿Qué es este SDK y para qué sirve?

**SIMI** es un CRM inmobiliario usado por inmobiliarias y constructoras (principalmente en Colombia) para
administrar su inventario de inmuebles, sus asesores y sus sedes. SIMI expone ese inventario mediante un API
HTTP público por inmobiliaria, autenticado con un token.

Ese API devuelve JSON "crudo", con nombres de campos inconsistentes entre endpoints
(`Codigo_Inmueble` vs `idInm`, `banios` vs `banos`, `Venta` vs `ValorVenta`, precios con símbolos y puntos
mezclados dentro de strings, etc.). **Este SDK existe para que nunca tengas que tocar ese JSON.**

Con el SDK obtienes:

| Sin SDK | Con SDK |
|---|---|
| Construir URLs a mano tipo `.../filtroInmueble/ciudad/5/total/12` | `$api->getInmuebles(["ciudad" => 5, "total" => 12])` |
| `curl` + `json_decode` + validar `status` en cada llamada | Objetos `Response*` con `isSuccess()` |
| Leer `$json["Inmuebles"][0]["Codigo_Inmueble"]` | `$inmueble->identificacion()` |
| Limpiar `"$ 350.000.000"` con regex | `$inmueble->valorVenta()` → `350.000.000` |
| Descubrir qué filtros acepta el API a base de errores | Filtros validados: filtro inválido → excepción inmediata |
| Reimplementar paginación en cada proyecto | `PaginadorInmueblePreview` + `PaginatorHTML` |

### Casos de uso típicos

- **Portales inmobiliarios**: listados con filtros, ficha de detalle, mapa, galería, video y fotos 360.
- **Landing pages / home**: carrusel de inmuebles destacados.
- **Buscadores**: selects encadenados departamento → ciudad → barrio, tipos de inmueble y gestiones.
- **Página "Nuestro equipo"**: listado paginado de asesores con foto, celular y correo.
- **Sincronizaciones / feeds**: exportar inventario hacia portales externos u otros sistemas.
- **Widgets y shortcodes** de WordPress alimentados con inventario real.

---

## 2. Requisitos

| Requisito | Detalle |
|---|---|
| PHP | 7.x u 8.x (el código es compatible desde PHP 7.1; usa tipado de retorno y `array_filter` con `ARRAY_FILTER_USE_BOTH`) |
| `ext-curl` | Obligatoria: toda petición HTTP se hace con cURL |
| `ext-json` | Obligatoria: parseo de las respuestas |
| `ext-mbstring` | Obligatoria |
| Token SIMI | Provisto por SIMI/la inmobiliaria (ver §4) |
| Salida a internet | El servidor debe poder alcanzar `simi-api.com` y `api.simicrm.app` |

---

## 3. Instalación

### Vía Composer (recomendado)

```bash
composer require homlity/sdk-simi
```

> El nombre del paquete en `composer.json` es **`homlity/sdk-simi`** y el repositorio es
> **[github.com/homlity/sdk-simi](https://github.com/homlity/sdk-simi)**.

### Migración desde `codwelt/sdk-simi`

El paquete se publicaba antes bajo el vendor `codwelt`. **El vendor y el namespace ahora son `homlity`**,
y ese es un cambio incompatible hacia atrás: todo el código que use el SDK debe actualizar sus
importaciones.

```diff
-composer require codwelt/sdk-simi
+composer require homlity/sdk-simi
```

```diff
-use Codwelt\SIMI\SDK\Domain\Providers\ApiServiceProvider;
-use Codwelt\SIMI\SDK\InfraStructure\API\ApiFachada;
+use Homlity\SIMI\SDK\Domain\Providers\ApiServiceProvider;
+use Homlity\SIMI\SDK\InfraStructure\API\ApiFachada;
```

Un solo comando actualiza todas las referencias de tu proyecto:

```bash
grep -rl 'Codwelt\\SIMI\\SDK' app/ config/ resources/ \
  | xargs sed -i '' 's/Codwelt\\SIMI\\SDK/Homlity\\SIMI\\SDK/g'   # macOS
```

```bash
grep -rl 'Codwelt\\SIMI\\SDK' app/ config/ resources/ \
  | xargs sed -i 's/Codwelt\\SIMI\\SDK/Homlity\\SIMI\\SDK/g'      # Linux
```

Después ejecuta `composer dump-autoload`. Ninguna clase, método ni firma cambió: **solo el namespace**.

> **Nota sobre versiones.** Cambiar el namespace rompe la compatibilidad, así que corresponde una
> versión mayor: **`v3.0.0`**. Publica ese tag antes de usar la restricción `^3.0`; mientras no exista,
> apunta a `dev-master`.

### Vía repositorio VCS

Si el paquete no está disponible en tu Packagist (por ejemplo, si trabajas contra un fork, una rama de
desarrollo o un Packagist privado), agrégalo como repositorio VCS en el `composer.json` de tu proyecto:

```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/homlity/sdk-simi.git"
    }
  ],
  "require": {
    "homlity/sdk-simi": "^3.0"
  }
}
```

```bash
composer update homlity/sdk-simi
```

Para fijar una versión exacta usa cualquiera de los tags publicados (`v2.5.7`, `v2.5.6`, …):

```json
"homlity/sdk-simi": "v2.5.7"
```

### Autoload

El paquete usa PSR-4:

```
Homlity\SIMI\SDK\  →  src/
```

Basta con incluir el autoloader de Composer:

```php
require __DIR__ . '/vendor/autoload.php';
```

---

## 4. El token de SIMI

Todas las peticiones se autentican con un único token que entrega SIMI a cada inmobiliaria.

### Formato

El SDK valida el token contra esta expresión regular antes de permitir cualquier llamada:

```
/^([A-Za-z0-9]{40,50})-([0-9]+)$/
```

Es decir: **entre 40 y 50 caracteres alfanuméricos**, un **guion**, y un **número** (el identificador de la
inmobiliaria/sede). Ejemplo con forma válida:

```
a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0-503
```

Si el token no cumple el formato, `setTokenProvider()` lanza:

```
Exception: El token es invalido
```

### Cómo se envía

| Destino | Mecanismo |
|---|---|
| `http://simi-api.com/ApiSimiweb/response/` | HTTP **Basic Auth**, con usuario vacío y el token como contraseña (`CURLOPT_USERPWD = ":$token"`) |
| `https://api.simicrm.app/crm/` (solo `getEstadoInmueble`) | Cabeceras `token: <token>` y `Accept: application/vnd.apisimi.v3+json` |

### Nunca lo publiques

El token da acceso completo al inventario de la inmobiliaria. **No lo escribas en el código fuente ni lo
subas al repositorio.** Cárgalo desde variables de entorno; para eso existe la interfaz
`TokenServiceProviderRespository` (ver §5).

---

## 5. Primeros pasos (Quickstart)

### Paso 1 — Implementa tu proveedor de token

El SDK nunca recibe el token "a mano": recibe un objeto que sabe de dónde sacarlo. Así puedes leerlo de
`.env`, de la base de datos, de un secreto de tu infraestructura o de la configuración multi-sitio.

```php
<?php

use Homlity\SIMI\SDK\Domain\Providers\TokenServiceProviderRespository;

class TokenSimiProvider implements TokenServiceProviderRespository
{
    public function getToken(): string
    {
        return getenv('SIMI_TOKEN');
    }
}
```

### Paso 2 — Construye el API

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use Homlity\SIMI\SDK\Domain\Providers\ApiServiceProvider;

$provider = ApiServiceProvider::build();
$provider->setTokenProvider(new TokenSimiProvider());   // valida el token aquí

$api = $provider->getAPi();                             // instancia de ApiFachada
```

> **Atajo**: si no necesitas el proveedor puedes instanciar la fachada directamente.
> Ojo: esta vía **no valida** el formato del token.
> ```php
> $api = new \Homlity\SIMI\SDK\InfraStructure\API\ApiFachada(getenv('SIMI_TOKEN'));
> ```

### Paso 3 — Consulta inmuebles

```php
$resultado = $api->getInmuebles([
    'ciudad' => 5,
    'tipOper' => 1,   // gestión: venta/arriendo según la inmobiliaria
    'total'  => 12,   // registros por página
    'limite' => 1,    // página
]);

/** @var \Homlity\SIMI\SDK\InfraStructure\Modelos\InmueblePreview[] $inmuebles */
$inmuebles = $resultado['inmuebles'];
/** @var \Homlity\SIMI\SDK\InfraStructure\Modelos\PaginadorInmueblePreview|null $paginador */
$paginador = $resultado['paginador'];

foreach ($inmuebles as $inmueble) {
    echo $inmueble->nombre(), PHP_EOL;              // "Apartamento - El Poblado, Medellín"
    echo $inmueble->identificacion(), PHP_EOL;      // "503-4848"
    echo $inmueble->valorVenta(), PHP_EOL;          // "350.000.000"
    echo $inmueble->fotoPortada(), PHP_EOL;         // URL de la foto principal
}
```

### Paso 4 — Ficha de detalle

```php
$detalle = $api->getDetalleInmueble('503-4848');

if ($detalle === null) {
    http_response_code(404);
    exit('Inmueble no disponible');
}

echo $detalle->tipoInmueble();     // "APARTAMENTO"
echo $detalle->areaConstruida();   // "85"
echo $detalle->descripcion();

foreach ($detalle->fotos() as $foto) {
    echo '<img src="' . htmlspecialchars($foto['foto']) . '">';
}

$asesor = $detalle->asesor();
if ($asesor !== null) {
    echo $asesor->nombre(), ' - ', $asesor->celular();
}
```

---

## 6. Arquitectura del SDK

El paquete sigue una separación por capas al estilo de arquitectura hexagonal:

```
src/
├── Domain/                     ← Contratos y puertos (lo estable)
│   ├── API/
│   │   ├── ApiFachadaRepository.php        (clase abstracta: el contrato del API)
│   │   └── ApiModelRepositoryFachada.php   (variante que envuelve en modelos de dominio)
│   ├── ModelRepository/
│   │   └── Inmueble.php                    (modelo de dominio con helpers de presentación)
│   └── Providers/
│       ├── ApiServiceProviderRepository.php     (fábrica + validación del token)
│       ├── ApiServiceProvider.php               (produce ApiFachada)
│       ├── ApiModelRepositoryServiceProvider.php(produce ApiModelRepositoryFachada)
│       └── TokenServiceProviderRespository.php  (interfaz que TÚ implementas)
│
├── InfraStructure/             ← Todo lo que habla HTTP y mapea JSON
│   ├── API/ApiFachada.php      (implementación concreta: los métodos que usas)
│   ├── Requests/               (una clase por endpoint + HttpClient con cURL)
│   ├── Responses/              (una clase por respuesta, con isSuccess()/getBody())
│   └── Modelos/                (InmueblePreview, InmuebleDetail, Ciudad, Asesor…)
│
├── Application/                ← Casos de uso listos para usar
│   ├── ObtenedorInmueblesSimilaresService.php
│   ├── ObtenedorUrlFichaInmuebleService.php
│   └── Models/PaginatorHTML.php
│
└── Helpers/Str.php
```

### Flujo de una llamada

```
Tu código
   │
   ├─► ApiServiceProvider::build()            (fábrica estática)
   │        └─ setTokenProvider(...)          → valida el formato del token
   │
   ├─► $provider->getAPi()                    → ApiFachada
   │
   └─► $api->getInmuebles([...])
            │
            ├─► RequestFiltroInmuebles        → valida filtros y arma el endpoint
            │        └─ HttpClient::send()    → cURL + Basic Auth
            │
            ├─► ResponseFiltroInmueble        → json_decode + isSuccess()
            │
            └─► InmueblePreview[] + PaginadorInmueblePreview
```

### Por qué te importa esta separación

- Puedes **tipar contra `ApiFachadaRepository`** (la abstracción) y no contra la implementación concreta.
  Eso te permite inyectar un doble de prueba, un decorador con caché o un mock en tus tests sin tocar red.
- Los **servicios de aplicación** (`Application/`) reciben `ApiFachadaRepository` por constructor, así que
  funcionan igual con la fachada real o con la que tú decores.

---

## 7. Referencia del API (`ApiFachada`)

Todos los métodos pueden lanzar `\Exception` (URL inválida, filtro no permitido, parámetro requerido faltante).

| Método | Devuelve | Endpoint real |
|---|---|---|
| `getInmuebles(array $filtros = [])` | `['inmuebles' => InmueblePreview[], 'paginador' => PaginadorInmueblePreview\|null]` | `v2.1.1/filtroInmueble/...` |
| `getDetalleInmueble($codigoInmueble)` | `InmuebleDetail` o `null` | `v2/inmueble/codInmueble/{codigo}` |
| `getInmueblesDestacados(array $filtros = [])` | `['inmuebles' => InmueblePreview[], 'paginador' => …]` | `v21/inmueblesDestacados/...` |
| `getDepartamentos()` | `Departamento[]` | `v2/departamento` |
| `getCiudades($idDepartamento)` | `Ciudad[]` | `v2/ciudad/idDepartamento/{id}` |
| `getBarrios($idCiudad)` | `Barrio[]` | `v2/barrios/idCiudad/{id}` |
| `getTiposInmueble()` | `TipoInmueble[]` | `v2/tipoInmuebles/unique/1` |
| `getGestionesInmueble()` | `GestionInmueble[]` | `gestion` |
| `getAsesores(array $filtros = [])` | `['asesores' => AsesorUsuario[], 'paginador' => PaginadorAsesores\|null]` | `usuarios/...` |
| `getEstadoInmueble(int $idEstado, $idGestion)` | `InmueblePreview[]` | `api.simicrm.app/crm/inmuebles?estado=…&gestion=…` |
| `getToken()` | `string` | — |

### `getInmuebles(array $filtros = [])`

Listado paginado con filtros. Es el método central del SDK.

```php
$r = $api->getInmuebles([
    'departamento' => 5,
    'ciudad'       => 1,
    'barrio'       => 320,
    'tipoInm'      => 1,
    'tipOper'      => 2,
    'valmin'       => 200000000,
    'valmax'       => 600000000,
    'alcobas'      => 3,
    'total'        => 12,
    'limite'       => 2,
]);
```

- Los filtros con valor "vacío" (`""`, `null`, `0`, `[]`) **se descartan** antes de armar la URL.
- Si `isSuccess()` falla, devuelve `['inmuebles' => [], 'paginador' => null]` — sin excepción.
- Valores por defecto: `total = 30`, `limite = 1`.

### `getDetalleInmueble($codigo)`

Recibe el **código público del inmueble** (formato `sede-consecutivo`, p. ej. `"503-4848"`).
Devuelve `InmuebleDetail` o `null` si el API respondió sin cuerpo útil.

```php
$detalle = $api->getDetalleInmueble('503-4848');
if ($detalle === null) { /* 404 */ }
```

Lanza excepción si `$codigo` está vacío:
`El codigo del inmueble es requerido para obtener el detalle del inmueble`.

### `getInmueblesDestacados(array $filtros = [])`

Solo acepta `limite` y `total`. Ideal para el home.

```php
$destacados = $api->getInmueblesDestacados(['total' => 6])['inmuebles'];
```

### `getDepartamentos()` / `getCiudades($id)` / `getBarrios($id)`

Catálogo geográfico **de la inmobiliaria** (solo devuelve zonas donde hay inventario). Los tres modelos
implementan `JsonSerializable`, así que puedes devolverlos directamente desde un endpoint JSON propio:

```php
header('Content-Type: application/json');
echo json_encode($api->getCiudades(5));   // [{"id":"1","nombre":"MEDELLIN"}, ...]
```

### `getTiposInmueble()`

Tipos con conteo de inventario, útil para menús tipo "Apartamentos (124)".

```php
foreach ($api->getTiposInmueble() as $tipo) {
    printf("%s (%d)\n", $tipo->nombre(), $tipo->totalInmuebles());
}
```

### `getGestionesInmueble()`

Las gestiones/operaciones configuradas (Venta, Arriendo, Arriendo/Venta…). El `id()` es el valor que se pasa
en el filtro `tipOper`.

### `getAsesores(array $filtros = [])`

Filtros permitidos: `limite` (página), `cantidad` (por página, por defecto 30) y `asesor` (id puntual).

```php
$r = $api->getAsesores(['cantidad' => 12, 'limite' => 1]);
foreach ($r['asesores'] as $asesor) {
    echo $asesor->nombre(), ' · ', $asesor->email(), ' · ', $asesor->celular();
}
echo 'Total: ' . $r['paginador']->total();
```

### `getEstadoInmueble(int $idEstado, $idGestion)`

**Usa un API distinto** (`https://api.simicrm.app/crm/`, cabecera `token`, versión `v3`). Devuelve un array
plano de `InmueblePreview` filtrando por estado y gestión. El SDK acepta las tres formas de respuesta que
usa ese endpoint (`data`, `Inmuebles` o array plano).

```php
$disponibles = $api->getEstadoInmueble(1, 2);
```

> Si tu token no está habilitado para el API v3 del CRM, este método devolverá un array vacío aunque los
> demás métodos funcionen correctamente.

---

## 8. Filtros disponibles

### `getInmuebles()`

Cualquier clave fuera de esta lista lanza `Exception: Filtro (x) no esta permitido en APISIMI`.

| Filtro | Significado | Ejemplo |
|---|---|---|
| `departamento` | Id de departamento (de `getDepartamentos()`) | `5` |
| `ciudad` | Id de ciudad (de `getCiudades()`) | `1` |
| `zona` | Id de zona | `12` |
| `barrio` | Id de barrio (de `getBarrios()`) | `320` |
| `tipoInm` | Id de tipo de inmueble (de `getTiposInmueble()`) | `1` |
| `tipOper` | Id de gestión/operación (de `getGestionesInmueble()`) | `2` |
| `areamin` / `areamax` | Rango de área construida en m² | `50` / `180` |
| `valmin` / `valmax` | Rango de precio (sin puntos ni símbolos) | `200000000` |
| `alcobas` | Número de alcobas | `3` |
| `banios` | Número de baños | `2` |
| `garajes` | Número de garajes | `1` |
| `campo` | Campo por el cual ordenar | `Venta` |
| `order` | Sentido del orden | `ASC` / `DESC` |
| `limite` | Página solicitada (por defecto `1`) | `2` |
| `total` | Registros por página (por defecto `30`) | `12` |
| `sede` | Id de sede, para inmobiliarias multi-sede | `503` |

### `getInmueblesDestacados()`

`limite`, `total`.

### `getAsesores()`

`limite`, `cantidad`, `asesor`.

---

## 9. Referencia de modelos

### `InmueblePreview`

Objeto liviano que devuelve `getInmuebles()`, `getInmueblesDestacados()` y `getEstadoInmueble()`.

| Método | Devuelve | Campo crudo |
|---|---|---|
| `identificacion()` | Código público, p. ej. `503-4848` | `Codigo_Inmueble` |
| `nombre()` | `"Apartamento - El Poblado, Medellín"` (generado) | — |
| `tipoInmueble()` | Nombre del tipo | `Tipo_Inmueble` |
| `gestion()` / `idGestion()` | Operación y su id | `Gestion` / `idGestion` |
| `enArriendo()` / `enArriendoVenta()` | `bool` según la gestión | — |
| `valorVenta(bool $format = true)` | `"350.000.000"` o `350000000` | `Venta` |
| `valorArriendo(bool $format = true)` | idem | `Canon` |
| `administracion($format = false)` | Valor de administración | `Administracion` |
| `alcobas()` / `baños()` / `garaje()` | Conteos | `Alcobas` / `banios` / `garaje` |
| `areaConstruida()` / `areaLote()` | Áreas en m² | `AreaConstruida` / `AreaLote` |
| `estrato()` / `edad()` / `estado()` | Datos adicionales | `Estrato` / `EdadInmueble` / `idEstado` |
| `departamento()` / `ciudad()` / `zona()` / `barrio()` | Ubicación (texto) | `Departamento`, `Ciudad`, `Zona`, `Barrio` |
| `latitud()` / `longitud()` | Coordenadas | `latitud` / `longitud` |
| `descripcion()` | Descripción larga | `descripcionlarga` |
| `fotoPortada()` | URL de la foto principal | `foto1` |
| `logo()` | Logo de la inmobiliaria | `logo` |
| `video360()` | URL del recorrido 360 | `video360` |

### `InmuebleDetail extends InmueblePreview`

Devuelto por `getDetalleInmueble()`. **Sobrescribe los getters** porque el endpoint de detalle usa otros
nombres de campo, y agrega:

| Método | Devuelve |
|---|---|
| `identificacion()` | `idInm` (id interno del detalle) |
| `direccion()` | Dirección o `null` |
| `barrioId()` / `ciudadId()` / `departamentoId()` / `idZona()` | Ids de ubicación |
| `idLocalidad()` / `nlocalidad()` | Localidad (disponible desde v3.4.0) |
| `idTipoInmueble()` / `idGestion()` / `idSede()` | Ids para armar consultas relacionadas |
| `fotos()` | Array crudo de fotos (`[['foto' => 'https://…'], …]`) |
| `fotos360()` | Array de recorridos 360 |
| `video()` | URL de video normalizada (limpia dobles barras) o `null` |
| `caracterisitcasInternas()` | `CaracteristicaInterna[]` *(nota: el nombre del método lleva la errata original)* |
| `caracteristicasExternas()` | `CaracteristicaExterna[]` |
| `caracteristicasAlrededores()` | `CaracteristicaAlrededores[]` |
| `caracteristicas()` | Todas las anteriores en un solo array |
| `caracteristicasPorColumnas(int $n = 3)` | Características repartidas en `n` columnas, listas para maquetar |
| `asesor()` | `AsesorDetalleInmueble` o `null` |
| `administracionIncluida()` | `bool` (campo `AdmonIncluida == '1'`) |
| `valorVenta()` / `valorArriendo()` | Leen `ValorVenta` / `ValorCanon` |

### Características

`CaracteristicaInterna`, `CaracteristicaExterna` y `CaracteristicaAlrededores` comparten la misma forma:

```php
$c->id();            // id de la característica
$c->descripcion();   // "Cocina integral"
$c->cantidad();      // "1"
$c->observacion();   // texto libre
```

### Asesores

`AsesorUsuario` (listado) y `AsesorDetalleInmueble` (ficha) extienden `AsesorRepository`:

```php
$asesor->id();        // string
$asesor->nombre();
$asesor->celular();
$asesor->email();
$asesor->foto();      // URL
$asesor->raw();       // array crudo, por si necesitas un campo no mapeado
```

### Catálogos

`Departamento`, `Ciudad`, `Barrio`, `GestionInmueble` y `TipoInmueble` exponen `id()` y `nombre()`
(`TipoInmueble` además `totalInmuebles()`). Todos implementan `JsonSerializable`.

---

## 10. Servicios de aplicación

### `ObtenedorInmueblesSimilaresService`

Devuelve inmuebles parecidos a uno dado (misma zona, mismo tipo, misma gestión), excluyendo el original.
Perfecto para el bloque "También te puede interesar" de la ficha.

```php
use Homlity\SIMI\SDK\Application\ObtenedorInmueblesSimilaresService;

$servicio = new ObtenedorInmueblesSimilaresService($api);

// A partir del código:
$similares = $servicio->obtenerConCodigo('503-4848');       // array (vacío si no existe)

// O si ya tienes el detalle cargado (evita una petición extra):
$similares = $servicio->obtener($detalle, 5);               // hasta 4 resultados
```

> `obtener($detalle, $cantidad)` pide `$cantidad` inmuebles al API y devuelve **`$cantidad - 1`**, porque
> reserva un espacio para descartar el inmueble original. Pide uno más de los que quieras mostrar.

### `ObtenedorUrlFichaInmuebleService`

Construye la URL de la ficha técnica en SIMI para un inmueble.

```php
use Homlity\SIMI\SDK\Application\ObtenedorUrlFichaInmuebleService;

$url = (new ObtenedorUrlFichaInmuebleService())->getUrl($inmueblePreview);
// https://simicrm.app/mcomercialweb/fichas_tecnicas/fichatec3.php?reg=503-4848
```

### `PaginatorHTML`

Paginador de propósito general que genera el HTML de la paginación (compatible con las clases de Bootstrap).

```php
use Homlity\SIMI\SDK\Application\Models\PaginatorHTML;

$paginador = $resultado['paginador'];

$html = new PaginatorHTML(
    $paginador->totalInmuebles(),     // total de registros
    $paginador->totalPorPagina(),     // registros por página
    $paginador->paginaActual(),       // página actual
    '/inmuebles?page=__PAGENUMBER__'  // patrón de URL
);
$html->setMaxPagesToShow(7);

echo $html->toHtml();
// o si prefieres maquetar tú:
foreach ($html->getPages() as $page) {
    // ['num' => 3, 'url' => '/inmuebles?page=3', 'isCurrent' => false]
}
```

---

## 11. Paginación

`getInmuebles()` y `getInmueblesDestacados()` devuelven un `PaginadorInmueblePreview`:

```php
$p = $resultado['paginador'];

$p->paginaActual();       // int — página actual
$p->totalInmuebles();     // int — total de registros del filtro
$p->totalPorPagina();     // int — registros por página
$p->numeroPaginaInicio(); // int
$p->numeroPaginaFin();    // int
```

`getAsesores()` devuelve un `PaginadorAsesores` con `paginaActual()`, `total()`, `totalPorPagina()`,
`numeroPaginaInicio()` y `numeroPaginaFin()`.

**Recuerda:** el paginador es `null` cuando la petición no fue exitosa. Verifica siempre antes de usarlo.

```php
$totalPaginas = 0;
if ($p !== null && $p->totalPorPagina() > 0) {
    $totalPaginas = (int) ceil($p->totalInmuebles() / $p->totalPorPagina());
}
```

---

## 12. Recetas y ejemplos completos

En la carpeta [`examples/`](examples/) encontrarás estos ejemplos como archivos PHP ejecutables.

### Buscador con selects encadenados (JSON para tu frontend)

```php
<?php
require __DIR__ . '/vendor/autoload.php';

header('Content-Type: application/json; charset=utf-8');

$api = (new ApiFactory())->make();     // tu propia fábrica, ver §13

switch ($_GET['recurso'] ?? '') {
    case 'departamentos':
        echo json_encode($api->getDepartamentos());
        break;
    case 'ciudades':
        echo json_encode($api->getCiudades((int) $_GET['idDepartamento']));
        break;
    case 'barrios':
        echo json_encode($api->getBarrios((int) $_GET['idCiudad']));
        break;
    case 'tipos':
        echo json_encode($api->getTiposInmueble());
        break;
    case 'gestiones':
        echo json_encode($api->getGestionesInmueble());
        break;
    default:
        http_response_code(400);
        echo json_encode(['error' => 'recurso no válido']);
}
```

### Listado con filtros desde `$_GET` (saneado)

```php
$permitidos = ['departamento','ciudad','zona','barrio','tipoInm','tipOper',
               'areamin','areamax','valmin','valmax','banios','garajes','alcobas'];

$filtros = array_intersect_key($_GET, array_flip($permitidos));
$filtros = array_filter($filtros, fn($v) => $v !== '' && $v !== null);

$filtros['total']  = 12;
$filtros['limite'] = max(1, (int) ($_GET['page'] ?? 1));

try {
    $resultado = $api->getInmuebles($filtros);
} catch (\Exception $e) {
    error_log('[SIMI] ' . $e->getMessage());
    $resultado = ['inmuebles' => [], 'paginador' => null];
}
```

> Filtrar contra la lista blanca **antes** de llamar al SDK evita que un parámetro inventado en la URL
> provoque la excepción `Filtro (x) no esta permitido en APISIMI`.

### Ficha completa con galería, mapa y similares

```php
$detalle = $api->getDetalleInmueble($_GET['codigo'] ?? '');

if ($detalle === null) {
    http_response_code(404);
    include 'templates/404.php';
    exit;
}

$fotos     = $detalle->fotos() ?: [];
$portada   = $fotos ? $fotos[0]['foto'] : '/img/placeholder.jpg';
$similares = (new ObtenedorInmueblesSimilaresService($api))->obtener($detalle, 5);
$columnas  = $detalle->caracteristicasPorColumnas(3);
?>
<h1><?= htmlspecialchars($detalle->tipoInmueble()) ?> en <?= htmlspecialchars($detalle->barrio()) ?></h1>
<p><?= htmlspecialchars($detalle->direccion() ?? '') ?></p>

<div class="galeria">
  <?php foreach ($fotos as $foto): ?>
    <img src="<?= htmlspecialchars($foto['foto']) ?>" loading="lazy" alt="">
  <?php endforeach; ?>
</div>

<?php if ($detalle->video()): ?>
  <iframe src="<?= htmlspecialchars($detalle->video()) ?>" allowfullscreen></iframe>
<?php endif; ?>

<div class="caracteristicas">
  <?php foreach ($columnas as $columna): ?>
    <ul>
      <?php foreach ($columna as $c): ?>
        <li><?= htmlspecialchars($c->descripcion()) ?> (<?= htmlspecialchars($c->cantidad()) ?>)</li>
      <?php endforeach; ?>
    </ul>
  <?php endforeach; ?>
</div>

<div id="mapa" data-lat="<?= $detalle->latitud() ?>" data-lng="<?= $detalle->longitud() ?>"></div>
```

### Precios: formateado vs. numérico

```php
$inmueble->valorVenta();        // "350.000.000"  → para mostrar
$inmueble->valorVenta(false);   // "350000000"    → para comparar, ordenar o JSON-LD
```

Útil para datos estructurados de SEO:

```php
$schema = [
    '@context' => 'https://schema.org',
    '@type'    => 'RealEstateListing',
    'name'     => $detalle->nombre(),
    'url'      => 'https://tusitio.com/inmueble/' . $detalle->identificacion(),
    'image'    => array_column($detalle->fotos() ?: [], 'foto'),
    'offers'   => [
        '@type'         => 'Offer',
        'price'         => $detalle->valorVenta(false),
        'priceCurrency' => 'COP',
    ],
];
echo '<script type="application/ld+json">' . json_encode($schema) . '</script>';
```

### Exportar todo el inventario (paginando)

```php
$pagina = 1;
$porPagina = 50;

do {
    $r = $api->getInmuebles(['total' => $porPagina, 'limite' => $pagina]);
    foreach ($r['inmuebles'] as $inmueble) {
        fputcsv($salida, [
            $inmueble->identificacion(),
            $inmueble->tipoInmueble(),
            $inmueble->ciudad(),
            $inmueble->barrio(),
            $inmueble->valorVenta(false),
            $inmueble->areaConstruida(),
        ]);
    }
    $hayMas = $r['paginador'] !== null
        && ($pagina * $porPagina) < $r['paginador']->totalInmuebles();
    $pagina++;
    usleep(200000);   // sé amable con el API
} while ($hayMas);
```

---

## 13. Integración con Laravel

### 1. Configuración

`config/simi.php`:

```php
<?php
return [
    'token' => env('SIMI_TOKEN'),
];
```

`.env`:

```
SIMI_TOKEN=a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0-503
```

### 2. Proveedor de token

`app/Services/Simi/TokenSimiProvider.php`:

```php
<?php
namespace App\Services\Simi;

use Homlity\SIMI\SDK\Domain\Providers\TokenServiceProviderRespository;

class TokenSimiProvider implements TokenServiceProviderRespository
{
    public function getToken(): string
    {
        return (string) config('simi.token');
    }
}
```

### 3. Service provider

`app/Providers/SimiServiceProvider.php`:

```php
<?php
namespace App\Providers;

use App\Services\Simi\TokenSimiProvider;
use Illuminate\Support\ServiceProvider;
use Homlity\SIMI\SDK\Domain\API\ApiFachadaRepository;
use Homlity\SIMI\SDK\InfraStructure\API\ApiFachada;

class SimiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ApiFachadaRepository::class, function () {
            return new ApiFachada((new TokenSimiProvider())->getToken());
        });
    }
}
```

> Se instancia `ApiFachada` directamente en lugar de usar `ApiServiceProvider::build()` para evitar el
> singleton estático del SDK (ver §17). Si quieres conservar la validación del formato del token,
> replícala o llama a `setTokenProvider()` una sola vez en el `register()`.

### 4. Uso en un controlador

```php
<?php
namespace App\Http\Controllers;

use Homlity\SIMI\SDK\Domain\API\ApiFachadaRepository;
use Illuminate\Http\Request;

class InmuebleController extends Controller
{
    public function __construct(private ApiFachadaRepository $simi) {}

    public function index(Request $request)
    {
        $filtros = $request->only([
            'ciudad', 'barrio', 'tipoInm', 'tipOper', 'valmin', 'valmax', 'alcobas',
        ]);
        $filtros = array_filter($filtros);
        $filtros['total']  = 12;
        $filtros['limite'] = max(1, (int) $request->query('page', 1));

        $resultado = cache()->remember(
            'simi:inmuebles:' . md5(serialize($filtros)),
            now()->addMinutes(10),
            fn () => $this->simi->getInmuebles($filtros)
        );

        return view('inmuebles.index', $resultado);
    }

    public function show(string $codigo)
    {
        $detalle = $this->simi->getDetalleInmueble($codigo);
        abort_if($detalle === null, 404);

        return view('inmuebles.show', ['inmueble' => $detalle]);
    }
}
```

> **Ojo con el caché**: los objetos del SDK son serializables porque solo guardan arrays, pero si prefieres
> cachear los datos crudos usa `Request*`/`Response*` directamente y guarda `getBody()`.

---

## 14. Integración con WordPress

Un shortcode `[simi_destacados total="6"]` para mostrar inventario en cualquier página:

```php
<?php
// wp-content/plugins/simi-inmuebles/simi-inmuebles.php
require_once __DIR__ . '/vendor/autoload.php';

use Homlity\SIMI\SDK\InfraStructure\API\ApiFachada;

function simi_api() {
    static $api = null;
    if ($api === null) {
        $api = new ApiFachada(defined('SIMI_TOKEN') ? SIMI_TOKEN : getenv('SIMI_TOKEN'));
    }
    return $api;
}

function simi_destacados_shortcode($atts) {
    $atts = shortcode_atts(['total' => 6], $atts);
    $key  = 'simi_destacados_' . (int) $atts['total'];

    $inmuebles = get_transient($key);
    if ($inmuebles === false) {
        try {
            $inmuebles = simi_api()->getInmueblesDestacados(['total' => (int) $atts['total']])['inmuebles'];
        } catch (\Exception $e) {
            error_log('[SIMI] ' . $e->getMessage());
            return '';
        }
        set_transient($key, $inmuebles, 15 * MINUTE_IN_SECONDS);
    }

    ob_start(); ?>
    <div class="simi-grid">
      <?php foreach ($inmuebles as $i): ?>
        <article class="simi-card">
          <img src="<?php echo esc_url($i->fotoPortada()); ?>" alt="" loading="lazy">
          <h3><?php echo esc_html($i->nombre()); ?></h3>
          <p class="precio">
            <?php echo $i->enArriendo()
                ? '$ ' . esc_html($i->valorArriendo()) . ' /mes'
                : '$ ' . esc_html($i->valorVenta()); ?>
          </p>
          <p><?php echo (int) $i->alcobas(); ?> alcobas ·
             <?php echo (int) $i->baños(); ?> baños ·
             <?php echo esc_html($i->areaConstruida()); ?> m²</p>
        </article>
      <?php endforeach; ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('simi_destacados', 'simi_destacados_shortcode');
```

Guarda el token en `wp-config.php`, nunca en la base de datos ni en el tema:

```php
define('SIMI_TOKEN', 'a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0-503');
```

---

## 15. Rendimiento y caché

El API de SIMI es la parte lenta de cualquier página que lo consuma. **Cachea siempre.**

Como los servicios del SDK dependen de la abstracción `ApiFachadaRepository`, puedes escribir un decorador
con caché y seguir usando todo el resto del SDK sin cambios:

```php
<?php

use Homlity\SIMI\SDK\Domain\API\ApiFachadaRepository;

class ApiSimiCacheado extends ApiFachadaRepository
{
    public function __construct(
        private ApiFachadaRepository $inner,
        private \Psr\SimpleCache\CacheInterface $cache,
        private int $ttl = 600
    ) {
        parent::__construct($inner->getToken());
    }

    private function recordar(string $key, callable $fn)
    {
        $key = 'simi.' . md5($key);
        $hit = $this->cache->get($key);
        if ($hit !== null) {
            return $hit;
        }
        $valor = $fn();
        $this->cache->set($key, $valor, $this->ttl);
        return $valor;
    }

    public function getInmuebles(array $filters = [])
    {
        return $this->recordar('inmuebles' . serialize($filters),
            fn () => $this->inner->getInmuebles($filters));
    }

    public function getDetalleInmueble($codigoInmueble)
    {
        return $this->recordar('detalle' . $codigoInmueble,
            fn () => $this->inner->getDetalleInmueble($codigoInmueble));
    }

    public function getDepartamentos()          { return $this->recordar('deptos', fn () => $this->inner->getDepartamentos()); }
    public function getCiudades($id)            { return $this->recordar('ciudades'.$id, fn () => $this->inner->getCiudades($id)); }
    public function getBarrios($id)             { return $this->recordar('barrios'.$id, fn () => $this->inner->getBarrios($id)); }
    public function getInmueblesDestacados(array $f = []) { return $this->recordar('destacados'.serialize($f), fn () => $this->inner->getInmueblesDestacados($f)); }
    public function getAsesores(array $f = [])  { return $this->recordar('asesores'.serialize($f), fn () => $this->inner->getAsesores($f)); }
    public function getTiposInmueble()          { return $this->recordar('tipos', fn () => $this->inner->getTiposInmueble()); }
    public function getGestionesInmueble()      { return $this->recordar('gestiones', fn () => $this->inner->getGestionesInmueble()); }
}
```

TTL sugeridos:

| Dato | TTL |
|---|---|
| Departamentos, ciudades, barrios, tipos, gestiones | 12–24 h (cambian muy poco) |
| Listados y destacados | 5–15 min |
| Ficha de detalle | 10–30 min |

---

## 16. Manejo de errores

El SDK usa dos mecanismos distintos, y conviene tener claro cuál aplica:

### Excepciones (`\Exception`)

Se lanzan **antes** de hacer la petición, por errores del programador o de configuración:

| Mensaje | Causa |
|---|---|
| `El token es invalido` | El token no cumple el patrón de §4 |
| `No a seteado el Proveedor del token...` | Llamaste a `getAPi()` sin `setTokenProvider()` |
| `Filtro (x) no esta permitido en APISIMI` | Filtro fuera de la lista blanca |
| `El codigo del inmueble es requerido...` | `getDetalleInmueble('')` |
| `El id del departemento es necesario...` | `getCiudades(null)` |
| `El id de la ciudad es necesaria...` | `getBarrios(null)` |
| `Url Invalida` | La URL construida no pasó `FILTER_VALIDATE_URL` |

### Respuestas vacías (sin excepción)

Si el API responde con error, no responde, o devuelve un cuerpo inesperado, **no hay excepción**: recibes
listas vacías o `null`.

```php
$r = $api->getInmuebles($filtros);
if (empty($r['inmuebles'])) {
    // Puede ser "sin resultados" O una caída del API. Trátalo como estado vacío.
}

$detalle = $api->getDetalleInmueble($codigo);
if ($detalle === null) {
    // 404 o API caído
}
```

### Patrón recomendado

```php
try {
    $resultado = $api->getInmuebles($filtros);
} catch (\Exception $e) {
    error_log('[SIMI] ' . $e->getMessage());
    $resultado = ['inmuebles' => [], 'paginador' => null];
}
```

---

## 17. Advertencias y comportamientos a tener en cuenta

Estas son particularidades reales del código. Conocerlas ahorra horas de depuración.

**1. `build()` es un singleton compartido entre proveedores.**
`ApiServiceProviderRepository::build()` guarda la instancia en una propiedad estática de la **clase padre**.
Si en el mismo proceso llamas primero a `ApiServiceProvider::build()` y luego a
`ApiModelRepositoryServiceProvider::build()`, la segunda llamada devuelve la **primera** instancia.
→ Si necesitas ambas variantes, instancia las fachadas directamente:
```php
$api      = new \Homlity\SIMI\SDK\InfraStructure\API\ApiFachada($token);
$apiModel = new \Homlity\SIMI\SDK\Domain\API\ApiModelRepositoryFachada($token);
```

**2. Filtros con valor `0` se descartan.** `getInmuebles()` filtra con `!empty($value)`, así que
`['garajes' => 0]` nunca llega al API. Para "sin garaje" tendrás que filtrar del lado de tu aplicación.

**3. `idTipoInmueble()` es `protected` en `InmueblePreview`.** Solo es público en `InmuebleDetail`.
Llamarlo sobre un preview desde fuera de la clase produce un `Error` de PHP.

**4. `fotoPortada()` en `InmuebleDetail` asume que hay fotos.** Accede a `fotos()[0]["foto"]` sin validar;
si el inmueble no tiene fotos, genera un aviso. Valida antes:
```php
$fotos = $detalle->fotos() ?: [];
$portada = $fotos ? $fotos[0]['foto'] : '/img/placeholder.jpg';
```

**5. `Domain\ModelRepository\Inmueble::valorArriendo()` devuelve el valor de venta.** Es un defecto conocido
de esa clase auxiliar. Usa `InmueblePreview::valorArriendo()` / `InmuebleDetail::valorArriendo()`.

**6. `caracterisitcasInternas()` está escrito con errata** (`caracterisitcas`, no `caracteristicas`). Se
mantiene así por compatibilidad hacia atrás.

**7. La URL base por defecto es HTTP, no HTTPS** (`http://simi-api.com/ApiSimiweb/response/`). Solo
`getEstadoInmueble()` usa `https://api.simicrm.app/crm/`.

**8. cURL no define timeouts.** Una caída del API puede colgar tu petición. Si es crítico para ti, envuelve
las llamadas en tu propia capa con timeout y caché (§15), o considera un job en segundo plano.

**9. `getEstadoInmueble()` habla con otro API y otra versión** (`v3` del CRM, autenticación por cabecera).
Que funcionen los demás métodos no garantiza que este también.

**10. Los métodos de catálogo no verifican `isSuccess()` antes de iterar.** `getDepartamentos()` itera
directamente sobre la respuesta; si el API falla, puede propagarse un aviso de PHP. Envuélvelos en
`try/catch` en producción.

---

## 18. Pruebas

Las pruebas del repositorio golpean el **API real**, así que necesitan un token válido.

```bash
composer install
cp tests/testing.env.php.example tests/testing.env.php
```

Edita `tests/testing.env.php`:

```php
<?php
return [
    "token-simi"            => "TU_TOKEN_REAL-503",
    "property-detail-code"  => "503-4848",
];
```

Ejecuta:

```bash
vendor/bin/phpunit
vendor/bin/phpunit --filter test_inmueble_detalle_metodos
```

`tests/testing.env.php` está en `.gitignore`: **no** subas tu token.

### Probar tu propio código sin red

Extiende la abstracción y devuelve datos fijos:

```php
use Homlity\SIMI\SDK\Domain\API\ApiFachadaRepository;
use Homlity\SIMI\SDK\InfraStructure\Modelos\InmueblePreview;

class ApiSimiFake extends ApiFachadaRepository
{
    public function getInmuebles(array $filters = [])
    {
        return [
            'inmuebles' => [new InmueblePreview([
                'Codigo_Inmueble' => '503-1',
                'Tipo_Inmueble'   => 'APARTAMENTO',
                'Barrio'          => 'LAURELES',
                'Ciudad'          => 'MEDELLIN',
                'Venta'           => '$ 350.000.000',
                'Canon'           => '0',
                'Alcobas'         => '3',
                'banios'          => '2',
            ])],
            'paginador' => null,
        ];
    }

    public function getDetalleInmueble($codigoInmueble)      { return null; }
    public function getDepartamentos()                        { return []; }
    public function getCiudades($idDepartamento)              { return []; }
    public function getBarrios($idCiudad)                     { return []; }
    public function getInmueblesDestacados(array $f = [])     { return ['inmuebles' => [], 'paginador' => null]; }
    public function getAsesores(array $f = [])                { return ['asesores' => [], 'paginador' => null]; }
    public function getTiposInmueble()                        { return []; }
    public function getGestionesInmueble()                    { return []; }
}
```

---

## 19. Versionado y contribución

- El proyecto sigue [Semantic Versioning](https://semver.org/spec/v2.0.0.html).
- Los cambios se registran en [`CHANGELOG.md`](CHANGELOG.md) siguiendo
  [Keep a Changelog](https://keepachangelog.com/en/1.0.0/).
- Fija la versión en tu `composer.json` (`"homlity/sdk-simi": "^3.0"`) y revisa el changelog antes de subir
  de versión menor.

### Para contribuir

1. Haz un fork de [`homlity/sdk-simi`](https://github.com/homlity/sdk-simi).
2. Crea una rama desde `master`: `git checkout -b fix/mi-arreglo`.
3. Si agregas un endpoint, sigue el patrón existente: una clase en `Requests/`, una en `Responses/`,
   su modelo en `Modelos/`, y expón el método en `ApiFachada` **y** en `ApiFachadaRepository`.
4. Agrega la entrada correspondiente en `CHANGELOG.md`.
5. Abre el Pull Request describiendo el cambio y su impacto en las versiones.

---

## 20. Soporte

| Recurso | Enlace |
|---|---|
| Sitio principal | <https://homlity.com/> |
| Portal de desarrolladores | <https://homlity.com/desarrolladores/> |
| Repositorio | <https://github.com/homlity/sdk-simi> |
| Reportar un problema | <https://github.com/homlity/sdk-simi/issues> |
| Historial de cambios | [CHANGELOG.md](CHANGELOG.md) |
| Licencia | [MIT](LICENSE) |

---

## 21. Licencia

Este SDK se distribuye bajo la licencia **MIT**. Puedes usarlo, modificarlo, integrarlo en proyectos
comerciales y redistribuirlo, siempre que conserves el aviso de copyright. El texto completo está en
[`LICENSE`](LICENSE).

```
Copyright (c) 2026 Homlity
```

> La licencia cubre **el SDK**, no el acceso al API de SIMI: para consumir datos necesitas un token
> válido entregado por SIMI o por la inmobiliaria propietaria del inventario.

---

<p align="center">
  <a href="https://homlity.com/desarrolladores/">
    <img src="https://homlity.com/wp-content/uploads/2026/08/Diseno-sin-titulo-1-e1787507729419-1024x338.webp" alt="Homlity para desarrolladores" width="260">
  </a>
</p>

<p align="center"><sub>Hecho con ☕ por el equipo de <a href="https://homlity.com/">Homlity</a>.</sub></p>
