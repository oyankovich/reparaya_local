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
}
?>