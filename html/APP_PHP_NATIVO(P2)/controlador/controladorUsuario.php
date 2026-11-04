<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../modelo/usuario.php';
require_once '../config/basedatos.php';

class ControladorUsuario {
    private $usuario;
    private $db;

    public function __construct() {
        //Instanciamos la clase para la base de datos
        $database = new Database();
        $this->db = $database->getConexion();

        //Instanciamos la clase Usuario con la conexión a la base de datos
        $this->usuario = new Usuario($this->db);
    }

    public function registroUsuario() {
        //Verificamos si se ha enviado el formulario de registro
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if(empty($_POST['nombre']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['telefono'])) {
                echo "Todos los campos son obligatorios.";
                return;
            }

            //Asignamos los datos al objeto Usuario
            $this->usuario->nombre = $_POST['nombre'];
            $this->usuario->email = $_POST['email'] ?? '';
            $this->usuario->password = $_POST['password'] ?? '';
            $this->usuario->rol = 'particular'; // Asignamos el rol como 'particular' por defecto
            $this->usuario->telefono = $_POST['telefono'] ?? '';

            //Llamamos al método registrarUsuario para registrar al usuario
            if ($this->usuario->registrar()) {
                echo "Registro exitoso.";
            } else {
                echo "Error al registrar el usuario.";
            }
        }
    }

    public function loginUsuario() {
        //Verificamos si se ha enviado el formulario de login
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if(empty($_POST['email']) || empty($_POST['password'])) {
                echo "Todos los campos son obligatorios.";
                return;
            }

            //Obtenemos el email y la contraseña del formulario
            $email = $_POST['email'];
            $password = $_POST['password'];

            //Llamamos al método login para obtener los datos del usuario
            $usuario = $this->usuario->login($email);

            //Verificamos si el usuario existe y si la contraseña es correcta
            if ($usuario && password_verify($password, $usuario['password'])) {

            //iniciamos la sesión
            if(session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['rol'] = $usuario['rol'];

            echo "Login exitoso. Bienvenido, " . $_SESSION['nombre'] . ". Tu rol es: " . $_SESSION['rol'] . ".";
            } else {
                echo "Correo electrónico o contraseña incorrectos.";
            }
        }
    }
}


if (isset($_POST['accion']) && $_POST['accion'] === 'registro') {
    $controlador = new ControladorUsuario();
    $controlador->registroUsuario();
} elseif (isset($_POST['accion']) && $_POST['accion'] === 'login') {
    $controlador = new ControladorUsuario();
    $controlador->loginUsuario();
}
?>