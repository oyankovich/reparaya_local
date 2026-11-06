<?php
class Historial {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    public function registrar($incidencia_id, $estado_anterior, $estado_nuevo, $usuario_id) {
        $consulta = "INSERT INTO historial_estados 
                     (incidencia_id, estado_anterior, estado_nuevo, usuario_id) 
                     VALUES 
                     (:incidencia_id, :estado_anterior, :estado_nuevo, :usuario_id)";
        
        $sentencia = $this->db->prepare($consulta);
        return $sentencia->execute([
            ':incidencia_id' => $incidencia_id,
            ':estado_anterior' => $estado_anterior,
            ':estado_nuevo' => $estado_nuevo,
            ':usuario_id' => $usuario_id
        ]);
    }

    public function obtenerPorIncidencia($incidencia_id) {
        $consulta = "SELECT * FROM historial_estados WHERE incidencia_id = :incidencia_id ORDER BY id ASC";
        $sentencia = $this->db->prepare($consulta);
        $sentencia->execute([':incidencia_id' => $incidencia_id]);
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>