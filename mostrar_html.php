<?php
if($_POST['dato']==1){
echo file_get_contents($_POST['codigo']);

}
if($_POST['dato']==2){
echo $_POST['codigo'];

}
if($_POST['dato']==3){

echo file_get_contents('archivos_html/'.$_POST['codigo'].'');

}
?>
