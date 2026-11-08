<?php
class Tecnico {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    public function obtenerTodos() {
        $consulta = "SELECT t.*, e.nombre_especialidad 
                     FROM tecnicos t 
                     LEFT JOIN especialidades e ON t.especialidad_id = e.id 
                     ORDER BY t.nombre_completo ASC";
        
        $sentencia = $this->db->prepare($consulta);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crear($usuario_id, $nombre_completo, $especialidad_id) {
        $consulta = "INSERT INTO tecnicos (usuario_id, nombre_completo, especialidad_id, disponible) 
                     VALUES (:usuario_id, :nombre_completo, :especialidad_id, 1)";
        
        $sentencia = $this->db->prepare($consulta);
        
        return $sentencia->execute([
            ':usuario_id' => $usuario_id,
            ':nombre_completo' => $nombre_completo,
            ':especialidad_id' => $especialidad_id
        ]);
    }

    public function obtenerPorUsuarioId($usuario_id) {
        $consulta = "SELECT * FROM tecnicos WHERE usuario_id = :usuario_id";
        $sentencia = $this->db->prepare($consulta);
        $sentencia->execute([':usuario_id' => $usuario_id]);
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }
}
?>