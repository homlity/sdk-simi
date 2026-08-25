# Changelog

Todos los notables cambios de este proyecto estaran documentados en este archivo.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [3.0.0] - 2026-08-24
### Changed
- **BREAKING**: el paquete pasa de `codwelt/sdk-simi` a `homlity/sdk-simi` y el namespace raíz de
  `Codwelt\SIMI\SDK\` a `Homlity\SIMI\SDK\`. Los proyectos que ya usan el SDK deben actualizar sus
  sentencias `use` y ejecutar `composer dump-autoload`. No cambió ninguna clase, método ni firma.

### Added
- Documentación completa para desarrolladores en `README.md` y en `docs/index.html`.
- Carpeta `examples/` con ocho ejemplos ejecutables desde la terminal.

## [2.5.5] - 2025-10-17
### Fixed
- Se hace correcion de configuracion de sincronizacion

## [2.5.1] - 2025-09-10
### Fixed
- Se modifica el numero de caracteres de la validacion del sdk


## [2.2.30] - 2023-03-02
### Changed
- Se añade a la sincronizacion de DOMUS que se le asigne el id de la caracteristica del integrador a la base de datos interna
- Se extrae logica que calcula el id de gestion del inmueble de wasi y se le añaden pruebas unitarias


## [3.4.0] - 2023-06-16

### Added
- Se añade la posibilidad de obtener la informacion de la localidad del inmueble