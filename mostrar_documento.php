<?php
$directorio_escaneado = scandir('archivos_subidos');
$archivos1 = "";
foreach ($directorio_escaneado as $item) {
    if ($item != '.' and $item != '..') {
        echo $archivos1 = $item;
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
         echo $datos[$columna] . "<br>";
     }
}
//Cerramos el archivo
fclose($archivo);
?>