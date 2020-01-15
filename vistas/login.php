<?php
ob_start();
//incluimos los archivos necesarios
//le asignamos un titulo
$titulo = 'Login';
include_once 'app/config.inc.php';
include_once 'app/Conexion.inc.php';
include_once 'app/RepositorioUsuario.inc.php';
include_once 'app/ValidadorLogin.inc.php';
include_once 'app/ControlSesion.inc.php';
include_once 'app/Redireccion.inc.php';
include_once 'plantillas/documento-apertura.inc.php';
include_once 'plantillas/barra_navegacion.inc.php';
include_once 'plantillas/documento-cierre.inc.php';

//se evalua si esta previamente la sesion iniciada
if(ControlSesion::sesion_iniciada()){
    //se redirige
    Redireccion::redirigir(SERVIDOR);
}
//se comprueba si el usuario a presionado o no el boton de login
if(isset($_POST['login'])){
    //se abre la conexion
    Conexion::abrir_conexion();
    //creamos un objeto de la clase validadorlogin y le pasamos los parametros necesarios
    $validador = new ValidadorLogin($_POST['email'], $_POST['clave'], Conexion::obtener_conexion());
    //se evalua que todo haya sido correcto
    if($validador -> obtener_error() === '' && 
            !is_null($validador -> obtener_usuario())){
        //iniciamos sesion y redirigimos mediante la clase ControlSesion
        ControlSesion::iniciar_sesion(
                $validador-> obtener_usuario() -> obtener_id(),
                $validador-> obtener_usuario() -> obtener_nombre());
        //se redirige
        Redireccion::redirigir(SERVIDOR);
    }
    //se cierra la conexion
    Conexion::cerrar_conexion();
    
}

//incluimos los archivos necesarios
include_once 'plantillas/documento-apertura.inc.php';
include_once 'plantillas/barra_navegacion.inc.php';
?>

<!--creamos el formulario-->
<div class="container">
    <div class="row">
        <div class="col-md-3">
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <h4>Iniciar sesión:</h4>
                </div>
                <div class="panel-body">
                    <form role="form" method="post" action="<?php echo RUTA_LOGIN; ?>">
                        <h2>Introduce tus datos:</h2>
                        <br>
                        <!--activamos el lector de pantalla-->
                        <label for="email" class="sr-only">Introduce tu e-mail</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Ingresa tu e-mail" 
                               <?php
                               //se evalua si se a ingresado algo en el campo email
                               if(isset($_POST['login']) && isset($_POST['email']) && !empty($_POST['email'])){
                                   //se mantiene lo ingresado
                                   echo 'value="' . $_POST['email'] . '"';
                               }
                               ?>
                               required autofocus>
                        <br>
                        <!--activamos el lector de pantalla-->
                        <label for="clave" class="sr-only">Introduce tu contraseña</label>
                        <input type="password" name="clave" id="clave" class="form-control" placeholder="Ingresa tu clave" required>
                        <br>
                        <?php
                        //si se presiono login y a sucesido un error se muestra
                        if(isset($_POST['login'])){
                            $validador -> mostrar_error();
                        }
                        ?>
                        <button type="submit" name="login" class="btn btn-lg btn-primary btn-block">Iniciar sesión</button>
                    </form>
                    <br>
                    <br>
                    <div class="text-center">
                        <a href="<?php echo RUTA_RECUPERAR_CLAVE; ?>">¿Olvidaste tu contraseña?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
ob_end_flush();
?>