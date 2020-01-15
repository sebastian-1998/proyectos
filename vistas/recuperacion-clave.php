<?php
//incluimos el archivo necesario
include_once 'app/RepositorioRecuperacionClave.inc.php';
include_once 'app/RepositorioUsuario.inc.php';
include_once 'app/Conexion.inc.php';
include_once 'app/Redireccion.inc.php';
//abrimos la conexion
Conexion :: abrir_conexion();
//comprobamos si existe la url
if(RepositorioRecuperacionClave::url_secreta_existe(Conexion::obtener_conexion(), $url_personal)){
    //recuperamos la id de usuario
    $id_usuario = RepositorioRecuperacionClave::obtener_id_usuario_mediante_url_secreta(Conexion::obtener_conexion(), $url_personal);
}  else {
    echo '404';
}
$clave1 = $_POST['clave'];
$clave2 = $_POST['clave2'];
//se evalua si a pulsado o no guardar
if(isset($_POST['guardar_datos'])){
    if($clave1 != $clave2){
        echo '<div class="alert alert-danger">Ambas claves deben coincidir.</div>';
    }  else {
        //ciframos la contraseña
        $clave_encriptada = password_hash($_POST['clave'], PASSWORD_DEFAULT);
        //actualizamos la clave
        $clave_actualizada = RepositorioUsuario::actualizar_clave(Conexion::obtener_conexion(), $id_usuario, $clave_encriptada);
        //redirigimos
        if($clave_actualizada){
            Redireccion::redirigir(RUTA_LOGIN);
        
        }else {
            echo "Error al actualizar la clave";
    }
    }
    
    
}

//cerramos la conexion
Conexion :: cerrar_conexion();
//le asignamos un titulo
$titulo = 'Recuperacion de contraseña';
//incluimos el archivo necesario
include_once 'plantillas/documento-apertura.inc.php';
include_once 'plantillas/barra_navegacion.inc.php';
?>
<!--creamos el form para actualizar la password-->
<div class="container">
    <div class="row">
        <div class="col-md-3">  
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <h4>Actualizar contraseña:</h4>
                </div>
                <div class="panel-body">
                    <!--."/".$url_personal hace que se pueda acceder a la ruta sin esto da un error 404-->
                    <form role="form" method="post" action="<?php echo RUTA_RECUPERACION_CLAVE."/".$url_personal; ?>">
                        <br>
                        <div class="form-group">
                            <label for="clave">Escribe tu nueva contraseña:</label>
                            <input type="password" name="clave" id="clave" class="form-control" placeholder="máximo 25 caracteres" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="clave2">Repite tu nueva contraseña:</label>
                            <input type="password" name="clave2" id="clave2" class="form-control" placeholder="Ambas claves deben coincidir" required>
                        </div>
                        <br>
                        <button type="submit" name="guardar_datos" class="btn btn-lg btn-primary btn-block">Guardar datos</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
