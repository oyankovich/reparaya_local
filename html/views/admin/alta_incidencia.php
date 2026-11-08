<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo aviso</title>
</head>
<body>
    <h1>Nuevo aviso (alta manual)</h1>

    <?php if (!empty($_SESSION['mensaje'])): ?>
        <p><strong><?php echo htmlspecialchars($_SESSION['mensaje']); ?></strong></p>
        <?php unset($_SESSION['mensaje']); ?>
    <?php endif; ?>

    <form method="POST" action="../public/index.php?ruta=admin_guardar_alta">
        <p>
            <label>Cliente:</label><br>
            <select name="cliente_id" required>
                <?php foreach ($clientes as $cliente): ?>
                    <option value="<?php echo $cliente['id']; ?>">
                        <?php echo htmlspecialchars($cliente['nombre'] . ' (' . $cliente['email'] . ')'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>

        <p>
            <label>Tipo de servicio:</label><br>
            <select name="especialidad_id" required>
                <?php foreach ($especialidades as $especialidad): ?>
                    <option value="<?php echo $especialidad['id']; ?>"><?php echo htmlspecialchars($especialidad['nombre_especialidad']); ?></option>
                <?php endforeach; ?>
            </select>
        </p>

        <p>
            <label>Urgencia:</label><br>
            <select name="tipo_urgencia" required>
                <option value="Estándar">Estándar (mínimo 48 horas)</option>
                <option value="Urgente">Urgente</option>
            </select>
        </p>

        <p>
            <label>Fecha y hora:</label><br>
            <input type="datetime-local" name="fecha_servicio" required>
        </p>

        <p>
            <label>Dirección:</label><br>
            <input type="text" name="direccion" size="50" required>
        </p>

        <p>
            <label>Descripción de la avería:</label><br>
            <textarea name="descripcion" rows="4" cols="50" required></textarea>
        </p>

        <button type="submit">Crear aviso</button>
    </form>

    <p><a href="../public/index.php?ruta=gestionar_incidencias">Volver al listado</a></p>
</body>
</html>