<?php 

require_once 'config/config_internal.php';
require_once 'helpers/helpers.php';

$params = array();
$__url__ = !empty($_REQUEST['__url__']) ? $_REQUEST['__url__'] : 'home/index';
$arrURL = explode("/", $__url__);

$controller = $arrURL[0];
$method = (!empty($arrURL[1]) && $arrURL[1] !== "") ? $arrURL[1] : METODO_PRINCIPAL;

if (!empty($arrURL[2]) && $arrURL[2] !== "") {
    for ($i = 2; $i < count($arrURL); $i++) {
        $params[] = $arrURL[$i];
    }
}

require_once 'libraries/core/autoload.php';  
require_once 'libraries/core/routing.php';