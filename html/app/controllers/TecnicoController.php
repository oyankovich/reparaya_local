<?php
class TecnicoController {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    public function verPanel() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'tecnico') {
            header("Location: index.php?ruta=inicio");
            exit;
        }

        require_once '../app/models/Tecnico.php';
        require_once '../app/models/Incidencia.php';

        $modeloTecnico = new Tecnico($this->db);
        $modeloIncidencia = new Incidencia($this->db);

        $tecnico = $modeloTecnico->obtenerPorUsuarioId($_SESSION['usuario_id']);
        
        if (!$tecnico) {
            die("Error del Servidor: Tu cuenta de usuario no está enlazada a una ficha de empleado técnico.");
        }

        $incidencias = $modeloIncidencia->obtenerPorTecnico($tecnico['id']);

        require_once '../views/tecnico/panel_tecnico.php';
    }

    public function procesarEstado() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'tecnico' || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?ruta=inicio");
            exit;
        }

        $incidencia_id = $_POST['incidencia_id'];
        $accion = $_POST['accion'];

        require_once '../app/models/Tecnico.php';
        require_once '../app/models/Incidencia.php';
        require_once '../app/models/Historial.php';

        $modeloTecnico = new Tecnico($this->db);
        $modeloIncidencia = new Incidencia($this->db);
        $modeloHistorial = new Historial($this->db);

        $tecnico = $modeloTecnico->obtenerPorUsuarioId($_SESSION['usuario_id']);
        $incidencia = $modeloIncidencia->obtenerPorIdGlobal($incidencia_id);

        if (!$incidencia || $incidencia['tecnico_id'] != $tecnico['id']) {
            die("Bloqueo de Seguridad: No tienes permisos sobre esta incidencia.");
        }

        if ($accion === 'iniciar' && $incidencia['estado'] === 'Asignada') {
            $nuevo_estado = 'En curso';
        } elseif ($accion === 'finalizar' && $incidencia['estado'] === 'En curso') {
            $nuevo_estado = 'Finalizada';
        } else {
            die("Bloqueo de Servidor: Transición de estado no permitida por las reglas de negocio.");
        }

        try {
            $this->db->beginTransaction();
            $modeloIncidencia->actualizarEstado($incidencia_id, $nuevo_estado);
            $modeloHistorial->registrar($incidencia_id, $incidencia['estado'], $nuevo_estado, $_SESSION['usuario_id']);
            $this->db->commit();
            
            header("Location: index.php?ruta=panel_tecnico&exito=estado_actualizado");
            exit;
        } catch (PDOException $e) {
            $this->db->rollBack();
            die("Error en transacción al cambiar estado de incidencia.");
        }
    }
}
?>