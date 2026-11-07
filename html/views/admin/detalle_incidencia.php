<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de incidencia</title>
</head>
<body>
    <h1>Incidencia <?php echo htmlspecialchars($incidencia['localizador']); ?></h1>

    <?php if (!empty($_SESSION['mensaje'])): ?>
        <p><strong><?php echo htmlspecialchars($_SESSION['mensaje']); ?></strong></p>
        <?php unset($_SESSION['mensaje']); ?>
    <?php endif; ?>

    <p><strong>Estado:</strong> <?php echo htmlspecialchars($incidencia['estado']); ?></p>
    <p><strong>Cliente:</strong> <?php echo htmlspecialchars($incidencia['cliente']); ?></p>
    <p><strong>Servicio:</strong> <?php echo htmlspecialchars($incidencia['servicio']); ?></p>
    <p><strong>Urgencia:</strong> <?php echo htmlspecialchars($incidencia['tipo_urgencia']); ?></p>
    <p><strong>Fecha:</strong> <?php echo date('d/m/Y H:i', strtotime($incidencia['fecha_servicio'])); ?></p>
    <p><strong>Dirección:</strong> <?php echo htmlspecialchars($incidencia['direccion']); ?></p>
    <p><strong>Descripción:</strong> <?php echo nl2br(htmlspecialchars($incidencia['descripcion'])); ?></p>
    <p><strong>Técnico:</strong> <?php echo $incidencia['tecnico'] ? htmlspecialchars($incidencia['tecnico']) : 'Sin asignar'; ?></p>

    <?php if ($incidencia['estado'] === 'Pendiente' || $incidencia['estado'] === 'Asignada'): ?>
        <h3>Asignar técnico</h3>
        <form method="POST" action="../public/index.php?ruta=admin_asignar">
            <input type="hidden" name="id" value="<?php echo $incidencia['id']; ?>">
            <select name="tecnico_id">
                <?php foreach ($tecnicos as $tecnico): ?>
                    <option value="<?php echo $tecnico['id']; ?>"><?php echo htmlspecialchars($tecnico['nombre_completo']); ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Asignar</button>
        </form>
    <?php endif; ?>

    <h3>Cancelar incidencia</h3>
    <!-- El botón sale siempre: si el estado no lo permite, lo rechaza el servidor -->
    <form method="POST" action="../public/index.php?ruta=admin_cancelar">
        <input type="hidden" name="id" value="<?php echo $incidencia['id']; ?>">
        <button type="submit">Cancelar incidencia</button>
    </form>

    <h3>Historial de estados</h3>
    <table border="1" cellpadding="5">
        <tr>
            <th>Fecha y hora</th>
            <th>Estado anterior</th>
            <th>Estado nuevo</th>
            <th>Usuario</th>
        </tr>
        <?php foreach ($historial as $cambio): ?>
            <tr>
                <td><?php echo date('d/m/Y H:i', strtotime($cambio['fecha_cambio'])); ?></td>
                <td><?php echo $cambio['estado_anterior'] ? htmlspecialchars($cambio['estado_anterior']) : '-'; ?></td>
                <td><?php echo htmlspecialchars($cambio['estado_nuevo']); ?></td>
                <td><?php echo htmlspecialchars($cambio['usuario']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <p><a href="../public/index.php?ruta=gestionar_incidencias">Volver al listado</a></p>
</body>
</html>