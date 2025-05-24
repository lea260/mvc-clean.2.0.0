<?php



//$path ="var/www/html";
define('BASE_PATH', dirname(__DIR__, 2));
// define('BASE_PATH', $path); // apunta a src/ /var/html/www
define('BASE_URL', 'http://localhost:8080/');
define('BASE_URL_CTRL', 'http://localhost:8080/controller/');
// define('BASE_URL_VIEW', 'http://localhost:8080/view/');
require_once BASE_PATH . '/config/bootstrap.php';


use Applicacion\ReservarAuto;
use Core\View;

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idUsuario = $_POST['id_usuario'] ?? null;
    $idAuto = $_POST['id_auto'] ?? null;

    try {
        if (!$idUsuario || !$idAuto) {
            throw new Exception('Faltan datos para la reserva.');
        }
        $casoUso = new ReservarAuto();
        $casoUso->ejecutar((int)$idUsuario, (int)$idAuto);
        $mensaje = "Reserva realizada con éxito.";
        View::render('mensaje/comun.php', [
            'titulo' => $mensaje,
            'mensaje' => "error al reservar auto",
        ]);
    } catch (Exception $e) {
        $mensaje = $e->getMessage();
        View::render('mensaje/comun.php', [
            'titulo' => $mensaje,
            'mensaje' => "auto reservado con éxito",
        ]);
    }
} else {
    $mensaje = "Método no permitido.";
    View::render('mensaje/comun.php', [
        'titulo' => $mensaje,
        'mensaje' => "error al reservar auto",
    ]);
}
