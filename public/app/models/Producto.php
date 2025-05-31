<?php
require_once __DIR__ . '/../../config/database.php';

class Producto {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Inserta un nuevo producto en la tabla Producto.
     */
    public function create(string $nombre, string $descripcion, float $precio, int $stock): bool {
        try {
            $sql = "INSERT INTO Producto (Nombre, Descripcion, PrecioUnitario, Stock)
                    VALUES (:nombre, :descripcion, :precio, :stock)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':stock', $stock);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Devuelve todos los productos.
     */
    public function getAll(): array {
        $stmt = $this->db->query("SELECT ProductoID, Nombre, Descripcion, PrecioUnitario, Stock FROM Producto ORDER BY Nombre ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Actualiza un producto existente por su ID.
     */
    public function update(int $productoID, string $nombre, string $descripcion, float $precio, int $stock): bool {
        try {
            $sql = "UPDATE Producto
                    SET Nombre = :nombre,
                        Descripcion = :descripcion,
                        PrecioUnitario = :precio,
                        Stock = :stock
                    WHERE ProductoID = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':stock', $stock);
            $stmt->bindParam(':id', $productoID, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
}
