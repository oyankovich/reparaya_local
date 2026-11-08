<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar incidencia</title>
</head>
<body>
    <h1>Modificar incidencia <?php echo htmlspecialchars($incidencia['localizador']); ?></h1>

    <?php if (!empty($_SESSION['mensaje'])): ?>
        <p><strong><?php echo htmlspecialchars($_SESSION['mensaje']); ?></strong></p>
        <?php unset($_SESSION['mensaje']); ?>
    <?php endif; ?>

    <p><strong>Cliente:</strong> <?php echo htmlspecialchars($incidencia['cliente']); ?></p>
    <p><strong>Estado:</strong> <?php echo htmlspecialchars($incidencia['estado']); ?></p>

    <form method="POST" action="../public/index.php?ruta=admin_guardar_edicion">
        <input type="hidden" name="id" value="<?php echo $incidencia['id']; ?>">

        <p>
            <label>Tipo de servicio:</label><br>
            <select name="especialidad_id" required>
                <?php foreach ($especialidades as $especialidad): ?>
                    <option value="<?php echo $especialidad['id']; ?>" <?php if ($especialidad['id'] == $incidencia['especialidad_id']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($especialidad['nombre_especialidad']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>

        <p>
            <label>Urgencia:</label><br>
            <select name="tipo_urgencia" required>
                <option value="Estándar" <?php if ($incidencia['tipo_urgencia'] === 'Estándar') echo 'selected'; ?>>Estándar (mínimo 48 horas)</option>
                <option value="Urgente" <?php if ($incidencia['tipo_urgencia'] === 'Urgente') echo 'selected'; ?>>Urgente</option>
            </select>
        </p>

        <p>
            <label>Fecha y hora:</label><br>
            <input type="datetime-local" name="fecha_servicio" required
                   value="<?php echo date('Y-m-d\TH:i', strtotime($incidencia['fecha_servicio'])); ?>">
        </p>

        <p>
            <label>Dirección:</label><br>
            <input type="text" name="direccion" size="50" required
                   value="<?php echo htmlspecialchars($incidencia['direccion']); ?>">
        </p>

        <p>
            <label>Descripción de la avería:</label><br>
            <textarea name="descripcion" rows="4" cols="50" required><?php echo htmlspecialchars($incidencia['descripcion']); ?></textarea>
        </p>

        <button type="submit">Guardar cambios</button>
    </form>

    <p><a href="../public/index.php?ruta=admin_detalle&id=<?php echo $incidencia['id']; ?>">Volver al detalle</a></p>
</body>
</html>