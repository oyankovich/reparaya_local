<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Técnico - ReparaYa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold" href="#"> ReparaYa | Portal del Técnico</a>
            <div class="d-flex align-items-center text-white">
                <span class="me-3">Sesión iniciada: <span class="text-info fw-bold"><?php echo htmlspecialchars($_SESSION['nombre']); ?></span></span>
                <a href="index.php?ruta=logout" class="btn btn-outline-danger btn-sm">Cerrar Sesión</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid px-4">
        
        <h3 class="mb-4 text-secondary">Mi Agenda de Averías Asignadas</h3>

        <?php if (isset($_GET['exito']) && $_GET['exito'] === 'estado_actualizado'): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <strong>¡Estado actualizado!</strong> El progreso de la avería se ha registrado correctamente.
            </div>
        <?php endif; ?>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover table-striped align-middle m-0">
                    <thead class="table-primary">
                        <tr>
                            <th>Ref. Avería</th> 
                            <th>Fecha y Hora</th>
                            <th>Cliente y Dirección</th>
                            <th>Especialidad / Urgencia</th>
                            <th>Descripción</th>
                            <th>Estado Actual</th>
                            <th class="text-center">Acción de Trabajo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($incidencias)): ?>
                            <?php foreach ($incidencias as $incidencia): ?>
                                <tr>
                                    <td class="fw-bold text-secondary">
                                        <?php echo !empty($incidencia['localizador']) ? htmlspecialchars($incidencia['localizador']) : '#REP-' . htmlspecialchars($incidencia['id']); ?>
                                    </td>
                                    
                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            📅 <?php echo date('d/m/Y H:i', strtotime($incidencia['fecha_servicio'])); ?>
                                        </span>
                                    </td>
                                    
                                    <td>
                                        <strong><?php echo htmlspecialchars($incidencia['cliente_nombre']); ?></strong><br>
                                        <small class="text-muted"> <?php echo htmlspecialchars($incidencia['direccion']); ?></small>
                                    </td>
                                    
                                    <td>
                                        <span class="fw-bold text-dark"><?php echo htmlspecialchars($incidencia['nombre_especialidad']); ?></span><br>
                                        <?php if ($incidencia['tipo_urgencia'] === 'Urgente'): ?>
                                            <span class="badge bg-danger"> Urgente</span>
                                        <?php else: ?>
                                            <span class="badge bg-info text-dark">🔹 Estándar</span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td>
                                        <p class="mb-0 text-truncate" style="max-width: 250px;" title="<?php echo htmlspecialchars($incidencia['descripcion']); ?>">
                                            <?php echo htmlspecialchars($incidencia['descripcion']); ?>
                                        </p>
                                    </td>
                                    
                                    <td>
                                        <?php if ($incidencia['estado'] === 'Asignada'): ?>
                                            <span class="badge bg-secondary fs-6">Asignada</span>
                                        <?php elseif ($incidencia['estado'] === 'En curso'): ?>
                                            <span class="badge bg-warning text-dark fs-6">En curso </span>
                                        <?php elseif ($incidencia['estado'] === 'Finalizada'): ?>
                                            <span class="badge bg-success fs-6">Finalizada </span>
                                        <?php else: ?>
                                            <span class="badge bg-dark fs-6"><?php echo htmlspecialchars($incidencia['estado']); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td class="text-center">
                                        <?php if ($incidencia['estado'] === 'Asignada'): ?>
                                            <form action="index.php?ruta=tecnico_cambiar_estado" method="POST" class="m-0">
                                                <input type="hidden" name="incidencia_id" value="<?php echo $incidencia['id']; ?>">
                                                <input type="hidden" name="accion" value="iniciar">
                                                <button type="submit" class="btn btn-warning btn-sm fw-bold shadow-sm">▶️ Empezar Trabajo</button>
                                            </form>
                                        <?php elseif ($incidencia['estado'] === 'En curso'): ?>
                                            <form action="index.php?ruta=tecnico_cambiar_estado" method="POST" class="m-0">
                                                <input type="hidden" name="incidencia_id" value="<?php echo $incidencia['id']; ?>">
                                                <input type="hidden" name="accion" value="finalizar">
                                                <button type="submit" class="btn btn-success btn-sm fw-bold shadow-sm">✅ Finalizar</button>
                                            </form>
                                        <?php elseif ($incidencia['estado'] === 'Finalizada'): ?>
                                            <button class="btn btn-outline-success btn-sm disabled" tabindex="-1">Completado</button>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <h4>¡Agenda libre!</h4>
                                    <p>No tienes ninguna avería asignada en este momento.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>

</body>
</html>