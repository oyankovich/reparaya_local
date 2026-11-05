<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once $_SERVER['DOCUMENT_ROOT'] . '/APP_PHP_NATIVO(P2)/config/basedatos.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/APP_PHP_NATIVO(P2)/modelo/usuario.php';

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

            //Guardamos los datos del usuario en la sesión
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['rol'] = $usuario['rol'];
            $_SESSION['email'] = $usuario['email'];
            $_SESSION['telefono'] = $usuario['telefono'];

            //Reedireccionamos al perfil del usuario

            header("Location: /APP_PHP_NATIVO(P2)/vista/Interfaces/perfil.php");
            exit();

            } else {
                echo "Correo electrónico o contraseña incorrectos.";
            }
        }
    }

    public function editarPerfil() {
        //Verificamos si se ha enviado el formulario de edición de perfil
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            if(empty($_POST['nombre']) || empty($_POST['email'])) {
                echo "EL nombre y el correo electrónico son obligatorios.";
                return;
            }

            //Asignamos los datos al objeto Usuario
            $this->usuario->id = $_POST['usuario_id'];
            $this->usuario->nombre = $_POST['nombre'];
            $this->usuario->email = $_POST['email'];
            $this->usuario->telefono = $_POST['telefono'] ?? '';

            //Llamamos al método actualizarPerfil para actualizar los datos del usuario
            if ($this->usuario->actualizarPerfil()) {
                //Actualizamos la sesión con los nuevos datos
                $_SESSION['nombre'] = $this->usuario->nombre;
                $_SESSION['email'] = $this->usuario->email;
                $_SESSION['telefono'] = $this->usuario->telefono;

                header("Location: /APP_PHP_NATIVO(P2)/vista/Interfaces/perfil.php");
                exit();
                
                } else {
                echo "Error al actualizar el perfil.";
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
} elseif (isset($_POST['accion']) && $_POST['accion'] === 'editarPerfil') {
    $controlador = new ControladorUsuario();
    $controlador->editarPerfil();
}
?>