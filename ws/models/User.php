<?php

class User {

    public $nombre;
    public $apellidos;
    public $contrasena;
    public $telefono;
    public $email;

    public $sexo;

    public function __construct($nombre, $apellidos, $contrasena, $telefono, $email, $sexo) {
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->contrasena=$contrasena;
        $this->telefono = $telefono;
        $this->email = $email;
        $this->sexo = $sexo;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getApellidos() {
        return $this->apellidos;
    }

    public function getcontrasena() {
        return $this->contrasena;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getSexo() {
        return $this->sexo;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    public function setContrasena($contrasena) {
        $this->contrasena = $contrasena;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setSexo($sexo) {
        $this->sexo = $sexo;
    }

    public function toJson(){
        return json_encode([
            "nombre"=> $this->nombre,
            "apellidos"=> $this->apellidos,
            "contrasena"=> $this->contrasena,
            "telefono"=> $this->telefono,
            "email"=> $this->email,
            "sexo"=> $this->sexo
        ]);
    }





}