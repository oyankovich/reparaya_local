<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - ReparaYa</title>
</head>
<body>
    <h2>Registro de Nuevo Cliente</h2>
    
    <form action="../public/index.php?ruta=procesar_registro" method="POST">
        <label for="nombre">Nombre completo:</label><br>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="email">Correo electrónico:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="telefono">Teléfono:</label><br>
        <input type="text" id="telefono" name="telefono"><br><br>

        <label for="password">Contraseña:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Registrarse</button>
    </form>
</body>
</html>