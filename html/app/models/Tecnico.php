<?php
class Tecnico {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    public function obtenerTodos() {
        $consulta = "SELECT * FROM tecnicos ORDER BY nombre_completo ASC";
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
}
?>