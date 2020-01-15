<div class="form-group">
    <h4><label for="entrada_id">Seleccione la ID de la entrada a comentar:</label></h4>
    <p>ID:
        <select id="entrada_id" name="entrada_id">
            <option value="0">Seleccione:</option>
            <!--llamamos a los metodos necesarios-->    
            <?php $validador -> mostrar_entrada_id(); ?>>
        <?php $validador -> mostrar_error_entrada_id(); ?>
            <?php
            $odb=new PDO('mysql:host=localhost;dbname=blog', 'root', '');
            $query = "select id from entradas";
            $data = $odb->prepare($query);
            $data->execute();
            while($row=$data->fetch(PDO::FETCH_ASSOC)){
                echo '<option value="'.$row['id'].'">'.$row['id'].'</option>';
            }
            ?>
        </select>
    </p>
</div>
<br>
<div class="form-group">
    <h4><label>Introduce el titulo del comentario:</label></h4>
    <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Esto es un titulo"
           <!--llamamos a los metodos necesarios-->    
            <?php $validador -> mostrar_titulo(); ?>>
    <?php $validador -> mostrar_error_titulo(); ?>>
</div>
<br>
<div class="form-group">
    <h4><label for="texto" style="color: black">
            Ingresa el contenido del comentario:
        </label></h4>
    <!--creamos un text area-->
    <textarea class="form-control" rows="20" id="texto" name="texto" placeholder="CONTENIDO COMENTARIO"
              ><?php $validador -> mostrar_texto(); ?></textarea>
    <?php $validador -> mostrar_error_texto(); ?>
</div>
<!--creamos el button-->
<button type="submit" class="btn btn-lg btn-primary" name="guardar">Guardar Comentario</button>