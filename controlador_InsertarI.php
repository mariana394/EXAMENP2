<?php

 session_start();
  require_once("model.php");


  $lugar = htmlspecialchars($_POST["Lugar"]);
  $tipo = htmlspecialchars($_POST["Tipo"]);

  
      if($_POST["Lugar"] && $_POST["Tipo"]){
      	insertar_incidente($lugar,$tipo);
          $_SESSION["mensaje"] = "Se registró el incidente";
      }
       else {
          $_SESSION["warning"] = "Ocurrió un error al registrar el incidente";
      }
  
//echo "hola";
  header("location: index.php");


?>