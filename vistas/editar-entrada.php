<?php
//incluimos los archivos necesarios
include_once 'app/ValidadorEntradaEditada.inc.php';
include_once 'app/Validador.inc.php';
include_once 'app/ValidadorEntrada.inc.php';
$titulo = "Editar entrada";
include_once 'app/Redireccion.inc.php';
//abrimos la conexion
Conexion::abrir_conexion();
//se verifica si se a presionado o no el boton de editar
if(isset($_POST['editar'])){
    //creamos las variables necesarias
    $entrada_publica_nueva = 0;
    //se verifica si se ha seleccionado o no el checkbox y si tiene el valor que deseamos 
    if(isset($_POST['publicar']) && $_POST['publicar'] == "SI"){
        //le cambiamos el valor a la variable
        $entrada_publica_nueva = 1;
    }
    //llamammos al validador
    $validador = new ValidadorEntradaEditada($_POST['titulo'], $_POST['titulo_original'], $_POST['url'], $_POST['url_original'],
            htmlspecialchars($_POST['texto']), $_POST['texto_original'], $entrada_publica_nueva, $_POST['publicar_original'], Conexion :: obtener_conexion());
    //verificamos si no hay cambios
    if(!$validador-> hay_cambios()){
        //si el if se cumple se redirige al gestor de entradas
        Redireccion :: redirigir(RUTA_GESTOR_ENTRADAS);
    }  else {
        //se verifica que no haya errores al validar los datos
        if($validador -> entrada_valida()){
            //si el if se cumple se llama al metodo para actualizar
            $cambio_efectuado = RepositorioEntrada :: actualizar_entrada(Conexion :: obtener_conexion(), 
                    $_POST['id_entrada'], $validador -> obtener_titulo(), 
                    $validador-> obtener_url(), $validador-> obtener_texto(),
                    $validador-> obtener_checkbox());
            //se verifica que todo se haya actualizado
            if($cambio_efectuado){
                //redirigimos al gestor de entradas
                Redireccion :: redirigir(RUTA_GESTOR_ENTRADAS);
            }
        }
    }
}
include_once 'app/config.inc.php';
include_once 'app/Conexion.inc.php';
include_once 'app/Entrada.inc.php';
include_once 'app/RepositorioEntrada.inc.php';
include_once 'app/ControlSesion.inc.php';
include_once 'plantillas/documento-apertura.inc.php';
include_once 'plantillas/barra_navegacion.inc.php';
?>
<!--creamos el form-->
<div class="container">
    <div class="jumbotron">
        <h1 class="text-center">Editar entrada:</h1>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form class="form-nueva-entrada" method="post" action="<?php echo RUTA_EDITAR_ENTRADA; ?>">
                    <?php
                    if(isset($_POST['editar_entrada'])){
                        //recuperamos la id de la entrada por el hiden
                        $id_entrada = $_POST['id_editar'];
                        //creamos una nueva variable cuyo valor sera el metodo recien creado
                        $entrada_recuperada = RepositorioEntrada :: obtener_entrada_por_id(Conexion::obtener_conexion(), $id_entrada);
                        //cerramos la conexion
                        Conexion::cerrar_conexion();
                        //incluimos el form nuevo
                        include_once 'plantillas/entrada-recuperada.inc.php';
                    }elseif (isset($_POST['editar'])) {
                        //recuperamos la id de la entrada por el hiden
                        $id_entrada = $_POST['id_entrada'];
                        //creamos una nueva variable cuyo valor sera el metodo recien creado
                        $entrada_recuperada = RepositorioEntrada :: obtener_entrada_por_id(Conexion::obtener_conexion(), $id_entrada);
                        //cerramos la conexion
                        Conexion::cerrar_conexion();
                        
                        //redirigimos a la plantilla validada
                        include_once 'plantillas/entrada-recuperada_validada.inc.php';
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
<?php
include_once 'plantillas/documento-cierre.inc.php';
?>
