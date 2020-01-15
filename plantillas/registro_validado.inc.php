<div class="form-group">
    <label>Introduce tu nombre de usuario:</label>
    <input type="text" class="form-control" name="nombre" placeholder="Juan" <?php $validador -> mostrar_nombre()?>>
    <?php
    //se muestra el error del nombre
    $validador -> mostrar_error_nombre();
    ?>
</div>
<div class="form-group">
    <label>Introduce tu e-mail:</label>
    <input type="email" class="form-control" name="email" placeholder="correo@algo.com" <?php $validador -> mostrar_email()?>>
    <?php
    //se muestra el error del email
    $validador -> mostrar_error_email();
    ?>
</div>
<div class="form-group">
    <label>Introduce tu contraseña:</label>
    <input type="password" class="form-control" name="clave1" placeholder="ontraseña debe contener menos de 25 caracteres">
    <?php
    //se muestra el error de la clave1
    $validador -> mostrar_error_clave1();
    ?>
</div>
<div class="form-group">
    <label>Repite tu contraseña:</label>
    <input type="password" class="form-control" name="clave2" placeholder="contraseña debe contener menos de 25 caracteres">
    <?php
    //se muestra el error de la clave2
    $validador -> mostrar_error_clave2();
    ?>
</div>
<br>
<button type="submit" class="btn btn-primary" name="enviar">Enviar datos</button>
<br>
<br>
<button type="reset" class="btn btn-default">Limpiar datos</button>