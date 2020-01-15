<div class="form-group">
    <h4><label for="titulo" style="color: black">
            Titulo de la entrada:
        </label></h4>
    <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Nueva entrada">
</div>
<div class="form-group">
    <h4><label for="url" style="color: black">
            Url de la entrada:
        </label></h4>
    <input type="url" class="form-control" id="url" name="url" placeholder="Direccion única sin espacios para la entrada">
</div>
<div class="form-group">
    <h4><label for="contenido" style="color: black">
            Contenido de la entrada:
        </label></h4>
    <!--creamos un text area-->
    <textarea class="form-control" rows="20" id="contenido" name="texto" placeholder="CONTENIDO ENTRADA"></textarea>
</div>
<div class="checkbox">
    <h4><label style="color: black">
            <input type="checkbox" value="SI" name="publicar"> Esta opcion permite que la entrada sea publicada de inmediato
        </label></h4>
</div>
<br>
<!--creamos un boton-->
<button type="submit" class="btn  btn-lg btn-primary" name="guardar">Guardar entrada</button>