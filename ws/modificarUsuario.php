<?php

if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido. Por favor, usa PUT.'
    ]);
    exit;
}



require_once './models/User.php';

$datos = "mysql:host=localhost;port=9999;dbname=colegio;charset=utf8";
$conexion = new PDO($datos, 'root', 'dada');
$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$id = isset($_POST['id']) ? $_POST['id'] : null;


if (!$id) {
    $response = [
        'success' => false,
        'message' => 'El id no está en la base de datos',
        'data' => null
    ];
} else {
    
    $consultaExiste = $conexion->prepare("SELECT COUNT(*) FROM alumno WHERE id = :id");
    $consultaExiste->execute([':id' => $id]);


      
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $contrasena = $_POST['contrasena'];
        $telefono = $_POST['telefono'];
        $email = $_POST['email'];
        $sexo = ($_POST['sexo'] === 'masculino') ? 'M' : 'F';
        $fecha_nacimiento = $_POST['fecha_nacimiento'];

        
        $user = new User($nombre, $apellidos, $contrasena, $telefono, $email, $sexo, $fecha_nacimiento, $id);

     
        $declaracion = $conexion->prepare("UPDATE alumno SET nombre = :nombre, apellidos = :apellidos, password = :contrasena, telefono = :telefono, email = :email, sexo = :sexo, fecha_nacimiento = :fecha_nacimiento WHERE id = :id");

        // Aquí se cambian los datos en la base de datos
        $actualizacionExitosa = $declaracion->execute([
            ':nombre' => $user->getNombre(),
            ':apellidos' => $user->getApellidos(),
            ':contrasena' => $user->getcontrasena(),
            ':telefono' => $user->getTelefono(),
            ':email' => $user->getEmail(),
            ':sexo' => $user->getSexo(),
            ':fecha_nacimiento' => $user->getFecha_nacimiento(),
            ':id' => $user->getId()
        ]);

        // Aquí hacemos que salga por pantalla
        $response = [
            'success' => $actualizacionExitosa,
            'message' =>  'Usuario actualizado correctamente',
            'data' => [
                'id' => $user->getId(),
                'nombre' => $user->getNombre(),
                'apellidos' => $user->getApellidos(),
                'telefono' => $user->getTelefono(),
                'email' => $user->getEmail(),
                'sexo' => $user->getSexo(),
                'fecha_nacimiento' => $user->getFecha_nacimiento()
            ]
        ];
    
}


echo json_encode($response);