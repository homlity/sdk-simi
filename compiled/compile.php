<?php
require __DIR__ . '/../vendor/autoload.php';
function recurse_copy($src,$dst) {
    $dir = opendir($src);
    @mkdir($dst);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            if ( is_dir($src . '/' . $file) ) {
                recurse_copy($src . '/' . $file,$dst . '/' . $file);
            }
            else {
                copy($src . '/' . $file,$dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}

use pmaslak\PhpObfuscator\Obfuscator;
$obfuscator = new Obfuscator([
    'allowed_mime_types' => ['text/x-php'],
    'obfuscation_options' => [
        "no-obfuscate-function-name",
        "no-obfuscate-variable-name",
        "no-obfuscate-constant-name",
        "no-obfuscate-trait-name",
        "no-obfuscate-class_constant-name",
        "no-obfuscate-property-name",
        "no-obfuscate-interface-name",
        "no-obfuscate-namespace-name",
        'no-obfuscate-method-name',
        'no-obfuscate-class-name']
]);


$pathOtAbs = __DIR__."/compile";
mkdir($pathOtAbs);
$pathOut = $pathOtAbs."/visualinmueblesynfony";
mkdir($pathOut);


$obfuscator->obfuscateDirectory(__DIR__ . "/../src", $pathOut . '/src/');
//crea la campeta vendo
//exec("composer install");

//la mueve al compilado
//rename(__DIR__."/vendor",$pathOut."/vendor");