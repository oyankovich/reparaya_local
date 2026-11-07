<?php
class Incidencia {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    public function crear($datos) {
        $consulta = "INSERT INTO incidencias 
                     (localizador, cliente_id, especialidad_id, descripcion, direccion, fecha_servicio, tipo_urgencia, estado) 
                     VALUES 
                     (:localizador, :cliente_id, :especialidad_id, :descripcion, :direccion, :fecha_servicio, :tipo_urgencia, 'Pendiente')";
        
        $sentencia = $this->db->prepare($consulta);
        $sentencia->execute([
            ':localizador' => $datos['localizador'],
            ':cliente_id' => $datos['cliente_id'],
            ':especialidad_id' => $datos['especialidad_id'],
            ':descripcion' => $datos['descripcion'],
            ':direccion' => $datos['direccion'],
            ':fecha_servicio' => $datos['fecha_servicio'],
            ':tipo_urgencia' => $datos['tipo_urgencia']
        ]);

        return $this->db->lastInsertId();
    }

    public function obtenerPorCliente($cliente_id) {
        $consulta = "SELECT * FROM incidencias 
                     WHERE cliente_id = :cliente_id 
                     ORDER BY fecha_servicio DESC";
        
        $sentencia = $this->db->prepare($consulta);
        $sentencia->execute([':cliente_id' => $cliente_id]);
        
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id, $cliente_id) {
        $consulta = "SELECT * FROM incidencias WHERE id = :id AND cliente_id = :cliente_id";
        $sentencia = $this->db->prepare($consulta);
        $sentencia->execute([
            ':id' => $id, 
            ':cliente_id' => $cliente_id
        ]);
        return $sentencia->fetch(PDO::FETCH_ASSOC); 
    }

    public function actualizarEstado($id, $nuevo_estado) {
        $consulta = "UPDATE incidencias SET estado = :estado WHERE id = :id";
        $sentencia = $this->db->prepare($consulta);
        return $sentencia->execute([
            ':estado' => $nuevo_estado,
            ':id' => $id
        ]);
    }

    public function obtenerTodasGlobal() {
        $consulta = "SELECT i.*, 
                            u.nombre AS cliente_nombre, 
                            e.nombre_especialidad 
                     FROM incidencias i
                     LEFT JOIN usuarios u ON i.cliente_id = u.id
                     LEFT JOIN especialidades e ON i.especialidad_id = e.id
                     ORDER BY i.fecha_servicio ASC";
        
        $sentencia = $this->db->prepare($consulta);
        $sentencia->execute();
        
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    public function asignarTecnico($incidencia_id, $tecnico_id) {
        $consulta = "UPDATE incidencias 
                     SET tecnico_id = :tecnico_id, estado = 'Asignada' 
                     WHERE id = :id";
        
        $sentencia = $this->db->prepare($consulta);
        return $sentencia->execute([
            ':tecnico_id' => $tecnico_id,
            ':id' => $incidencia_id
        ]);
    }
}
?>