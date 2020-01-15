<?php
ob_start();
//incluimos los archivos necesarios
$titulo = 'Blog de Sebastian Carrasco';
include_once 'app/Conexion.inc.php';
include_once 'app/RepositorioUsuario.inc.php';
include_once 'app/EscritorEntradas.inc.php';

include_once 'plantillas/documento-apertura.inc.php';
include_once 'plantillas/barra_navegacion.inc.php';
?>

<div class="container">
    <!--creamos un jumbotron que es un panel grande-->
    <div class="jumbotron">
        <!--le agregamos un titular-->
        <h1>Blog de Sebastian Carrasco</h1>
        <p>
            Blog hecho para aprender a desarrollar paginas web
        </p>
    </div>
</div>
<!--se crean 2 contenedores donde 1 servira para archivos y para buscar 
el otro sera parafiltrar-->
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Búsqueda
                        </div>
                        <div class="panel-body">
                            <form role="form" method="post" action="
<?php
                            echo RUTA_BUSCAR;?>">
                                <div class="form-group">
                                    <input type="search" name="termino_buscar" class="form-control" placeholder="¿Qué buscas?" required>
                                </div>
                                <button type="submit" name="buscar" class="form-control btn btn-primary">
                                    Buscar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--se crea otra fila y columna para el filtro-->
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <span class="glyphicon glyphicon-filter" aria-hidden="true"></span> Filtro

                        </div>
                        <div class="panel-body">

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-file-archive-o" aria-hidden="true"></i>Archivos

                        </div>
                        <div class="panel-body">

                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-8">
<?php
            //llamamos al metodo
            EscritorEntradas::escribir_entradas();
?>
        </div>
    </div>
</div>
<?php
include_once 'plantillas/documento-cierre.inc.php';
?>
