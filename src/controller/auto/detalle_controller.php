<?php

//$path ="var/www/html";
$path = dirname(__DIR__, 2);
define('BASE_PATH', dirname(__DIR__, 2));
// define('BASE_PATH', $path); // apunta a src/ /var/html/www
define('BASE_URL', 'http://localhost:8080/');
define('BASE_URL_CTRL', 'http://localhost:8080/controller/');
// define('BASE_URL_VIEW', 'http://localhost:8080/view/');
require_once BASE_PATH . '/config/bootstrap.php';



use Applicacion\VerDetalleAuto;
use Core\View;

try {
    $casoUso = new VerDetalleAuto();
    $auto = $casoUso->obtenerPorId($_GET['id']);
    View::render('auto/detalle.php', ['auto' => $auto]);
} catch (Exception $e) {
    $error = "Error al obtener los autos: " . $e->getMessage();
}
