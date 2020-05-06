<?php
	session_start();
	require_once("model.php");
    $Lugar = htmlspecialchars($_POST["Lugar"]);
    //echo "Los zombies totales son=".contar_zombies($estado);
    echo consultar_incidentes($Lugar);

?>