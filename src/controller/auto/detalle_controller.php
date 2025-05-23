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




// Formulario para alquilar
?>
<form method="POST" action="controller/alquilar_auto_controller.php">
    <input type="hidden" name="id_usuario" value="<?= $usuario->getId() ?>">
    <label>Auto a alquilar:</label>
    <select name="id_auto">
        <?php foreach ($autosDisponibles as $auto): ?>
            <option value="<?= $auto->getId() ?>"><?= $auto->getMarca() ?> <?= $auto->getModelo() ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Alquilar</button>
</form>

<form method="POST" action="controller/comprar_auto_controller.php">
    <input type="hidden" name="id_usuario" value="<?= $usuario->getId() ?>">
    <label>Auto a comprar:</label>
    <select name="id_auto">
        <?php foreach ($autosDisponibles as $auto): ?>
            <option value="<?= $auto->getId() ?>"><?= $auto->getMarca() ?> <?= $auto->getModelo() ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Comprar</button>
</form>