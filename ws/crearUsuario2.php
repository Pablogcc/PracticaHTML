<?php
// Parámetros de conexión a la base de datos
$host = 'localhost';
$port = 9999;
$usuario = 'root';
$password = 'dada';
$dbname = 'colegio';

try {
    // Crear la conexión PDO
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8";
    $conn = new PDO($dsn, $usuario, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Lista de campos requeridos
    $requiredFields = ['nombre', 'apellidos', 'contrasena', 'telefono', 'email', 'sexo', 'fecha_nacimiento'];
    $missingFields = [];

    // Comprobación de cada campo
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            $missingFields[] = $field;
        }
    }

    // Si faltan campos, mostrar cuáles
    if (!empty($missingFields)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Faltan los siguientes parámetros: ' . implode(', ', $missingFields)
        ]);
        exit; // Terminar la ejecución si faltan campos
    }

    // Limpiar y preparar los datos
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    $contrasena = password_hash(trim($_POST['contrasena']), PASSWORD_DEFAULT); // Hashear la contraseña
    $telefono = trim($_POST['telefono']);
    $email = trim($_POST['email']);
    $sexo = ($_POST['sexo'] === 'masculino') ? 'M' : 'F';
    $fecha_nacimiento = $_POST['fecha_nacimiento'];

    // Preparar la consulta de inserción
    $stmt = $conn->prepare("INSERT INTO alumno (nombre, apellidos, password, telefono, email, sexo, fecha_nacimiento) VALUES (:nombre, :apellidos, :contrasena, :telefono, :email, :sexo, :fecha_nacimiento)");
    
    // Vincular los parámetros
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':apellidos', $apellidos);
    $stmt->bindParam(':contrasena', $contrasena);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':sexo', $sexo);
    $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener el último ID insertado
    $ultimoId = $conn->lastInsertId();

    // Preparar la respuesta en formato JSON
    $response = json_encode([
        'status' => 'success',
        'message' => 'Usuario creado correctamente',
        'data' => [
            'id' => $ultimoId,
            'nombre' => $nombre,
            'apellidos' => $apellidos,
            'telefono' => $telefono,
            'email' => $email,
            'sexo' => $sexo,
            'fecha_nacimiento' => $fecha_nacimiento
        ]
    ]);

} catch (PDOException $e) {
    // Manejar errores de conexión o consulta
    $response = json_encode([
        'status' => 'error',
        'message' => 'Error en la base de datos: ' . $e->getMessage()
    ]);
} finally {
    // Cerrar la conexión
    $conn = null;
}

// Imprimir la respuesta como string JSON
echo $response;

