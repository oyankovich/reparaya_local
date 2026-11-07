<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Incidencia (Administración) - ReparaYa</title>
</head>
<body>
    <h2>Crear Nueva Incidencia Manualmente</h2>
    
    <nav style="margin-bottom: 20px;">
        <a href="index.php?ruta=panel_admin" style="padding: 10px; background: #eee; border: 1px solid #ccc; text-decoration: none; color: black;">← Volver al Panel</a>
    </nav>

    <form action="index.php?ruta=admin_procesar_incidencia" method="POST" style="max-width: 500px;">
        
        <div style="margin-bottom: 15px;">
            <label for="cliente_id"><strong>Cliente:</strong></label><br>
            <select name="cliente_id" id="cliente_id" required style="width: 100%; padding: 8px;">
                <option value="">-- Seleccionar Cliente --</option>
                <?php foreach ($clientes as $cliente): ?>
                    <option value="<?php echo $cliente['id']; ?>">
                        <?php echo htmlspecialchars($cliente['nombre'] . ' (' . $cliente['email'] . ')'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label for="especialidad_id"><strong>Especialidad:</strong></label><br>
            <select name="especialidad_id" id="especialidad_id" required style="width: 100%; padding: 8px;">
                <option value="">-- Seleccionar Especialidad --</option>
                <?php foreach ($especialidades as $especialidad): ?>
                    <option value="<?php echo $especialidad['id']; ?>">
                        <?php echo htmlspecialchars($especialidad['nombre_especialidad']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label for="tipo_urgencia"><strong>Tipo de Urgencia:</strong></label><br>
            <select name="tipo_urgencia" id="tipo_urgencia" required style="width: 100%; padding: 8px;">
                <option value="Estándar">Estándar</option>
                <option value="Urgente">Urgente</option>
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label for="fecha_servicio"><strong>Fecha y Hora del Servicio:</strong></label><br>
            <input type="datetime-local" name="fecha_servicio" id="fecha_servicio" required style="width: 100%; padding: 8px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="direccion"><strong>Dirección:</strong></label><br>
            <input type="text" name="direccion" id="direccion" required style="width: 100%; padding: 8px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="descripcion"><strong>Descripción de la Avería:</strong></label><br>
            <textarea name="descripcion" id="descripcion" rows="4" required style="width: 100%; padding: 8px;"></textarea>
        </div>

        <button type="submit" style="padding: 10px 20px; background: #007BFF; color: white; border: none; cursor: pointer;">Crear Incidencia</button>
    </form>
</body>
</html>