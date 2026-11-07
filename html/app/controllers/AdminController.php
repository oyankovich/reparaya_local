<?php
class AdminController {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    public function gestionarTecnicos() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
            header("Location: index.php?ruta=inicio");
            exit;
        }

        require_once '../app/models/Especialidad.php';
        require_once '../app/models/Tecnico.php';

        $modeloEspecialidad = new Especialidad($this->db);
        $modeloTecnico = new Tecnico($this->db);

        $especialidades = $modeloEspecialidad->obtenerTodas();
        $tecnicos = $modeloTecnico->obtenerTodos();

        require_once '../views/admin/gestion_tecnicos.php';
    }

    public function crearTecnico() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin' || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?ruta=inicio");
            exit;
        }

        require_once '../app/models/Tecnico.php';
        $modeloTecnico = new Tecnico($this->db);

        $nombre_completo = trim($_POST['nombre_completo']);
        $especialidad_id = $_POST['especialidad_id'];
        
        $usuario_id = !empty($_POST['usuario_id']) ? $_POST['usuario_id'] : null;

        $modeloTecnico->crear($usuario_id, $nombre_completo, $especialidad_id);

        header("Location: index.php?ruta=gestion_tecnicos&exito=1");
        exit;
    }

    public function verPanelGlobal() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
            header("Location: index.php?ruta=inicio");
            exit;
        }

        require_once '../app/models/Incidencia.php';
        require_once '../app/models/Tecnico.php';

        $modeloIncidencia = new Incidencia($this->db);
        $modeloTecnico = new Tecnico($this->db);

        $incidencias = $modeloIncidencia->obtenerTodasGlobal();
        $tecnicos = $modeloTecnico->obtenerTodos();

        require_once '../views/admin/panel_admin.php';
    }

    public function procesarAsignacion() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin' || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?ruta=inicio");
            exit;
        }

        require_once '../app/models/Incidencia.php';
        require_once '../app/models/Historial.php';

        $modeloIncidencia = new Incidencia($this->db);
        $modeloHistorial = new Historial($this->db);

        $incidencia_id = $_POST['incidencia_id'];
        $tecnico_id = $_POST['tecnico_id'];

        $modeloIncidencia->asignarTecnico($incidencia_id, $tecnico_id);

        $descripcion = "La avería ha sido asignada a un técnico y está a la espera de intervención.";
        $modeloHistorial->registrar($incidencia_id, 'Asignada', $descripcion);

        header("Location: index.php?ruta=panel_admin&exito=asignada");
        exit;
    }

    public function mostrarFormularioIncidencia() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
            header("Location: index.php?ruta=inicio");
            exit;
        }

        require_once '../app/models/Especialidad.php';
        $modeloEspecialidad = new Especialidad($this->db);
        $especialidades = $modeloEspecialidad->obtenerTodas();

        $consulta = $this->db->prepare("SELECT id, nombre, email FROM usuarios WHERE rol = 'particular'");
        $consulta->execute();
        $clientes = $consulta->fetchAll(PDO::FETCH_ASSOC);

        require_once '../views/admin/crear_incidencia_admin.php';
    }

    public function procesarIncidenciaAdmin() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin' || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?ruta=inicio");
            exit;
        }

        require_once '../app/models/Incidencia.php';
        require_once '../app/models/Historial.php';
        $modeloIncidencia = new Incidencia($this->db);
        $modeloHistorial = new Historial($this->db);

        $localizador = 'REP-' . strtoupper(substr(uniqid(), -8));
        
        $datos = [
            'localizador' => $localizador,
            'cliente_id' => $_POST['cliente_id'],
            'especialidad_id' => $_POST['especialidad_id'],
            'descripcion' => $_POST['descripcion'],
            'direccion' => $_POST['direccion'],
            'fecha_servicio' => $_POST['fecha_servicio'],
            'tipo_urgencia' => $_POST['tipo_urgencia']
        ];

        try {
            $this->db->beginTransaction();
            $incidencia_id = $modeloIncidencia->crear($datos);
            $modeloHistorial->registrar($incidencia_id, NULL, 'Pendiente', $_SESSION['usuario_id']);
            $this->db->commit();
            
            header("Location: index.php?ruta=panel_admin&exito=creada");
            exit;
        } catch (PDOException $e) {
            $this->db->rollBack();
            die("Error crítico al crear la incidencia manual.");
        }
    }

    public function cancelarIncidenciaAdmin() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin' || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?ruta=inicio");
            exit;
        }

        $incidencia_id = $_POST['incidencia_id'];

        require_once '../app/models/Incidencia.php';
        require_once '../app/models/Historial.php';
        $modeloIncidencia = new Incidencia($this->db);
        $modeloHistorial = new Historial($this->db);

        $incidencia = $modeloIncidencia->obtenerPorIdGlobal($incidencia_id);

        if (!$incidencia || ($incidencia['estado'] !== 'Pendiente' && $incidencia['estado'] !== 'Asignada')) {
            die("Bloqueo de Seguridad: Solo se pueden cancelar incidencias Pendientes o Asignadas.");
        }

        try {
            $this->db->beginTransaction();
            $modeloIncidencia->actualizarEstado($incidencia_id, 'Cancelada');
            $modeloHistorial->registrar($incidencia_id, $incidencia['estado'], 'Cancelada', $_SESSION['usuario_id']);
            $this->db->commit();
            
            header("Location: index.php?ruta=panel_admin&exito=cancelada");
            exit;
        } catch (PDOException $e) {
            $this->db->rollBack();
            die("Error en transacción al cancelar (Admin).");
        }
    }
}
?>