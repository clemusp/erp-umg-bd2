<?php
require_once __DIR__ . '/../models/Producto.php';

class InventarioController {
    private $model;

    public function __construct() {
        $this->model = new Producto();
    }

    public function index() {
        // Si es POST, intentamos crear y devolvemos JSON
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre      = $_POST['nombre'] ?? '';
            $descripcion = $_POST['descripcion'] ?? '';
            $precio      = $_POST['precio'] ?? 0;
            $stock       = $_POST['stock'] ?? 0;

            $success = $this->model->create($nombre, $descripcion, $precio, $stock);

            header('Content-Type: application/json');
            echo json_encode(['success' => $success]);
            exit;
        }

        // Si no es POST, carga la vista
        include __DIR__ . '/../views/inventario/index.php';
    }
}