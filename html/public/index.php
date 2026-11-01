<?php

session_start();

require_once '../config/database.php';

$db = new Database();
$conexion = $db->getConnection();

$ruta = isset($_GET['ruta']) ? $_GET['ruta'] : 'inicio';

switch ($ruta) {
    case 'inicio':
        require_once '../app/controllers/HomeController.php';
        $controlador = new HomeController($conexion);
        $controlador->inicio();
        break;
        
    case 'registro':
        require_once '../app/controllers/AuthController.php';
        $controlador = new AuthController($conexion);
        $controlador->mostrarRegistro();
        break;
    
    case 'procesar_registro':
        require_once '../app/controllers/AuthController.php';
        $controlador = new AuthController($conexion);
        $controlador->procesarRegistro();
        break;

    case 'login':
        require_once '../app/controllers/AuthController.php';
        $controlador = new AuthController($conexion);
        $controlador->mostrarLogin();
        break;

    case 'procesar_login':
        require_once '../app/controllers/AuthController.php';
        $controlador = new AuthController($conexion);
        $controlador->procesarLogin();
        break;
    
    case 'logout':
        require_once '../app/controllers/AuthController.php';
        $controlador = new AuthController($conexion);
        $controlador->logout();
        break;

    default:
        echo "<h1>Error 404</h1>";
        echo "<p>El módulo solicitado no existe.</p>";
        break;
}
?>