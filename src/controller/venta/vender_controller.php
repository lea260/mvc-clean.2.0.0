<?php
// src/controller/venta/vender.php

define('BASE_PATH', dirname(__DIR__, 2));
// define('BASE_PATH', $path); // apunta a src/ /var/html/www
define('BASE_URL', 'http://localhost:8080/');
define('BASE_URL_CTRL', 'http://localhost:8080/controller/');
// define('BASE_URL_VIEW', 'http://localhost:8080/view/');
require_once BASE_PATH . '/config/bootstrap.php';



use Aplicacion\RegistrarVenta;
use Core\View;




try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Método no permitido", 405);
    }
    //$pdo = Database::getConnection();
    $caso = new RegistrarVenta();
    $idAuto = $_POST['id_auto'] ?? null;
    $idUsuario = $_POST['id_usuario'] ?? null;
    $precio = $_POST['precio'] ?? null;
    $caso->ejecutar($_POST['id_auto'], $_POST['id_usuario']);
    View::render("mensaje/comun", [
        'titulo' => "Venta Auto",
        'mensaje' => "Auto vendido con exito",
    ]);
} catch (Exception $e) {
    http_response_code(500);
    View::render("mensaje/error", ['mensaje' => "Error interno del servidor."]);
} catch (Exception $e) {
    http_response_code($e->getCode());
    View::render("mensaje/error", [
        'titulo' => "Error en la venta",
        'mensaje' => $e->getMessage(),
    ]);
}
