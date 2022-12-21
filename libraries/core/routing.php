<?php 

$controller = loadController($controller, $db);
loadMethod($controller, $method, $params);

function loadController($nameController, $db) {

    $nameController = strtolower($nameController);
    $fileController = "controllers/" . $nameController . ".php";

    if (!file_exists($fileController)) {

        $fileController = "controllers/" . CONTROLADOR_PRINCIPAL . ".php";
        $nameController = strtolower(CONTROLADOR_PRINCIPAL);
    }

    require_once $fileController;
    $control = new $nameController($db);
    return $control;
}

function loadMethod($controller, $method, $params = array()) {

    if (isset($method)) {
        
        if (method_exists($controller, $method)) {

            $controller->$method($params);
        } else {

            require_once 'controllers/error.php';
        }         
    } else {
        require_once 'controllers/error.php';
    }
}