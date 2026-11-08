<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Avisos - ReparaYa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4 shadow-sm">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold" href="index.php?ruta=inicio">ReparaYa | Area de Cliente</a>
            <div class="d-flex align-items-center text-white">
                <span class="me-3">Conectado como: <span class="fw-bold text-light"><?php echo htmlspecialchars($_SESSION['nombre']); ?></span></span>
                <a href="index.php?ruta=logout" class="btn btn-outline-light btn-sm">Cerrar Sesion</a>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark m-0">Historial de Incidencias</h2>
            <a href="index.php?ruta=inicio" class="btn btn-secondary btn-sm">Volver al Panel</a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0 table-responsive">
                
                <?php if (empty($incidencias)): ?>
                    <div class="text-center p-5 text-muted">
                        <h4>Sin registros</h4>
                        <p>Aun no has solicitado ninguna asistencia tecnica.</p>
                        <a href="index.php?ruta=crear_incidencia" class="btn btn-primary mt-2">Solicitar ahora</a>
                    </div>
                <?php else: ?>
                    <table class="table table-hover table-striped align-middle m-0">
                        <thead class="table-primary">
                            <tr>
                                <th>Localizador</th>
                                <th>Fecha de Cita</th>
                                <th>Urgencia</th>
                                <th>Estado Actual</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($incidencias as $incidencia): ?>
                                <tr>
                                    <td class="fw-bold text-secondary">
                                        <?php echo htmlspecialchars($incidencia['localizador']); ?>
                                    </td>
                                    
                                    <td>
                                        <?php echo date('d/m/Y H:i', strtotime($incidencia['fecha_servicio'])); ?>
                                    </td>
                                    
                                    <td>
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
                                    
                                    <td class="text-center">
                                        <a href="index.php?ruta=detalle_incidencia&id=<?php echo $incidencia['id']; ?>" class="btn btn-outline-primary btn-sm fw-bold">Ver detalle</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>

            </div>
        </div>

    </div>
</body>
</html>