<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario de Incidencias - ReparaYa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold" href="index.php?ruta=panel_admin">ReparaYa | Panel de Administracion</a>
            
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?ruta=admin_crear_incidencia">Crear Nueva Incidencia</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?ruta=gestion_tecnicos">Gestion de Tecnicos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php?ruta=calendario_admin">Ver Calendario</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center text-white">
                    <span class="me-3">Admin: <span class="text-info fw-bold"><?php echo htmlspecialchars($_SESSION['nombre']); ?></span></span>
                    <a href="index.php?ruta=logout" class="btn btn-outline-danger btn-sm">Cerrar Sesion</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid px-4">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-secondary mb-0">Calendario de Intervenciones</h3>
        </div>

        <div class="card shadow-sm border-0 mb-5">
            <div class="card-body p-4">
                <div id="calendario"></div>
            </div>
        </div>
        
    </div>

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
                buttonText: {
                    today: 'Hoy',
                    month: 'Mes',
                    week: 'Semana',
                    day: 'Dia'
                },
                events: <?php echo $eventos_json; ?>,
                
                eventClick: function(info) {
                    var props = info.event.extendedProps;
                    
                    var detalles = "Estado y Urgencia: " + info.event.title + "\n\n" +
                                   "Cliente: " + props.cliente + "\n" +
                                   "Direccion: " + props.direccion + "\n" +
                                   "Especialidad: " + props.especialidad + "\n\n" +
                                   "Descripcion:\n" + props.descripcion;
                                   
                    alert(detalles);
                }
            });
            
            calendar.render();
        });
    </script>
</body>
</html>