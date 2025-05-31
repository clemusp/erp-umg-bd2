<?php

require_once __DIR__ . '/app/models/Vendedor.php';

$model = new Vendedor();
$lista = $model->getAll(); 

header('Content-Type: application/json; charset=UTF-8');
echo json_encode($lista);
