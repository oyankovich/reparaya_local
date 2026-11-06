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
            require_once '../views/admin/panel_admin.php';
            
        } elseif ($rolUsuario === 'tecnico') {
            require_once '../views/tecnico/panel_tecnico.php';
            
        } else {
            
            require_once '../views/cliente/panel_cliente.php';
        }
    }
}
?>