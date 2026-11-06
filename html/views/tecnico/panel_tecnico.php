<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Técnico</title>
</head>
<body>
    <h1>Bienvenido, <?php echo $_SESSION['nombre']; ?></h1>
    <h3>Panel de Control: TÉCNICO</h3>
    <ul>
        <li><a href="../public/index.php?ruta=incidencias_asignadas">Ver incidencias asignadas</a></li>
    </ul>
    <br>
    <a href="../public/index.php?ruta=logout">Cerrar Sesión</a>
</body>
</html>