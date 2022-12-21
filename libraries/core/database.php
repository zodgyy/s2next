<?php

abstract class dataBase {
    
    public $dbLink = null;
    private $config;
    
    protected function connect($configFile) {
        
        if (!file_exists($configFile)) {
            throw new Exception('No existe el archivo de conexion: ' . $configFile);
        }
        
        $this->config = parse_ini_file($configFile, true);
        
        if (!$this->config) {
            throw new Exception('No hay parametros de conexion');
        }
                
        $driver = $this->config['database']['driver'];
        $host = $this->config['database']['host'];
        $port = $this->config['database']['port'];
        $dbname = $this->config['database']['dbname'];
        $username = $this->config['database']['user'];
        $pwd = $this->config['database']['pwd'];    
        $charset = $this->config['database']['charset'];
        $dsn = $driver . ":host=" . $host . ";port=" . $port .";dbname=" . $dbname . ";" . $charset;
        
        try {
            
            $this->dbLink = new PDO($dsn, $username, $pwd, array( PDO::ATTR_PERSISTENT => false, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
            $this->dbLink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            return $this->dbLink;
            
        } catch (PDOException $exc) {
            die ('No se pudo conectar a la base de datos: ' . $exc->getMessage());
        }
    }
}