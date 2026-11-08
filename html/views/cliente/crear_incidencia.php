<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Incidencia - ReparaYa</title>
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
        
        <div class="row justify-content-center">
            <div class="col-md-8">
                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold text-dark m-0">Solicitar Nueva Asistencia</h2>
  
                    <a href="index.php?ruta=inicio" class="btn btn-secondary btn-sm">Volver al Panel</a>
                </div>

                <div class="alert alert-info shadow-sm" role="alert">
                    Los servicios de tipo Estandar deben solicitarse con un minimo de 48 horas de antelacion a la fecha requerida.                
                </div>
                <?php if (isset($_GET['error']) && $_GET['error'] === '48h'): ?>
                    <div class="alert alert-danger shadow-sm mb-4" role="alert">
                        <strong>Operacion rechazada:</strong> Las asistencias de tipo "Estandar" deben solicitarse con un minimo de 48 horas de antelacion. Si tu averia no puede esperar, selecciona el nivel "Urgente".
                    </div>
                <?php endif; ?>
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <form action="index.php?ruta=procesar_incidencia" method="POST">
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="especialidad_id" class="form-label fw-bold">Tipo de Servicio</label>
                                    <select id="especialidad_id" name="especialidad_id" class="form-select" required>
                                        <option value="">-- Seleccionar --</option>
                                        <option value="1">Fontaneria</option>
                                        <option value="2">Electricidad</option>
                                        <option value="3">Climatizacion</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="tipo_urgencia" class="form-label fw-bold">Nivel de Urgencia</label>
                                    <select id="tipo_urgencia" name="tipo_urgencia" class="form-select" required>
                                        <option value="Estandar">Estandar (Normal)</option>
                                        <option value="Urgente">Urgente (Prioritario)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="fecha_servicio" class="form-label fw-bold">Fecha y Hora de la Cita</label>
                                <input type="datetime-local" id="fecha_servicio" name="fecha_servicio" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="direccion" class="form-label fw-bold">Direccion Completa del Domicilio</label>
                                <input type="text" id="direccion" name="direccion" class="form-control" placeholder="Ej: Calle Mayor 12, 3B, Barcelona" required>
                            </div>

                            <div class="mb-4">
                                <label for="descripcion" class="form-label fw-bold">Descripcion de la Averia y Telefono</label>
                                <textarea id="descripcion" name="descripcion" class="form-control" rows="4" placeholder="Describe detalladamente el problema y deja un telefono de contacto valido." required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 fw-bold py-2">Registrar y Enviar Solicitud</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>
</body>
</html>