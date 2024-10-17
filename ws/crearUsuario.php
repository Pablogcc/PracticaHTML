<?php

require_once './models/User.php';

    $nombre = $_POST['nombre'] ?? '';
    $apellidos = $_POST['apellidos'] ??'';
    $contrasena = $_POST['contrasena'] ??'';
    $telefono = $_POST['telefono'] ??'';
    $email = $_POST['email'] ??'';
    $sexo = $_POST['sexo'] ??'';


    $user = new User($nombre, $apellidos, $contrasena, $telefono, $email, $sexo);
    
    $almacenar = $nombre . ', ' . $apellidos . ', ' . $contrasena . ', ' . $telefono . ', ' . $email . ', ' . $sexo . PHP_EOL;
    file_put_contents('user.txt', $almacenar, FILE_APPEND);


    echo $user->toJson();








