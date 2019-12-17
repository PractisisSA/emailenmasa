    <?php
    // Conectar (se detendrá la ejecución si se produce un error) - * RELLENA LOS DATOS QUE FALTAN *:
    

        function conectar_PostgreSQL( $usuario, $pass, $host, $bd )
        {
             $conexion = null;
            try
            {
                $conexion = pg_connect( "user=".$usuario." ".
                                                         "password=".$pass." ".
                                                         "host=".$host." ".
                                                         "dbname=".$bd
                                                       );
                if( $conexion == false )
                     throw new Exception( "Error PostgreSQL ".pg_last_error() );
            }
            catch( Exception $e )
            {
                 throw $e;
            }
            return $conexion;
        }

        function generate_random_key() {
    $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
 
    $new_key = "";
    for ($i = 0; $i < 32; $i++) {
        $new_key .= $chars[rand(0,35)];
    }
    return $new_key;
}


        function listarPersonas( $conexion )
  {
    $sql = "SELECT * FROM usuario ORDER BY id";
    $ok = true;

    // Ejecutar la consulta:
    $rs = pg_query( $conexion, $sql );

    if( $rs )
    {
      // Obtener el número de filas:
      if( pg_num_rows($rs) > 0 )
      {
        echo "<p/>LISTADO DE PERSONAS<br/>";
        echo "===================<p />";

        // Recorrer el resource y mostrar los datos:
        while( $objFila = pg_fetch_object($rs) )
          echo $objFila->id." - ".$objFila->usuario."<br />";
      }
      else
        echo "No se encontraron personas<br />";
    }
    else
      $ok = false;

    return $ok;
  }

  function insertarUsuario( $conexion, $correo, $pass )
    {

        $sql = "SELECT * FROM usuario WHERE usuario='".$correo."'";
        // Ejecutar la consulta:
        $rs = pg_query($conexion,$sql);

        if(pg_num_rows($rs)==0){

         $random_key=generate_random_key(); 

      $sql = "INSERT INTO usuario (usuario, password, activacion) VALUES ('".$correo."', '".$pass."', '".$random_key."')";

        // Ejecutamos la consulta (se devolverá true o false):
        $exe=pg_query($conexion, $sql);

        return 1;
        }else{

            return 0;
        }
    }

    function validaUsuario( $conexion, $correo, $password )
    {
        $sql = "SELECT id,usuario FROM usuario WHERE usuario='".$correo."' and password='".$password."'";
        $devolver = null;

        // Ejecutar la consulta:
        $rs = pg_query( $conexion, $sql );

        if( $rs )
        {
            // Si se encontró el registro, se obtiene un objeto en PHP con los datos de los campos:
            if( pg_num_rows($rs) > 0 )
                $objPersona = pg_fetch_object( $rs, 0 );
            session_start();
            $_SESSION["usuario"]=$objPersona->usuario;
            $devolver=$objPersona->usuario;
        }

        return $devolver;
    }


    function listarPeliculas( $conexion )
  {
    $sql = "SELECT * FROM peliculas ORDER BY id";
    $ok = true;

    // Ejecutar la consulta:
    $rs = pg_query( $conexion, $sql );

    if( $rs )
    {
      // Obtener el número de filas:
      if( pg_num_rows($rs) > 0 )
      {
        /*echo "<p/>LISTADO DE PERSONAS<br/>";
        echo "===================<p />";*/
        return $rs;
        // Recorrer el resource y mostrar los datos:
        /*while( $objFila = pg_fetch_object($rs) )
          echo $objFila->id." - ".$objFila->nombre."<br />";*/
      }
      else
        echo "No se encontraron Peliculas<br />";
    }
    else
      $ok = false;

    return $ok;
  }
  
  function listarPeliculasLimit($conexion, $limit, $offset)
  {
    $sql = "SELECT * FROM peliculas ORDER BY id limit ".$limit." offset ".$offset."";
    $ok = true;

    // Ejecutar la consulta:
    $rs = pg_query( $conexion, $sql );

    if( $rs )
    {
      // Obtener el número de filas:
      if( pg_num_rows($rs) > 0 )
      {
        /*echo "<p/>LISTADO DE PERSONAS<br/>";
        echo "===================<p />";*/
        return $rs;
        // Recorrer el resource y mostrar los datos:
        /*while( $objFila = pg_fetch_object($rs) )
          echo $objFila->id." - ".$objFila->nombre."<br />";*/
      }
      else
        echo "No se encontraron Peliculas<br />";
    }
    else
      $ok = false;

    return $ok;
  }


function peliculaportada( $conexion )
  {
    $sql = "SELECT * FROM peliculas where portada=true";
    $ok = true;

    // Ejecutar la consulta:
    $rs = pg_query( $conexion, $sql );

    if( $rs )
    {
      // Obtener el número de filas:
      if( pg_num_rows($rs) > 0 )
      {
        /*echo "<p/>LISTADO DE PERSONAS<br/>";
        echo "===================<p />";*/
        return $rs;
        // Recorrer el resource y mostrar los datos:
        /*while( $objFila = pg_fetch_object($rs) )
          echo $objFila->id." - ".$objFila->nombre."<br />";*/
      }
      else
        echo "No se encontraron Peliculas<br />";
    }
    else
      $ok = false;

    return $ok;
  }
  
  
  
   function selectPeliculas( $conexion, $id )
  {
    $sql = "SELECT * FROM peliculas where id=".$id." ORDER BY id";
    $ok = true;

    // Ejecutar la consulta:
    $rs = pg_query( $conexion, $sql );

    if( $rs )
    {
      // Obtener el número de filas:
      if( pg_num_rows($rs) > 0 )
      {
        /*echo "<p/>LISTADO DE PERSONAS<br/>";
        echo "===================<p />";*/
        return $rs;
        // Recorrer el resource y mostrar los datos:
        /*while( $objFila = pg_fetch_object($rs) )
          echo $objFila->id." - ".$objFila->nombre."<br />";*/
      }
      else
        echo "No se encontraron Peliculas<br />";
    }
    else
      $ok = false;

    return $ok;
  }

  function insertarLista( $conexion, $nombre, $titulo, $comentario )
    {

        
      $sql = "INSERT INTO lista (nombre, titulo, comentario) VALUES ('".$nombre."', '".$titulo."', '".$comentario."') returning id";

        // Ejecutamos la consulta (se devolverá true o false):
        $exe=pg_query($conexion, $sql);
        $new_id = pg_fetch_array($exe);
        return $new_id['id'];
        
    }


function insertarCorreo( $conexion, $nombre, $direccion , $id_lista)
    {

        
      $sql = "INSERT INTO correo (nombre, direccion, id_lista) VALUES ('".$nombre."', '".$direccion."',$id_lista) returning id";

        // Ejecutamos la consulta (se devolverá true o false):
        $exe=pg_query($conexion, $sql);
        $new_id = pg_fetch_array($exe);
        return $new_id['id'];
        
    }

function insertarPlantilla( $conexion, $codigo, $id_lista)
    {

      $codigo=pg_escape_bytea($codigo);
        
     $sql = "INSERT INTO plantilla (codigo, id_lista) VALUES ('".$codigo."',$id_lista) returning id";

        // Ejecutamos la consulta (se devolverá true o false):
        $exe=pg_query($conexion, $sql);
        $new_id = pg_fetch_array($exe);
        return $new_id['id'];
        
    }



function selectPlantilla( $conexion, $id_lista)
    {

     
        
     $sql = "SELECT * from plantilla where id_lista=".$id_lista."  ORDER BY id";

    $ok = true;

    // Ejecutar la consulta:
    $rs = pg_query( $conexion, $sql );

   if( $rs )
    {
      // Obtener el número de filas:
      if( pg_num_rows($rs) > 0 )
      {
        /*echo "<p/>LISTADO DE PERSONAS<br/>";
        echo "===================<p />";*/
        //return $rs;
        // Recorrer el resource y mostrar los datos:
        while( $objFila = pg_fetch_object($rs) )
         $ok= base64_decode(pg_unescape_bytea($objFila->codigo));
      
    }
    else{
      $ok = false;
    }

    return $ok;

       
        
        }else{


        echo "No existen Plantillas<br />";
        }
    }


    function selectLista( $conexion)
    {

     
        
     $sql = "SELECT * from lista  ORDER BY id";

    $ok = true;

    // Ejecutar la consulta:
    $rs = pg_query( $conexion, $sql );

   if( $rs )
    {
      // Obtener el número de filas:
      if( pg_num_rows($rs) > 0 )
      {
        /*echo "<p/>LISTADO DE PERSONAS<br/>";
        echo "===================<p />";*/
        return $rs;
        // Recorrer el resource y mostrar los datos:
        /*while( $objFila = pg_fetch_object($rs) )
         $ok= base64_decode(pg_unescape_bytea($objFila->codigo));*/
      
    }
    else{
      $ok = false;
    }

    return $ok;

       
        
        }else{


        echo "No existen Plantillas<br />";
        }
    }

    function selectListaId( $conexion, $id_lista)
    {

     
        
     $sql = "SELECT * from lista where id=".$id_lista." ORDER BY id";

    $ok = true;

    // Ejecutar la consulta:
    $rs = pg_query( $conexion, $sql );

   if( $rs )
    {
      // Obtener el número de filas:
      if( pg_num_rows($rs) > 0 )
      {
        /*echo "<p/>LISTADO DE PERSONAS<br/>";
        echo "===================<p />";*/
        return $rs;
        // Recorrer el resource y mostrar los datos:
        /*while( $objFila = pg_fetch_object($rs) )
         $ok= base64_decode(pg_unescape_bytea($objFila->codigo));*/
      
    }
    else{
      $ok = false;
    }

    return $ok;

       
        
        }else{


        echo "No existen Plantillas<br />";
        }
    }

function selectCorreo( $conexion, $id_lista)
    {

     
        
     $sql = "SELECT * from correo  where id_lista=".$id_lista."  ORDER BY id";

    $ok = true;

    // Ejecutar la consulta:
    $rs = pg_query( $conexion, $sql );

   if( $rs )
    {
      // Obtener el número de filas:
      if( pg_num_rows($rs) > 0 )
      {
        /*echo "<p/>LISTADO DE PERSONAS<br/>";
        echo "===================<p />";*/
        return $rs;
        // Recorrer el resource y mostrar los datos:
        /*while( $objFila = pg_fetch_object($rs) )
         $ok= base64_decode(pg_unescape_bytea($objFila->codigo));*/
      
    }
    else{
      $ok = false;
    }

    return $ok;

       
        
        }else{


        echo "No existen Correos<br />";
        }
    }


function selectCorreoid( $conexion, $id)
    {

     
        
     $sql = "SELECT * from correo  where id=".$id."  ORDER BY id";

    $ok = true;

    // Ejecutar la consulta:
    $rs = pg_query( $conexion, $sql );

   if( $rs )
    {
      // Obtener el número de filas:
      if( pg_num_rows($rs) > 0 )
      {
        /*echo "<p/>LISTADO DE PERSONAS<br/>";
        echo "===================<p />";*/
        return $rs;
        // Recorrer el resource y mostrar los datos:
        /*while( $objFila = pg_fetch_object($rs) )
         $ok= base64_decode(pg_unescape_bytea($objFila->codigo));*/
      
    }
    else{
      $ok = false;
    }

    return $ok;

       
        
        }else{


        echo "No existen Correos<br />";
        }
    }

    ?>