<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config/basedatos.php';
require_once __DIR__ . '/../modelo/Tecnico.php';
require_once __DIR__ . '/../modelo/Especialidad.php';

class ControladorMaestro {
    private $db;
    private $tecnico;
    private $especialidad;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConexion();
        $this->tecnico = new Tecnico($this->db);
        $this->especialidad = new Especialidad($this->db);
    }

    //Listar técnicos para la vista
    public function listarTecnicos() {
        return $this->tecnico->obtenerTodos();
    }

    public function crearTecnico() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->tecnico->nombre_completo = $_POST['nombre_completo'];
            $this->tecnico->especialidad_id = $_POST['especialidad_id'];

            if($this->tecnico->crear()) {
                //Redirigimos para crecargar la página y ver el técnico en la tabla
                header("Location: /APP_PHP_NATIVO(P2)/vista/Interfaces/gestionTecnicos.php");
                exit();
            } else {
                echo "Error al dar de alta al técnico";
            }

        }
    }

    public function listarEspecialidades() {
        return $this->especialidad->obtenerTodas();
    }

    public function crearEspecialidad() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->especialidad->nombre_especialidad = $_POST['nombre_especialidad'];
            $this->especialidad->precio_base = $_POST['precio_base'];

            if($this->especialidad->crear()) {
                header("Location: /APP_PHP_NATIVO(P2)/vista/Interfaces/gestionServicios.php");
                exit();
            } else {
                echo "Error al crear el servicio";
            }
        }
    }
}

if (isset($_POST['accion']) && $_POST['accion'] === 'crearTecnico') {
    $controlador = new ControladorMaestro();
    $controlador->crearTecnico();
}

if (isset($_POST['accion']) && $_POST['accion'] === 'crearEspecialidad') {
    $controlador = new ControladorMaestro;
    $controlador->crearEspecialidad();
}


?>