<?php
if (isset($_POST['archivo'])) {
    $archivo = $_POST['archivo'];
    if (file_exists("archivos_html/$archivo")) {
        unlink("archivos_html/$archivo");
        echo 1;
    } else {
        echo 0;
    }
}
?>
