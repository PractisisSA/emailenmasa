<?php
if (isset($_FILES['archivo2'])) {
$nombresesion="archivohtml";
$directorio_escaneado = scandir('archivos_html');
$contador=0;
$archivos = array();
foreach ($directorio_escaneado as $item) {
    if ($item != '.' and $item != '..') {
        $contador=$contador+1;
    }
}

    if($contador==0){
    $archivo = $_FILES['archivo2'];
    $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
    $time = time();
    $nombre = "$nombresesion.$extension";
    if (move_uploaded_file($archivo['tmp_name'], "archivos_html/$nombre")) {
        echo 1;
    } else {
        echo 0;
    }
}else{

    echo "Ya existe un archivo";
}
}
?>
