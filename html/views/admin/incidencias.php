<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de incidencias</title>
</head>
<body>
    <h1>Gestión de incidencias</h1>

    <?php if (!empty($_SESSION['mensaje'])): ?>
        <p><strong><?php echo htmlspecialchars($_SESSION['mensaje']); ?></strong></p>
        <?php unset($_SESSION['mensaje']); ?>
    <?php endif; ?>

    <form method="GET" action="../public/index.php">
        <input type="hidden" name="ruta" value="gestionar_incidencias">
        <label>Filtrar por estado:</label>
        <select name="estado">
            <option value="">Todos</option>
            <?php foreach (['Pendiente', 'Asignada', 'En curso', 'Finalizada', 'Cancelada'] as $e): ?>
                <option value="<?php echo $e; ?>" <?php if ($estado === $e) echo 'selected'; ?>><?php echo $e; ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Filtrar</button>
    </form>
    <br>

    <table border="1" cellpadding="5">
        <tr>
            <th>Código</th>
            <th>Fecha</th>
            <th>Cliente</th>
            <th>Servicio</th>
            <th>Urgencia</th>
            <th>Técnico</th>
            <th>Estado</th>
            <th></th>
        </tr>

        <?php if (empty($incidencias)): ?>
            <tr><td colspan="8">No hay incidencias.</td></tr>
        <?php endif; ?>

        <?php foreach ($incidencias as $inc): ?>
            <tr>
                <td><?php echo htmlspecialchars($inc['localizador']); ?></td>
                <td><?php echo date('d/m/Y H:i', strtotime($inc['fecha_servicio'])); ?></td>
                <td><?php echo htmlspecialchars($inc['cliente']); ?></td>
                <td><?php echo htmlspecialchars($inc['servicio']); ?></td>
                <td><?php echo htmlspecialchars($inc['tipo_urgencia']); ?></td>
                <td><?php echo $inc['tecnico'] ? htmlspecialchars($inc['tecnico']) : 'Sin asignar'; ?></td>
                <td><?php echo htmlspecialchars($inc['estado']); ?></td>
                <td><a href="../public/index.php?ruta=admin_detalle&id=<?php echo $inc['id']; ?>">Ver</a></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <p><a href="../public/index.php?ruta=inicio">Volver al panel</a></p>
</body>
</html>