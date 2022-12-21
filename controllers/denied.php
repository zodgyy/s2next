<?php

class denied extends controllers {
    
    public function __construct() {
        parent::__construct(null);        
    }
    
    function index() {
        
        $data['page_id'] = 0;
        $data['name_domain'] = NAME_SITE;
        $data['page_name'] = "DENIED";
        
        $this->views->get_views($this, "denied", $data);
    }
}