<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Técnico - ReparaYa</title>
</head>
<body style="font-family: Arial, sans-serif; padding: 20px;">
    <h2>Área de Trabajo - Técnico: <?php echo htmlspecialchars($_SESSION['nombre']); ?></h2>
    
    <nav style="margin-bottom: 20px;">
        <a href="index.php?ruta=logout" style="padding: 10px; background: #ffcccc; border: 1px solid #cc0000; text-decoration: none; color: black;">Cerrar Sesión</a>
    </nav>

    <hr>

    <h3>Mi Agenda de Averías Asignadas</h3>

    <?php if (isset($_GET['exito']) && $_GET['exito'] === 'estado_actualizado'): ?>
        <p style="color: green;"><strong>El estado de la avería se ha actualizado correctamente.</strong></p>
    <?php endif; ?>

    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; text-align: left; margin-top: 15px;">
        <thead style="background-color: #f4f4f4;">
            <tr>
                <th>ID</th>
                <th>Fecha/Hora Cita</th>
                <th>Cliente y Dirección</th>
                <th>Especialidad / Urgencia</th>
                <th>Descripción</th>
                <th>Estado Actual</th>
                <th>Acción de Trabajo</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($incidencias)): ?>
                <?php foreach ($incidencias as $incidencia): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($incidencia['id']); ?></strong></td>
                        <td><?php echo htmlspecialchars($incidencia['fecha_servicio']); ?></td>
                        <td>
                            <?php echo htmlspecialchars($incidencia['cliente_nombre']); ?><br>
                            <small><?php echo htmlspecialchars($incidencia['direccion']); ?></small>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($incidencia['nombre_especialidad']); ?><br>
                            <span style="color: <?php echo ($incidencia['tipo_urgencia'] === 'Urgente') ? 'red' : 'blue'; ?>;">
                                <?php echo htmlspecialchars($incidencia['tipo_urgencia']); ?>
                            </span>
                        </td>
                        <td><?php echo htmlspecialchars($incidencia['descripcion']); ?></td>
                        <td><strong><?php echo htmlspecialchars($incidencia['estado']); ?></strong></td>
                        
                        <td>
                            <?php if ($incidencia['estado'] === 'Asignada'): ?>
                                <form action="index.php?ruta=tecnico_cambiar_estado" method="POST">
                                    <input type="hidden" name="incidencia_id" value="<?php echo $incidencia['id']; ?>">
                                    <input type="hidden" name="accion" value="iniciar">
                                    <button type="submit" style="padding: 8px 15px; background: #ffc107; border: none; cursor: pointer;">Empezar Trabajo (En Curso)</button>
                                </form>
                            <?php elseif ($incidencia['estado'] === 'En curso'): ?>
                                <form action="index.php?ruta=tecnico_cambiar_estado" method="POST">
                                    <input type="hidden" name="incidencia_id" value="<?php echo $incidencia['id']; ?>">
                                    <input type="hidden" name="accion" value="finalizar">
                                    <button type="submit" style="padding: 8px 15px; background: #28a745; color: white; border: none; cursor: pointer;">Marcar como Finalizada</button>
                                </form>
                            <?php elseif ($incidencia['estado'] === 'Finalizada'): ?>
                                <span style="color: green; font-weight: bold;">✔ Completado</span>
                            <?php else: ?>
                                <span style="color: gray;">Sin acciones</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No tienes ninguna avería asignada en este momento.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>