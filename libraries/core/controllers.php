<?php

class controllers {
    
    private $dbc;
    
    public function __construct($dbc) {
        $this->dbc = $dbc; // carga de la conexion a DB
        $this->views = new views(); // carga de vistas        
        $this->loadModels($this->dbc); // carga de modelos
    }
    
    public function loadModels($db) {
        $model = get_class($this) . "Model";
        $routeClass = "models/" . $model . ".php";
        if (file_exists($routeClass)) {
            require_once $routeClass;
            $this->model = new $model($db);
        } 
    }
}