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

$root = dirname(__DIR__, 1);;
$parts = explode("/", $root);
$last_line = end($parts);
$last_line = ($last_line == "")? "" : "/";

define("URL_ROOT", $root . $last_line );

$dotenv = Dotenv\Dotenv::createImmutable(URL_ROOT);
$dotenv->load(); 

define("EMAIL_TEMPLATE_DEFAULT" , env("APP_MAIL_TEMPLATE_DEFAULT"));

#spl_autoload_register('autoload');