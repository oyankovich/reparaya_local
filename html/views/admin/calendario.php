<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calendario de Incidencias - ReparaYa</title>
    
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendario');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: <?php echo $eventos_json; ?>,
                
                eventClick: function(info) {
                    var props = info.event.extendedProps;
                    var fecha = info.event.start.toLocaleString('es-ES');
                    
                    alert(
                        "DETALLE DE LA AVERÍA\n\n" +
                        "Estado/Tipo: " + info.event.title + "\n" +
                        "Fecha: " + fecha + "\n" +
                        "Cliente: " + props.cliente + "\n" +
                        "Especialidad: " + props.especialidad + "\n" +
                        "Dirección: " + props.direccion + "\n" +
                        "Descripción: " + props.descripcion
                    );
                }
            });

            calendar.render();
        });
    </script>

    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        #calendario { max-width: 1000px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    </style>
</head>
<body style="background: #f4f4f9;">
    
    <div style="max-width: 1000px; margin: 0 auto 20px auto;">
        <h2>Planificación de Servicios (Calendario)</h2>
        <a href="index.php?ruta=panel_admin" style="padding: 10px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px;">← Volver al Panel Global</a>
        
        <span style="margin-left: 20px; padding: 5px 10px; background: #dc3545; color: white; border-radius: 3px;">■ Urgentes</span>
        <span style="margin-left: 10px; padding: 5px 10px; background: #0d6efd; color: white; border-radius: 3px;">■ Estándar</span>
    </div>

    <div id="calendario"></div>

</body>
</html>