<?php

$host = "db"; // Nombre del servicio en docker-compose
$database = "mydatabase"; // Nombre de la base de datos
$username = "user"; // Usuario de la base de datos
$password = "userpassword"; // Contraseña de la base de datos

try {
    // Crear conexión PDO
    $dsn = "mysql:host=$host;dbname=$database;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Manejo de errores con excepciones
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Devolver resultados como arrays asociativos
        PDO::ATTR_EMULATE_PREPARES => false, // Desactivar emulación de prepares
    ];

    $pdo = new PDO($dsn, $username, $password, $options);

    echo "<h2>✅ Conexión exitosa a MySQL con PDO</h2>";

    // Ejecutar una consulta simple para probar
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll();

    if ($tables) {
        echo "<h3>📌 Tablas en la base de datos:</h3>";
        echo "<ul>";
        foreach ($tables as $table) {
            echo "<li>" . array_values($table)[0] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p> No hay tablas en la base de datos.</p>";
    }
} catch (PDOException $e) {
    var_dump($e);
    echo "<h2> Error de conexión:</h2> " . $e->getMessage();
}
