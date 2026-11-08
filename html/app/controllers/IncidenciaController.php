<?php
class IncidenciaController {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    public function mostrarFormularioCrear() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'particular') {
            header("Location: ../public/index.php?ruta=inicio");
            exit;
        }

        require_once '../views/cliente/crear_incidencia.php';
    }

    public function procesarIncidencia() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'particular' || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: ../public/index.php?ruta=inicio");
            exit;
        }

        $tipo_urgencia = $_POST['tipo_urgencia'];
        
        $fecha_cita_segundos = strtotime($_POST['fecha_servicio']);
        $tiempo_actual_segundos = time();
        
        $diferencia_horas = ($fecha_cita_segundos - $tiempo_actual_segundos) / 3600;

        if ($tipo_urgencia === 'Estandar' && $diferencia_horas < 48) {
            header("Location: ../public/index.php?ruta=crear_incidencia&error=48h");
            exit;
        }

        $localizador = 'REP-' . strtoupper(substr(uniqid(), -8));

        $datos = [
            'localizador' => $localizador,
            'cliente_id' => $_SESSION['usuario_id'],
            'especialidad_id' => $_POST['especialidad_id'],
            'descripcion' => $_POST['descripcion'],
            'direccion' => $_POST['direccion'],
            'fecha_servicio' => $_POST['fecha_servicio'],
            'tipo_urgencia' => $tipo_urgencia
        ];

        require_once '../app/models/Incidencia.php';
        require_once '../app/models/Historial.php';
        $modeloIncidencia = new Incidencia($this->db);
        $modeloHistorial = new Historial($this->db);
        
        try {
            $this->db->beginTransaction();

            $incidencia_id = $modeloIncidencia->crear($datos);

            $modeloHistorial->registrar($incidencia_id, NULL, 'Pendiente', $_SESSION['usuario_id']);

            $this->db->commit();
            
            header("Location: ../public/index.php?ruta=inicio");
            exit;

        } catch (PDOException $e) {
            $this->db->rollBack();
            header("Location: ../public/index.php?ruta=inicio");
            exit;
        }
    }

    public function listarMisIncidencias() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'particular') {
            header("Location: ../public/index.php?ruta=inicio");
            exit;
        }

        $cliente_id = $_SESSION['usuario_id'];

        require_once '../app/models/Incidencia.php';
        $modelo = new Incidencia($this->db);
        
        $incidencias = $modelo->obtenerPorCliente($cliente_id);

        require_once '../views/cliente/mis_incidencias.php';
    }

    public function verDetalle() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'particular' || !isset($_GET['id'])) {
            header("Location: index.php?ruta=inicio");
            exit;
        }

        $incidencia_id = $_GET['id'];
        $cliente_id = $_SESSION['usuario_id'];

        require_once '../app/models/Incidencia.php';
        require_once '../app/models/Historial.php';
        
        $modeloIncidencia = new Incidencia($this->db);
        $modeloHistorial = new Historial($this->db);
        
        $incidencia = $modeloIncidencia->obtenerPorId($incidencia_id, $cliente_id);

        if (!$incidencia) {
            die("Bloqueo del Servidor: La incidencia no existe o no tienes permisos para verla.");
        }

        $historial = $modeloHistorial->obtenerPorIncidencia($incidencia_id);

        require_once '../views/cliente/detalle_incidencia.php';
    }

    public function cancelarIncidencia() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'particular' || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?ruta=inicio");
            exit;
        }

        $incidencia_id = $_POST['incidencia_id'];
        $cliente_id = $_SESSION['usuario_id'];

        require_once '../app/models/Incidencia.php';
        require_once '../app/models/Historial.php';
        $modeloIncidencia = new Incidencia($this->db);
        $modeloHistorial = new Historial($this->db);

        $incidencia = $modeloIncidencia->obtenerPorId($incidencia_id, $cliente_id);

        if (!$incidencia || ($incidencia['estado'] !== 'Pendiente' && $incidencia['estado'] !== 'Asignada')) {
            die("Bloqueo: La incidencia no existe o su estado actual no permite cancelación.");
        }

        $fecha_cita = strtotime($incidencia['fecha_servicio']);
        $ahora = time();
        $horas_restantes = ($fecha_cita - $ahora) / 3600;

        if ($horas_restantes < 48) {
            die("Bloqueo del Servidor: No puedes cancelar una asistencia si faltan menos de 48 horas.");
        }

        try {
            $this->db->beginTransaction();

            $modeloIncidencia->actualizarEstado($incidencia_id, 'Cancelada');

            $modeloHistorial->registrar($incidencia_id, $incidencia['estado'], 'Cancelada', $cliente_id);

            $this->db->commit();
            
            header("Location: index.php?ruta=detalle_incidencia&id=" . $incidencia_id);
            exit;

        } catch (PDOException $e) {
            $this->db->rollBack();
            die("Error en transacción al cancelar.");
        }
    }
}
?>