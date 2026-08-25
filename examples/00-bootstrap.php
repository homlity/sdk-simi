<?php
/**
 * Homlity — SDK SIMI · Bootstrap común de los ejemplos
 * https://homlity.com/desarrolladores/
 *
 * Todos los ejemplos incluyen este archivo. Define el token en una variable
 * de entorno antes de ejecutarlos:
 *
 *     export SIMI_TOKEN="tu-token-de-40-a-50-caracteres-503"
 *     php examples/01-listado-inmuebles.php
 */

require __DIR__ . '/../vendor/autoload.php';

use Homlity\SIMI\SDK\Domain\Providers\ApiServiceProvider;
use Homlity\SIMI\SDK\Domain\Providers\TokenServiceProviderRespository;

/**
 * El SDK no recibe el token directamente: recibe un objeto que sabe obtenerlo.
 * Así puedes leerlo del entorno, de la base de datos o de un gestor de secretos
 * sin que el token quede escrito en el código.
 */
class TokenSimiEnvProvider implements TokenServiceProviderRespository
{
    public function getToken(): string
    {
        $token = getenv('SIMI_TOKEN');

        if (!$token) {
            fwrite(STDERR, "Falta la variable de entorno SIMI_TOKEN\n");
            exit(1);
        }

        return $token;
    }
}

/**
 * Devuelve la fachada del API lista para usar.
 *
 * @return \Homlity\SIMI\SDK\InfraStructure\API\ApiFachada
 */
function simi_api()
{
    static $api = null;

    if ($api === null) {
        try {
            $provider = ApiServiceProvider::build();
            $provider->setTokenProvider(new TokenSimiEnvProvider()); // valida el formato del token
            $api = $provider->getAPi();
        } catch (\Exception $e) {
            fwrite(STDERR, '[SIMI] ' . $e->getMessage() . PHP_EOL);
            exit(1);
        }
    }

    return $api;
}

function titulo(string $texto): void
{
    echo PHP_EOL . str_repeat('=', 70) . PHP_EOL . $texto . PHP_EOL . str_repeat('=', 70) . PHP_EOL;
}
