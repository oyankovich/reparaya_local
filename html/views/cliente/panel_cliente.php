<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Cliente - ReparaYa</title>
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

    <div class="container px-4 mt-5">
        
        <div class="mb-5">
            <h2 class="text-dark fw-bold">Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?></h2>
            <p class="text-muted">Selecciona una opcion de tu panel de control.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 text-center p-3">
                    <div class="card-body">
                        <h5 class="card-title fw-bold text-primary">Nueva Averia</h5>
                        <p class="card-text text-muted">Solicita una nueva asistencia tecnica en tu domicilio, ya sea estandar o urgente.</p>
                        <a href="index.php?ruta=crear_incidencia" class="btn btn-primary w-100 mt-3">Solicitar Asistencia</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 text-center p-3">
                    <div class="card-body">
                        <h5 class="card-title fw-bold text-secondary">Mis Incidencias</h5>
                        <p class="card-text text-muted">Consulta el historial y el estado en tiempo real de todas tus solicitudes anteriores.</p>
                        <a href="index.php?ruta=mis_incidencias" class="btn btn-secondary w-100 mt-3">Consultar Historial</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 text-center p-3">
                    <div class="card-body">
                        <h5 class="card-title fw-bold text-dark">Mi Perfil</h5>
                        <p class="card-text text-muted">Actualiza tu informacion personal, correo electronico y cambia tu contrasena de acceso.</p>
                        <a href="index.php?ruta=mi_perfil" class="btn btn-outline-dark w-100 mt-3">Modificar Datos</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>
</html>