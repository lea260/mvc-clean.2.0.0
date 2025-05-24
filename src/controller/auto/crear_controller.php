<?php

//$path ="var/www/html";
define('BASE_PATH', dirname(__DIR__, 2));
// define('BASE_PATH', $path); // apunta a src/ /var/html/www
define('BASE_URL', 'http://localhost:8080/');
define('BASE_URL_CTRL', 'http://localhost:8080/controller/');
// define('BASE_URL_VIEW', 'http://localhost:8080/view/');
require_once BASE_PATH . '/config/bootstrap.php';

use Core\View;

try {
    //se puede verificar si el usuario es admin
    View::render('mensaje/comun.php', [
        'titulo' => "Crear Auto",
        'mensaje' => "auto creado con exito",
    ]);
} catch (Exception $e) {
    View::render('mensaje/comun.php', [
        'titulo' => "Crear Auto",
        'mensaje' => "auto creado con exito",
    ]);
}
