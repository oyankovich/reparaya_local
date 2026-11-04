<?php

class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $conn;

    public function __construct() {
        //Lee las variables de entorno que tenemos en el archivo .env
        $this->host = "db"; 
        $this->db_name = "reparaya_db";
        $this->username = "reparaya_user";
        $this->password = "1234jaumeuoc";
    }

    public function getConexion() {

        $this->conn = null;
        try{

            //Creamos la conexión PDO
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4",
                $this->username,
                $this->password
            );

            //Lo configuramos para que lance exepciones en caso de error
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }
        return $this->conn;
        
    }
}

?>