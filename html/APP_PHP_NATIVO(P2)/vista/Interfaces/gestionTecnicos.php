<?php
session_start();
if(!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: interfazUsuario.php");
    exit();
}

require_once __DIR__ . '/../../controlador/controladorMaestro.php';
$controlador = new ControladorMaestro();
$tecnicos = $controlador->listarTecnicos();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Técnicos</title>
</head>
<body>
    <?php require_once '../menu.php'; ?>

    <h1>Gestión de Técnicos</h1>

    <h2>Añadir nuevo Técnico</h2>
    <form action="../../controlador/controladorMaestro.php" method="POST">
        <input type="hidden" name="accion" value="crearTecnico">

        <label>Nombre Completo:</label>
        <input type="text" name="nombre_completo" required><br><br>

        <label>Especialidad:</label>
        <select name="especialidad_id" required>
            <option value="">Selecciona una especialidad...</option>
            <?php
            //Hacemos una consulta rápida para traer las especialidades de la BBDD

            require_once __DIR__ . '/../../config/basedatos.php';
            $db = (new Database())->getConexion();
            $stmt = $db->query("SELECT id, nombre_especialidad FROM especialidades");
            while ($esp = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$esp['id']}'>{$esp['nombre_especialidad']}</option>";
            }

            ?>
        </select><br><br>

        <input type="submit" value="Dar de Alta Técnico">
    </form>

    <hr>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre Completo</th>
                <th>Especialidad</th>
                <th>Disponible</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $tecnicos->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['nombre_completo']); ?></td>
                    <td><?php echo htmlspecialchars($row['nombre_especialidad']); ?></td>
                    <td><?php echo htmlspecialchars($row['disponible'] ? 'Sí' : 'No'); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    
</body>
</html>