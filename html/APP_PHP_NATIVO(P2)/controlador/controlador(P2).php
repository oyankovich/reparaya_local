
    <!--ESTA ES UNA PRUEBA PARA LA PARTE DEL CONTROLADOR YA QUE NO SE SI USAR UNA NUEVA O UTILIZAR EL ARCHIVO INDex.php-->

    <?php
    //incluimos el archivo de la base de datos
    require_once '../config/basedatos.php';

    //Instanciamos la clase parala base de datos
    $database = new Database();
    $db = $database->getConexion();

    if($db) {
        echo "<h1>¡Conexión a la base de datos éxitosa! </h1>";
    } else {
        echo "<h1>Error al conectar a la base de datos </h1>";
    }
    
    ?>