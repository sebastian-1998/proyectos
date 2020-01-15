<?php
//le asignamos un titulo
$titulo = 'Recuperar clave';
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
                    <h4>Recuperacion de clave:</h4>
                </div>
                <div class="panel-body">
                    <form role="form" method="post" action="<?php echo RUTA_GENERAR_URL_SECRETA; ?>">
                        <h2>Introduce tu e-mail:</h2>
                        <br>
                        <p>
                            Escribe la dirección de correo electronico que hayas proporcionado al registrarte y se te enviara
                            un e-mail con el que podras reestablecer tu contraseña.
                        </p>
                        <br>
                        <!--activamos el lector de pantalla-->
                        <label for="email" class="sr-only">Introduce tu e-mail</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Ingresa tu e-mail" required autofocus>
                        <br>
                        <button type="submit" name="enviar_email" class="btn btn-lg btn-primary btn-block">Enviar e-mail</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
