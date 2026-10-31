<?php

require_once '../app/models/Usuario.php';

class HomeController {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    public function inicio() {
        $modeloUsuario = new Usuario($this->db);
        $usuarios = $modeloUsuario->obtenerTodosLosUsuarios();

        echo "<h3>Datos extraídos de la base de datos:</h3>";
        echo "<pre>";
        print_r($usuarios);
        echo "</pre>";
    }
}
?>