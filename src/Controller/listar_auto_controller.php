<?php
// $base = __DIR__ . '/../config/bootstrap.php';
// $real = realpath(__DIR__ . '/../config/bootstrap.php');
// $real = __DIR__ . '/../config/bootstrap.php';
//$path ="var/www/html";
$path = dirname(__DIR__, 1);
define('BASE_PATH', dirname(__DIR__, 1));    // apunta a src/
define('BASE_URL', 'http://localhost:8080/');
require_once __DIR__ . '/../config/bootstrap.php';



use Applicacion\ListarAuto;
use Core\View;
// require_once 'config/config.php';
// require_once 'infraestructura/AutoRepositorio.php';


$autos = [];

try {
    $casoUso = new ListarAuto();
    $autos = $casoUso->listar();
} catch (Exception $e) {
    $error = "Error al obtener los autos: " . $e->getMessage();
}

View::render('listar_auto_view.php', ['autos' => $autos]);
