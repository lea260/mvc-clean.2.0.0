<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h2>Detalle del Auto</h2>
    <?php if ($auto): ?>
        <ul>
            <li><strong>ID:</strong> <?= htmlspecialchars($auto->getId()) ?></li>
            <li><strong>Patente:</strong> <?= htmlspecialchars($auto->getPatente()) ?></li>
            <li><strong>Marca:</strong> <?= htmlspecialchars($auto->getMarca()) ?></li>
            <li><strong>Modelo:</strong> <?= htmlspecialchars($auto->getModelo()) ?></li>
            <li><strong>Estado:</strong> <?= htmlspecialchars($auto->getEstado()) ?></li>
        </ul>
        <?php
        if ($auto->getEstado() === 'disponible'): ?>
            <p>El auto está disponible para reservar o comprar.</p>
            <form method="POST" action="<?= BASE_URL_CTRL ?>reserva/auto_controller.php">
                <input type="hidden" name="id_auto" value="<?= htmlspecialchars($auto->getId()) ?>">
                <label>ID Usuario: <input type="number" name="id_usuario" required></label>
                <button type="submit">Reservar</button>
            </form>
            <form method="POST" action="/controller/comprar_auto_controller.php">
                <input type="hidden" name="id_auto" value="<?= htmlspecialchars($auto->getId()) ?>">
                <label>ID Usuario: <input type="number" name="id_usuario" required></label>
                <button type="submit">Comprar</button>
            </form>
        <?php elseif ($auto->getEstado() === 'reservado'): ?>
            <p>El auto está reservado.</p>
        <?php elseif ($auto->getEstado() === 'vendido'): ?>
            <p>El auto ha sido vendido.</p>
        <?php endif; ?>
    <?php else: ?>
        <p>No se encontró información del auto.</p>
    <?php endif; ?>
    <p><a href="<?= BASE_URL ?>index.php">Volver al menú</a></p>
</body>

</html>