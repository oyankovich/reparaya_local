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

    //El constructor que recibe la conexión a la BBDD
    public function __construct($db) {
        $this->conn = $db;
    }

    public function registrar() {

    //Estructura base de la consulta SQL para el ingreso de usuarios en la base de datos.
        $query = "INSERT INTO " . $this->table_name . " (nombre, email, password, rol, telefono) VALUES (:nombre, :email, :password, :rol, :telefono)";

        //Se prepara la consulta en la base de datos
        $consulta = $this->conn->prepare($query);

        //Hasheamos la contraseña para que la contraseña no se guarde en texto plano.
        $password_hasheada = password_hash($this->password, PASSWORD_DEFAULT);

        //Vinculamos los datos a los marcadores para la sentencia SQL
        $consulta->bindParam(':nombre', $this->nombre);
        $consulta->bindParam(':email', $this->email);
        $consulta->bindParam(':password', $password_hasheada);
        $consulta->bindParam(':rol', $this->rol);
        $consulta->bindParam(':telefono', $this->telefono);

        if($consulta->execute()) {
            return true;
        }

        return false;
    }
}

?>