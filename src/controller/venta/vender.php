<?php
// src/controller/venta/vender.php

define('BASE_PATH', dirname(__DIR__, 2));
// define('BASE_PATH', $path); // apunta a src/ /var/html/www
define('BASE_URL', 'http://localhost:8080/');
define('BASE_URL_CTRL', 'http://localhost:8080/controller/');
// define('BASE_URL_VIEW', 'http://localhost:8080/view/');
require_once BASE_PATH . '/config/bootstrap.php';



use Aplicacion\RegistrarVenta;

try {
    //$pdo = Database::getConnection();
    $caso = new RegistrarVenta($pdo);
    $caso->ejecutar($_POST['id_auto'], $_POST['id_usuario']);
    echo "Venta registrada con éxito.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
