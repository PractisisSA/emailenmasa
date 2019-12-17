<?php

require_once('lib/PHPMailer/class.phpmailer.php');
include("lib/PHPMailer/class.smtp.php");

 include('conect.php');

 $id_lista=$_POST['id_lista'];
 $envioseleccion=$_POST['envioseleccion'];


$conexion = conectar_PostgreSQL( "postgres", "postgres", "localhost", "email_masivo" );
/*******************************************************************************************/
/////////////////////////////////Correo General/////////////////////////////////////////////
/******************************************************************************************/



$rs=selectListaId( $conexion, $id_lista);
 
while( $objFila = pg_fetch_object($rs) ){

$asunto=$objFila->titulo;

}

   
$correohtml=selectPlantilla( $conexion, $id_lista);


 


$mail  = new PHPMailer();

//asigna a $body el contenido del correo electrónico
$body = $correohtml; 

// Indica que se usará SMTP para enviar el correo
$mail->IsSMTP(); 

$mail->SMTPDebug  = 2;                     
// Activar los mensajes de depuración, 
// muy útil para saber el motivo si algo sale mal
// 1 = errores y mensajes
// 2 = solo mensajes entre el servidor u la clase PHPMailer

$mail->SMTPAuth = true;
// Activar autenticación segura a traves de SMTP, necesario para gmail

$mail->SMTPSecure = "tls";
// Indica que la conexión segura se realizará mediante TLS

$mail->Host = "smtp.gmail.com";
// Asigna la dirección del servidor smtp de GMail

$mail->Port = 587;
// Asigna el puerto usado por GMail para conexion con su servidor SMTP

$mail->Username = "marketing@practisis.com";  
// Indica el usuario de gmail a traves del cual se enviará el correo

$mail->Password = "practisismkt18";
// GMAIL password
/////////////////////////////////////////////////////////////////
//////////////////////General///////////////////////////////////
if($envioseleccion==''){

	
   $rs1=selectCorreo( $conexion, $id_lista);

   //$totalCorreos=pg_num_rows($correos);
while( $objFila1 = pg_fetch_object($rs1) ){
$mail->SetFrom('marketing@practisis.com', 'Marketing Practisis'); 
//Asignar la dirección de correo y el nombre del contacto que aparecerá cuando llegue el correo

///////////////////////////////////////////////////////////////////
$mail->Subject = $asunto; 
//Asignar el asunto del correo

$mail->MsgHTML($body); 
//Si deseas enviar un correo con formato HTML debes descomentar la linea anterior

$mail->AddAddress($objFila1->direccion, $objFila1->nombre); 
//Indica aquí la dirección que recibirá el correo que será enviado

if(!$mail->Send()) {
  echo "Error enviando correo: " . $mail->ErrorInfo;
} else {
  echo "Correo enviado!!!";
  $mail->ClearAddresses(); 
}
}
}else{


 $correosenviados = explode(",", $envioseleccion);
 $cont=count($correosenviados);
		for($a=0;$a<$cont;$a++){
			
		$idCorreo=$correosenviados[$a];

	
 $rs2=selectCorreoid( $conexion, $idCorreo);
   //$totalCorreos=pg_num_rows($correos);
while( $objFila1 = pg_fetch_object($rs2) ){
$mail->SetFrom('marketing@practisis.com', 'Marketing Practisis'); 
//Asignar la dirección de correo y el nombre del contacto que aparecerá cuando llegue el correo

///////////////////////////////////////////////////////////////////
$mail->Subject = $asunto; 
//Asignar el asunto del correo

$mail->MsgHTML($body); 
//Si deseas enviar un correo con formato HTML debes descomentar la linea anterior

$mail->AddAddress($objFila1->direccion, $objFila1->nombre); 
//Indica aquí la dirección que recibirá el correo que será enviado

if(!$mail->Send()) {
  echo "Error enviando correo: " . $mail->ErrorInfo;
} else {
  echo "Correo enviado!!!";
  $mail->ClearAddresses(); 
}

}
	}
}
?>