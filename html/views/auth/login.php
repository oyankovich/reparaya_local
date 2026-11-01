<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso - ReparaYa</title>
</head>
<body>
    <h2>Iniciar Sesión</h2>
    
    <form action="../public/index.php?ruta=procesar_login" method="POST">
        <label for="email">Correo electrónico:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Contraseña:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Entrar</button>
    </form>

    <p>¿No tienes cuenta? <a href="../public/index.php?ruta=registro">Regístrate aquí</a></p>
</body>
</html>