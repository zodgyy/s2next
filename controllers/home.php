<?php

class home extends controllers {
    
    protected $params = array();
    
    public function __construct($dbc) {
        parent::__construct($dbc);        
    }
    
    // Metodo principal
    function index($params = array()) {
        
        $this->params = $params;
        
        $data['page_id'] = 0;
        $data['page_name'] = "Prueba de desarrollo";
        $data['page_tag'] = "Prueba";        
        $data['page_title'] = "Prueba de desarrollo";
        $data['page_function_js'] = "operationsGeneral.js";
        $data['parametros'] = $this->params;
        // Llenamos el menu arbol
        $data['parametros']['menus'] = $this->getAllRegistros();
                      
        $this->views->get_views($this, "home", $data);
    }

    public function test() {
        $arrHijo = $this->model->getRegistros(-1, 1);
        show_dep($arrHijo);
    }
    
    public function getSelectRegistros() {
        $htmlOptions = '<option value="" style="display: none;">Menus</option>';
        $htmlOptions .= '<option value="0">Generar padre nuevo</option>';
        $arrData = $this->model->getRegistros(0); // Cero para puros padres o -1 para todos los registros (hijos de hijos)
        if(count($arrData) > 0) {            
            for($i=0; $i < count($arrData); $i++) {
                // Posibilidad de crear hijos de hijos
                $creaHijosDeHijos = (intval($arrData[$i]['id_raiz']) > 0) ? $arrData[$i]['menu_padre'] . "->" : "";
                    
                $htmlOptions .= '<option value="'.$arrData[$i]['id_menu'].'">'. $creaHijosDeHijos . $arrData[$i]['menu'].'</option>';                    
            }
        }
        echo $htmlOptions;
        die();
    }
    
    public function getAllRegistros() {
        $arrData = $this->model->getRegistrosTree(0);  
        //show_dep($arrData);
        return json_encode($arrData, JSON_UNESCAPED_UNICODE);
    }
    
    public function getRegistrosMenu() {
        
        $arrData = $this->model->getRegistros(-1); // -1 para obtener todos los registros padres e hijos
        //show_dep($arrData);
        for ($i = 0; $i < count($arrData); $i++) {
            
            if(intval($arrData[$i]['id_raiz']) === 0) {
                $arrData[$i]['nivel'] = '<span class="badge badge-info">Padre</span>';
            } else {
                $arrData[$i]['nivel'] = '<span class="badge badge-success">Hijo</span>';
            }
                      
            $arrData[$i]['options'] = '<div class="btns-options">'                    
                    . '<button onclick="editarRegistro('.$arrData[$i]['id_menu'].');" class="btn btn-primary btn-sm" title="Editar"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>'
                    . '<button onclick="borrarRegistro('.$arrData[$i]['id_menu'].');" class="btn btn-danger btn-sm" title="Eliminar"><i class="fa fa-trash-o" aria-hidden="true"></i></button>'
                    . '</div>';
            
            
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }
    
    public function getRegistro($params) {
        //show_dep($params);
        if (intval($params[0]) > 0) {
            
            $this->params['id_menu'] = intval($params[0]);
            
            // Llamamos al modelo
            $response = $this->model->getOneRegistro(json_encode($this->params));
            if (!empty($response)) {
                
                $out = array(
                    "status" => true,
                    "msg" => "Registro encontrado correctamente.",
                    "data" => $response
                );

            } else {

                $out = array(
                    "status" => false,
                    "msg" => "Datos no econtrados.",
                    "data" => ""
                );

            }
            echo json_encode($out, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function setRegistro() {
        
        // Validamos la existencia de datos antes de continuar
        if (isset($_POST['id_raiz']) && (intval($_POST['id_raiz']) > -1) &&
            isset($_POST['menu']) && !empty($_POST['menu'])) { 
                
            $this->params['id_menu'] = intval($_POST['id_menu']);
            $this->params['id_raiz'] = intval($_POST['id_raiz']);
            $this->params['menu'] = stringClean($_POST['menu']);
            $this->params['descripcion'] = stringClean($_POST['descripcion']);    
                            
            if ($this->params['id_menu'] === 0) {
                $response = $this->model->insertRegistro(json_encode($this->params));
                $msg = "insertado";
            } else {
                $response = $this->model->updateRegistro(json_encode($this->params)); 
                $msg = "actualizado";
            }

            if (intval($response) > 0) {

                $out = array(
                    "status" => true,
                    "msg" => "Registro " . $msg . " correctamente."
                );

            } else if ($response == DUPLIED) {

                $out = array(
                    "status" => false,
                    "msg" => "¡Atencion! Ya existe un registro con las mismas caracteristicas."
                );

            } else {

                $out = array(
                    "status" => false,
                    "msg" => "No es posible almacenar el registro."
                );

            }

        } else {
            $out = array(
                "status" => false,
                "msg" => "¡Error! Faltan datos para realizar la accion."
            );
        }
        
        echo json_encode($out, JSON_UNESCAPED_UNICODE);
        die();
    }
    
    public function delRegistro($params) {
        //show_dep($params);
        if (intval($params[0]) > 0) {
            
            $this->params['id_menu'] = intval($params[0]);

            if ($this->params['id_menu'] > 0) {
                $response = $this->model->deleteRegistro(json_encode($this->params));
                if ($response == SUCCESS) {
                    $out = array(
                        "status" => true,
                        "msg" => "Registro eliminado correctamente."
                    );
                } else {

                    $out = array(
                        "status" => false,
                        "msg" => "No es posible eliminar el registro."
                    );

                }
                
                echo json_encode($out, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }
    
}