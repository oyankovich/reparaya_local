<?php
class Especialidad {
    private $conn;
    private $table_name = "especialidades";

    public $id;
    public $nombre_especialidad;
    public $precio_base;

    public function __construct($db) {
        $this->conn = $db;
    }

    //Crear una nueva especialidad
    public function crear() {
        $query = "INSERT INTO " . $this->table_name . " (nombre_especialidad, precio_base) VALUES (:nombre_especialidad, :precio_base)";
        $stmt = $this->conn->prepare($query);

        $this->nombre_especialidad = htmlspecialchars(strip_tags($this->nombre_especialidad));
        $this->precio_base = htmlspecialchars(strip_tags($this->precio_base));

        $stmt->bindParam(':nombre_especialidad', $this->nombre_especialidad);
        $stmt->bindParam(':precio_base', $this->precio_base);

        return $stmt->execute();
    }

    //Listar todas las especialidades
    public function obtenerTodas() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}


?>