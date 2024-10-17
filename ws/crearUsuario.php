<?php

require_once './models/User.php';

    $nombre = $_POST['nombre'] ?? '';
    $apellidos = $_POST['apellidos'] ??'';
    $contrasena = $_POST['contrasena'] ??'';
    $telefono = $_POST['telefono'] ??'';
    $email = $_POST['email'] ??'';
    $sexo = $_POST['sexo'] ??'';
    




    $user = new User($nombre, $apellidos, $contrasena, $telefono, $email, $sexo);
    echo $user->toJson();



















