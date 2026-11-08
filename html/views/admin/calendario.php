<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calendario de incidencias</title>
    <!-- Librería FullCalendar para mostrar el calendario -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.15/locales/es.global.min.js"></script>
    <style>
        .fc-event-title, .fc-event-time { white-space: normal; }
    </style>
</head>
<body>
    <h1>Calendario de incidencias</h1>

    <p>
        <span style="background: #d9534f; color: white; padding: 3px 8px;">Urgente</span>
        <span style="background: #337ab7; color: white; padding: 3px 8px;">Estándar</span>
    </p>

    <div id="calendario" style="max-width: 1000px;"></div>

    <p>
        <a href="../public/index.php?ruta=gestionar_incidencias">Ver listado</a> |
        <a href="../public/index.php?ruta=inicio">Volver al panel</a>
    </p>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendario = new FullCalendar.Calendar(document.getElementById('calendario'), {
                locale: 'es',
                initialView: 'dayGridMonth',
                 eventDisplay: 'block',
                // En la vista de mes no mostramos la hora, se ve en semana y día
                views: { dayGridMonth: { displayEventTime: false } },
                
                // Botones para cambiar entre vista mensual, semanal y diaria
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                // Los eventos los prepara el controlador en PHP
                events: <?php echo json_encode($eventos); ?>
            });
            calendario.render();
        });
    </script>
</body>
</html>