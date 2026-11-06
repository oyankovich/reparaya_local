<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Avisos - ReparaYa</title>
    <style>
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Mis Incidencias</h2>
    
    <?php if (empty($incidencias)): ?>
        <p>Aún no tienes incidencias registradas.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Localizador</th>
                    <th>Fecha Servicio</th>
                    <th>Urgencia</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($incidencias as $incidencia): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($incidencia['localizador']); ?></td>
                        <td><?php echo htmlspecialchars($incidencia['fecha_servicio']); ?></td>
                        <td><?php echo htmlspecialchars($incidencia['tipo_urgencia']); ?></td>
                        <td><strong><?php echo htmlspecialchars($incidencia['estado']); ?></strong></td>
                        <td>
                            <a href="../public/index.php?ruta=detalle_incidencia&id=<?php echo $incidencia['id']; ?>">Ver detalle</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    
    <br>
    <a href="../public/index.php?ruta=inicio">Volver al Panel</a>
</body>
</html>