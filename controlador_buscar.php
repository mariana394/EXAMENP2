<?php
	session_start();
	require_once("model.php");
    $estado = htmlspecialchars($_POST["estado"]);
    //echo "Los zombies totales son=".contar_zombies($estado);
    //echo consultar_incidentes($estado);

?>