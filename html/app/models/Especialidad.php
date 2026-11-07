<?php
class Especialidad {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    public function obtenerTodas() {
        $consulta = "SELECT * FROM especialidades ORDER BY nombre_especialidad ASC";
        $sentencia = $this->db->prepare($consulta);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>