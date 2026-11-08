<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - ReparaYa</title>
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
            <div class="col-md-6">
                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold text-dark m-0">Gestion de Perfil</h2>
                    <a href="index.php?ruta=inicio" class="btn btn-secondary btn-sm">Volver al Panel</a>
                </div>

                <?php if (isset($_GET['exito'])): ?> 
                    <div class="alert alert-success shadow-sm" role="alert">
                        <strong>Datos actualizados correctamente.</strong> Tus cambios han sido guardados en el sistema.
                    </div>
                <?php endif; ?>

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <form action="index.php?ruta=actualizar_perfil" method="POST">
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Cambiar Nombre</label>
                                <input type="text" class="form-control" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Cambiar Correo Electronico</label>
                                <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Nueva Contrasena</label>
                                <input type="password" class="form-control" name="password" placeholder="Dejar en blanco para no modificar">
                            </div>
                            
                            <button type="submit" class="btn btn-success w-100 fw-bold py-2">Guardar Cambios</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>
</body>
</html>