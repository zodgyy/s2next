<?php

class error_ extends controllers {
    
    public function __construct() {
        parent::__construct(null);        
    }
    
    function notFound() {
        
        $data['page_id'] = 0;
        $data['name_domain'] = SITE;
        $data['page_name'] = "ERROR";
        
        $this->views->get_views($this, "error_", $data);
    }
}

$notFound = new error_();
$notFound->notFound();