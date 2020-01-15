<?php
include_once 'plantillas/documento-apertura.inc.php';
include_once 'plantillas/documento-cierre.inc.php';
$titulo = 'Gestor de comentarios';
?>
<div class="row parte-gestor-comentarios">
    <div class="col-md-12">
        <h2>Gestor de comentarios</h2>
        <br>
        <br>
        <!--creamos el enlace que actuara como un boton para guardar un comentario nuevo-->
        <a href="<?php echo RUTA_NUEVO_COMENTARIO; ?>" class="btn btn-lg btn-primary" role="button">Ingresar comentario nuevo</a>
        <br>
        <br>
    </div>
</div>
<div class="row parte-gestor-comentarios">
    <div class="col-md-12">
        <?php
        //contamos si el array de comentarios tiene o no datos
        if (count($array_comentarios) > 0) {
            ?>
            <!--creamos una tabla para mostrar los datos-->
            <table class="table table-striped">
                <!--creamos la cabezera-->
                <thead>
                    <tr>
                        <th>Id comentario</th>
                        <th>Autor comentario</th>
                        <th>Id entrada comentada</th>
                        <th>Titulo comentario</th>
                        <th>Contenido comentario</th>
                        <th>Fecha comentario</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for($i = 0; $i < count($array_comentarios); $i++){
                        //hacemos que comentario_actual sea igual al array_comentarios y se indica las posiciones
                        $comentario_actual = $array_comentarios[$i];
                        //var_dump($array_comentarios);
                    ?>
                        <tr>
                            <td><?php echo $comentario_actual->obtener_id() ; ?></td>
                            <td><?php echo $comentario_actual-> obtener_autor_id(); ?></td>
                            <td><?php echo $comentario_actual-> obtener_entrada_id(); ?></td>
                            <td><?php echo $comentario_actual-> obtener_titulo(); ?></td>
                            <td><?php echo $comentario_actual-> obtener_texto(); ?></td>
                            <td><?php echo $comentario_actual-> obtener_fecha(); ?></td>
                            <!--creamos los button-->
                            <td>
                                <button type="button" class="btn btn-default">Editar comentario</button>
                                <br>
                                <br>
                                <button type="button" class="btn btn-default">Borrar comentario</button>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <?php
        } else {
            ?>
            <!--en caso de no haber comentarios mostramos un mensaje-->
            <h3 class="text-center">Todavía no has escrito ningun comentario</h3>
            <br>
            <br>
            <?php
        }
        ?>
    </div>
</div>