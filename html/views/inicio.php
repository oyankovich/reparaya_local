<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Inicio - ReparaYa</title>
</head>
<body>
    <h2>Bienvenido al sistema</h2>
    

    <p>Hola, <strong><?php echo $_SESSION['nombre']; ?></strong>.</p>
    <p>Tu nivel de acceso en la base de datos es: <strong><?php echo $_SESSION['rol']; ?></strong>.</p>

    <a href="../public/index.php?ruta=logout">Cerrar Sesión</a>
</body>
</html>