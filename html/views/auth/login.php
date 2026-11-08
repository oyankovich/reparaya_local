<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso - ReparaYa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    
    <div class="card shadow-sm border-0" style="width: 100%; max-width: 400px;">
        <div class="card-body p-4 p-md-5">
            
            <div class="text-center mb-4">
                <h2 class="text-primary fw-bold">ReparaYa</h2>
                <p class="text-muted">Inicia sesion</p>
            </div>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger py-2 text-center" role="alert">
                    Credenciales incorrectas o usuario no encontrado.
                </div>
            <?php endif; ?>
            
            <form action="../public/index.php?ruta=procesar_login" method="POST">
                
                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Correo electronico</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="ejemplo@correo.com" required>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label fw-bold">Contrasena</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="******" required>
                </div>

                <button type="submit" class="btn btn-primary w-100 fw-bold mb-3">Entrar</button>
                
            </form>

            <div class="text-center mt-2">
                <span class="text-muted">¿No tienes cuenta?</span> 
                <a href="../public/index.php?ruta=registro" class="text-decoration-none fw-bold">Registrate aqui</a>
            </div>
            
        </div>
    </div>

</body>
</html>