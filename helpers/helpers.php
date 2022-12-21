<?php
/*************************************************************/
function base_url() {
    return WEB_PATH;
}
/*************************************************************/
function head($data = "") {
    $view_header = "views/template/head.php";
    require_once $view_header;
}
/*************************************************************/
function foot($data = "") {
    $view_footer = "views/template/foot.php";
    require_once $view_footer;
}
/*************************************************************/
function getModal ($nameModal, $data) {
    $view_modal = "views/template/modals/{$nameModal}.php";
    require_once $view_modal;
}
/**************** IMPRIMIR ARREGLOS EN PANTALLA ****************/
function show_dep($data = array()) {
    
    $format = print('<pre>');
    $format .= print_r($data);
    $format .= print('</pre>');
    return $format;
    
}
/*********** EVITAMOS INYECCIONES *********************************/
function stringClean ($stringChk) { 
    $string = preg_replace(['/\s+/','/^\s|\s$/'], [' ',''], $stringChk); // limpia exceso de espacios entre palabras
    $string = trim($string);
    $string = str_ireplace("<script>", "", $string);
    $string = str_ireplace("</script>", "", $string);
    $string = str_ireplace("<script src", "", $string);
    $string = str_ireplace("<script type=", "", $string);
    $string = str_ireplace("SELECT * FROM", "", $string);
    $string = str_ireplace("INSERT INTO", "", $string);
    $string = str_ireplace("DELETE FROM", "", $string);
    $string = str_ireplace("UPDATE ", "", $string);
    $string = str_ireplace("DROP TABLE", "", $string);
    $string = str_ireplace("OR '1' = 1'", "", $string);
    $string = str_ireplace('OR "1" = "1"', "", $string);
    $string = str_ireplace('OR ´1´ = ´1´', "", $string);
    $string = str_ireplace("IS NULL; --", "", $string);
    $string = str_ireplace("IS NULL; /*", "", $string);
    $string = str_ireplace("onclick=", "", $string);
    $string = str_ireplace("--", "", $string);
    $string = str_ireplace("==", "", $string);
    $string = str_ireplace("LIKE '", "", $string);
    $string = str_ireplace('LIKE "', "", $string);
    $string = str_ireplace('LIKE ´', "", $string);
    return $string;
}
/************** PINTAMOS EL MENU ***************************************/
function printMenu($arreglo) {
    $htmlMenu = "";
    if (!empty($arreglo)) {
        //show_dep($arreglo);
        foreach ($arreglo as $key => $data) {
            
            $url = (!empty($data['url'])) ? $data['url'] : "#";
            $url_txt = (!empty($data['url'])) ? $data['url'] : "";
            $target = (!empty($data['url'])) ? "_blank" : "_self";
                
            if (is_array($data)) {
                
                $htmlMenu .= "<li>";
                $htmlMenu .= "<a href='".$url."' target='".$target."'>".$data['menu']."<small style='font-size:9px;'>".$url_txt."</small><br><small style='font-size:7px;'>".$data['descripcion']."</small></a>";
                if(isset($data['children']) && count($data['children']) > 0) {
                    $htmlMenu .= "<ul>";
                    $htmlMenu .= printMenu($data['children']);
                    $htmlMenu .= "</ul>";
                }
                
                $htmlMenu .= "</li>";
                
            } else {
                
                $htmlMenu .= "<li>";
                $htmlMenu .= "<a href='#' target='_self'>".$data['menu']."<br><small>".$data['descripcion']."</small></a>";
                $htmlMenu .= "</li>";
                
            }
        }
        
    }
    return $htmlMenu;
}
