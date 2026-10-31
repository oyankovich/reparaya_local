<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Diagnóstico: ReparaYa</title>
</head>
<body>
    <h2>Proyecto: ReparaYa</h2>
    <p>Grupo 4: <?php echo getenv('STUDENT_NAME') ?: 'Nombre no configurado en el .env'; ?></p>
    <p>Entorno: Local</p>
    
    <p>Versión de PHP: <?php echo phpversion(); ?></p>
    <p>Fecha y hora: <?php echo date('Y-m-d H:i:s'); ?></p>

    <hr>
    <h3>Estado de la Base de Datos</h3>
    <?php
    $servername = "db";
    $username = "reparaya_user";
    $password = "1234jaumeuoc";
    $dbname = "reparaya_db";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("<p style='color: red;'>Conexión fallida: " . mysqli_connect_error() . "</p>");
    }
    echo "<p style='color: green;'>Conectado con éxito a la base de datos.</p>";
    ?>
</body>
</html>