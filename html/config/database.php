<?php

class Database {
    private $host = 'db'; 
    private $db_name = 'reparaya_db';
    private $username = 'reparaya_user';
    private $password = 'user_secret';
    private $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            // Se establece la conexión
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8",
                $this->username,
                $this->password
            );
            
            // Configuración de errores para que lance excepciones
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch(PDOException $exception) {
            die("Error de conexión: " . $exception->getMessage());
        }

        return $this->conn;
    }
}
?>