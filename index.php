<?php

//una prueba
    session_start();
    require_once("model.php");
    $titulo= "Pagina principal";
    
    include("_header.html");

   // include("busqueda.html");

    include("botonA.html");

    if (isset($_POST["estado"])) {
          $estado = htmlspecialchars($_POST["estado"]);
      } else {
          $estado = "";
      }
    
   echo '<div id="resultados_consulta">';
    //echo "Los zombies totales son=".contar_zombies($estado);   
    echo consultar_incidentes($estado);
    echo '</div>';
    include("_footer.html");


?>