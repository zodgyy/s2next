<?php

class views {
    
    function get_views ($controller, $view, $data) {
        
        $controller = get_class($controller);
        
        if ($controller === "home") {
            $view = "views/" . $view . ".php";
        } else {
            $view = "views/" . $controller . "/" . $view . ".php";
        }
        
        require_once $view;
    }
}