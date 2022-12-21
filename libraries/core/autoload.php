<?php

spl_autoload_register(function ($clase) {
    if (file_exists("libraries/core/" . $clase . ".php")) {
        require_once "libraries/core/" . $clase . ".php";
    }        
});