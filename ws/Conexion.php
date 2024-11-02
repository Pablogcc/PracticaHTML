<?php

// Parámetros de conexión
$host = 'localhost';
$port = 9999;
$usuario = 'root';
$password = 'dada';
$dbname = 'colegio';

try {
    // Crear una nueva conexión PDO
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8";
    $conn = new PDO($dsn, $usuario, $password);

    // Configurar el modo de error de PDO para que lance excepciones
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Probar la conexión con una consulta simple
    $query = $conn->query("SELECT DATABASE() AS current_database");
    $result = $query->fetch(PDO::FETCH_ASSOC);

    echo "La conexión funciona: " . $result['current_database'];

} catch (PDOException $e) {
    // Captura de error en caso de fallo en la conexión o consulta
    echo "No funciona la conexión: " . $e->getMessage();
}

// Cerrar la conexión (PDO lo hace automáticamente al final del script)
$conn = null;