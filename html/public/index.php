<?php
// html/public/index.php

session_start();

require_once '../config/database.php';

$db = new Database();
$conexion = $db->getConnection();

$ruta = isset($_GET['ruta']) ? $_GET['ruta'] : 'inicio';

if ($ruta === 'inicio') {
    require_once '../app/controllers/HomeController.php';
    $controlador = new HomeController($conexion);
    $controlador->inicio();
} else {
    echo "<h1>Error 404</h1>";
    echo "<p>El módulo solicitado no existe.</p>";
}
?>