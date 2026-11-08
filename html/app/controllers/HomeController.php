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
            header("Location: index.php?ruta=panel_tecnico");
            exit;
            
        } else {
            require_once '../views/cliente/panel_cliente.php';
        }
    }
}
?>