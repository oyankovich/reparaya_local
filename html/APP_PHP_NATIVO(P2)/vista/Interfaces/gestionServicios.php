<?php
session_start();
if(!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: interfazUsuario.php");
    exit();
}

require_once __DIR__ . '/../../controlador/controladorMaestro.php';
$controlador = new ControladorMaestro();
$servicio = $controlador->listarEspecialidades();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Servicios</title>
</head>
<body>
    <?php require_once '../menu.php'; ?>

    <h1>Gestión de Servicios</h1>

    <h2>Añadir nuevo Servicio</h2>
    <form action="../../controlador/controladorMaestro.php" method="POST">
        <input type="hidden" name="accion" value="crearEspecialidad">

        <label>Nombre del Servicio:</label>
        <input type="text" name="nombre_especialidad" required><br><br>

        <label>Precio Base (€):</label>
        <input type="number" step="0.01" name="precio_base" required><br><br>

        <input type="submit" value="Crear Servicio">
    </form>
    <hr>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Servicio</th>
                <th>Precio Base</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $servicio->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['nombre_especialidad']); ?></td>
                    <td><?php echo htmlspecialchars($row['precio_base']); ?> €</td>                    
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>