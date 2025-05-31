<?php

require_once __DIR__ . '/app/models/Cliente.php'; 

$model = new Cliente();
$lista = $model->getAll(); 

header('Content-Type: application/json; charset=UTF-8');
echo json_encode($lista);
