<?php
class Usuario {
    private $conn;
    private $table_name = "usuarios";

    //Estas serán las propiedades del usuario que deberán coincidir con la tabla en la BBDD
    public $id;
    public $nombre;
    public $email;
    public $password;
    public $rol;
    public $telefono;

    //El constructorque recibe la conexión a la BBDD
    public function __construct($db) {
        $this->conn = $db;
    }

    public function registrar() {

        $query = "INSERT INTO " . $this->table_name . " (nombre, email, password, rol, telefono) VALUES (:nombre, :email, :password, :rol, :telefono)";

        

    }
}

?>