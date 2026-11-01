<?php
class AuthController {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    public function mostrarRegistro() {
       
        require_once '../views/auth/registro.php';
    }

    public function mostrarLogin() {
        
        require_once '../views/auth/login.php';
    }

    public function procesarRegistro() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $nombre = $_POST['nombre'];
            $email = $_POST['email'];
            $telefono = $_POST['telefono'];
            $password = $_POST['password'];

            $passwordHash = password_hash($password, PASSWORD_BCRYPT);

           require_once '../app/models/Usuario.php';
            $modeloUsuario = new Usuario($this->db);
            $registroExitoso = $modeloUsuario->registrarUsuario($nombre, $email, $passwordHash, $telefono);

            if ($registroExitoso) {
                header("Location: ../public/index.php?ruta=login");
                exit;
            } else {
                echo "<h3>Error: El correo electrónico ya está registrado.</h3>";
                echo "<a href='../public/index.php?ruta=registro'>Volver al registro</a>";
            }
        }
    }

    public function procesarLogin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $email = $_POST['email'];
            $password = $_POST['password'];

            require_once '../app/models/Usuario.php';
            $modeloUsuario = new Usuario($this->db);
            $usuarioEncontrado = $modeloUsuario->buscarPorEmail($email);

            if ($usuarioEncontrado && password_verify($password, $usuarioEncontrado['password'])) {
                
                $_SESSION['usuario_id'] = $usuarioEncontrado['id'];
                $_SESSION['rol'] = $usuarioEncontrado['rol'];
                $_SESSION['nombre'] = $usuarioEncontrado['nombre'];

                header("Location: ../public/index.php?ruta=inicio");
                exit;
                
            } else {
                echo "<h3>Error: Credenciales incorrectas.</h3>";
                echo "<a href='../public/index.php?ruta=login'>Volver al Login</a>";
            }
        }
    }
}
?>