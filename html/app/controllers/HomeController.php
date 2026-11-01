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

        require_once '../views/inicio.php';
    }
}
?>