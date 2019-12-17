<?php

//print_r($_POST);
 include('conect.php');
  $conexion = conectar_PostgreSQL( "postgres", "postgres", "localhost", "email_masivo" );


  $nombre=$_POST['nombre'];
  $titulo=$_POST['titulo'];
  $comentario=$_POST['comentario'];
  $id_lista=insertarLista( $conexion, $nombre, $titulo,$comentario );


  

$directorio_escaneado = scandir('archivos_subidos');
$archivos1 = "";
foreach ($directorio_escaneado as $item) {
    if ($item != '.' and $item != '..') {
        $archivos1 = $item;
    }
}


$linea = 0;
//Abrimos nuestro archivo
$archivo = fopen("archivos_subidos/".$archivos1."", "r");

//Lo recorremos
while (($datos = fgetcsv($archivo, ",")) == true) 
{
  $num = count($datos);
  $linea++;
  //Recorremos las columnas de esa linea
  for ($columna = 0; $columna < $num; $columna++) 
      {
        $nombre=$datos[$columna];
        $direccion=$datos[$columna+1];

         insertarCorreo( $conexion, $nombre, $direccion , $id_lista);
		$columna++;        

     }
}
//Cerramos el archivo
fclose($archivo);




if($_POST['opc']==1){
$codigohtml1=file_get_contents($_POST['url']);

}
if($_POST['opc']==2){
$codigohtml1=$_POST['codigo'];

}
if($_POST['opc']==3){
  $directorio_escaneado = scandir('archivos_html');

foreach ($directorio_escaneado as $item) {
    if ($item != '.' and $item != '..') {
        $archivos = $item;
    }
}
  $codigohtml1=file_get_contents('archivos_html/'.$archivos.'');

}

$codigohtml= base64_encode($codigohtml1);

insertarPlantilla( $conexion, $codigohtml, $id_lista);


$nombresesion="archivohtml.html";
$nombresesion2="archivocsv.csv";

if (file_exists("archivos_subidos/$nombresesion2")) {
        unlink("archivos_subidos/$nombresesion2");
        
    }

if (file_exists("archivos_html/$nombresesion")) {
        unlink("archivos_html/$nombresesion");
      
    } 

    echo "<script>

    alert('Lista Guardada Correctamente');
    window.location.href = 'principal.php';
    </script>

    ";

?>