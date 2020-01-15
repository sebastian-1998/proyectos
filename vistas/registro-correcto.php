<?php
//incluimos los archivos necesarios
include_once 'app/config.inc.php';
include_once 'app/Conexion.inc.php';
include_once 'app/RepositorioUsuario.inc.php';
include_once 'app/Redireccion.inc.php';

$titulo = '¡Registro exitoso!';

include_once 'plantillas/documento-apertura.inc.php';
include_once 'plantillas/barra_navegacion.inc.php';
include_once 'plantillas/documento-cierre.inc.php';
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span>
                </div>
                <div class="panel-body text-center">
                    <p>
                        <!--mostramos un parrafo con un mensaje y entre etiquetas php concatenamos el nombre proporcionado-->
                        ¡Gracias por registrarte <b><?php echo $nombre ?></b>!</p>
                    <br>
                    <!--mostramos un enlace con la RUTA_LOGIN-->
                    <p><a href="<?php echo RUTA_LOGIN ?>">Iniciar sesión</a> para comenzar a configurar y usar tu cuenta</p>
                </div>
            </div>
        </div>
    </div>
</div>
