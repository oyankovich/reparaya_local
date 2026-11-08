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

    // CRUD 3 - Gestión Admin
    case 'gestionar_incidencias':
        require_once '../app/controllers/AdminController.php';
        $controlador = new AdminController($conexion);
        $controlador->listarIncidencias();
        break;

    case 'admin_detalle':
        require_once '../app/controllers/AdminController.php';
        $controlador = new AdminController($conexion);
        $controlador->verDetalle();
        break;

    case 'admin_asignar':
        require_once '../app/controllers/AdminController.php';
        $controlador = new AdminController($conexion);
        $controlador->asignarTecnico();
        break;

    case 'admin_cancelar':
        require_once '../app/controllers/AdminController.php';
        $controlador = new AdminController($conexion);
        $controlador->cancelarIncidencia();
        break;

    // CRUD 3 - Panel técnico
    case 'incidencias_asignadas':
        require_once '../app/controllers/TecnicoController.php';
        $controlador = new TecnicoController($conexion);
        $controlador->verAgenda();
        break;

    case 'tecnico_cambiar_estado':
        require_once '../app/controllers/TecnicoController.php';
        $controlador = new TecnicoController($conexion);
        $controlador->cambiarEstado();
        break;

    case 'admin_calendario':
        require_once '../app/controllers/AdminController.php';
        $controlador = new AdminController($conexion);
        $controlador->verCalendario();
        break;

    case 'admin_alta':
        require_once '../app/controllers/AdminController.php';
        $controlador = new AdminController($conexion);
        $controlador->mostrarAlta();
        break;

    case 'admin_guardar_alta':
        require_once '../app/controllers/AdminController.php';
        $controlador = new AdminController($conexion);
        $controlador->guardarAlta();
        break;

    default:
        echo "<h1>Error 404</h1>";
        echo "<p>El módulo solicitado no existe.</p>";
        break;
}
?>