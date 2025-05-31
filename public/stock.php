<?php

require_once __DIR__ . '/app/models/Producto.php';

header('Content-Type: application/json; charset=UTF-8');

$model = new Producto();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $productos = $model->getAll();
    echo json_encode($productos);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if (!is_array($data)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'JSON inválido']);
        exit;
    }

    $allOk = true;
    foreach ($data as $row) {
        if (isset($row['ProductoID'], $row['Nombre'], $row['Descripcion'], $row['PrecioUnitario'], $row['Stock'])) {
            $id    = intval($row['ProductoID']);
            $nombre = trim($row['Nombre']);
            $descripcion = trim($row['Descripcion']);
            $precio = floatval($row['PrecioUnitario']);
            $stock  = intval($row['Stock']);

            $updated = $model->update($id, $nombre, $descripcion, $precio, $stock);
            if (!$updated) {
                $allOk = false;
            }
        } else {
            $allOk = false;
        }
    }

    if ($allOk) {
        echo json_encode(['success' => true]);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Error al actualizar uno o más productos']);
    }
    exit;
}

http_response_code(405);
echo json_encode(['success' => false, 'message' => 'Método no permitido']);
