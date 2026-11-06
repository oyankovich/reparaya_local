<?php
class ClienteController {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    public function verPerfil() {
        if (!isset($_SESSION['usuario_id'])) { header("Location: index.php?ruta=inicio"); exit; }
        require_once '../app/models/Usuario.php';
        $usuario = (new Usuario($this->db))->obtenerPorId($_SESSION['usuario_id']);
        require_once '../views/cliente/perfil.php';
    }

    public function actualizarPerfil() {
        if (!isset($_SESSION['usuario_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') { exit; }
        require_once '../app/models/Usuario.php';
        $modelo = new Usuario($this->db);
        $id = $_SESSION['usuario_id'];
        
        // Actualizar datos en disco duro y en memoria RAM (sesión)
        $modelo->actualizarDatos($id, trim($_POST['nombre']), trim($_POST['email']));
        $_SESSION['nombre'] = trim($_POST['nombre']);

        // Actualizar contraseña solo si el cliente escribió algo
        if (!empty($_POST['password'])) {
            $modelo->actualizarPassword($id, password_hash($_POST['password'], PASSWORD_BCRYPT));
        }
        
        header("Location: index.php?ruta=mi_perfil&exito=1");
        exit;
    }
}
?>