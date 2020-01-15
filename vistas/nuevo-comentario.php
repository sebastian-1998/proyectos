<?php
//incluimos los archivos necesarios
$titulo = "Nuevo comentario";
include_once 'app/config.inc.php';
include_once 'app/Conexion.inc.php';
include_once 'app/Comentario.inc.php';
include_once 'app/RepositorioComentario.inc.php';
include_once 'app/ValidadorComentario.inc.php';
include_once 'app/ControlSesion.inc.php';
include_once 'app/Redireccion.inc.php';
include_once 'plantillas/documento-apertura.inc.php';
include_once 'plantillas/barra_navegacion.inc.php';
include_once 'plantillas/documento-cierre.inc.php';
?>
<!--creamos el form-->
<div class="container">
    <div class="jumbotron">
        <h1 class="text-center">Crear nuevo comentario:</h1>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form class="form-nuevo-comentario" method="post" action="<?php echo RUTA_NUEVO_COMENTARIO; ?>">
<?php
                //evalua si se ha presionado guardar o no
                if(isset($_POST['guardar'])){
                    //si se presiono se le carga el form validado
                    include_once 'plantillas/nuevo-comentario-valido.inc.php';
                }  else {
                    //si no se ha pulsado se muestra el form vacio
                    include_once 'plantillas/nuevo-comentario-vacio.inc.php';
                }
?>
            </form>
        </div>
    </div>
</div>
<?php
//se verifica que el usuario a presionado guardar o no
if(isset($_POST['guardar'])){
    //abrimos la conexion
    Conexion :: abrir_conexion();
    //indicamos los datos
    $validador = new ValidadorComentario($_POST['entrada_id'], $_POST['titulo'], htmlspecialchars($_POST['texto']), Conexion :: obtener_conexion());
}
//verificamos que no hayan errores
    if($validador->comentario_valido()){
        //se verifica que el usuario haya iniciado sesion
        if(ControlSesion :: sesion_iniciada()){
            //creamos el comentario
            $comentario = new Comentario('', $_SESSION['id_usuario'], $validador -> obtener_entrada_id(), $validador -> obtener_titulo(), $validador -> obtener_texto(), '');
            $comentario_insertado = RepositorioComentario :: insertar_comentario(Conexion :: obtener_conexion(), $comentario);
            if($comentario_insertado){
                //si todo a salido bien se redirige
                Redireccion::redirigir(RUTA_GESTOR_COMENTARIOS);
            }
        }  else {
            //si no ha iniciado sesion se redirige al login
            Redireccion::redirigir(RUTA_LOGIN);
    }
        //cerramos la conexion
        Conexion :: cerrar_conexion();
}
?>