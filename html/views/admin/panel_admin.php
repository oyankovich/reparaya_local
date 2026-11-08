<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administracion - ReparaYa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold" href="index.php?ruta=panel_admin">ReparaYa | Panel de Administracion</a>
            
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?ruta=admin_crear_incidencia">Crear Nueva Incidencia</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?ruta=gestion_tecnicos">Gestion de Tecnicos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?ruta=calendario_admin">Ver Calendario</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center text-white">
                    <span class="me-3">Admin: <span class="text-info fw-bold"><?php echo htmlspecialchars($_SESSION['nombre']); ?></span></span>
                    <a href="index.php?ruta=logout" class="btn btn-outline-danger btn-sm">Cerrar Sesion</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid px-4">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-secondary">Gestion Global de Incidencias</h3>
            
            <form action="index.php" method="GET" class="d-flex align-items-center">
                <input type="hidden" name="ruta" value="panel_admin">
                <label class="me-2 fw-bold text-muted">Filtrar por estado:</label>
                <select name="estado" class="form-select form-select-sm w-auto me-2">
                    <option value="Todos">Todos</option>
                    <option value="Pendiente" <?php echo (isset($_GET['estado']) && $_GET['estado'] == 'Pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                    <option value="Asignada" <?php echo (isset($_GET['estado']) && $_GET['estado'] == 'Asignada') ? 'selected' : ''; ?>>Asignada</option>
                    <option value="En curso" <?php echo (isset($_GET['estado']) && $_GET['estado'] == 'En curso') ? 'selected' : ''; ?>>En curso</option>
                    <option value="Finalizada" <?php echo (isset($_GET['estado']) && $_GET['estado'] == 'Finalizada') ? 'selected' : ''; ?>>Finalizada</option>
                    <option value="Cancelada" <?php echo (isset($_GET['estado']) && $_GET['estado'] == 'Cancelada') ? 'selected' : ''; ?>>Cancelada</option>
                </select>
                <button type="submit" class="btn btn-secondary btn-sm">Filtrar</button>
            </form>
        </div>

        <?php if (isset($_GET['exito']) && $_GET['exito'] === 'tecnico_asignado'): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                El tecnico ha sido asignado y la averia ha pasado a estado Asignada correctamente.
            </div>
        <?php endif; ?>

        <div class="card shadow-sm border-0 mb-5">
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover table-striped align-middle m-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Ref. Averia</th>
                            <th>Fecha de Cita</th>
                            <th>Cliente Particular</th>
                            <th>Servicio / Urgencia</th>
                            <th>Estado</th>
                            <th>Asignar Tecnico</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($incidencias)): ?>
                            <?php foreach ($incidencias as $incidencia): ?>
                                <tr>
                                    <td class="fw-bold text-secondary">
                                        <?php echo !empty($incidencia['localizador']) ? htmlspecialchars($incidencia['localizador']) : 'REF-' . htmlspecialchars($incidencia['id']); ?>
                                    </td>
                                    
                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            <?php echo date('d/m/Y H:i', strtotime($incidencia['fecha_servicio'])); ?>
                                        </span>
                                    </td>
                                    
                                    <td>
                                        <strong><?php echo htmlspecialchars($incidencia['cliente_nombre']); ?></strong><br>
                                        <small class="text-muted"><?php echo htmlspecialchars($incidencia['direccion']); ?></small>
                                    </td>
                                    
                                    <td>
                                        <span class="fw-bold text-dark"><?php echo htmlspecialchars($incidencia['nombre_especialidad']); ?></span><br>
                                        <?php if ($incidencia['tipo_urgencia'] === 'Urgente'): ?>
                                            <span class="badge bg-danger">Urgente</span>
                                        <?php else: ?>
                                            <span class="badge bg-info text-dark">Estandar</span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td>
                                        <?php if ($incidencia['estado'] === 'Pendiente'): ?>
                                            <span class="badge bg-secondary">Pendiente</span>
                                        <?php elseif ($incidencia['estado'] === 'Asignada'): ?>
                                            <span class="badge bg-primary">Asignada</span>
                                        <?php elseif ($incidencia['estado'] === 'En curso'): ?>
                                            <span class="badge bg-warning text-dark">En curso</span>
                                        <?php elseif ($incidencia['estado'] === 'Finalizada'): ?>
                                            <span class="badge bg-success">Finalizada</span>
                                        <?php elseif ($incidencia['estado'] === 'Cancelada'): ?>
                                            <span class="badge bg-dark">Cancelada</span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td>
                                        <?php if (in_array($incidencia['estado'], ['Pendiente', 'Asignada'])): ?>
                                            <form action="index.php?ruta=asignar_tecnico" method="POST" class="d-flex">
                                                <input type="hidden" name="incidencia_id" value="<?php echo $incidencia['id']; ?>">
                                                <select name="tecnico_id" class="form-select form-select-sm me-2" required>
                                                    <option value="">-- Seleccionar --</option>
                                                    <?php if (!empty($tecnicos)): ?>
                                                        <?php foreach ($tecnicos as $tecnico): ?>
                                                            <option value="<?php echo $tecnico['id']; ?>" <?php echo ($incidencia['tecnico_id'] == $tecnico['id']) ? 'selected' : ''; ?>>
                                                                <?php echo htmlspecialchars($tecnico['nombre_completo']); ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </select>
                                                <button type="submit" class="btn btn-primary btn-sm">Asignar</button>
                                            </form>
                                        <?php else: ?>
                                            <span class="text-muted text-sm">Bloqueado por estado</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No se encontraron incidencias con los criterios actuales.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>

</body>
</html>