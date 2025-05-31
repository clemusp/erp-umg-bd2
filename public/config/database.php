<?php

class Database {
    private static $instance = null;
    private $conn;

    private function __construct() {

        $server = 'CRILEMPER';
        $dbName = 'ERP';

        $dsn = "sqlsrv:Server={$server};Database={$dbName}";

        try {

            $this->conn = new PDO(
                $dsn,
                null, // Usuario (null para Integrated Security / Windows Auth)
                null, // Contraseña (null para Integrated Security)
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]
            );
        } catch (PDOException $e) {

            die('Error de conexión: ' . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }
}
