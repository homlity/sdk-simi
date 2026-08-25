<p align="center">
  <a href="https://homlity.com/desarrolladores/">
    <img src="https://homlity.com/wp-content/uploads/2026/08/Diseno-sin-titulo-1-e1787507729419-1024x338.webp" alt="Homlity para desarrolladores" width="320">
  </a>
</p>

# Ejemplos del SDK SIMI

Ejemplos ejecutables desde la línea de comandos. Todos incluyen
[`00-bootstrap.php`](00-bootstrap.php), que construye la fachada del API a partir
de la variable de entorno `SIMI_TOKEN`.

```bash
composer install
export SIMI_TOKEN="tu-token-de-40-a-50-caracteres-503"

php examples/01-listado-inmuebles.php
```

| Archivo | Qué muestra |
|---|---|
| [`00-bootstrap.php`](00-bootstrap.php) | Cómo implementar `TokenServiceProviderRespository` y construir el API |
| [`01-listado-inmuebles.php`](01-listado-inmuebles.php) | Listado con filtros, lectura de modelos y paginación (`PaginatorHTML`) |
| [`02-detalle-inmueble.php`](02-detalle-inmueble.php) | Ficha completa: ubicación, precios, fotos, video, características y asesor |
| [`03-catalogos-buscador.php`](03-catalogos-buscador.php) | Departamentos → ciudades → barrios, tipos y gestiones; salida JSON |
| [`04-destacados-y-asesores.php`](04-destacados-y-asesores.php) | Destacados para el home y listado paginado de asesores |
| [`05-inmuebles-similares.php`](05-inmuebles-similares.php) | Bloque "También te puede interesar" + URL de la ficha técnica |
| [`06-exportar-inventario-csv.php`](06-exportar-inventario-csv.php) | Recorrido de todas las páginas y exportación a CSV |
| [`07-api-con-cache.php`](07-api-con-cache.php) | Decorador con caché sobre `ApiFachadaRepository` |

Algunos ejemplos aceptan argumentos:

```bash
php examples/02-detalle-inmueble.php 503-4848
php examples/05-inmuebles-similares.php 503-4848
php examples/06-exportar-inventario-csv.php > inventario.csv
```

> Estos ejemplos consultan el **API real** de SIMI. Necesitas un token válido y
> salida a internet hacia `simi-api.com`.

Documentación completa en el [README del SDK](../README.md) y en el
[portal de desarrolladores de Homlity](https://homlity.com/desarrolladores/).
