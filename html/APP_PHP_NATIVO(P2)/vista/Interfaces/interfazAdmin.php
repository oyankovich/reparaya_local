<?php
session_start();

if(!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: interfazUsuario.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
</head>
<body>
    <?php require_once '../menu.php'; ?>

    <h1>Panel de Administración - ReparaYa</h1>
    <p>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?>! Desde aquí puedes gestionar toda la plataforma ReparaYa.</p>

    <hr>

    <h2>Accesos Rápidos</h2>
    <ul>
        <li><a href="panelAdmin.php">Ver todas las Incidencias</a> (Asignar técnicos, cambiar estado)</li>
        <li><a href="gestionTecnicos.php">Gestionar Técnicos</a> (Alta de nuevos técnicos)</li>
        <li><a href="gestionServicios.php">Gestionar Servicios</a></li>
    </ul>
</body>
</html>