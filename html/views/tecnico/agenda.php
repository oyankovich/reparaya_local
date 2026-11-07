<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi agenda</title>
</head>
<body>
    <h1>Mis incidencias asignadas</h1>

    <?php if (!empty($_SESSION['mensaje'])): ?>
        <p><strong><?php echo htmlspecialchars($_SESSION['mensaje']); ?></strong></p>
        <?php unset($_SESSION['mensaje']); ?>
    <?php endif; ?>

    <?php if (empty($incidencias)): ?>
        <p>No tienes incidencias asignadas.</p>
    <?php endif; ?>

    <?php foreach ($incidencias as $inc): ?>
        <div style="border: 1px solid #999; padding: 10px; margin-bottom: 10px;">
            <h3><?php echo htmlspecialchars($inc['localizador']); ?> - <?php echo htmlspecialchars($inc['estado']); ?></h3>
            <p><strong>Fecha:</strong> <?php echo date('d/m/Y H:i', strtotime($inc['fecha_servicio'])); ?></p>
            <p><strong>Urgencia:</strong> <?php echo htmlspecialchars($inc['tipo_urgencia']); ?></p>
            <p><strong>Servicio:</strong> <?php echo htmlspecialchars($inc['servicio']); ?></p>
            <p><strong>Cliente:</strong> <?php echo htmlspecialchars($inc['cliente']); ?></p>
            <p><strong>Dirección:</strong> <?php echo htmlspecialchars($inc['direccion']); ?></p>
            <p><strong>Descripción:</strong> <?php echo nl2br(htmlspecialchars($inc['descripcion'])); ?></p>

            <?php if ($inc['estado'] === 'Asignada'): ?>
                <form method="POST" action="../public/index.php?ruta=tecnico_cambiar_estado">
                    <input type="hidden" name="id" value="<?php echo $inc['id']; ?>">
                    <input type="hidden" name="estado" value="En curso">
                    <button type="submit">Empezar trabajo</button>
                </form>
            <?php endif; ?>

            <?php if ($inc['estado'] === 'En curso'): ?>
                <form method="POST" action="../public/index.php?ruta=tecnico_cambiar_estado">
                    <input type="hidden" name="id" value="<?php echo $inc['id']; ?>">
                    <input type="hidden" name="estado" value="Finalizada">
                    <button type="submit">Marcar como finalizada</button>
                </form>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

    <p><a href="../public/index.php?ruta=inicio">Volver al panel</a></p>
</body>
</html>