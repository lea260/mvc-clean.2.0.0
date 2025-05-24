<?php
define('BASE_PATH', dirname(__DIR__, 2));
// define('BASE_PATH', $path); // apunta a src/ /var/html/www
define('BASE_URL', 'http://localhost:8080/');
define('BASE_URL_CTRL', 'http://localhost:8080/controller/');
// define('BASE_URL_VIEW', 'http://localhost:8080/view/');
require_once BASE_PATH . '/config/bootstrap.php';

use Applicacion\AgregarAuto;
use Core\View;
use Dominio\Auto;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patente = strtoupper(trim($_POST['patente'] ?? ''));
    $marca = trim($_POST['marca'] ?? '');
    $modelo = trim($_POST['modelo'] ?? '');
    $estado = trim($_POST['estado'] ?? 'disponible');

    try {
        // Crear instancia del auto
        $auto = new Auto(
            patente: $patente,
            marca: $marca,
            modelo: $modelo,
            estado: $estado
        );
        $casoUso = new AgregarAuto();
        $casoUso->agregar($auto);

        View::render('mensaje/comun.php', ['titulo' => "Autos", 'mensaje' => "Auto registrado con éxito"]);
        // Redirigir con mensaje de éxito
    } catch (\Exception $e) {
        // Mostrar error
        View::render('mensaje/comun.php', ['titulo' => "Autos", 'mensaje' => "Error al registrar el auto"]);
    }
} else {
    echo "Método no permitido.";
}
