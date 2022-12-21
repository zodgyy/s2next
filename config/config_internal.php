<?php
/**
 * SE DEBE CAMBIAR A LA RUTA
 * Ej. localhost/prueba
 */
define("NAME_SITE", "localhost/s2next");
define("SITE", "localhost/s2next");

/******************************* NO EDITAR *******************************/

// Variable de control para instancia a la base de datos
$PROTOCOL = (isset($_SERVER['HTTPS'])) ? 'https://' : 'http://'; // No editar
$db = NULL; 
$nav_menu = "";
define('DEBUG', false);

define('C_DIR', "/"); // No editar

// Definimos la WEB PATH General
define("WEB_PATH", $PROTOCOL . SITE . '/'); // No editar

// Obtenemos la ruta absoluta
define('RAIZ', dirname(__DIR__) . C_DIR); // No editar

define("SUCCESS", 1);  // No editar
define("FAILED", -1);  // No editar
define("DUPLIED", -2);  // No editar
define("NOEXIST", -3);  // No editar

//lenguaje default
$Language = "es";

// Definimos localidad mexico
setlocale(LC_TIME, "es_MX.UTF-8");

// zona horaria
date_default_timezone_set('America/Mexico_City'); 

// Obtenemos fecha de ingreso general al sitio
define("DateTimeServer", date("Y-m-d H:i:s"));

// Controlador default
define("CONTROLADOR_PRINCIPAL", "home");

// Metodo default
define("METODO_PRINCIPAL", "index");

// validamos la existencia del archivo de conexion a la base de datos
if ((!file_exists("config/config.ini")) && (!preg_match("/config.ini/", $_SERVER['PHP_SELF']))) {
    die("No se puede continuar....");
} else {    
    // requerimos archivo para la conexion a la base de datos
    require_once('libraries/core/db.php');
    // Creamos instancia a la base de datos
    $db = new db('config/config.ini');
}