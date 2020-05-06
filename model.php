<?php
 function conectar_bd() {
      $conexion_bd = mysqli_connect("localhost","root","","EXP2");
      if ($conexion_bd == NULL) {
          die("No se pudo conectar con la base de datos");
      }
      return $conexion_bd;
  }

  //función para desconectarse de una bd
  //@param $conexion: Conexión de la bd que se va a cerrar
  function desconectar_bd($conexion_bd) {
      mysqli_close($conexion_bd);
  }

 function consultar_estados($idZombie=''){
        $conexion_bd = conectar_bd();
        $resultado = '<td>';
        $consulta = 'SELECT E.nombre as nombreE, T.fechaCreacion as fecha   
        			 FROM estado as E , tiene as T 
        			 WHERE T.id_estado =E.id and T.id_zombie ='.$idZombie.'';
        
        $resultados = $conexion_bd->query($consulta);
        while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
          $resultado .= ''.$row ['nombreE'] .'('.$row['fecha'] .')<br>' ;
        }
      
       // echo $consulta;
        return $resultado;
    }

   function consultar_zombies($estado=""){
        $conexion_bd = conectar_bd();
       
       $resultado=
        "<table class='highlight'>
            <thead>
                <tr>
                    <th>Zombie</th>
                    <th>Estados</th>
                </tr>
            </thead>
            <tbody>";
       
           $consulta = 'select distinct Z.id as idZ, Z.nombre as nombreZ 
                from zombie as Z,estado as E ,tiene as T
                where Z.id=T.id_zombie and E.id = T.id_estado ';
       
        if ($estado != "") {
            $consulta .= " AND T.id_estado=".$estado;
        }
       $consulta .= ' order by T.fechaCreacion';
       
       $resultados = $conexion_bd->query($consulta);
       
       while($row = mysqli_fetch_array( $resultados, MYSQLI_BOTH) ){
           $resultado .= '<tr>';
           $resultado .= '<td>'.$row['nombreZ'].'</td>';
           $resultado .= consultar_estados($row['idZ']);
           $resultado .= '<a class="waves-effect waves-light btn" href="form_RegistrarEstado.php?id='.$row['idZ'].' " ><i class="material-icons  left">add</i>Registrar estado</a>';
           $resultado .=' </td>
           </tr>';
              
       } 
        $resultado .= '</tbody></table>';
        desconectar_bd($conexion_bd);
        return $resultado;
       
   }


    function insertar_estado($idZ,$idE) {
    $conexion_bd = conectar_bd();

    //Prepara la consulta
  

    $dml = 'INSERT INTO tiene (id_zombie,id_estado) VALUES (?,?)';
    if ( !($statement = $conexion_bd->prepare($dml)) ) {
        die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
        return 0;
    }

    //Unir los parámetros de la función con los parámetros de la consulta
    //El primer argumento de bind_param es el formato de cada parámetro
    if (!$statement->bind_param("ii", $idZ,$idE)) {
        die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
        return 0;
    }

    //Executar la consulta
    if (!$statement->execute()) {
      die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
        return 0;
    }
desconectar_bd($conexion_bd);
    return 1;
  }



function insertar_zombie($nombre,$id_estado) {
    $conexion_bd = conectar_bd();
      
    //Prepara la consulta
    $dml = 'INSERT INTO zombie (nombre) VALUES (?) ';
   
    if ( !($statement = $conexion_bd->prepare($dml)) ) {
        die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
        return 0;
    }
      
    //Unir los parámetros de la función con los parámetros de la consulta   
    //El primer argumento de bind_param es el formato de cada parámetro
    if (!$statement->bind_param("s",$nombre)) {
        die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
        return 0;
    }
      
    //Executar la consulta
    if (!$statement->execute()) {
      die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
        return 0;
    }
      
      //seleccionar id de zombie
   $consulta = "select id from  zombie where nombre='".$nombre ."'";
    echo $consulta;
    $resultados = $conexion_bd->query($consulta);
    while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
      $resultado = $row["id"];
    }
      
      
      echo $resultado;
      
      
          //seleccionar id de zombie
    $dml = 'INSERT INTO tiene (id_zombie ,id_estado) VALUES (?,?)';
 
    if ( !($statement = $conexion_bd->prepare($dml)) ) {
        die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
        return 0;
    }
      
    //Unir los parámetros de la función con los parámetros de la consulta   
    //El primer argumento de bind_param es el formato de cada parámetro
    if (!$statement->bind_param("ii",$resultado,$id_estado)) {
        die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
        return 0;
    }
      
    //Executar la consulta
    if (!$statement->execute()) {
      die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
        return 0;
    }
    desconectar_bd($conexion_bd);
      return 1;
  }
  function crear_select($id, $columna_descripcion, $tabla, $seleccion=0) {
    $conexion_bd = conectar_bd();  
      
      
    $resultado = '<div class="input-field"><select name="'.$tabla.'" id="'.$tabla.'"><option value="" disabled selected>Selecciona una opción</option>';
    
            
    $consulta = "SELECT $id  , $columna_descripcion  FROM $tabla";
    $resultados = $conexion_bd->query($consulta);
    while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {

      $resultado .= '<option value="'.$row["$id"].'">'.$row["$columna_descripcion"].'</option>';
       
    }
        
    desconectar_bd($conexion_bd);
    $resultado .=  '</select><label>'.$tabla.'...</label></div>';
    return $resultado;
  }

function contar_zombies($estado){
        $conexion_bd = conectar_bd();
        
        if ($estado != "") {
            $consulta = "select COUNT(Z.nombre) as zombies, T.fechaCreacion as fecha from zombie as Z , tiene as T where Z.id=T.id_zombie and T.id_estado =$estado;";
        }else{
            $consulta = 'select count(*) as zombies from zombie ';
        }
        
        $resultados = $conexion_bd->query($consulta);
       
       while($row = mysqli_fetch_array( $resultados, MYSQLI_BOTH) ){
           $resultado = $row['zombies'];
       } 

        desconectar_bd($conexion_bd);
        return $resultado;
    }

?>