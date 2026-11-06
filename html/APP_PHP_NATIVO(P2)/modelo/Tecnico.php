<?php

class Tecnico {
    private $conn;
    private $table_name = "tecnicos";

    public $id;
    public $usuario_id;
    public $nombre_completo;
    public $especialidad_id;
    public $disponibilidad;

    public function __construct($db) {
        $this->conn = $db;
    }

    //Método para registrar un técnico en la tabla tecnicos
    public function crear() {
        $query = "INSERT INTO " . $this->table_name . " (nombre_completo, especialidad_id, disponible) VALUES (:nombre_completo, :especialidad_id, 1)"; //1 = Disponible

        $stmt = $this->conn->prepare($query);

        $this->nombre_completo = htmlspecialchars(strip_tags($this->nombre_completo));
        $this->especialidad_id = htmlspecialchars(strip_tags($this->especialidad_id));

        $stmt->bindParam(':nombre_completo', $this->nombre_completo);
        $stmt->bindParam(':especialidad_id', $this->especialidad_id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    //Método para listar todos los técnicos con su especialidad
    public function obtenerTodos() {
        $query = "SELECT t.*, e.nombre_especialidad
                 FROM " . $this->table_name . " t
                 LEFT JOIN especialidades e ON t.especialidad_id = e.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}

?>