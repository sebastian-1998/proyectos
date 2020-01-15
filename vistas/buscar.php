<?php
include_once 'app/EscritorEntradas.inc.php';
include_once 'app/RepositorioEntrada.inc.php';

$busqueda = null;
$resultados = null;

$buscar_titulo = false;
$buscar_contenido = false;
$buscar_tags = false;
$buscar_autor = false;

$ordenar_antiguas = false;

if (isset($_POST['buscar']) && isset($_POST['termino-buscar']) && !empty($_POST['termino-buscar'])) {
    $busqueda = $_POST['termino-buscar'];

    Conexion::abrir_conexion();
    $resultados = RepositorioEntrada::buscar_entradas_todos_los_campos(Conexion::obtener_conexion(), $busqueda);

    Conexion::cerrar_conexion();
}

if (isset($_POST['busqueda_avanzada']) && isset($_POST['campos'])) {

    if (in_array("titulo", $_POST['campos'])) {
        $buscar_titulo = true;
    }

    if (in_array("contenido", $_POST['campos'])) {
        $buscar_contenido = true;
    }

    if (in_array("tags", $_POST['campos'])) {
        $buscar_tags = true;
    }

    if (in_array("autor", $_POST['campos'])) {
        $buscar_autor = true;
    }

    if ($_POST['fecha'] == "recientes") {
        $orden = "DESC";
    }

    if ($_POST['fecha'] == "antiguas") {
        $orden = "ASC";
    }

    if (isset($_POST['termino-buscar']) && !empty($_POST['termino-buscar'])) {
        $busqueda = $_POST['termino-buscar'];

        Conexion::abrir_conexion();

        if ($buscar_titulo) {
            $entradas_por_titulo = RepositorioEntrada::buscar_entradas_titulo(Conexion::obtener_conexion(), $busqueda, $orden);
        }

        if ($buscar_contenido) {
            $entradas_por_contenido = RepositorioEntrada::buscar_entradas_texto(Conexion::obtener_conexion(), $busqueda, $orden);
        }

        if ($buscar_tags) {
            //añadir tags cuando existan
        }

        if ($buscar_autor) {
            $entradas_por_autor = RepositorioEntrada::buscar_entradas_autor(Conexion::obtener_conexion(), $busqueda, $orden);
        }
    }
}

$titulo = "Buscar";

include_once 'plantillas/documento-apertura.inc.php';
include_once 'plantillas/barra_navegacion.inc.php';
?>

<div class="container">
    <div class="row">
        <div class="jumbotron">
            <h1 class="text-center">Buscar en JavaDevOne</h1>
            <br>
            <div class="row">
                <div class="col-md-2">
                </div>
                <div class="col-md-8">
                    <form role="form" method="post" action="<?php echo RUTA_BUSCAR; ?>">
                        <div class="form-group">
                            <input type="search" class="form-control" name="termino-buscar"
                            <?php if (isset($busqueda)) echo "value='" . $busqueda . "'" ?>
                                   placeholder="¿Qué buscas?">
                        </div>
                        <button type="submit" name="buscar" class="form-control btn btn-primary btn-buscar">
                            Buscar
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" href="#collapse1">Búsqueda avanzada</a>
                    </h4>
                </div>
                <div id="collapse1" class="panel-collapse collapse">
                    <div class="panel-body">
                        <form role="form" method="post" action="<?php echo RUTA_BUSCAR; ?>">
                            <div class="form-group">
                                <input type="search" class="form-control" name="termino-buscar"
                                <?php if (isset($busqueda)) echo "value='" . $busqueda . "'" ?>
                                       placeholder="¿Qué buscas?">
                            </div>
                            <p>Buscar en los siguientes campos: </p>
                            <label class="checkbox-inline">
                                <input type="checkbox" name="campos[]" value="titulo"
                                <?php
                                if (isset($_POST['busqueda_avanzada'])) {
                                    if ($buscar_titulo) {
                                        echo "checked";
                                    }
                                } else {
                                    echo " checked";
                                }
                                ?>
                                       >Título
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name="campos[]" value="contenido"
                                <?php
                                if (isset($_POST['busqueda_avanzada'])) {
                                    if ($buscar_contenido) {
                                        echo "checked";
                                    }
                                } else {
                                    echo " checked";
                                }
                                ?>
                                       >Contenido
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name="campos[]" value="tags"
                                <?php
                                if (isset($_POST['busqueda_avanzada'])) {
                                    if ($buscar_tags) {
                                        echo "checked";
                                    }
                                } else {
                                    echo " checked";
                                }
                                ?>
                                       >Tags
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name="campos[]" value="autor"
                                <?php
                                if (isset($_POST['busqueda_avanzada'])) {
                                    if ($buscar_autor) {
                                        echo "checked";
                                    }
                                } else {
                                    echo " checked";
                                }
                                ?>
                                       >Autor
                            </label>
                            <hr>
                            <p>Ordenar por:</p>
                            <label class="radio-inline">
                                <input type="radio" name="fecha" value="recientes"
                                <?php
                                if (isset($_POST['busqueda_avanzada']) && isset($orden) && $orden == 'DESC') {
                                    echo "checked";
                                }

                                if (!isset($_POST['busqueda_avanzada'])) {
                                    echo "checked";
                                }
                                ?>
                                       >Entradas más recientes
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="fecha" value="antiguas"
                                <?php
                                if (isset($_POST['busqueda_avanzada']) && isset($orden) && $orden == 'ASC') {
                                    echo "checked";
                                }
                                ?>
                                       >Entradas más antiguas
                            </label>
                            <hr>
                            <button type="submit" name="busqueda_avanzada" class="btn btn-primary btn-buscar">
                                Búsqueda avanzada
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container" id="resultados">
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h1>
                    Resultados
                    <?php
                    if (isset($_POST['buscar']) && count($resultados)) {
                        echo " ";
                        ?>
                        <small><?php echo count($resultados); ?></small>
                        <?php
                    } //COMPROBAR RESULTADOS EN BÚSQUEDA MÚLTIPLE
                    ?>
                </h1>
            </div>
        </div>
    </div>

    <?php
    if (isset($_POST['buscar'])) {
        if (count($resultados)) {
            EscritorEntradas::mostrar_entradas_busqueda($resultados);
        } else {
            ?>
            <h3>Sin coincidencias</h3>
            <br>
            <?php
        }
    } else if (isset($_POST['busqueda_avanzada'])) {
        if (count($entradas_por_titulo) || count($entradas_por_contenido) || count($entradas_por_autor)) {
            $parametros = count($_POST['campos']);
            $ancho_columnas = 12 / $parametros;
            ?>
            <div class="row">
                <?php
                for ($i = 0; $i < $parametros; $i++) {
                    ?>
                    <div class="<?php echo 'col-md-' . $ancho_columnas; ?> text-center">
                        <h4><?php echo 'Coincidencias en ' . $_POST['campos'][$i]; ?></h4>
                        <br>
                        <?php
                        switch ($_POST['campos'][$i]) {
                            case "titulo":
                                EscritorEntradas::mostrar_entradas_busqueda_multiple($entradas_por_titulo);
                                break;
                            case "contenido":
                                EscritorEntradas::mostrar_entradas_busqueda_multiple($entradas_por_contenido);
                                break;
                            case "tags":
                                break;
                            case "autor":
                                EscritorEntradas::mostrar_entradas_busqueda_multiple($entradas_por_autor);
                                break;
                        }
                        ?>
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php
        } else {
            ?>
            <h3>Sin coincidencias</h3>
            <br>
            <?php
        }
    }
    ?>
</div>

<?php
include_once 'plantillas/documento-cierre.inc.php';
?>