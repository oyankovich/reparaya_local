<?php

//Si la sesión no está iniciada, la iniciamos
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>

<nav>
    <ul>
        <li><a href="perfil.php">Mi Perfil</a></li>

        <?php if (isset($_SESSION['rol'])): ?>
            
            <!--Si es Administrador:-->
            <?php if ($_SESSION['rol'] === 'administrador'): ?>
                <li><a href="#">Panel de Administración</a></li>
                <li><a href="#">Gestión de Técnicos</a></li>
            <?php endif; ?>

            <!--Si es Técnico:-->
            <?php if ($_SESSION['rol'] === 'tecnico'): ?>
                <li><a href="#"> Mi Agenda</a></li>
            <?php endif; ?>

            <!--Si es Cliente:-->
            <?php if ($_SESSION['rol'] === 'particular'): ?>
                <li><a href="nuevaIncidencia.php">Nueva Incidencia</a></li>
                <li><a href="misIncidencias.php">Mis Incidencias</a></li>
            <?php endif; ?>

            <!--Para todos los roles:-->
            <li><a href="logout.php">Cerrar sesión</a></li>
        
        <?php else: ?>
            <li><a href="interfazUsuario.php">Iniciar sesión</a></li>
        <?php endif; ?>
    </ul>
</nav>