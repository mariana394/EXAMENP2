<?php
 function conectar_bd() {
      $conexion_bd = mysqli_connect("mysql1008.mochahost.com","dawbdorg_1704671","1704671","dawbdorg_A01704671");
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

 function consultar_tipos($idLugar=''){
        $conexion_bd = conectar_bd();
        $dml = 'CALL agregaTipo (?,?)';
        $resultado = '<td>';
        $consulta = 'SELECT T.nombre as nombreT, Lt.fechaCreacion as fecha FROM Tipo as T , Lugar_Tipo as Lt WHERE Lt.id_Tipo =T.id and Lt.id_Lugar ='.$idLugar .'';
       
        
        $resultados = $conexion_bd->query($consulta);
        while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
          $resultado .= ''.$row ['nombreT'] .'('.$row['fecha'] .' )  <br>' ;
        }
      
       // echo $consulta;
        return $resultado;
    }

   function consultar_incidentes($lugar=""){
        $conexion_bd = conectar_bd();
       
       $resultado=
        "<table class='highlight'>
            <thead>
                <tr>
                    <th>Lugar</th>
                    <th>Tipo</th>
                 
                </tr>
            </thead>
            <tbody>";
       
           $consulta =  'SELECT DISTINCT L.id as idL,L.nombre as nombreL FROM Lugar as L ,Lugar_Tipo as Lt, Tipo as T WHERE L.id=Lt.id_Lugar and T.id = Lt.id_Tipo' ;
       
       if ($lugar != "") {
            $consulta .= " AND Lt.id_Lugar=".$lugar;
        }
       $consulta .= ' order by Lt.fechaCreacion';
       
       $resultados = $conexion_bd->query($consulta);
       
       while($row = mysqli_fetch_array( $resultados, MYSQLI_BOTH) ){
           $resultado .= '<tr>';
           $resultado .= '<td>'.$row['nombreL'].'</td>';
           $resultado .= consultar_tipos($row['idL']);

           $resultado .= '<a class="waves-effect waves-light btn" href="regitrarTipoI.php?id='.$row['idL'].' " ><i class="material-icons  left">add</i>Registrar tipo Incidente</a>';

           $resultado .=' </td>

           </tr>';
              
       } 
        $resultado .= '</tbody></table>';
        desconectar_bd($conexion_bd);
        return $resultado;
       
   }


    function insertar_tipoIncidente($lugar,$tipo) {
    $conexion_bd = conectar_bd();

    //Prepara la consulta
  

    $dml = 'INSERT INTO Lugar_Tipo (id_Lugar,id_Tipo) VALUES (?,?)';
    if ( !($statement = $conexion_bd->prepare($dml)) ) {
        die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
        return 0;
    }

    //Unir los parámetros de la función con los parámetros de la consulta
    //El primer argumento de bind_param es el formato de cada parámetro
    if (!$statement->bind_param("ii", $lugar,$tipo)) {
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



function insertar_incidente($lugar,$tipo) {
    $conexion_bd = conectar_bd();
      
    
    $dml = 'INSERT INTO Lugar_Tipo (id_Lugar ,id_Tipo) VALUES (?,?)';
 
    if ( !($statement = $conexion_bd->prepare($dml)) ) {
        die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
        return 0;
    }
      
    //Unir los parámetros de la función con los parámetros de la consulta   
    //El primer argumento de bind_param es el formato de cada parámetro
    if (!$statement->bind_param("ii",$lugar,$tipo)) {
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



?>