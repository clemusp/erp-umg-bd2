<?php
require __DIR__ . '/config/database.php';
$db = Database::getInstance()->getConnection();
echo '¡Conexión exitosa a ' . $db->query('SELECT DB_NAME()')->fetchColumn() . '!';
