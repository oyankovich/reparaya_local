<?php
class Usuario {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    public function obtenerTodosLosUsuarios() {
        $consulta = "SELECT * FROM usuarios";
        $sentencia = $this->db->prepare($consulta);
        $sentencia->execute();
        
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>