<?php
include_once 'plantillas/documento-apertura.inc.php';
include_once 'plantillas/documento-cierre.inc.php';
?>
<div class="row text-center">
    <div class="col-md-4 gg-elemento" id="gestor-generico-entradas">
        <h2><i class="fa fa-newspaper-o" aria-hidden="true"></i></h2>
        <h3>Entradas</h3>
        <hr>
        <h4><?php echo $cantidad_entradas_activas; ?></h4>
        <h5>Entradas publicadas</h5>
        <h5><?php echo $cantidad_entradas_inactivas; ?></h5>
        <h5>Borradores</h5>
        
    </div>
    <div class="col-md-4 gg-elemento" id="gestor-generico-comentarios">
        <h2><i class="fa fa-commenting" aria-hidden="true"></i></h2>
        <h3>Comentarios</h3>
        <hr>
        <h4><?php echo $cantidad_comentarios; ?></h4>
    </div>
    <div class="col-md-4 gg-elemento" id="gestor-generico-favoritos">
        <h2><i class="fa fa-heart" aria-hidden="true"></i> </h2>
        <h3>Favoritos</h3>
        <hr>
        <h4>-</h4>
        <h5>Entradas favoritas</h5>
        <h4>-</h4>
        <h5>Autores favoritos</h5>
        <h5>-</h5>
    </div>
</div>