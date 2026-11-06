<?php
session_start(); // Iniciamos la sesión para acceder a $_SESSION['usuario_id']

if (!isset($_SESSION['usuario_id'])) {
    // Si no está autenticado, redirigimos al usuario a la página de inicio de sesión
    header("Location: interfazUsuario.php");
    exit();
}

require_once '../../controlador/controladorIncidencias.php';
$controlador = new controladorIncidencias();
$mis_incidencias = $controlador->listarMisIncidencias($_SESSION['usuario_id']); //Se obtiene el ID del cliente desde la sesión

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Incidencias</title>
</head>
<body>
    <?php require_once '../menu.php'; ?>
    <h1>Mis Incidencias</h1>

    <?php if(isset($_GET['mensaje']) && $_GET['mensaje'] === 'cancelada'): ?>
        <p style="color: green;">La incidencia ha sido cancelada correctamente.</p>
    <?php endif; ?>

    <?php if (!empty($mis_incidencias)): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Localizador</th>
                    <th>Servicio</th>
                    <th>Fecha</th>
                    <th>Urgencia</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $mis_incidencias->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['localizador']); ?></td>
                        <td><?php echo htmlspecialchars($row['nombre_especialidad']); ?></td>
                        <td><?php echo htmlspecialchars($row['fecha_servicio']); ?></td>
                        <td><?php echo htmlspecialchars($row['tipo_urgencia']); ?></td>
                        <td><?php echo htmlspecialchars($row['estado']); ?></td>
                        <td>
                            <a href="detalleIncidencia.php?id=<?php echo $row['id']; ?>">Ver Historial</a>
                            <br><br>
                            <?php if ($row['estado'] === 'Pendiente' || $row['estado'] === 'Asignada'): ?>
                                <form method="POST" action="../../controlador/controladorIncidencias.php" style="display:inline;">
                                    <input type="hidden" name="accion" value="cancelarIncidencia">
                                    <input type="hidden" name="id_incidencia" value="<?php echo $row['id']; ?>">
                                    <input type="hidden" name="fecha_servicio" value="<?php echo $row['fecha_servicio']; ?>">
                                    <button type="submit" onclick="return confirm('¿Estás seguro de que quieres cancelar esta incidencia?');">Cancelar</button>
                                </form>
                            <?php else: ?>
                                <span>No disponible</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No tienes incidencias registradas.</p>
    <?php endif; ?>    
</body>
</html>