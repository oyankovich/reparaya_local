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
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        $password_hashed = password_hash($password, PASSWORD_BCRYPT);

        try {
            $this->db->beginTransaction();

            $sqlUsuario = "INSERT INTO usuarios (nombre, email, password, rol) VALUES (:nombre, :email, :password, 'tecnico')";
            $stmtUsuario = $this->db->prepare($sqlUsuario);
            $stmtUsuario->execute([
                ':nombre' => $nombre_completo,
                ':email' => $email,
                ':password' => $password_hashed
            ]);

            $nuevo_usuario_id = $this->db->lastInsertId();

            $modeloTecnico->crear($nuevo_usuario_id, $nombre_completo, $especialidad_id);

            $this->db->commit();

            header("Location: index.php?ruta=gestion_tecnicos&exito=1");
            exit;

        } catch (PDOException $e) {
            $this->db->rollBack();
            die("Error crítico: Es posible que el email ya esté en uso o haya un problema en la base de datos.");
        }
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

        $estado_filtro = '';
        if (isset($_GET['estado']) && $_GET['estado'] !== 'Todos') {
            $estado_filtro = $_GET['estado'];
        }

        $incidencias = $modeloIncidencia->obtenerTodasGlobal($estado_filtro);
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

        $modeloHistorial->registrar($incidencia_id, 'Pendiente', 'Asignada', $_SESSION['usuario_id']);

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

        $tipo_urgencia = $_POST['tipo_urgencia'];
        $fecha_cita_segundos = strtotime($_POST['fecha_servicio']);
        $tiempo_actual_segundos = time();
        
        $diferencia_horas = ($fecha_cita_segundos - $tiempo_actual_segundos) / 3600;

        if ($tipo_urgencia === 'Estandar' && $diferencia_horas < 48) {
            header("Location: index.php?ruta=admin_crear_incidencia&error=48h");
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
            'tipo_urgencia' => $tipo_urgencia
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
            die("Error critico al crear la incidencia manual.");
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

    public function verCalendario() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
            header("Location: index.php?ruta=inicio");
            exit;
        }

        require_once '../app/models/Incidencia.php';
        $modeloIncidencia = new Incidencia($this->db);
        
        $incidencias = $modeloIncidencia->obtenerTodasGlobal();

        $eventos = [];
        foreach ($incidencias as $incidencia) {
            
            $color = ($incidencia['tipo_urgencia'] === 'Urgente') ? '#dc3545' : '#0d6efd';

            $titulo_evento = $incidencia['estado'] . ' | ' . $incidencia['tipo_urgencia'];

            $eventos[] = [
                'id' => $incidencia['id'],
                'title' => $titulo_evento,
                'start' => $incidencia['fecha_servicio'],
                'color' => $color,
                'extendedProps' => [
                    'cliente' => $incidencia['cliente_nombre'],
                    'direccion' => $incidencia['direccion'],
                    'especialidad' => $incidencia['nombre_especialidad'],
                    'descripcion' => $incidencia['descripcion']
                ]
            ];
        }

        $eventos_json = json_encode($eventos);

        require_once '../views/admin/calendario.php';
    }
}
?>