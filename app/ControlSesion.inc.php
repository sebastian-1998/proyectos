<?php
class ControlSesion{
    //creamos los metodos necesarios
    public static function iniciar_sesion($id_usuario, $nombre_usuario) {
        //$_SESSION -> crea y controla las sesiones en las paginas web
        //iniciamos la sesion evaluando si ya se a iniciado o no
        if(session_id() == ''){
            //si el if se cumple entonces se crea la sesion
            session_start();
        }
        //le asignamos un nombre a la sesion y un valor
        $_SESSION['id_usuario'] = $id_usuario;
        $_SESSION['nombre_usuario'] = $nombre_usuario;
    }
    //metodo para cerrar la sesion
    public static function cerrar_sesion(){
        //evaluamos si la sesion ya se a iniciado o no
        if(session_id() == ''){
            //si el if se cumple entonces la sesion ya se inicio
            session_start();
        }
        //borramos las cokiees de la sesion
        if(isset($_SESSION['id_usuario'])){
            //se borran las cokiees asociadas
            unset($_SESSION['id_usuario']);
        }
        if(isset($_SESSION['nombre_usuario'])){
            //se borran las cokiees asociadas
            unset($_SESSION['nombre_usuario']);
        }
        //nos aseguramos de destruir la sesion completamente
        session_destroy();
    }
    //metodo para saber si la sesion esta iniciada o no
    public static function sesion_iniciada(){
        //evaluamos si la sesion ya se a iniciado o no
        if(session_id() == ''){
            //si el if se cumple entonces se crea la sesion
            session_start();
        }
        //comprobamos si existe el nombre_usuario y el id_usuario
        if(isset($_SESSION['id_usuario']) && isset($_SESSION['nombre_usuario'])){
            //devolvemos verdadero si se ha iniciado sesion 
            return true;
        }  else {
            //en caso contrario se devuelve false
            return false;
        }
    }
}

?>
