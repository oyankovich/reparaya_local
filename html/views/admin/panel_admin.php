<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración - ReparaYa</title>
</head>
<body>
    <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?></h2>
    
    <nav style="margin-bottom: 20px;">
        <a href="index.php?ruta=gestion_tecnicos" style="padding: 10px; background: #eee; border: 1px solid #ccc; text-decoration: none; color: black;"
        >Gestión de Técnicos</a>

        <a href="index.php?ruta=admin_crear_incidencia" style="padding: 10px; background: #28a745; border: 1px solid #003300; text-decoration: none; color: white; margin-left: 20px;"
        >+ Crear Incidencia</a>
         
        <a href="index.php?ruta=logout" style="padding: 10px; background: #ffcccc; border: 1px solid #cc0000; text-decoration: none; color: black; margin-left: 20px;"
        >Cerrar Sesión</a>
    </nav>

    <hr>

    <h3>Panel Global de Incidencias</h3>
    
    <?php if (isset($_GET['exito']) && $_GET['exito'] === 'asignada'): ?>
        <p style="color: green;"><strong>Técnico asignado correctamente. El estado ha cambiado a "Asignada".</strong></p>
    <?php elseif (isset($_GET['exito']) && $_GET['exito'] === 'creada'): ?>
        <p style="color: green;"><strong>Incidencia creada manualmente con éxito.</strong></p>
    <?php elseif (isset($_GET['exito']) && $_GET['exito'] === 'cancelada'): ?>
        <p style="color: red;"><strong>La incidencia ha sido cancelada correctamente.</strong></p>
    <?php endif; ?>

    <table border="1" cellpadding="8" cellspacing="0" style="width: 100%; text-align: left;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha de Servicio</th>
                <th>Cliente</th>
                <th>Especialidad</th>
                <th>Urgencia</th>
                <th>Estado</th>
                <th>Asignación / Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($incidencias)): ?>
                <?php foreach ($incidencias as $incidencia): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($incidencia['id']); ?></td>
                        <td><?php echo htmlspecialchars($incidencia['fecha_servicio']); ?></td>
                        <td><?php echo htmlspecialchars($incidencia['cliente_nombre']); ?></td>
                        <td><?php echo htmlspecialchars($incidencia['nombre_especialidad']); ?></td>
                        <td><?php echo htmlspecialchars($incidencia['tipo_urgencia']); ?></td>
                        <td><strong><?php echo htmlspecialchars($incidencia['estado']); ?></strong></td>
                        
                        <td>
                            <?php if ($incidencia['estado'] === 'Pendiente'): ?>
                                <form action="index.php?ruta=asignar_tecnico" method="POST" style="margin: 0; display: inline-block;">
                                    <input type="hidden" name="incidencia_id" value="<?php echo $incidencia['id']; ?>">
                                    <select name="tecnico_id" required>
                                        <option value="">-- Seleccionar Técnico --</option>
                                        <?php foreach ($tecnicos as $tecnico): ?>
                                            <?php if ($tecnico['disponible'] == 1): ?>
                                                <option value="<?php echo $tecnico['id']; ?>">
                                                    <?php echo htmlspecialchars($tecnico['nombre_completo']); ?>
                                                </option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                    <button type="submit">Asignar</button>
                                </form>
                            <?php elseif (!empty($incidencia['tecnico_id'])): ?>
                                Técnico Asignado (ID: <?php echo htmlspecialchars($incidencia['tecnico_id']); ?>)
                            <?php else: ?>
                                Sin técnico asignado
                            <?php endif; ?>

                            <?php if ($incidencia['estado'] === 'Pendiente' || $incidencia['estado'] === 'Asignada'): ?>
                                <form action="index.php?ruta=admin_cancelar_incidencia" method="POST" style="display:inline; margin-left: 5px;" onsubmit="return confirm('¿Estás seguro de que deseas cancelar esta incidencia?');">
                                    <input type="hidden" name="incidencia_id" value="<?php echo $incidencia['id']; ?>">
                                    <button type="submit" style="padding: 3px 8px; background: #dc3545; color: white; border: none; cursor: pointer; border-radius: 3px;">Cancelar</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No hay incidencias registradas en el sistema global.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>