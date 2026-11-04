<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Registrar usuario</h2>
    <form method="POST" action="../../controlador/controladorUsuario.php">
        <input type="hidden" name="accion" value="registro">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required><br><br>

        <label for="email">Correo electrónico:</label>
        <input type="email" name="email" id="email" required><br><br>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required><br><br>

        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" id="telefono" required><br><br>

        <input type="submit" value="Registrar">
    </form> 

    <h2>Inicio de sesión</h2>
    <form method="POST" action="../../controlador/controladorUsuario.php">
        <input type="hidden" name="accion" value="login">
        <label for="email">Correo electrónico:</label>
        <input type="email" name="email" id="email" required><br><br>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required><br><br>

        <input type="submit" value="Iniciar sesión">
    </form>
</body>
</html>