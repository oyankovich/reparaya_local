<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Incidencia - ReparaYa</title>
</head>
<body>
    <h2>Solicitar Nueva Asistencia</h2>
    
    <form action="../public/index.php?ruta=procesar_incidencia" method="POST">
        
        <label for="especialidad_id">Tipo de servicio (Especialidad):</label><br>
        <select id="especialidad_id" name="especialidad_id" required>
            <option value="1">Fontanería</option>
            <option value="2">Electricidad</option>
            <option value="3">Climatización</option>
        </select><br><br>

        <label for="tipo_urgencia">Nivel de urgencia:</label><br>
        <select id="tipo_urgencia" name="tipo_urgencia" required>
            <option value="Estándar">Estándar</option>
            <option value="Urgente">Urgente</option>
        </select><br><br>

        <label for="fecha_servicio">Fecha y Hora de la cita:</label><br>
        <input type="datetime-local" id="fecha_servicio" name="fecha_servicio" required><br><br>

        <label for="direccion">Dirección completa:</label><br>
        <input type="text" id="direccion" name="direccion" required><br><br>

        <label for="descripcion">Descripción de la avería (Por favor, incluye tu teléfono de contacto aquí):</label><br>
        <textarea id="descripcion" name="descripcion" rows="5" cols="40" required></textarea><br><br>

        <button type="submit">Registrar Incidencia</button>
    </form>
    
    <br>
    <a href="../public/index.php?ruta=inicio">Volver al Panel</a>
</body>
</html>