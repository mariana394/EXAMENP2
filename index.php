<?php

//una prueba
    session_start();
    require_once("model.php");
    $titulo= "Bienvenido a Jurassic Park";
    
    include("_header.html");
    include("botonA.html");

    include("busqueda.html");


    if (isset($_POST["Lugar"])) {
          $Lugar = htmlspecialchars($_POST["Lugar"]);
      } else {
          $Lugar = "";
      }
    
   echo '<div id="resultados_consulta">';
    //echo "Los zombies totales son=".contar_zombies($estado);   
    echo consultar_incidentes($Lugar);
    echo '</div>';
    include("_footer.html");


?>