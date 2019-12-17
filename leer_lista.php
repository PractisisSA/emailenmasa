<?php

//print_r($_POST);

 include('conect.php');
 
$conexion = conectar_PostgreSQL( "postgres", "postgres", "localhost", "email_masivo" );

$id_lista=$_POST['id_lista'];
 
echo $plantilla=selectPlantilla( $conexion, $id_lista);



?>