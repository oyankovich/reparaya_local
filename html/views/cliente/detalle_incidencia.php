<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de Incidencia</title>
</head>
<body>
    <h2>Detalle: <?php echo htmlspecialchars($incidencia['localizador']); ?></h2>
    
    <p><strong>Estado Actual:</strong> <?php echo htmlspecialchars($incidencia['estado']); ?></p>
    <p><strong>Urgencia:</strong> <?php echo htmlspecialchars($incidencia['tipo_urgencia']); ?></p>
    <p><strong>Fecha de la Cita:</strong> <?php echo htmlspecialchars($incidencia['fecha_servicio']); ?></p>
    <p><strong>Dirección:</strong> <?php echo htmlspecialchars($incidencia['direccion']); ?></p>
    <p><strong>Descripción:</strong><br> <?php echo nl2br(htmlspecialchars($incidencia['descripcion'])); ?></p>

    <?php 
    if ($incidencia['estado'] === 'Pendiente' || $incidencia['estado'] === 'Asignada'): 
    ?>
        <form action="../public/index.php?ruta=cancelar_incidencia" method="POST" onsubmit="return confirm('¿Cancelar cita?');">
            <input type="hidden" name="incidencia_id" value="<?php echo $incidencia['id']; ?>">
            <button type="submit">Cancelar Solicitud</button>
        </form>
    <?php endif; ?>

    <hr>

    <h3>Historial de Cambios</h3>
    <?php if (empty($historial)): ?>
        <p>No hay registros.</p>
    <?php else: ?>
        <table border="1">
            <tr>
                <th>Estado Anterior</th>
                <th>Estado Nuevo</th>
            </tr>
            <?php foreach ($historial as $registro): ?>
                <tr>
                    <td><?php echo $registro['estado_anterior'] ? htmlspecialchars($registro['estado_anterior']) : 'N/A'; ?></td>
                    <td><?php echo htmlspecialchars($registro['estado_nuevo']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <br>
    <a href="../public/index.php?ruta=mis_incidencias">Volver al listado</a>
</body>
</html>