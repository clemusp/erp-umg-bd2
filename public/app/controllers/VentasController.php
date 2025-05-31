<?php
// app/controllers/VentasController.php

require_once __DIR__ . '/../models/Venta.php';

class VentasController {
    private $model;

    public function __construct() {
        $this->model = new Venta();
    }

    public function index() {
        include __DIR__ . '/../views/ventas/index.php';
    }


    public function store() {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        header('Content-Type: application/json; charset=UTF-8');

        try {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);

            if (!is_array($data) || !isset($data['header'], $data['details'])) {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => 'JSON inválido: se esperaba { header: {...}, details: [...] }.'
                ]);
                exit;
            }

            $header  = $data['header'];   // ['ClienteID' => ..., 'VendedorID' => ..., 'Fecha' => ...]
            $details = $data['details'];  // [ {ProductoID, Cantidad, PrecioUnitario}, ... ]

            $startTime = microtime(true);
            $success = $this->model->createSale($header, $details);
            $endTime = microtime(true);

            error_log("Llegó a createSale(); éxito: " . var_export($success, true)
                      . " - Duración en segundos: " . round($endTime - $startTime, 4));

            if ($success) {
                echo json_encode(['success' => true]);
            } else {
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'message' => 'Error al insertar la venta.'
                ]);
            }
        }
        catch (PDOException $e) {
            http_response_code(500);
            error_log("Excepción PDO en store(): " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Excepción PDO: ' . $e->getMessage()
            ]);
        }
        catch (\Exception $e) {
            http_response_code(500);
            error_log("Excepción genérica en store(): " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Error inesperado: ' . $e->getMessage()
            ]);
        }

        exit;
    }
}
