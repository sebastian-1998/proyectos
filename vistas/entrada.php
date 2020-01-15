<?php
//incluimos los archivos necesarios
include_once 'app/config.inc.php';
include_once 'app/Conexion.inc.php';
include_once 'app/Usuario.inc.php';
include_once 'app/Entrada.inc.php';
include_once 'app/Comentario.inc.php';
//incluimos los repositorios
include_once 'app/RepositorioUsuario.inc.php';
include_once 'app/RepositorioEntrada.inc.php';
include_once 'app/RepositorioComentario.inc.php';
//definimos el titulo
$titulo = $entrada -> obtener_titulo();
include_once 'plantillas/documento-apertura.inc.php';
include_once 'plantillas/documento-cierre.inc.php';
include_once 'plantillas/barra_navegacion.inc.php';

?>

<div class="container contenido_articulo">
    <div class="row">
        <div class="col-md-12">
            <h1>
                <?php
                echo $entrada ->obtener_titulo();
                ?>
            </h1>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <p>
                    Por:
                    <a href="#">
                        <span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?php echo $autor ->obtener_nombre(); ?>
                    </a>
                    el
                    <?php
                    echo $entrada ->obtener_fecha();
                    ?>
                </p>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <article class="text-justify">
                    <?php
                    echo nl2br($entrada -> obtener_texto());
                    ?>
                </article>
            </div>
        </div>
        <?php
        include_once 'plantillas/entradas_al_azar.inc.php';
        ?>
        <br>
        <?php
        //comprobamos cuantos comentarios existen
        if(count($comentarios) > 0 ){
            //incluimos el archivo necesario
            include_once 'plantillas/comentarios_entrada.inc.php';   
        }  else {
            //si no existen datos mostramos el mensaje
            echo '<p>Todavía no existen comentarios</p>';
        }
        ?>
    </div>
</div>
<?php
include_once 'plantillas/documento-cierre.inc.php';
?>
