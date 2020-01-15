<?php
include_once 'app/config.inc.php';
include_once 'app/Conexion.inc.php';
include_once 'app/Usuario.inc.php';
include_once 'app/RecuperacionClave.inc.php';
include_once 'app/RepositorioUsuario.inc.php';
include_once 'app/RepositorioRecuperacionClave.inc.php';
include_once 'app/Redireccion.inc.php';

function sa($longitud) {
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $numero_caracteres = strlen($caracteres);
    $string_aleatorio = '';
    
    for ($i = 0; $i < $longitud; $i++) {
        $string_aleatorio .= $caracteres[rand(0, $numero_caracteres - 1)];
    }
    
    return $string_aleatorio;
}
//se evalua si se a presionado o no el boton
if (isset($_POST['enviar_email'])) {
	$email = $_POST['email'];
//se abre la conexion
	Conexion::abrir_conexion();
//se evalua si el email no existe
	if (!RepositorioUsuario :: email_existe(Conexion :: obtener_conexion(), $email)) {
		return;
	}
//se llama al metodo necesario
	$usuario = RepositorioUsuario :: obtener_usuario_por_email(Conexion :: obtener_conexion(), $email);
//se llama al metodo para obtener el nombre
	$nombre_usuario = $usuario -> obtener_nombre();
        //se crea una variable y como valor se le pasa la funcion y se indica el maximo de caracteres
	$string_aleatorio = sa(10);
        //se crea la url al concatenar el string aleatorio con el nombre de usuario
	$url_secreta = hash('sha256', $string_aleatorio . $nombre_usuario);
//se llama al metodo para insertar los datos
	$peticion_generada = RepositorioRecuperacionClave :: generar_peticion(Conexion :: obtener_conexion(), $usuario -> obtener_id(), $url_secreta);
//se cierra la conexion
	Conexion :: cerrar_conexion();

	//si la peticion es correcta se redirige al servidor
	if ($peticion_generada) {
		Redireccion :: redirigir(SERVIDOR);
	}
}