<?php
class AuthController {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    public function mostrarRegistro() {
        // La instrucción require_once inserta el HTML en el flujo de salida hacia el navegador
        require_once '../views/auth/registro.php';
    }
}
?>