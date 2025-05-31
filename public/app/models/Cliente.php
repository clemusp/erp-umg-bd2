<?php
// app/models/Cliente.php

require_once __DIR__ . '/../../config/database.php';

class Cliente {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Devuelve todos los clientes con ClienteID y Nombre.
     */
    public function getAll(): array {
        $stmt = $this->db->query("SELECT ClienteID, Nombre FROM Cliente ORDER BY Nombre ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
