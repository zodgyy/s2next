<?php

declare(strict_types=1);

class homeModel {
    
    private $db;

    public function __construct(object $dbc) {        
        $this->db = $dbc;
    }
    
    public function getRegistrosTree(int $id_raiz = 0) {
        $data = array();
        // Iniciamos la busqueda de menus
        $searchMenu = $this->getRegistros($id_raiz);
        if (count($searchMenu) > 0) {
            // Buscamos herencia
            foreach ($searchMenu as $menu) {
                $children = "";
                $id_raiz_busco = intval($menu['id_menu']);
                if($id_raiz === 0) {
                    
                    $data[$id_raiz_busco]['id_menu'] = $menu['id_menu'];
                    $data[$id_raiz_busco]['id_raiz'] = $menu['id_raiz'];
                    $data[$id_raiz_busco]['menu'] = $menu['menu'];
                    $data[$id_raiz_busco]['menu_padre'] = $menu['menu_padre'];
                    $data[$id_raiz_busco]['descripcion'] = $menu['descripcion'];
                    $data[$id_raiz_busco]['estatus'] = $menu['estatus'];  
                    $children = $this->getRegistrosTree(intval($menu['id_menu']));
                    if(!empty($children)) {
                        $data[$id_raiz_busco]['children'] = $children;
                    }
                } else {
                    
                    $data[$id_raiz_busco]['id_menu'] = $menu['id_menu'];
                    $data[$id_raiz_busco]['id_raiz'] = $menu['id_raiz'];
                    $data[$id_raiz_busco]['menu'] = $menu['menu'];
                    $data[$id_raiz_busco]['menu_padre'] = $menu['menu_padre'];
                    $data[$id_raiz_busco]['descripcion'] = $menu['descripcion']; 
                    $data[$id_raiz_busco]['estatus'] = $menu['estatus'];
                    $children = $this->getRegistrosTree(intval($menu['id_menu']));
                    if(!empty($children)) {
                        $data[$id_raiz_busco]['children'] = $children;
                    }
                }
            }
        }        
        return $data;
    }
    
    public function getRegistros(int $id_raiz = 0) {   
        $values = NULL;
        $filtro = " 1 = 1 ";


        if($id_raiz >= 0) {
            $filtro .= " AND id_raiz = :id_raiz ";
            $values = array('id_raiz' => $id_raiz);
        } 

        // Obtenemos todos los registros a partir del filtro
        return $this->db->query("SELECT id_menu, id_raiz, menu, (SELECT menu FROM cat_menu WHERE id_menu = qry1.id_raiz) as menu_padre, descripcion, estatus FROM cat_menu AS qry1 WHERE $filtro AND estatus IS NULL ORDER BY id_raiz, id_menu, menu;", $values, 0);
    }
    
    public function getOneRegistro(string $param) {
        
        $out = "";        
        $datos = json_decode($param);
        $id_menu = $datos->id_menu;
        
        $sql = "SELECT id_menu, id_raiz, menu, (SELECT menu FROM cat_menu WHERE id_menu = qry1.id_raiz) as menu_padre, descripcion, estatus FROM cat_menu AS qry1 WHERE id_menu = :id_menu;";
        $response = $this->db->query($sql, array('id_menu' => $id_menu), 0);
        if ($response !== false) {
            if ($this->db->numRows() > 0) {
                $out = $response[0];  // <== Colocamos indice 0 ya que solo es un registro
            }
        }
        return $out;
    }
    
    public function insertRegistro(string $param) {
        
        $out = FAILED;
        $datos = json_decode($param);
        // Parseamos los datos que viene del JSON
        $id_raiz = intval($datos->id_raiz);
        $menu = stringClean($datos->menu);
        $descripcion = stringClean($datos->descripcion);
                
        // Validamos duplicidad
        $sqlChk = "SELECT * FROM cat_menu WHERE menu = :menu AND id_raiz = :id_raiz;";
        $rsChk = $this->db->query($sqlChk, array('menu' => $menu, 'id_raiz' => $id_raiz), 0);
        if ($rsChk !== false) {
            if ($this->db->numRows() > 0) {
                // Se encontro un registro, hay duplicidad
                $out = DUPLIED;
            } else {
                // Se inserta el registro
                $values = array(
                    'id_raiz' => $id_raiz, 
                    'menu' => $menu, 
                    'descripcion' => $descripcion);
                $out = $this->db->query("INSERT INTO cat_menu (id_raiz, menu, descripcion) VALUES (:id_raiz, :menu, :descripcion);", $values, 0);
            }
        }
        return $out;
    }
    
    public function updateRegistro(string $param) {
        
        $out = FAILED;
        $datos = json_decode($param);
        // Parseamos los datos que viene del JSON
        $id_menu = intval($datos->id_menu);
        $id_raiz = intval($datos->id_raiz);
        $menu = stringClean($datos->menu);
        $descripcion = stringClean($datos->descripcion);
        
        // Validamos duplicidad
        $sqlChk = "SELECT * FROM cat_menu WHERE menu = :menu AND id_raiz = :id_raiz AND id_menu != :id_menu;";
        $rsChk = $this->db->query($sqlChk, array('menu' => $menu, 'id_raiz' => $id_raiz, 'id_menu' => $id_menu), 0);
        if ($rsChk !== false) {
            if ($this->db->numRows() > 0) {
                // Se encontro un registro, hay duplicidad
                $out = DUPLIED;
            } else {
                // Se actualiza el registro
                $values = array(
                    'id_menu' => $id_menu,
                    'id_raiz' => $id_raiz, 
                    'menu' => $menu, 
                    'descripcion' => $descripcion);
                $sqlUpd = "UPDATE cat_menu SET id_raiz = :id_raiz, menu = :menu, descripcion = :descripcion WHERE id_menu = :id_menu;";
                $rsUpd = $this->db->query($sqlUpd, $values, 0);
                if ($rsUpd !== false) {
                    $out = SUCCESS;
                }
            }
        }
        return $out;
    }
    
    public function deleteRegistro(string $param) {
        
        $out = FAILED;
        $datos = json_decode($param);
        // Parseamos los datos que viene del JSON
        $id_menu = intval($datos->id_menu);

        // damos de baja el registro
        $rsDel = $this->db->query("UPDATE cat_menu SET estatus = 'B' WHERE id_menu = :id_menu;", array('id_menu' => $id_menu), 0);
        if ($rsDel !== false) {
            // Damos de baja todos los hijos
            $rsDelSons = $this->db->query("UPDATE cat_menu SET estatus = 'B' WHERE id_raiz = :id_menu;", array('id_menu' => $id_menu), 0);
            if ($rsDelSons !== false) {
                $out = SUCCESS;
            }
        }
        return $out;
    }

}