<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Técnicos - Admin</title>
</head>
<body>
    <h2>Gestión de Técnicos</h2>

    <?php if (isset($_GET['exito']) && $_GET['exito'] == 1): ?>
        <p style="color: green;"><strong>Técnico registrado correctamente.</strong></p>
    <?php endif; ?>

    <h3>Registrar Nuevo Técnico</h3>
    <form action="../public/index.php?ruta=crear_tecnico" method="POST">
        <p>
            <label>Nombre Completo:</label><br>
            <input type="text" name="nombre_completo" required>
        </p>

        <p>
            <label>Especialidad:</label><br>
            <select name="especialidad_id" required>
                <option value="">-- Selecciona una especialidad --</option>
                <?php foreach ($especialidades as $especialidad): ?>
                    <option value="<?php echo $especialidad['id']; ?>">
                        <?php echo htmlspecialchars($especialidad['nombre_especialidad']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>

        <p>
            <label>ID de Usuario</label><br>
            <input type="number" name="usuario_id" placeholder="Ej: 5">
        </p>

        <button type="submit">Guardar Técnico</button>
    </form>

    <hr>

    <h3>Plantilla de Técnicos</h3>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>ID Especialidad</th>
                <th>Disponible</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($tecnicos)): ?>
                <?php foreach ($tecnicos as $tecnico): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($tecnico['id']); ?></td>
                        <td><?php echo htmlspecialchars($tecnico['nombre_completo']); ?></td>
                        <td><?php echo htmlspecialchars($tecnico['especialidad_id']); ?></td>
                        <td><?php echo $tecnico['disponible'] ? 'Sí' : 'No'; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No hay técnicos registrados en el sistema.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <br>
    <a href="../public/index.php?ruta=inicio">Volver al Panel</a>
</body>
</html>