<?php
class HomeController {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    public function inicio() {

        if (!isset($_SESSION['usuario_id'])) {
            header("Location: ../public/index.php?ruta=login");
            exit;
        }

        $rolUsuario = $_SESSION['rol'];

        if ($rolUsuario === 'admin') {
            header("Location: ../public/index.php?ruta=panel_admin");
            exit;
            
        } elseif ($rolUsuario === 'tecnico') {
            require_once '../views/tecnico/panel_tecnico.php';
            
        } else {
            require_once '../views/cliente/panel_cliente.php';
        }
    }
}
?>