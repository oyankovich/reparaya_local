<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Cliente</title>
</head>
<body>
    <h1>Bienvenido, <?php echo $_SESSION['nombre']; ?></h1>
    <h3>Panel de Control: CLIENTE</h3>
    <ul>
        <li><a href="../public/index.php?ruta=crear_incidencia">Crear nueva incidencia</a></li>
        <li><a href="../public/index.php?ruta=mis_incidencias">Ver mis incidencias</a></li>
    </ul>
    <br>
    <a href="../public/index.php?ruta=logout">Cerrar Sesión</a><br><br>
    <a href="../public/index.php?ruta=mi_perfil">Modificar Datos Usuario</a>
</body>
</html>