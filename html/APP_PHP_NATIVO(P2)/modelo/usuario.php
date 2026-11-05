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

    public function login($email_buscado) {

    //Preparamos consulta SQL con 'SELECT *' para cuando el controlador haga el login pueda obtener todos los datos del usuario y no solo el email.
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email";

    //Limpiamos la variable de entrada para evitar inyecciones SQL y otros ataques. Deesta manera podemos aportar una capa de seguridad adicional a la aplicación.
        $email_buscado = htmlspecialchars(strip_tags($email_buscado));

    //Preparamos la consulta en la base de datos
        $consulta = $this->conn->prepare($query);

    //Vinculamos el parámetro de la consulta con el valor del email buscado
        $consulta->bindParam(':email', $email_buscado);

    //Ejecutamos la consulta y si se ejecuta correctamente, devolvemos los datos del usuario en un array asociativo.
        if($consulta->execute()) {
            return $consulta->fetch(PDO::FETCH_ASSOC);
        }

        return false;
    }

    public function actualizarPerfil() {
        //Actualizamos nombre, email y teléfono.
        //La contraseña la dejamos para otro método o lo incluimos si queremos que el usuario pueda cambiarla desde su perfil.
        $query = "UPDATE " . $this->table_name . " SET nombre = :nombre, email = :email, telefono = :telefono WHERE id = :id";
        $consulta = $this->conn->prepare($query);

        //Limpiamos los datos de entrada para evitar inyecciones SQL y otros ataques.
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));

        //Vinculamos los parámetros de la consulta con los valores de las propiedades del objeto
        $consulta->bindParam(':nombre', $this->nombre);
        $consulta->bindParam(':email', $this->email);
        $consulta->bindParam(':telefono', $this->telefono);
        $consulta->bindParam(':id', $this->id);
        
        if($consulta->execute()) {
            return true;
        }
        return false;
    }

    public function obtenerUsuarioPorId($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $consulta = $this->conn->prepare($query);

        //Limpiamos el ID de entrada para evitar inyecciones SQL y otros ataques.
        $id = htmlspecialchars(strip_tags($id));

        //Vinculamos el parámetro de la consulta con el valor del ID
        $consulta->bindParam(':id', $id);

        if($consulta->execute()) {
            return $consulta->fetch(PDO::FETCH_ASSOC);
        }

        return false;
    }
}

?>