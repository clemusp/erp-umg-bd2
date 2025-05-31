<?php
// app/models/Venta.php

require_once __DIR__ . '/../../config/database.php';

class Venta {
    private $db;

    public function __construct() {
        // Obtenemos la misma instancia de PDO
        $this->db = Database::getInstance()->getConnection();
    }

    public function createSale(array $header, array $details): bool {
        try {
            $sqlCreateTemp = "
                IF OBJECT_ID('tempdb..#DetalleVentaTemp') IS NOT NULL
                    DROP TABLE #DetalleVentaTemp;

                CREATE TABLE #DetalleVentaTemp (
                    ProductoID       INT,
                    Cantidad         INT,
                    PrecioUnitario   DECIMAL(18,2)
                );
            ";
            $this->db->exec($sqlCreateTemp);

            $insertTempSql = "
                INSERT INTO #DetalleVentaTemp (ProductoID, Cantidad, PrecioUnitario)
                VALUES (:prodID, :cant, :precio)
            ";
            $insertTempStmt = $this->db->prepare($insertTempSql);

            foreach ($details as $index => $det) {
                if (
                    !isset($det['ProductoID'], $det['Cantidad'], $det['PrecioUnitario']) ||
                    !is_numeric($det['ProductoID']) ||
                    !is_numeric($det['Cantidad']) ||
                    !is_numeric($det['PrecioUnitario'])
                ) {
                    error_log("Venta::createSale - Detalle inválido en índice {$index}: " . json_encode($det));
                    return false;
                }

                $insertTempStmt->bindValue(':prodID', intval($det['ProductoID']), PDO::PARAM_INT);
                $insertTempStmt->bindValue(':cant', intval($det['Cantidad']), PDO::PARAM_INT);
                $insertTempStmt->bindValue(':precio', floatval($det['PrecioUnitario']));
                $ok = $insertTempStmt->execute();
                if (!$ok) {
                    $errorInfo = $insertTempStmt->errorInfo();
                    error_log("Venta::createSale - Error al insertar en #DetalleVentaTemp: " .
                              "SQLSTATE[{$errorInfo[0]}] Código: {$errorInfo[1]} Mensaje: {$errorInfo[2]}");
                    return false;
                }
            }

            $sqlExecSp = "
                EXEC sp_InsertarVenta 
                    @ClienteID  = :clienteID,
                    @VendedorID = :vendedorID,
                    @Fecha      = :fecha
            ";
            $execStmt = $this->db->prepare($sqlExecSp);
            $execStmt->bindValue(':clienteID', intval($header['ClienteID']), PDO::PARAM_INT);
            $execStmt->bindValue(':vendedorID', intval($header['VendedorID']), PDO::PARAM_INT);
            $execStmt->bindValue(':fecha', $header['Fecha']); // Formato 'YYYY-MM-DD'

            $ok2 = $execStmt->execute();
            if (!$ok2) {
                $errorInfo = $execStmt->errorInfo();
                error_log("Venta::createSale - Error al ejecutar sp_InsertarVenta: " .
                          "SQLSTATE[{$errorInfo[0]}] Código: {$errorInfo[1]} Mensaje: {$errorInfo[2]}");
                return false;
            }

            return true;
        }
        catch (PDOException $e) {
            error_log("Venta::createSale - Excepción PDO: " . $e->getMessage());
            return false;
        }
        catch (\Exception $e) {
            error_log("Venta::createSale - Excepción general: " . $e->getMessage());
            return false;
        }
    }
}
