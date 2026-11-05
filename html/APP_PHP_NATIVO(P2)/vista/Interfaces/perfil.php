<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    echo "<h2>No has iniciado sesión</h2>";
    echo "<p>Por favor, <a href='interfazUsuario.php'>inicia sesión</a> para acceder a tu perfil.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi perfil</title>
</head>
<body>
    <?php require_once '../menu.php'; ?>
    <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?>!</h1>
    <p>Tu rol es: <?php echo htmlspecialchars($_SESSION['rol']); ?></p>
    <p><a href="interfazUsuario.php">Volver a la interfaz de usuario</a></p>

    <a href="editarPerfil.php">Editar Perfil</a>
    
</body>
</html>