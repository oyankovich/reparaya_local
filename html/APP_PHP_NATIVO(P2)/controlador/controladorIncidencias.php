<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once $_SERVER['DOCUMENT_ROOT'] . '/APP_PHP_NATIVO(P2)/config/basedatos.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/APP_PHP_NATIVO(P2)/modelo/incidencias.php';

class controladorIncidencias {
    private $db;
    private $incidencias;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConexion();
        $this->incidencias = new Incidencias($this->db);
    }

    public function crearIncidencias() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            //1. Recogemos los datos del formulario
            $fecha_servicio = $_POST['fecha_servicio'];
            $tipo_urgencia = $_POST['tipo_urgencia'];

            //2. Realizamos la lógica de las 48 horas
            $fecha_actual = new DateTime();
            $fecha_servicio = new DateTime($fecha_servicio);

            //3.1. Calculamos la diferencia en horas entre la fecha actual y la fecha de servicio
            $diferencia = $fecha_actual->diff($fecha_servicio);
            $horas_diferencia = ($diferencia->days * 24) + $diferencia->h + ($diferencia->i / 60);

            //3.2. Si es Estándar y faltan menos de 48 horas mostramos menjaje de error y no se crea la incidencia
            if($tipo_urgencia === 'Estándar' && $horas_diferencia < 48) {
                echo "ERROR: No se puede crear la incidencia. La fecha de servicio debe ser al menos 48 horas después de la fecha actual para urgencia Estándar.";
                return; //Se detiene la ejecución del método para que no se cree la incidencia
            }

            //4. Asignamos los datos al modelo
            $this->incidencias->cliente_id = $_SESSION['usuario_id']; //Se obtiene el ID del cliente desde la sesión
            $this->incidencias->especialidad_id = $_POST['especialidad_id'];
            $this->incidencias->descripcion = $_POST['descripcion'];
            $this->incidencias->direccion = $_POST['direccion'];
            $this->incidencias->fecha_servicio = $fecha_servicio->format('Y-m-d H:i:s');
            $this->incidencias->tipo_urgencia = $tipo_urgencia;

            //5.Llamamos al método para que guarde la incidencia en la base de datos
            if($this->incidencias->crear()) {
                echo "Incidencia creada correctamente con localizador: " . $this->incidencias->localizador;
            } else {
                echo "Error al crear la incidencia.";
            }
        }
    }

    public function listarMisIncidencias() {
        return $this->incidencias->obtenerPorCliente($_SESSION['usuario_id']); //Se obtiene el ID del cliente desde la sesión
    }

    public function cancelarIncidencia() {
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_incidencia'])) {
            $id_incidencia = $_POST['id_incidencia'];
            $fecha_servicio = $_POST['fecha_servicio'];

            //Comprobamos que la fecha de servicio sea al menos 48 horas después de la fecha actual
            $fecha_actual = new DateTime();
            $fecha_cita = new DateTime($fecha_servicio);
            $diferencia = $fecha_actual->diff($fecha_cita);
            $horas_diferencia = ($diferencia->days * 24) + $diferencia->h + ($diferencia->i / 60);

            if($horas_diferencia < 48) {
                echo "ERROR: No se puede cancelar la incidencia. La fecha de servicio debe ser al menos 48 horas después de la fecha actual.";
                return; //Se detiene la ejecución del método para que no se cancele la incidencia
            }

            //Obtener el estado actual de la incidencia antes de cancelarla
            $incidencia_actual = $this->incidencias->obtenerPorId($id_incidencia);
            $estado_anterior = $incidencia_actual['estado'];

            //Cancelar en la base de datos
            if($this->incidencias->cancelar($id_incidencia)) {
                //Registrar la cancelación en la tabla de incidencias_canceladas
                $this->incidencias->registrarHistorial($id_incidencia, $estado_anterior, 'Cancelada', $_SESSION['usuario_id']); //Se obtiene el ID del cliente desde la sesión
                
                //Redirigir al usuario a la página de mis incidencias con un mensaje de éxito
                header("Location: /APP_PHP_NATIVO(P2)/vista/Interfaces/misIncidencias.php?mensaje=cancelada");
                exit();
            } else {
                echo "Error al cancelar la incidencia.";
            }
        }
        
    }

    public function verHistorial($id_incidencia) {
        return $this->incidencias->obtenerHistorial($id_incidencia);
    }
}

//Creamos una instancia del controlador y llamamos al método para crear la incidencia
if (isset($_POST['accion']) && $_POST['accion'] === 'crearIncidencia') {
    $controlador = new controladorIncidencias();
    $controlador->crearIncidencias();
} else if (isset($_POST['accion']) && $_POST['accion'] === 'cancelarIncidencia') {
    $controlador = new controladorIncidencias();
    $controlador->cancelarIncidencia();
}

?>