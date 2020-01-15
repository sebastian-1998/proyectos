<?php
//evitamos que se guarden las imagenes en cache
header("Expires: tue, 01 JAN 2000 00:00:00 GMT");
header("Last-Modified: ". gmdate("D, d M Y h:i:s") . "GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
//incluimos los archivos necesarios
include_once 'app/Conexion.inc.php';
include_once 'app/RepositorioUsuario.inc.php';
include_once 'app/ControlSesion.inc.php';
include_once 'app/Usuario.inc.php';
//evaluamos si el usuario no ha iniciado sesion
if(!ControlSesion :: sesion_iniciada()){
    //se redirige a la pagina principal
    Redireccion :: redirigir(SERVIDOR);
}  else {
    //si se a iniciado sesion se entra en esta parte
    Conexion :: abrir_conexion();
    //recuperamos la id del usuario
    $id = $_SESSION['id_usuario'];
    //llamamos al metodo necesario para recuperar los otros datos
    $usuario = RepositorioUsuario :: obtener_usuario_por_id(Conexion::obtener_conexion(), $id);
}
//se evalua si el usuario ha pulsado el boton para guardar la imagen y si ha seleccionado alguna imagen
if(isset($_POST['guardar_imagen']) && !empty($_FILES['archivo_subido']['tmp_name'])){
    //creamos la variable necesaria y le indicamos la carpeta necesaria donde se guardaran las imagenes subidas
    $directorio = DIRECTORIO_RAIZ."/imagen_subida/";
    //a carpeta objetivo le pasamos como valor directorio y basename obtiene el nombre del archivo
    $carpeta_objetivo = $directorio.basename($_FILES['archivo_subido']['name']);
    //creamos una variable que nos permitira saber si la imagen se subio correctamente o no
    $subida_correcta = 1;
    //verificamos el tipo de imagen
    $tipo_imagen = pathinfo($carpeta_objetivo, PATHINFO_EXTENSION);
    //verificamos el tamaño
    $comprobacion = getimagesize($_FILES['archivo_subido']['tmp_name']);
    if($comprobacion !== false){
        //todo correcto
        $subida_correcta = 1;
    }  else {
        //error
        $subida_correcta = 0;
    }
    //comprobamos el tamaño
    if($_FILES['archivo_subido']['size'] > 1000000){
        //mostramos un mensaje
        echo '<div class="alert alert-danger">Se ha sobrepasado el tamaño máximo permitido</div>';
        //error
        $subida_correcta = 0;
    }
    //evaluamos el tipo de imagen
    if($tipo_imagen != "jpg" && $tipo_imagen != "png" && $tipo_imagen != "jpeg" && $tipo_imagen != "gif"){
        //mostramos un mensaje
        echo '<div class="alert alert-danger">Formato incorrecto la imagen debe ser JPG, PNG, JPEG o GIF</div>';
        //error
        $subida_correcta = 0;
    }
    //se evalua si no se ha subido correctamente el archivo
    if($subida_correcta == 0){
        //mostramos un mensaje
        echo '<div class="alert alert-danger">Error al subir el archivo</div>';
    }  else {
        //se evalua si se ha subido correctamente el archivo a la carpeta correspondiente junto a la id del usuario
        if(move_uploaded_file($_FILES['archivo_subido']['tmp_name'], DIRECTORIO_RAIZ."/imagen_subida/".$usuario->obtener_id())){
            //mostramos un mensaje
        echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>El archivo "'.basename($_FILES['archivo_subido']['name']).'" se ha subido correctamente </div>';
        }  else {
            //en caso de error se muestra un mensaje
            echo '<div class="alert alert-danger">Error al subir el archivo</div>';
        }
    }
}

//le asignamos un titulo
$titulo = "Perfil de usuarios";
include_once 'plantillas/documento-apertura.inc.php';
include_once 'plantillas/barra_navegacion.inc.php';
?>
<div class="container perfil">
    <div class="row">
        <!--creamos 2 columnas en la primera colocaremos la imagen y en la segunda los datos del usuario-->
        <div class="col-md-3">
            <!--en caso de existir una imagen en la carpeta se muestra si no se mantiene la original
            <?php
            //comprobamos si existe o no la imagen
            if(file_exists(DIRECTORIO_RAIZ."/imagen_subida/".$usuario->obtener_id())){
                //reemplazamos la imagen por defecto por la que se encuentra en la carpeta
                ?>
                <!--cargamos la imagen guardada en la carpeta-->
                <img src="<?php echo SERVIDOR.'/imagen_subida/'.$usuario->obtener_id(); ?>" class="img-responsive">
                <?php
            }  else {
                ?>
                 <!--cargamos la imagen por defecto en caso de no existir-->
                <img src="img/imagen.png" class="img-responsive">
                <?php
            }
            ?>
            <br>
            <!--creamos un formulario que nos permita guardar la imagen en la BD
            multipart/form-data permite subir la imagen a la bd-->
            <form class="text-center" action="<?php echo RUTA_PERFIL; ?>" method="post" enctype="multipart/form-data">
                <!--con for hacemos que se comporte como un boton al presionar el label nos permite elegir la imagen-->
                <label for="archivo_subido" id="label-archivo">Subir imagen</label>
                <!--creamos los input necesarios-->
                <input type="file" name="archivo_subido" id="archivo_subido" class="boton_subir">
                <br>
                <br>
                <!--creamos los botones-->
                <input type="submit" value="Guardar imagen" name="guardar_imagen" class="form-control">
            </form>
        </div>
        <div class="col-md-9">
            <!--creamos titulares-->
            <h4><small>Nombre de usuario</small></h4>
            <!--recuperamos los datos necesarios-->
            <h4><?php echo $usuario -> obtener_nombre(); ?></h4>
            <br>
            <h4><small>Email de usuario</small></h4>
            <h4><?php echo $usuario -> obtener_email(); ?></h4>
            <br>
            <h4><small>Ingresado al sistema desde</small></h4>
            <h4><?php echo $usuario -> obtener_fecha_registro(); ?></h4>
        </div>
    </div>
</div>
<?php
include_once 'plantillas/documento-cierre.inc.php';