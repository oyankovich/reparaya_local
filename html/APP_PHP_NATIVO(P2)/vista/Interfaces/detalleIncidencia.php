<?php
session_start(); // Iniciamos la sesión para acceder a $_SESSION['usuario_id']
require_once '../../controlador/controladorIncidencias.php';
$controlador = new controladorIncidencias();

//Recogemos el ID de la incidencia desde la URL
$id_incidencia = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id_incidencia) {
    header("Location: misIncidencias.php");
    exit();
}

$historial = $controlador->verHistorial($id_incidencia);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Incidencia</title>
</head>
<body>
    <?php require_once '../menu.php'; ?>
    <h1>Detalle de Incidencia</h1>

    <h3>Historial de Cambios</h3>
    <?php if (!empty($historial)): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Usuario que realizó el cambio</th>
                    <th>Estado Anterior</th>
                    <th>Estado Nuevo</th>
                   
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $historial->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['fecha_cambio']); ?></td>
                        <td><?php echo htmlspecialchars($row['usuario_nombre']); ?></td>
                        <td><?php echo htmlspecialchars($row['estado_anterior']); ?></td>
                        <td><?php echo htmlspecialchars($row['estado_nuevo']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <br>
        <a href="misIncidencias.php">Volver a Mis Incidencias</a>
    <?php else: ?>
        <p>No hay historial de cambios para esta incidencia.</p>
        <a href="misIncidencias.php">Volver a Mis Incidencias</a>
    
    <?php endif; ?>
</body>
</html>