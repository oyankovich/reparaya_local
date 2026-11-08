<?php
require_once '../app/models/GestionIncidencia.php';

class AdminController {
    private $modelo;

    public function __construct($conexion) {
        $this->modelo = new GestionIncidencia($conexion);
    }

    // Solo puede entrar el admin
    private function comprobarAdmin() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
            header("Location: ../public/index.php?ruta=login");
            exit;
        }
    }

    // Listado de todas las incidencias con filtro por estado
    public function listarIncidencias() {
        $this->comprobarAdmin();

        $estados = ['Pendiente', 'Asignada', 'En curso', 'Finalizada', 'Cancelada'];
        $estado = isset($_GET['estado']) ? $_GET['estado'] : '';

        // Si llega un estado que no existe, se muestran todas
        if (!in_array($estado, $estados)) {
            $estado = '';
        }

        $incidencias = $this->modelo->obtenerTodas($estado);
        require_once '../views/admin/incidencias.php';
    }

    // Detalle de una incidencia con su historial
    public function verDetalle() {
        $this->comprobarAdmin();

        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $incidencia = $this->modelo->obtenerPorId($id);

        if (!$incidencia) {
            $_SESSION['mensaje'] = "La incidencia no existe.";
            header("Location: ../public/index.php?ruta=gestionar_incidencias");
            exit;
        }

        $tecnicos = $this->modelo->obtenerTecnicosDisponibles();
        $historial = $this->modelo->obtenerHistorial($id);
        require_once '../views/admin/detalle_incidencia.php';
    }

    public function asignarTecnico() {
        $this->comprobarAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: ../public/index.php?ruta=gestionar_incidencias");
            exit;
        }

        $id = (int)$_POST['id'];
        $tecnico_id = (int)$_POST['tecnico_id'];

        // Comprobamos que el técnico elegido existe y está disponible
        $valido = false;
        foreach ($this->modelo->obtenerTecnicosDisponibles() as $tecnico) {
            if ($tecnico['id'] == $tecnico_id) {
                $valido = true;
            }
        }

        if (!$valido) {
            $_SESSION['mensaje'] = "Tienes que elegir un técnico disponible.";
        } else {
            $resultado = $this->modelo->asignarTecnico($id, $tecnico_id, $_SESSION['usuario_id']);
            $_SESSION['mensaje'] = ($resultado === true) ? "Técnico asignado correctamente." : $resultado;
        }

        header("Location: ../public/index.php?ruta=admin_detalle&id=" . $id);
        exit;
    }

    public function cancelarIncidencia() {
        $this->comprobarAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: ../public/index.php?ruta=gestionar_incidencias");
            exit;
        }

        $id = (int)$_POST['id'];
        $resultado = $this->modelo->cambiarEstado($id, 'Cancelada', $_SESSION['usuario_id'], 'admin');
        $_SESSION['mensaje'] = ($resultado === true) ? "Incidencia cancelada." : $resultado;

        header("Location: ../public/index.php?ruta=admin_detalle&id=" . $id);
        exit;
    }

    // Calendario con todas las incidencias
    public function verCalendario() {
        $this->comprobarAdmin();

        $incidencias = $this->modelo->obtenerTodas();
        $eventos = [];

        foreach ($incidencias as $inc) {
            $eventos[] = [
                // El estado va en el título para que no dependa solo del color
                'title' => $inc['localizador'] . ' - ' . $inc['estado'],
                'start' => date('Y-m-d\TH:i:s', strtotime($inc['fecha_servicio'])),
                // Rojo para urgentes, azul para estándar
                'color' => ($inc['tipo_urgencia'] === 'Urgente') ? '#d9534f' : '#337ab7',
                // Al hacer clic se abre el detalle
                'url' => '../public/index.php?ruta=admin_detalle&id=' . $inc['id']
            ];
        }

        require_once '../views/admin/calendario.php';
    }

        // Formulario de alta manual de avisos
    public function mostrarAlta() {
        $this->comprobarAdmin();

        $clientes = $this->modelo->obtenerClientes();
        $especialidades = $this->modelo->obtenerEspecialidades();
        require_once '../views/admin/alta_incidencia.php';
    }

    // Guarda el aviso que crea el admin
    public function guardarAlta() {
        $this->comprobarAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: ../public/index.php?ruta=admin_alta");
            exit;
        }

        $datos = [
            'cliente_id' => (int)($_POST['cliente_id'] ?? 0),
            'especialidad_id' => (int)($_POST['especialidad_id'] ?? 0),
            'tipo_urgencia' => $_POST['tipo_urgencia'] ?? '',
            'fecha_servicio' => $_POST['fecha_servicio'] ?? '',
            'direccion' => trim($_POST['direccion'] ?? ''),
            'descripcion' => trim($_POST['descripcion'] ?? '')
        ];

        // Comprobamos que el cliente y el servicio existen
        $clienteValido = false;
        foreach ($this->modelo->obtenerClientes() as $cliente) {
            if ($cliente['id'] == $datos['cliente_id']) {
                $clienteValido = true;
            }
        }

        $servicioValido = false;
        foreach ($this->modelo->obtenerEspecialidades() as $especialidad) {
            if ($especialidad['id'] == $datos['especialidad_id']) {
                $servicioValido = true;
            }
        }

        $fecha = strtotime($datos['fecha_servicio']);
        $horasQueFaltan = ($fecha - time()) / 3600;
        $error = '';

        if (!$clienteValido) {
            $error = "Elige un cliente válido.";
        } elseif (!$servicioValido) {
            $error = "Elige un tipo de servicio válido.";
        } elseif ($datos['tipo_urgencia'] !== 'Estándar' && $datos['tipo_urgencia'] !== 'Urgente') {
            $error = "El nivel de urgencia no es válido.";
        } elseif ($datos['direccion'] === '' || $datos['descripcion'] === '') {
            $error = "Rellena la dirección y la descripción.";
        } elseif ($fecha === false || $horasQueFaltan <= 0) {
            $error = "La fecha tiene que ser posterior a ahora.";
        } elseif ($datos['tipo_urgencia'] === 'Estándar' && $horasQueFaltan < 48) {
            // Regla del enunciado: las estándar con 48 horas de antelación como mínimo
            $error = "Las incidencias estándar necesitan al menos 48 horas de antelación.";
        }

        if ($error !== '') {
            $_SESSION['mensaje'] = $error;
            header("Location: ../public/index.php?ruta=admin_alta");
            exit;
        }

        $datos['fecha_servicio'] = date('Y-m-d H:i:s', $fecha);
        $id = $this->modelo->crearIncidencia($datos, $_SESSION['usuario_id']);

        $_SESSION['mensaje'] = "Aviso creado correctamente.";
        header("Location: ../public/index.php?ruta=admin_detalle&id=" . $id);
        exit;
    }

        // Formulario para modificar una incidencia
    public function mostrarEditar() {
        $this->comprobarAdmin();

        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $incidencia = $this->modelo->obtenerPorId($id);

        if (!$incidencia) {
            $_SESSION['mensaje'] = "La incidencia no existe.";
            header("Location: ../public/index.php?ruta=gestionar_incidencias");
            exit;
        }

        if ($incidencia['estado'] !== 'Pendiente' && $incidencia['estado'] !== 'Asignada') {
            $_SESSION['mensaje'] = "Solo se puede modificar una incidencia Pendiente o Asignada.";
            header("Location: ../public/index.php?ruta=admin_detalle&id=" . $id);
            exit;
        }

        $especialidades = $this->modelo->obtenerEspecialidades();
        require_once '../views/admin/editar_incidencia.php';
    }

    // Guarda los cambios de la incidencia
    public function guardarEdicion() {
        $this->comprobarAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: ../public/index.php?ruta=gestionar_incidencias");
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);
        $datos = [
            'especialidad_id' => (int)($_POST['especialidad_id'] ?? 0),
            'tipo_urgencia' => $_POST['tipo_urgencia'] ?? '',
            'fecha_servicio' => $_POST['fecha_servicio'] ?? '',
            'direccion' => trim($_POST['direccion'] ?? ''),
            'descripcion' => trim($_POST['descripcion'] ?? '')
        ];

        $servicioValido = false;
        foreach ($this->modelo->obtenerEspecialidades() as $especialidad) {
            if ($especialidad['id'] == $datos['especialidad_id']) {
                $servicioValido = true;
            }
        }

        $fecha = strtotime($datos['fecha_servicio']);
        $horasQueFaltan = ($fecha - time()) / 3600;
        $error = '';

        if (!$servicioValido) {
            $error = "Elige un tipo de servicio válido.";
        } elseif ($datos['tipo_urgencia'] !== 'Estándar' && $datos['tipo_urgencia'] !== 'Urgente') {
            $error = "El nivel de urgencia no es válido.";
        } elseif ($datos['direccion'] === '' || $datos['descripcion'] === '') {
            $error = "Rellena la dirección y la descripción.";
        } elseif ($fecha === false || $horasQueFaltan <= 0) {
            $error = "La fecha tiene que ser posterior a ahora.";
        } elseif ($datos['tipo_urgencia'] === 'Estándar' && $horasQueFaltan < 48) {
            $error = "Las incidencias estándar necesitan al menos 48 horas de antelación.";
        }

        if ($error !== '') {
            $_SESSION['mensaje'] = $error;
            header("Location: ../public/index.php?ruta=admin_editar&id=" . $id);
            exit;
        }

        $datos['fecha_servicio'] = date('Y-m-d H:i:s', $fecha);
        $resultado = $this->modelo->actualizarIncidencia($id, $datos);
        $_SESSION['mensaje'] = ($resultado === true) ? "Incidencia modificada correctamente." : $resultado;

        header("Location: ../public/index.php?ruta=admin_detalle&id=" . $id);
        exit;
    }
}