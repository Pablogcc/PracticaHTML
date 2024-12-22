<?php
// Datos de conexión a la base de datos
$servidor = "localhost"; // IP del servidor de la base de datos MySQL
$puerto = "3306";           // Puerto MySQL (por defecto es 3306)
$baseDatos = "colegio";      // Nombre de la base de datos
$usuario = "root";           // Usuario de la base de datos
$contrasena = "dada";        // Contraseña del usuario

try {
    // Conexión a la base de datos usando PDO
    $conexion = new PDO("mysql:host=$servidor;port=$puerto;dbname=$baseDatos;charset=utf8", $usuario, $contrasena);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode([
        'success' => false,
        'message' => 'Error al conectar con la base de datos: ' . $e->getMessage()
    ]));
}

// Comprobar si se pasa un ID por URL
$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id) {
    // Mostrar datos de un solo usuario
    $sql = "SELECT * FROM alumno WHERE id = :id";
    $declaracion = $conexion->prepare($sql);
    $declaracion->bindParam(':id', $id, PDO::PARAM_INT);
    $declaracion->execute();
    $resultado = $declaracion->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        echo json_encode([
            'success' => true,
            'message' => "Usuario encontrado.",
            'data' => $resultado
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => "No se encontró un usuario con ID $id.",
            'data' => null
        ]);
    }
} else {
    // Mostrar todos los usuarios
    $sql = "SELECT * FROM alumno";
    $declaracion = $conexion->query($sql);
    $resultados = $declaracion->fetchAll(PDO::FETCH_ASSOC);

    if ($resultados) {
        echo json_encode([
            'success' => true,
            'message' => "Lista de usuarios obtenida correctamente.",
            'data' => $resultados
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => "No hay usuarios en la base de datos.",
            'data' => null
        ]);
    }
}
?>
