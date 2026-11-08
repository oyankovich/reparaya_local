<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Técnicos - Admin</title>
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
                        <a class="nav-link active" href="index.php?ruta=gestion_tecnicos">Gestion de Tecnicos</a>
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
    <div class="container mt-5">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Gestión de Técnicos</h2>
        </div>

        <?php if (isset($_GET['exito']) && $_GET['exito'] == 1): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>¡Excelente!</strong> El técnico ha sido registrado y su cuenta de acceso creada correctamente.
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Registrar Nuevo Técnico</h5>
                    </div>
                    <div class="card-body">
                        <form action="../public/index.php?ruta=crear_tecnico" method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nombre Completo:</label>
                                <input type="text" name="nombre_completo" class="form-control" placeholder="Ej: Marco Polo" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Especialidad:</label>
                                <select name="especialidad_id" class="form-select" required>
                                    <option value="">-- Selecciona --</option>
                                    <?php foreach ($especialidades as $especialidad): ?>
                                        <option value="<?php echo $especialidad['id']; ?>">
                                            <?php echo htmlspecialchars($especialidad['nombre_especialidad']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">Email de acceso:</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="ej: tecnico@reparaya.com" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-bold">Contraseña Inicial:</label>
                                <input type="text" name="password" id="password" class="form-control" value="123456" required>
                            </div>

                            <button type="submit" class="btn btn-success w-100">Guardar Técnico</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">Plantilla Actual</h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped table-hover m-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID Empleado</th>
                                    <th>Nombre</th>
                                    <th>Especialidad</th>
                                    <th>Disponibilidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($tecnicos)): ?>
                                    <?php foreach ($tecnicos as $tecnico): ?>
                                        <tr>
                                            <td class="align-middle fw-bold text-muted">#<?php echo htmlspecialchars($tecnico['id']); ?></td>
                                            <td class="align-middle"><?php echo htmlspecialchars($tecnico['nombre_completo']); ?></td>
                                            <td class="align-middle">
                                                <span class="badge bg-info text-dark">
                                                    <?php echo htmlspecialchars($tecnico['nombre_especialidad'] ?? 'Sin asignar'); ?>
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                <?php if ($tecnico['disponible']): ?>
                                                    <span class="badge bg-success">Disponible</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Ocupado</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">No hay técnicos registrados en el sistema.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>
</html>