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
}