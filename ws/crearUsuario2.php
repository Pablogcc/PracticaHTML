<?php


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido. Por favor, usa POST.'
    ]);
    exit;
}


require_once './models/User.php';  

$datos = "mysql:host=localhost;port=9999;dbname=colegio;charset=utf8";
$conexion = new PDO($datos, 'root', 'dada');
$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Recopila los datos del formulario
$nombre = ($_POST['nombre']);
$apellidos = ($_POST['apellidos']);
$contrasena = ($_POST['contrasena']); 
$telefono = ($_POST['telefono']);
$email = ($_POST['email']);
$sexo = ($_POST['sexo'] === 'masculino') ? 'M' : 'F';
$fecha_nacimiento = $_POST['fecha_nacimiento'];

// Crea el objeto User
$user = new User($nombre, $apellidos, $contrasena, $telefono, $email, $sexo, $fecha_nacimiento, null);

// Inserta el usuario en la base de datos
$declaracion = $conexion->prepare("INSERT INTO alumno (nombre, apellidos, password, telefono, email, sexo, fecha_nacimiento) VALUES (:nombre, :apellidos, :contrasena, :telefono, :email, :sexo, :fecha_nacimiento)");
$declaracion->execute([
    ':nombre' => $user->getNombre(),
    ':apellidos' => $user->getApellidos(),
    ':contrasena' => $user->getcontrasena(),
    ':telefono' => $user->getTelefono(),
    ':email' => $user->getEmail(),
    ':sexo' => $user->getSexo(),
    ':fecha_nacimiento' => $user->getFecha_nacimiento()
]);

// Respuesta en JSON
echo json_encode([
    'status' => 'success',
    'message' => 'Usuario creado correctamente',
    'data' => [
        'id' => $conexion->lastInsertId(),
        'nombre' => $user->getNombre(),
        'apellidos' => $user->getApellidos(),
        'telefono' => $user->getTelefono(),
        'email' => $user->getEmail(),
        'sexo' => $user->getSexo(),
        'fecha_nacimiento' => $user->getFecha_nacimiento()
    ]
]);
