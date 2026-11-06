<?php

class Incidencias {
    private $conn;
    private $table_name = "incidencias";

    //Propiedades
    public $id;
    public $localizador;
    public $cliente_id;
    public $tecnico_id;
    public $especialidad_id;
    public $descripcion;
    public $direccion;
    public $fecha_servicio;
    public $tipo_urgencia;
    public $estado;

    public function __construct($db) {
        $this->conn = $db;
    }

    //Método para crear una incidencia
    public function crear() {
        //Generamos un código único aleatorio para el localizador
        $this->localizador = "REP-" . rand(100000, 999999);

        //Escribimos la consulta SQL para insertar una nueva incidencia en la base de datos. Su estado por defecto es "Pendiente"
        $query = "INSERT INTO " . $this->table_name . " (localizador, cliente_id, especialidad_id, descripcion, direccion, fecha_servicio, tipo_urgencia, estado) VALUES (:localizador, :cliente_id, :especialidad_id, :descripcion, :direccion, :fecha_servicio, :tipo_urgencia, 'Pendiente')";
    
        //Preparamos la consulta
        $stmt = $this->conn->prepare($query);

        //Limpiamos los datos para evitar inyecciones SQL
        $this->localizador = htmlspecialchars(strip_tags($this->localizador));
        $this->cliente_id = htmlspecialchars(strip_tags($this->cliente_id));
        $this->especialidad_id = htmlspecialchars(strip_tags($this->especialidad_id));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->direccion = htmlspecialchars(strip_tags($this->direccion));
        $this->fecha_servicio = htmlspecialchars(strip_tags($this->fecha_servicio));
        $this->tipo_urgencia = htmlspecialchars(strip_tags($this->tipo_urgencia));

        //Vinculamos los parámetros
        $stmt->bindParam(':localizador', $this->localizador);
        $stmt->bindParam(':cliente_id', $this->cliente_id);
        $stmt->bindParam(':especialidad_id', $this->especialidad_id);
        $stmt->bindParam(':descripcion', $this->descripcion);
        $stmt->bindParam(':direccion', $this->direccion);
        $stmt->bindParam(':fecha_servicio', $this->fecha_servicio);
        $stmt->bindParam(':tipo_urgencia', $this->tipo_urgencia);

        //Ejecutamos la consulta y verificamos si se realizó correctamente
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }   
    
    }

    public function obtenerPorCliente($cliente_id) {
        $query = "SELECT i.*, e.nombre_especialidad 
            FROM " . $this->table_name . " i 
            LEFT JOIN especialidades e ON i.especialidad_id = e.id 
            WHERE i.cliente_id = :cliente_id
            ORDER BY i.fecha_servicio DESC";

        $stmt = $this->conn->prepare($query);

        $cliente_id = htmlspecialchars(strip_tags($cliente_id));
        $stmt->bindParam(':cliente_id', $cliente_id);
        $stmt->execute();
        return $stmt;
    }

    public function cancelar($id_incidencia) {
        $query = "UPDATE " . $this->table_name . " SET estado = 'Cancelada' WHERE id = :id_incidencia";
        $stmt = $this->conn->prepare($query);

        $id_incidencia = htmlspecialchars(strip_tags($id_incidencia));
        $stmt->bindParam(':id_incidencia', $id_incidencia);
        return $stmt->execute();
    }

public function registrarHistorial($id_incidencias, $estado_anterior, $estado_nuevo, $usuario_id) {
    $query = "INSERT INTO historial_incidencias (incidencias_id, estado_anterior, estado_nuevo, usuario_id) 
              VALUES (:incidencias_id, :estado_anterior, :estado_nuevo, :usuario_id)";
    
    $stmt = $this->conn->prepare($query);

    // Limpiar los datos
    $id_incidencias = htmlspecialchars(strip_tags($id_incidencias));
    $estado_anterior = htmlspecialchars(strip_tags($estado_anterior));
    $estado_nuevo = htmlspecialchars(strip_tags($estado_nuevo));
    $usuario_id = htmlspecialchars(strip_tags($usuario_id));

    // Vincular los parámetros
    $stmt->bindParam(':incidencias_id', $id_incidencias);
    $stmt->bindParam(':estado_anterior', $estado_anterior);
    $stmt->bindParam(':estado_nuevo', $estado_nuevo);
    $stmt->bindParam(':usuario_id', $usuario_id);

    // Ejecutar la consulta y verificar si se realizó correctamente
    return $stmt->execute();

}

public function obtenerHistorial($incidencia_id) {
    $query = "SELECT h.*, u.nombre AS usuario_nombre 
              FROM historial_incidencias h 
              LEFT JOIN usuarios u ON h.usuario_id = u.id 
              WHERE h.incidencias_id = :incidencia_id
              ORDER BY h.fecha_cambio DESC";
    $stmt = $this->conn->prepare($query);
    $incidencia_id = htmlspecialchars(strip_tags($incidencia_id));
    $stmt->bindParam(':incidencia_id', $incidencia_id);
    $stmt->execute();
    return $stmt;
}

public function obtenerPorId($id_incidencia) {
    $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id_incidencia";
    $stmt = $this->conn->prepare($query);

    $id_incidencia = htmlspecialchars(strip_tags($id_incidencia));
    $stmt->bindParam(':id_incidencia', $id_incidencia);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);

}
}

?>