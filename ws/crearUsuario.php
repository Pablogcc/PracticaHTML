<?php

require_once './models/User.php';

// Aquí ponemos que cuando el formulario se envíe con todos los valores, (?? '') esto sirve para que si es null se ponga un valor predeterminado
$nombre = $_POST['nombre'] ?? '';
$apellidos = $_POST['apellidos'] ?? '';
$contrasena = $_POST['contrasena'] ?? '';
$telefono = $_POST['telefono'] ?? '';
$email = $_POST['email'] ?? '';
$sexo = $_POST['sexo'] ?? '';


$user = new User($nombre, $apellidos, $contrasena, $telefono, $email, $sexo);


// El PHP_EOL sirve como un salto de línea
$almacenar = $nombre . ', ' . $apellidos . ', ' . $contrasena . ', ' . $telefono . ', ' . $email . ', ' . $sexo . PHP_EOL;
// El file_put_contents es una función que sirve para escribir en un archivo de texto (.txt)
// Y el FILE_APPEND sirve para que se escriba en el txt y se acumulen los datos enviados por el formulario sin borrar llos que ya estaban
file_put_contents('user.txt', $almacenar, FILE_APPEND);

// El toJson convierte los datos del formulario en un JSON y luego salen por pantalla con el echo
echo $user->toJson();
