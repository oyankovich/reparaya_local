<!DOCTYPE html>
<html lang="es">
<head><title>Mi Perfil</title></head>
<body>
    <h2>Mi Perfil</h2>
    
    <?php if (isset($_GET['exito'])): ?> 
        <p style="color: green;"><strong>Datos actualizados.</strong></p> 
    <?php endif; ?>
    
    <form action="../public/index.php?ruta=actualizar_perfil" method="POST">
        <p>
            Nombre: <br>
            <input type="text" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
        </p>
        <p>
            Email: <br>
            <input type="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
        </p>
        <p>
            Nueva Contraseña: <br>
            <input type="password" name="password" placeholder="Dejar en blanco para no cambiar">
        </p>
        <button type="submit">Guardar Cambios</button>
    </form>
    
    <br>
    <a href="../public/index.php?ruta=inicio">Volver al Panel</a>
</body>
</html>