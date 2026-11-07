<?php
require_once __DIR__ . '/Historial.php';

class GestionIncidencia {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    // Comprueba si el cambio de estado está permitido según el rol
    public function puedeCambiar($estadoActual, $estadoNuevo, $rol) {
        if ($rol === 'admin') {
            // El admin solo puede asignar o cancelar si está Pendiente o Asignada
            if ($estadoActual === 'Pendiente' && ($estadoNuevo === 'Asignada' || $estadoNuevo === 'Cancelada')) {
                return true;
            }
            if ($estadoActual === 'Asignada' && $estadoNuevo === 'Cancelada') {
                return true;
            }
        }

        if ($rol === 'tecnico') {
            // El técnico empieza el trabajo y luego lo termina
            if ($estadoActual === 'Asignada' && $estadoNuevo === 'En curso') {
                return true;
            }
            if ($estadoActual === 'En curso' && $estadoNuevo === 'Finalizada') {
                return true;
            }
        }

        // Cualquier otro cambio no se permite (Finalizada y Cancelada ya no se tocan)
        return false;
    }

    // Todas las incidencias para el admin. Si llega un estado, filtra por él
    public function obtenerTodas($estado = '') {
        $consulta = "SELECT i.*, u.nombre AS cliente, e.nombre_especialidad AS servicio, t.nombre_completo AS tecnico
                     FROM incidencias i
                     JOIN usuarios u ON i.cliente_id = u.id
                     JOIN especialidades e ON i.especialidad_id = e.id
                     LEFT JOIN tecnicos t ON i.tecnico_id = t.id";

        if ($estado !== '') {
            $consulta .= " WHERE i.estado = :estado ORDER BY i.fecha_servicio";
            $sentencia = $this->db->prepare($consulta);
            $sentencia->execute([':estado' => $estado]);
        } else {
            $consulta .= " ORDER BY i.fecha_servicio";
            $sentencia = $this->db->prepare($consulta);
            $sentencia->execute();
        }

        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    // Una incidencia concreta con sus datos
    public function obtenerPorId($id) {
        $consulta = "SELECT i.*, u.nombre AS cliente, e.nombre_especialidad AS servicio,
                            t.nombre_completo AS tecnico, t.usuario_id AS tecnico_usuario_id
                     FROM incidencias i
                     JOIN usuarios u ON i.cliente_id = u.id
                     JOIN especialidades e ON i.especialidad_id = e.id
                     LEFT JOIN tecnicos t ON i.tecnico_id = t.id
                     WHERE i.id = :id";
        $sentencia = $this->db->prepare($consulta);
        $sentencia->execute([':id' => $id]);
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }

    // Las incidencias asignadas al técnico que ha iniciado sesión
    public function obtenerPorTecnico($usuario_id) {
        $consulta = "SELECT i.*, u.nombre AS cliente, e.nombre_especialidad AS servicio
                     FROM incidencias i
                     JOIN tecnicos t ON i.tecnico_id = t.id
                     JOIN usuarios u ON i.cliente_id = u.id
                     JOIN especialidades e ON i.especialidad_id = e.id
                     WHERE t.usuario_id = :usuario_id
                     ORDER BY i.fecha_servicio";
        $sentencia = $this->db->prepare($consulta);
        $sentencia->execute([':usuario_id' => $usuario_id]);
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    // Técnicos que se pueden asignar
    public function obtenerTecnicosDisponibles() {
        $consulta = "SELECT id, nombre_completo FROM tecnicos WHERE disponible = 1 ORDER BY nombre_completo";
        $sentencia = $this->db->prepare($consulta);
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    // Cambia el estado y lo guarda en el historial. Devuelve true o un mensaje de error
    public function cambiarEstado($id, $estadoNuevo, $usuario_id, $rol) {
        $incidencia = $this->obtenerPorId($id);

        if (!$incidencia) {
            return "La incidencia no existe.";
        }

        // Un técnico solo puede tocar sus propias incidencias
        if ($rol === 'tecnico' && $incidencia['tecnico_usuario_id'] != $usuario_id) {
            return "Esta incidencia no está asignada a ti.";
        }

        if (!$this->puedeCambiar($incidencia['estado'], $estadoNuevo, $rol)) {
            return "No se puede pasar de " . $incidencia['estado'] . " a " . $estadoNuevo . ".";
        }

        $sentencia = $this->db->prepare("UPDATE incidencias SET estado = :estado WHERE id = :id");
        $sentencia->execute([':estado' => $estadoNuevo, ':id' => $id]);

        $historial = new Historial($this->db);
        $historial->registrar($id, $incidencia['estado'], $estadoNuevo, $usuario_id);

        return true;
    }

    // Asigna un técnico. Si estaba Pendiente pasa a Asignada
    public function asignarTecnico($id, $tecnico_id, $usuario_id) {
        $incidencia = $this->obtenerPorId($id);

        if (!$incidencia) {
            return "La incidencia no existe.";
        }

        if ($incidencia['estado'] !== 'Pendiente' && $incidencia['estado'] !== 'Asignada') {
            return "Solo se puede asignar técnico si está Pendiente o Asignada.";
        }

        if ($incidencia['estado'] === 'Pendiente') {
            $sentencia = $this->db->prepare("UPDATE incidencias SET tecnico_id = :tecnico_id, estado = 'Asignada' WHERE id = :id");
            $sentencia->execute([':tecnico_id' => $tecnico_id, ':id' => $id]);

            $historial = new Historial($this->db);
            $historial->registrar($id, 'Pendiente', 'Asignada', $usuario_id);
        } else {
            // Ya estaba asignada: solo cambiamos el técnico
            $sentencia = $this->db->prepare("UPDATE incidencias SET tecnico_id = :tecnico_id WHERE id = :id");
            $sentencia->execute([':tecnico_id' => $tecnico_id, ':id' => $id]);
        }

        return true;
    }
}