<?php
include_once 'app/EscritorEntradas.inc.php';
include_once 'plantillas/documento-apertura.inc.php';
include_once 'plantillas/documento-cierre.inc.php';
?>
<!--creamos un row-->
<div class="row">
    <!--creamos una columna y un titular-->
    <div class="col-md-12">
        <hr>
        <h3>Otras entradas:</h3>
    </div>
    <?php
    //creamos un iterador en 0 hacemos que sea menor a la cantidad de entradas al azar y en cada vuelta va sumando 1
    for($i = 0; $i< count($entradas_al_azar); $i++){
        //hacemos que entrada actual que seria la que corresponde a la posicion del array sea igual a entradas_al_azar
        $entrada_actual = $entradas_al_azar[$i];
   
    ?>
    <!--creamos una columna de tamaño 4-->
    <div class="col-md-4">
        <!--escribimos los datos de la entrada-->
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php echo $entrada_actual -> obtener_titulo();?>
            </div>
            <div class="panel-body">
                <p>
                    <!--mostramos el texto pero resumido-->
                    <?php echo EscritorEntradas::resumir_texto(nl2br($entrada_actual -> obtener_texto()));?>
                </p>
                
            </div>
        </div>
    </div>
    <?php
    //cerramos el for
    }
    ?>
    <div class="col-md-12">
        <!--creamos un salto de linea-->
        <hr>
    </div>
</div>