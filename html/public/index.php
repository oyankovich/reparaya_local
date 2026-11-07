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

    case 'crear_incidencia':
        require_once '../app/controllers/IncidenciaController.php';
        $controlador = new IncidenciaController($conexion);
        $controlador->mostrarFormularioCrear();
        break;

    case 'mis_incidencias':
        require_once '../app/controllers/IncidenciaController.php';
        $controlador = new IncidenciaController($conexion);
        $controlador->listarMisIncidencias();
        break;

    case 'procesar_incidencia':
        require_once '../app/controllers/IncidenciaController.php';
        $controlador = new IncidenciaController($conexion);
        $controlador->procesarIncidencia();
        break;

    case 'detalle_incidencia':
        require_once '../app/controllers/IncidenciaController.php';
        $controlador = new IncidenciaController($conexion);
        $controlador->verDetalle();
        break;

    case 'cancelar_incidencia':
        require_once '../app/controllers/IncidenciaController.php';
        $controlador = new IncidenciaController($conexion);
        $controlador->cancelarIncidencia();
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

    case 'mi_perfil':
        require_once '../app/controllers/ClienteController.php';
        $controlador = new ClienteController($conexion);
        $controlador->verPerfil();
        break;

    case 'actualizar_perfil':
        require_once '../app/controllers/ClienteController.php';
        $controlador = new ClienteController($conexion);
        $controlador->actualizarPerfil();
        break;

    case 'gestion_tecnicos':
        require_once '../app/controllers/AdminController.php';
        $controlador = new AdminController($conexion);
        $controlador->gestionarTecnicos();
        break;

    case 'panel_admin':
        require_once '../app/controllers/AdminController.php';
        $controlador = new AdminController($conexion);
        $controlador->verPanelGlobal();
        break;

    case 'crear_tecnico':
        require_once '../app/controllers/AdminController.php';
        $controlador = new AdminController($conexion);
        $controlador->crearTecnico();
        break;

    case 'asignar_tecnico':
        require_once '../app/controllers/AdminController.php';
        $controlador = new AdminController($conexion);
        $controlador->procesarAsignacion();
        break;

    case 'admin_crear_incidencia':
        require_once '../app/controllers/AdminController.php';
        $controlador = new AdminController($conexion);
        $controlador->mostrarFormularioIncidencia();
        break;

    case 'admin_procesar_incidencia':
        require_once '../app/controllers/AdminController.php';
        $controlador = new AdminController($conexion);
        $controlador->procesarIncidenciaAdmin();
        break;

    case 'admin_cancelar_incidencia':
        require_once '../app/controllers/AdminController.php';
        $controlador = new AdminController($conexion);
        $controlador->cancelarIncidenciaAdmin();
        break;

    default:
        echo "<h1>Error 404</h1>";
        echo "<p>El módulo solicitado no existe.</p>";
        break;
}
?>