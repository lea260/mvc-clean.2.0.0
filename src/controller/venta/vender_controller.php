<?php
// src/controller/venta/vender.php

define('BASE_PATH', dirname(__DIR__, 2));
// define('BASE_PATH', $path); // apunta a src/ /var/html/www
define('BASE_URL', 'http://localhost:8080/');
define('BASE_URL_CTRL', 'http://localhost:8080/controller/');
// define('BASE_URL_VIEW', 'http://localhost:8080/view/');
require_once BASE_PATH . '/config/bootstrap.php';


use Applicacion\RegistrarVenta;
use Core\View;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {

        //$pdo = Database::getConnection();
        $caso = new RegistrarVenta();
        $idAuto = (int)$_POST['id_auto'] ?? null;
        $idUsuario = (int)$_POST['id_usuario'] ?? null;
        $precio = (float)$_POST['precio'] ?? null;
        $caso->ejecutar(
            idAuto: $idAuto,
            idVendedor: $idUsuario,
            precio: $precio
        );
        View::render("mensaje/comun.php", [
            'titulo' => "Venta Auto",
            'mensaje' => "Auto vendido con éxito",
        ]);
    } catch (Exception $e) {
        //http_response_code(500);
        View::render("mensaje/comun.php", [
            'titulo' => "Venta Auto",
            'mensaje' => "Auto vendido con exito",
        ]);
    }
} else {
    http_response_code(405);
    View::render("mensaje/error", [
        'titulo' => "Método no permitido",
        'mensaje' => "Solo se permiten solicitudes POST.",
    ]);
}
