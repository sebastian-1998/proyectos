<?php
include_once 'plantillas/documento-apertura.inc.php';
include_once 'plantillas/documento-cierre.inc.php';
$titulo = 'Gestor de entradas';
?>
<div class="row parte_gestor-entrada">
    <div class="col-md-12">
        <h2>Gestión de entradas</h2>
        <br>
        <!--creamos un enlace adornado como button para crear una entrada-->
        <a href="<?php echo RUTA_NUEVA_ENTRADA; ?>" class="btn btn-lg btn-primary" role="button" id="nueva-entrada">Agregar nueva entrada</a>
        <br>
        <br>
    </div>
</div>
<div class="row parte_gestor-entrada">
    <div class="col-md-12">
        <!--se evalua si el array_entradas es mayor a 0 si se cumple se muestran los datos-->
        <?php 
        if(count($array_entradas)> 0){
            ?>
            <!--creamos una tabla para mostrar las entradas-->
            <table class="table table-striped">
                    <!--le asignamos un titulo a los elementos de la tabla-->
                    <thead>
                        <!--tr table row-->
                        <tr>
                            <!--se crean los titulos-->
                            <th>Fecha</th>
                            <th>Título</th>
                            <th>Estado</th>
                            <th>Comentarios</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for($i = 0; $i < count($array_entradas); $i++){
                            //hacemos que entrada_actual sea igual al array_entradas y se indica las posiciones
                            $entrada_actual = $array_entradas[$i][0];
                            $comentarios_entrada_actual = $array_entradas[$i][1];
                            ?>
                                <tr>
                                    <!--llenamos los datos de la tabla con el metodo necesario-->
                                    <td><?php echo $entrada_actual-> obtener_fecha(); ?></td>
                                    <td><?php echo $entrada_actual-> obtener_titulo(); ?></td>
                                    <td><?php echo $entrada_actual-> esta_activa(); ?></td>
                                    <td><?php echo $comentarios_entrada_actual; ?></td>
                                    <td>
                                        <form method="post" action="<?php echo RUTA_EDITAR_ENTRADA; ?>">
                                            <!--creamos un imput oculto con su id y como valor tendra el metodo obtener_id-->
                                            <input type="hidden" name="id_editar" value="<?php echo $entrada_actual -> obtener_id(); ?>">
                                            <!--creamos los botones-->
                                            <button type="submit" class="btn btn-primary" name="editar_entrada">Editar datos</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form method="post" action="<?php echo RUTA_BORRAR_ENTRADA; ?>">
                                            <!--creamos un imput oculto con su id y como valor tendra el metodo obtener_id-->
                                            <input type="hidden" name="id_borrar" value="<?php echo $entrada_actual -> obtener_id(); ?>">
                                            <!--creamos los botones-->
                                            <button type="submit" class="btn btn-primary" name="borrar_entrada">Borrar datos</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
           <?php
        }  else {
            //si el usuario no tiene entradas se muestra un mensaje
            ?>
                <h3 class="text-center">Todavia no has escrito ninguna entrada</h3>
                <br>
                <br>
        <?php
        
        }
        ?>
    </div>
</div>