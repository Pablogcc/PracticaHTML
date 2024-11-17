<?php

// Aquí se hace que si no se pasa por el método get en el postman, no funciona
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode([
        'success' => false,
        'message' => 'El método no es el correcto, cambia al GET.'
    ]);
    exit; 
}

require_once './models/User.php';

//Aquí se conecta la base de datos con el archivo de php
//Lo primero se crea una variable donde tengas dentro todos los datos de tu mysql(host, puesrto, nombre de la base de datos y charset)
$datos = "mysql:host=localhost;port=9999;dbname=colegio;charset=utf8";
// Luego se hace otra variable con la clase PDO que sirve para  hacer la conexión con la base de datos
$conexion = new PDO($datos, 'root', 'dada');
// El setAttribute es un metodo para configurar la base de datos, el ATTR_ERRMODE maneja los errores de la base de datos, y el ERRMODE_EXCEPTION saca la excepción
$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Aquí comprobamos si la id está en la id está en la url(isset($_GET['id']))
//Luego tenemos un operador ternario "?" que funciona como un if-else, el cuál, si la condición es verdadera ocurre el "$_GET['id']", si es falsa sería null
$id = isset($_GET['id']) ? $_GET['id'] : null;

// Aquí hace otro opeador ternario, el cuál, te da a elegir si quieres ver todos los usuarios de la base de datos o solo uno modificando la url
$pantalla = $id ? alumnoUsuario($conexion, $id) : todosAlumnosUsuarios($conexion);


function alumnoUsuario($conexion, $id)
{
    // Aquí se declara lo que quieres que se muestre por pantalla, en este caso el id, en el que pondremos nuestra variable conexion y prepare() que es de seguridad
    $declaracion = $conexion->prepare("SELECT * FROM alumno WHERE id = :id");

    // Aquí en el bindparam, donde está ':id' es donde se le dice a PHP que ponga la variable $id
    // El param_int es para ver qe el id es un número entero
    $declaracion->bindParam(':id', $id, PDO::PARAM_INT);
    $declaracion->execute();

    // Aquí se usa el FETCH_ASSOC que convierte cada declaración a un array asociativo
    $data = $declaracion->fetch(PDO::FETCH_ASSOC);

    return $data ? [
        'success' => true,
        'message' => 'El usuario está en la base de datos del colegio.',
        'data' => json_decode((new User($data['nombre'], $data['apellidos'], $data['password'], $data['telefono'], $data['email'], $data['sexo'], $data['fecha_nacimiento'], $data['id']))->toJson())
    ] : [
        'success' => false,
        'message' => "El usuario con el id " . $id . " no está",
        'data' => null
    ];
}


function todosAlumnosUsuarios($conexion)
{
    $declaracion = $conexion->prepare("SELECT * FROM alumno");
    $declaracion->execute();
    $alumnos = $declaracion->fetchAll(PDO::FETCH_ASSOC);

  
    foreach ($alumnos as $alumno) {
        $data[] = json_decode((new User($alumno['nombre'], $alumno['apellidos'], $alumno['password'], $alumno['telefono'], $alumno['email'], $alumno['sexo'], $alumno['fecha_nacimiento'], $alumno['id']))->toJson());
    }

    return $data ? [
        'success' => true,
        'message' => 'Estos son los usuarios que hay en la base de datos del colegio: ',
        'data' => $data
    ] : [
        'success' => false,
        'message' => 'No hay nadie en la base de datos',
        'data' => null
    ];
}


// Aquí hacemos que se muestre por pantalla 
echo json_encode($pantalla);
