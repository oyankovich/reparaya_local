<?php
require_once '../app/models/GestionIncidencia.php';

class TecnicoController {
    private $modelo;

    public function __construct($conexion) {
        $this->modelo = new GestionIncidencia($conexion);
    }

    // Solo puede entrar un técnico
    private function comprobarTecnico() {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'tecnico') {
            header("Location: ../public/index.php?ruta=login");
            exit;
        }
    }

    // Agenda con las incidencias asignadas al técnico
    public function verAgenda() {
        $this->comprobarTecnico();

        $incidencias = $this->modelo->obtenerPorTecnico($_SESSION['usuario_id']);
        require_once '../views/tecnico/agenda.php';
    }

    // El técnico pasa la incidencia a En curso o a Finalizada
    public function cambiarEstado() {
        $this->comprobarTecnico();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: ../public/index.php?ruta=incidencias_asignadas");
            exit;
        }

        $id = (int)$_POST['id'];
        $estado = $_POST['estado'];

        // Desde aquí el técnico solo puede pedir estos dos estados
        if ($estado !== 'En curso' && $estado !== 'Finalizada') {
            $_SESSION['mensaje'] = "Estado no válido.";
        } else {
            $resultado = $this->modelo->cambiarEstado($id, $estado, $_SESSION['usuario_id'], 'tecnico');
            $_SESSION['mensaje'] = ($resultado === true) ? "Estado actualizado a " . $estado . "." : $resultado;
        }

        header("Location: ../public/index.php?ruta=incidencias_asignadas");
        exit;
    }
}