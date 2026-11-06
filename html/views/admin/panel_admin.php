<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Administrador</title>
</head>
<body>
    <h1>Bienvenido, <?php echo $_SESSION['nombre']; ?></h1>
    <h3>Panel de Control: ADMINISTRADOR</h3>
    <ul>
        <li><a href="../public/index.php?ruta=gestionar_usuarios">Gestionar Usuarios</a></li>
        <li><a href="../public/index.php?ruta=gestionar_incidencias">Gestionar todas las incidencias</a></li>
    </ul>
    <br>
    <a href="../public/index.php?ruta=logout">Cerrar Sesión</a>
</body>
</html>