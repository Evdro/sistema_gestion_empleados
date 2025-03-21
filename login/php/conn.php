<?php

class Conexion {
    
    private $host = 'localhost';
    private $db = 'sistemaregistro';
    private $usuario = 'root';
    private $pass = '';
    private $charset = 'utf8';

    private $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO(
                "mysql:host=$this->host;dbname=$this->db;charset=$this->charset",
                $this->usuario,
                $this->pass,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            error_log("Error de conexión: " . $e->getMessage());
            throw new Exception("No se pudo conectar a la base de datos. Detalles: " . $e->getMessage());
        }
    }

    public function getPDO() {
        if ($this->pdo === null) {
            throw new Exception("No se pudo inicializar la conexión PDO.");
        }
        return $this->pdo;
    }
}
