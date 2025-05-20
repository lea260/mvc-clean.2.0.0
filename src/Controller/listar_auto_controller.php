<?php
$base = __DIR__ . '/../config/bootstrap.php';
$real = realpath(__DIR__ . '/../config/bootstrap.php');
$real = __DIR__ . '/../config/bootstrap.php';
require_once __DIR__ . '/../config/bootstrap.php';
// require_once dirname(__DIR__) . '/config/bootstrap.php';



use Infraestructura\AutoRepositorio;


// require_once 'config/config.php';
// require_once 'infraestructura/AutoRepositorio.php';


$autos = [];

try {
    $repo = new AutoRepositorio();
    $autos = $repo->listar();
    var_dump($autos);
} catch (Exception $e) {
    $error = "Error al obtener los autos: " . $e->getMessage();
} finally {
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Lista de Autos</title>
</head>

<body>
    <h1>Lista de Autos</h1>
    <?php if (!empty($autos)): ?>
        <table border="1" cellpadding="5">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Fecha de Compra</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($autos as $auto): ?>
                    <tr>
                        <td><?= htmlspecialchars($auto['id']) ?></td>
                        <td><?= htmlspecialchars($auto['Marca']) ?></td>
                        <td><?= htmlspecialchars($auto['Modelo']) ?></td>
                        <td><?= htmlspecialchars($auto['Fecha_Compra']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay autos registrados.</p>
    <?php endif; ?>
    <p><a href="index.php">Volver al menú</a></p>
</body>

</html>