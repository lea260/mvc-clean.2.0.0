<?php
$base = __DIR__ . '/../config/bootstrap.php';
$real = realpath(__DIR__ . '/../config/bootstrap.php');
$real = __DIR__ . '/../config/bootstrap.php';
require_once __DIR__ . '/../config/bootstrap.php';
// require_once dirname(__DIR__) . '/config/bootstrap.php';



use Core\View;
use Infraestructura\AutoRepositorio;
// require_once 'config/config.php';
// require_once 'infraestructura/AutoRepositorio.php';


$autos = [];

try {
    $repo = new AutoRepositorio();
    $autos = $repo->listar();
} catch (Exception $e) {
    $error = "Error al obtener los autos: " . $e->getMessage();
}

View::render('listar_auto_view.php', ['autos' => $autos]);
