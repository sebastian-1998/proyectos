<?php
//creamos las variables necesarias
$destinatario = "sodokoy336@quick-mail.cc";
$asunto = "Prueba de email";
$mensaje = "Correo de prueba";
//llamamos a la(s) funcion(es) de php para enviar e-mail y le pasamos los parametros necesarios
$exito = mail($destinatario, $asunto, $mensaje);
//se evalua si el email se a enviado o no
if($exito){
    //si se a enviado se muestra este mensaje
    echo 'EMAIL ENVIADO';
}  else {
    //si no se envio se muestra este otro mensaje
    echo 'EMAIL FALLIDO';
}