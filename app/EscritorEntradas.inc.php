<?php
//incluimos los archivos necesarios
include_once 'app/Conexion.inc.php';
include_once 'app/RepositorioEntrada.inc.php';
include_once 'app/Entrada.inc.php';
//creamos la clase
class EscritorEntradas {
    //creamos la funcion necesaria
    public static function escribir_entradas() {
        //llamamos al metodo necesario
        $entradas = RepositorioEntrada::obtener_por_fecha_descendente(Conexion::obtener_conexion());
        //se cuentan si existen entradas o no
        if (count($entradas)) {
            //se crea un for el cual recorrera la bd en busqueda de resultados
            foreach ($entradas as $entrada) {
                //se llama a la funcion necesaria
                self::escribir_entrada($entrada);
            }
        }
    }

    public static function escribir_entrada($entrada) {
        if (!isset($entrada)) {
            return;
        }
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php
                        echo $entrada -> obtener_titulo();
                        ?>
                    </div>
                    <div class="panel-body">
                        <p>
                            <strong>
                                <?php
                                echo $entrada->obtener_fecha();
                                ?>
                            </strong>
                            <br>
                            <strong>
                                <?php
                                echo $entrada->obtener_id();
                                ?>
                            </strong>
                        </p>
                        <div class="text-justify">
                        <?php
                        echo nl2br(self::resumir_texto($entrada->obtener_texto()));
                        ?>
                        </div>
                        <br>
                        <div class="text-center">
                            <a class="btn btn-primary" href="
                                <?php echo RUTA_ENTRADA . '/' . $entrada -> obtener_url() ?>
                               " role="button">Seguir leyendo</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    public static function mostrar_entradas_busqueda($entradas) {
        for ($i = 1; $i <= count($entradas); $i++) {
            if($i % 3 == 0) {
                ?>
                <div class="row">
                <?php
            }

            $entrada = $entradas[$i - 1];
            self::mostrar_entrada_busqueda($entrada);

            if($i % 3 == 0) {
                ?>
                </div>
                <?php
            }
        }
    }

    public static function mostrar_entradas_busqueda_multiple($entradas) {
        for ($i = 0; $i < count($entradas); $i++) {
            ?>
            <div class="row">
            <?php

            $entrada = $entradas[$i];
            self::mostrar_entrada_busqueda_multiple($entrada);

            ?>
            </div>
            <?php
        }
    }

    public static function mostrar_entrada_busqueda($entrada) {
        if (!isset($entrada)) {
            return;
        }
        ?>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php
                    echo $entrada -> obtener_titulo();
                    ?>
                </div>
                <div class="panel-body">
                    <p>
                        <strong>
                            <?php
                            echo $entrada->obtener_fecha();
                            ?>
                        </strong>
                        <br>
                        <strong>
                            <?php
                            echo $entrada->obtener_id();
                            ?>
                        </strong>
                    </p>
                    <div class="text-justify">
                    <?php
                    echo nl2br(self::resumir_texto($entrada->obtener_texto()));
                    ?>
                    </div>
                    <br>
                    <div class="text-center">
                        <a class="btn btn-primary" href="<?php echo RUTA_ENTRADA . '/' . $entrada -> obtener_url()?>" role="button">Seguir leyendo</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    public static function mostrar_entrada_busqueda_multiple($entrada) {
        if (!isset($entrada)) {
            return;
        }
        ?>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?php
                    echo $entrada -> obtener_titulo();
                    ?>
                </div>
                <div class="panel-body">
                    <p>
                        <strong>
                            <?php
                            echo $entrada->obtener_fecha();
                            ?>
                        </strong>
                        <br>
                        <strong>
                            <?php
                            echo $entrada->obtener_id();
                            ?>
                        </strong>
                    </p>
                    <div class="text-justify">
                    <?php
                    echo nl2br(self::resumir_texto($entrada->obtener_texto()));
                    ?>
                    </div>
                    <br>
                    <div class="text-center">
                        <a class="btn btn-primary" href="<?php echo RUTA_ENTRADA . '/' . $entrada -> obtener_url()?>" role="button">Seguir leyendo</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    public static function resumir_texto($texto) {
        $longitud_maxima = 400;

        $resultado = '';

        if (strlen($texto) >= $longitud_maxima) {

            $resultado = substr($texto, 0, $longitud_maxima);

            $resultado .= '...';
        } else {
            $resultado = $texto;
        }

        return $resultado;
    }

}