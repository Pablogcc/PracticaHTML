<?php
// Aquí en el require_once, en vez de poner "./" debes de poner "interfaces/", porque si no, no funciona
require_once 'interfaces/IToJson.php';
class User implements IToJson {

    public $nombre;
    public $apellidos;
    public $contrasena;
    public $telefono;
    public $email;

    public $sexo;

    public $fecha_nacimiento;

    public $id;

    public function __construct($nombre, $apellidos, $contrasena, $telefono, $email, $sexo, $fecha_nacimiento, $id) {
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->contrasena=$contrasena;
        $this->telefono = $telefono;
        $this->email = $email;
        $this->sexo = $sexo;
        $this->fecha_nacimiento = $fecha_nacimiento;
        $this->id = $id;
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

    public function getFecha_nacimiento(){
        return $this->fecha_nacimiento;
    }

    public function getId() {
        return $this->id;
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

    public function setFecha_nacimiento($fecha_nacimiento){
        $this->fecha_nacimiento = $fecha_nacimiento;
    }

    public function setId($id) {
        $this->id = $id;
    }

// El json_ENCODE hace que lo que le pases se convierta en un .json y se pueda enviar al archivo
    public function toJson(){
        return json_encode([
            "nombre"=> $this->nombre,
            "apellidos"=> $this->apellidos,
            "contrasena"=> $this->contrasena,
            "telefono"=> $this->telefono,
            "email"=> $this->email,
            "sexo"=> $this->sexo,
            "fecha_nacimiento"=> $this->fecha_nacimiento,
            "id" => $this->id
        ]);
    }





}