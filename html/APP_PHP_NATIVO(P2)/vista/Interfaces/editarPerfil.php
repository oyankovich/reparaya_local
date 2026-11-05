<?php
session_start();
//Cargamos el menú
require_once '../menu.php';

//cargamos el controlador de usuario
require_once '../../controlador/controladorUsuario.php';

//Aseguramos que es usuario está logeado antes de permitirle acceder a la página de edición de perfil
if (!isset($_SESSION['usuario_id'])) {
    header("Location: interfazUsuario.php");
    exit();
}

$controlador = new ControladorUsuario();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
</head>
<body>
    
    <h1>Editar Perfil</h1>
    <form method="POST" action="../../controlador/controladorUsuario.php">
        <input type="hidden" name="accion" value="editarPerfil">
        <input type="hidden" name="usuario_id" value="<?php echo htmlspecialchars($_SESSION['usuario_id']); ?>">

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($_SESSION['nombre']); ?>" required><br><br>

        <label for="email">Correo electrónico:</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($_SESSION['email'] ?? ''); ?>" required><br><br>

        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" id="telefono" value="<?php echo htmlspecialchars($_SESSION['telefono'] ?? ''); ?>" required><br><br>

        <input type="submit" value="Actualizar Perfil">
    </form>
</body>
</html>