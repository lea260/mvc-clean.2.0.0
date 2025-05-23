<?php

require_once __DIR__ . '/../../config/bootstrap.php';

use Aplicacion\ReservarAuto;
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
        View::render('auto/listar.php', [
            'titulo' => "auto reservado",
            'mensaje' => "auto reservado con éxito",
        ]);
    } catch (Exception $e) {
        $mensaje = "Error: " . $e->getMessage();
        View::render('mensaje/comun.php', [
            'titulo' => "reserva de auto",
            'mensaje' => "error al reservar auto",
        ]);
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reservar Auto</title>
</head>

<body>
    <h1>Reservar Auto</h1>
    <form method="post" action="">
        <label>ID Usuario: <input type="number" name="id_usuario" required></label><br>
        <label>ID Auto: <input type="number" name="id_auto" required></label><br>
        <button type="submit">Reservar</button>
    </form>
    <p><?= htmlspecialchars($mensaje) ?></p>
    <p><a href="/index.php">Volver al menú</a></p>
</body>

</html>