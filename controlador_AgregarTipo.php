<?php
    session_start();
    require_once("model.php");  
    $idLugar = htmlspecialchars($_POST["id"]);
   
    $tipo = htmlspecialchars($_POST["Tipo"]);
       // echo "este es el nombre".$idZ ;
        //echo  "<br>este es el estado".$estado;

      if(isset($_POST["Tipo"])) {
          if (insertar_tipoIncidente($idLugar , $tipo))  {
              $_SESSION["mensaje"] = "Se registró el nuevo estado";
          } else {
              $_SESSION["warning"] = "Ocurrió un error al registrar el estado";
          }
      }
      else{
       $_SESSION["warning"] = "Ocurrió un error al registrar el estado";
      }

      header("location:index.php");
?>