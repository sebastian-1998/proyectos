<input type="hidden" id="id_entrada" name="id_entrada" value="<?php echo $id_entrada; ?>">
<div class="form-group">
    <h4><label for="titulo" style="color: black">
            Titulo de la entrada:
        </label></h4>
    <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Nueva entrada"
           value="<?php echo $entrada_recuperada -> obtener_titulo(); ?>">
    <input type="hidden" id="titulo_original" name="titulo_original" value="<?php echo $entrada_recuperada -> obtener_titulo();  ?>">
</div>
<div class="form-group">
    <h4><label for="url" style="color: black">
            Url de la entrada:
        </label></h4>
    <input type="url" class="form-control" id="url" name="url" placeholder="Direccion única sin espacios para la entrada"
           value="<?php echo $entrada_recuperada -> obtener_url(); ?>">
    <input type="hidden" id="url_original" name="url_original" value="<?php echo $entrada_recuperada -> obtener_url();  ?>">
</div>
<div class="form-group">
    <h4><label for="contenido" style="color: black">
            Contenido de la entrada:
        </label></h4>
    <!--creamos un text area-->
    <textarea class="form-control" rows="20" id="contenido" name="texto" placeholder="CONTENIDO ENTRADA"><?php echo $entrada_recuperada -> obtener_texto(); ?></textarea>
    <input type="hidden" id="texto_original" name="texto_original" value="<?php echo $entrada_recuperada -> obtener_texto();  ?>">
</div>
<div class="checkbox">
    <h4><label style="color: black">
            <input type="checkbox" value="SI" name="publicar" <?php if($entrada_recuperada -> esta_activa()) echo 'checked' ?>> Esta opcion permite que la entrada sea publicada de inmediato
            <input type="hidden" id="publicar_original" name="publicar_original" value="<?php echo $entrada_recuperada -> esta_activa();  ?>">
        </label></h4>
</div>
<br>
<!--creamos un boton-->
<button type="submit" class="btn  btn-lg btn-primary" name="editar">Editar entrada</button>