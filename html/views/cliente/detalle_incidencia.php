<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Incidencia</title>
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
            <h3 class="fw-bold m-0">Detalle de Averia: <span class="text-primary"><?php echo htmlspecialchars($incidencia['localizador']); ?></span></h3>
            <a href="index.php?ruta=mis_incidencias" class="btn btn-secondary btn-sm">Volver al listado</a>
        </div>

        <div class="row g-4">
            
            <div class="col-md-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-dark text-white fw-bold">
                        Informacion del Servicio
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush mb-3">
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <strong>Estado Actual:</strong> 
                                <span class="badge bg-secondary fs-6"><?php echo htmlspecialchars($incidencia['estado']); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <strong>Urgencia:</strong> 
                                <span><?php echo htmlspecialchars($incidencia['tipo_urgencia']); ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <strong>Fecha Programada:</strong> 
                                <span><?php echo date('d/m/Y H:i', strtotime($incidencia['fecha_servicio'])); ?></span>
                            </li>
                            <li class="list-group-item px-0">
                                <strong>Direccion:</strong><br> 
                                <span class="text-muted"><?php echo htmlspecialchars($incidencia['direccion']); ?></span>
                            </li>
                            <li class="list-group-item px-0">
                                <strong>Descripcion del Problema:</strong><br>
                                <p class="text-muted mt-2 mb-0"><?php echo nl2br(htmlspecialchars($incidencia['descripcion'])); ?></p>
                            </li>
                        </ul>

                        <?php if ($incidencia['estado'] === 'Pendiente' || $incidencia['estado'] === 'Asignada'): ?>
                            <form action="index.php?ruta=cancelar_incidencia" method="POST" onsubmit="return confirm('¿Estas seguro de que deseas cancelar esta solicitud? Esta accion no se puede deshacer.');">
                                <input type="hidden" name="incidencia_id" value="<?php echo $incidencia['id']; ?>">
                                <button type="submit" class="btn btn-outline-danger w-100 mt-2">Cancelar Solicitud</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-light fw-bold text-secondary border-bottom">
                        Historial de Transiciones
                    </div>
                    <div class="card-body p-0">
                        <?php if (empty($historial)): ?>
                            <div class="p-4 text-center text-muted">
                                No hay registros de cambios para esta averia.
                            </div>
                        <?php else: ?>
                            <table class="table table-sm table-striped m-0">
                                <thead>
                                    <tr>
                                        <th class="ps-3">Estado Anterior</th>
                                        <th>Estado Nuevo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($historial as $registro): ?>
                                        <tr>
                                            <td class="ps-3 text-muted"><?php echo $registro['estado_anterior'] ? htmlspecialchars($registro['estado_anterior']) : 'N/A'; ?></td>
                                            <td class="fw-bold text-dark"><?php echo htmlspecialchars($registro['estado_nuevo']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>

    </div>
</body>
</html>