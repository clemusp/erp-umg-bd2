<?php
// app/models/Vendedor.php

require_once __DIR__ . '/../../config/database.php';

class Vendedor {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Devuelve todos los vendedores con VendedorID y Nombre.
     */
    public function getAll(): array {
        $stmt = $this->db->query("
            SELECT VendedorID, Nombre 
            FROM Vendedor 
            ORDER BY Nombre ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
