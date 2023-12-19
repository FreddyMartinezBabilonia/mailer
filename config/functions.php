<?php
function autoload($class) {
    include 'controllers/'.$class.'.php';
}
function env($string = "", $default = "")
{    
    if($string == "") return "";
    return $_SERVER["$string"]??$default;
}
function sanitizeInput($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    return $input;
}
function dd($content=null){
    print_r($content);
    die();
}
function save_image($url_imagen = ""){

    $nombre_imagen = basename($url_imagen);

    $ruta_carpeta = URL_ROOT."temp/";

    if (!file_exists($ruta_carpeta)) {
        mkdir($ruta_carpeta, 0777, true);
    }

    $ruta_archivo = $ruta_carpeta . $nombre_imagen;
    
    if(file_exists($ruta_archivo)) return $nombre_imagen;

    $resultado = file_put_contents($ruta_archivo, file_get_contents($url_imagen));

    return $nombre_imagen;
}
$root = dirname(__DIR__, 1);;
$parts = explode("/", $root);
$last_line = end($parts);
$last_line = ($last_line == "")? "" : "/";

define("URL_ROOT", $root . $last_line );

$dotenv = Dotenv\Dotenv::createImmutable(URL_ROOT);
$dotenv->load(); 

define("EMAIL_TEMPLATE_DEFAULT" , env("APP_MAIL_TEMPLATE_DEFAULT"));

$ruta_partials = URL_ROOT."views/partials/";
if (!file_exists($ruta_partials)) {
    mkdir($ruta_partials, 0777, true);
}

#spl_autoload_register('autoload');