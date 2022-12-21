<?php

require_once 'database.php';

class db extends dataBase {
    
    private $db;
    private $sentencia;
    private $lastIdInsert = 0;
    
    public function __construct($configFile) {
        $this->db = parent::connect($configFile);        
    }
    
    public function query($sql, $valores = array(), $ver = 0) {
        
        $data = array();
        // Bandera para imprimir query
        if($ver === 1) { print($this->showQuery($sql, $valores)); }
        // Obtenemos el tipo de query enviado
        $tipoQuery = strtoupper(explode(' ', $sql)[0]);
        
        if($this->sentencia = $this->db->prepare($sql)) {
            if(preg_match_all("/(:\w+)/", $sql, $campo, PREG_PATTERN_ORDER)) {
                $campos = array_pop($campo);
                
                foreach ($campos as $value) {
                    $this->sentencia->bindValue($value, $valores[substr($value, 1)]);
                }
            }
                        
            try {                 
                
                if (!$this->sentencia->execute()) {
                    print_r($this->sentencia->errorInfo());
                }                
                
                if ($tipoQuery === 'SELECT') {
                    $data = $this->sentencia->fetchAll(PDO::FETCH_ASSOC);
                }  
                
                // Obtenemos el ID del registro insertado para retornarlo
                if ($tipoQuery == 'INSERT') {
                    $this->lastIdInsert = $this->db->lastInsertId();
                    $data = $this->getLastInsertId();
                }
                
                // Cerramos la coneccion
                $this->sentencia->closeCursor();
                
            } catch (PDOException $ex) {                
                echo "Error al ejecutar la consulta: ";
                print_r($ex->getMessage());
            }
        }
        return $data;
    }
    
    public function numRows() {
        $cantidad = 0;
        if(intval($this->sentencia->rowCount()) > 0) {
            $cantidad = intval($this->sentencia->rowCount());
        }
        return $cantidad;
    }
    
    private function showQuery($query, $params) {
        
        $count = 0;
        $keys = array();
        $values = array();
       
        # construmos una expresion regular por cada parametro
        foreach ($params as $key => $value) {
            if (is_string($key)) {
                $keys[] = '/:'.$key.'/';
            } else {
                $keys[] = '/[?]/';
            }
           
            if(is_numeric($value)) {
                $values[] = intval($value);
            } else {
                $values[] = '"'.$value .'"';
            }
            $count++;
        }
       
        $sqlView = preg_replace($keys, $values, $query, 1, $count);
        return $sqlView;
    }
    
    public function getLastInsertId() {
        return $this->lastIdInsert;
    }
}

