<?php
define('BASE_URL', 'http://localhost:8080/');
define('BASE_URL_CTRL', 'http://localhost:8080/Controller/'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    hola desde src index.
    <?php
    $nombre = "hola";
    $apellido = "hola";
    ?>
    <ul>
        <li><a href="index.php">Ir a la página principal (actual)</a></li>
        <li><a href="<?= BASE_URL_CTRL ?>listar_auto_controller.php">yyListar Autos Disponibles</a></li>
    </ul>
</body>

</html>