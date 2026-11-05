<?php 

//1. Iniciamos la sesión
session_start();

//2. Destruimos todas las variables de sesión
$_SESSION = array();

//3. Destruimos la sesión
session_destroy();

//4. Redirigimos al usuario a la página de inicio de sesión
header("Location: interfazUsuario.php");
exit();

?>