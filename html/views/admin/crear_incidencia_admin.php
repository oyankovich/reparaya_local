<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Incidencia (Administracion) - ReparaYa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold" href="index.php?ruta=panel_admin">ReparaYa | Panel de Administracion</a>
            
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php?ruta=admin_crear_incidencia">Crear Nueva Incidencia</a>
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
<body class="bg-light">

    <div class="container mt-5">
        
        <div class="row justify-content-center">
            <div class="col-md-8">
                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold text-dark m-0">Crear Nueva Incidencia</h2>
                    
                </div>

                <?php if (isset($_GET['error']) && $_GET['error'] === '48h'): ?>
                    <div class="alert alert-danger shadow-sm mb-4" role="alert">
                        <strong>Operacion rechazada:</strong> Las asistencias "Estandar" requieren 48 horas de antelacion. Para citas a corto plazo, selecciona el nivel "Urgente".
                    </div>
                <?php endif; ?>
                
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <form action="index.php?ruta=admin_procesar_incidencia" method="POST">
                            
                            <div class="mb-3">
                                <label for="cliente_id" class="form-label fw-bold">Cliente</label>
                                <select name="cliente_id" id="cliente_id" class="form-select" required>
                                    <option value="">-- Seleccionar Cliente --</option>
                                    <?php foreach ($clientes as $cliente): ?>
                                        <option value="<?php echo $cliente['id']; ?>">
                                            <?php echo htmlspecialchars($cliente['nombre'] . ' (' . $cliente['email'] . ')'); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="especialidad_id" class="form-label fw-bold">Especialidad</label>
                                    <select name="especialidad_id" id="especialidad_id" class="form-select" required>
                                        <option value="">-- Seleccionar Especialidad --</option>
                                        <?php foreach ($especialidades as $especialidad): ?>
                                            <option value="<?php echo $especialidad['id']; ?>">
                                                <?php echo htmlspecialchars($especialidad['nombre_especialidad']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="tipo_urgencia" class="form-label fw-bold">Tipo de Urgencia</label>
                                    <select name="tipo_urgencia" id="tipo_urgencia" class="form-select" required>
                                        <option value="Estandar">Estandar</option>
                                        <option value="Urgente">Urgente</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="fecha_servicio" class="form-label fw-bold">Fecha y Hora del Servicio</label>
                                <input type="datetime-local" name="fecha_servicio" id="fecha_servicio" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="direccion" class="form-label fw-bold">Direccion Completa</label>
                                <input type="text" name="direccion" id="direccion" class="form-control" required>
                            </div>

                            <div class="mb-4">
                                <label for="descripcion" class="form-label fw-bold">Descripcion de la Averia</label>
                                <textarea name="descripcion" id="descripcion" rows="4" class="form-control" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 fw-bold py-2">Registrar Incidencia</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>
</body>
</html>