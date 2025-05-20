<?php

$path = __DIR__ . '/../config/bootstrap.php';
require_once __DIR__ . '/../config/bootstrap.php';

use Dominio\Auto;
// require_once 'config/config.php';
// require_once 'Dominio/Auto.php';
// require_once 'Aplication/AgregarAutoUseCase.php';
// require_once 'Infraestructura/AutoRepository.php';
// require_once 'encore/Conexion.php';

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $marca = $_POST['marca'] ?? '';
    $modelo = $_POST['modelo'] ?? '';
    $fecha = $_POST['fecha_compra'] ?? '';

    try {
        $auto = new Auto($marca, $modelo, $fecha);
        $repo = new AutoRepository();
        //$useCase = new AgregarAutoUseCase($repo);

        // if ($useCase->agregarAuto($auto)) {
        //     $mensaje = "Auto agregado con éxito.";
        // } else {
        //     $mensaje = "Error al agregar el auto.";
        // }
    } catch (Exception $e) {
        $mensaje = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Agregar Auto</title>
</head>

<body>
    <h1>Agregar Auto</h1>
    <form method="post" action="">
        <label>Marca: <input type="text" name="marca" required></label><br>
        <label>Modelo: <input type="text" name="modelo" required></label><br>
        <label>Fecha de compra (YYYY-MM-DD): <input type="date" name="fecha_compra" required></label><br>
        <button type="submit">Guardar</button>
    </form>
    <p><?= htmlspecialchars($mensaje) ?></p>
    <p><a href="index.php">Volver al menú</a></p>
</body>

</html>