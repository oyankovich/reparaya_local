<?php
session_start(); // Iniciamos la sesión para acceder a $_SESSION['usuario_id']

//1. Verificamos si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    // Si no está autenticado, redirigimos al usuario a la página de inicio de sesión
    header("Location: interfazUsuario.php");
    exit();
}

//2. Conectamos con la base de datos para sacar las especialidades
require_once '../../config/basedatos.php';
$database = new Database();
$db = $database->getConexion();

//3. Hacemos una consuta rápida para traer las especialidades y mostrarlas en el select del formulario
$query = "SELECT id, nombre_especialidad FROM especialidades";
$stmt = $db->prepare($query);
$stmt->execute();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Solicitud</title>
</head>
<body>
    <?php require_once '../menu.php'; ?>
    <h1>Formulario de Nueva Solicitud</h1>

    <form action="../../controlador/controladorIncidencias.php" method="POST">
        <input type="hidden" name="accion" value="crearIncidencia">
        <label for="especialidad_id">Especialidad:</label>
        <select name="especialidad_id" id="especialidad_id" required>
            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['nombre_especialidad']); ?></option>
            <?php } ?>
        </select><br><br>

        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion" required></textarea><br><br>

        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion" id="direccion" required><br><br>

        <label for="fecha_servicio">Fecha de Servicio:</label>
        <input type="datetime-local" name="fecha_servicio" id="fecha_servicio" required><br><br>

        <label for="tipo_urgencia">Tipo de Urgencia:</label>
        <select name="tipo_urgencia" id="tipo_urgencia" required>
            <option value="Estándar">Estándar</option>
            <option value="Urgente">Urgente</option>
        </select><br><br>

        <button type="submit">Crear Solicitud</button>
    </form>
</body>
</html>