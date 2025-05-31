<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/app/controllers/MenuController.php';

$controller = new MenuController();
$controller->index();