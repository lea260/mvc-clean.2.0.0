<?php
require_once '/config.php';
require_once 'Infraestructura/AutoRepository.php';
require_once 'encore/Conexion.php';

$autos = [];

try {
    $pdo = Conexion::getPDOConnection();
    $stmt = $pdo->query("SELECT id, Marca, Modelo, Fecha_Compra FROM lanzamientosmodelos");
    $autos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $error = "Error al obtener los autos: " . $e->getMessage();
} finally {
    Conexion::cerrar();
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
