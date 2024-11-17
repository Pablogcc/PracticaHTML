<?php

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    echo json_encode([
        'success' => false,
        'message' => 'El método no es el correcto, cambia al DELETE.'
    ]);
    exit; 
}



require_once './models/User.php';

$datos = "mysql:host=localhost;port=9999;dbname=colegio;charset=utf8";
$conexion = new PDO($datos, 'root', 'dada');
$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Aquí pones el id que deseas eliminar, en este caso 5
$id = 16;


$pantalla = eliminarUsuario($conexion, $id);


function eliminarUsuario($conexion, $id)
{
    // Aquí usamos el DELETE para eliminar al alumno
    $declaracion = $conexion->prepare("DELETE FROM alumno WHERE id = :id");
    $declaracion->bindParam(':id', $id, PDO::PARAM_INT);

    $eliminado = $declaracion->execute();
    
    return $eliminado
        ? [
            'success' => true,
            'message' => 'El usuario se ha eliminado de la tabla alumnos',
            'data' => null
        ]
        : [
            'success' => false,
            'message' => 'No se pudo eliminar el usuario',
            'data' => null
        ];
}

echo json_encode($pantalla);
