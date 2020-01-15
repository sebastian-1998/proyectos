<?php
//incluimos los archivos necesarios
$titulo = "Nueva entrada";
include_once 'app/config.inc.php';
include_once 'app/Conexion.inc.php';
include_once 'app/Entrada.inc.php';
include_once 'app/RepositorioEntrada.inc.php';
include_once 'app/ValidadorEntrada.inc.php';
include_once 'app/ControlSesion.inc.php';
include_once 'app/Redireccion.inc.php';
//creamos una variable
$entrada_publica = 0;
//evalua si se ha presionado guardar o no
if(isset($_POST['guardar'])){
    //abrimos la conexion
    Conexion :: abrir_conexion();
    //creamos un objeto de la clase ValidadorEntrada
    //htmlspecialchars-> filtra el texto en busca de caracteres raros y los cambia por caracteres mas entendibles
    $validador = new ValidadorEntrada($_POST['titulo'], $_POST['url'], htmlspecialchars($_POST['texto']), Conexion :: obtener_conexion());
    //se evalua si el checkbox ha sido presionado o no y si tiene el valor de si
    if(isset($_POST['publicar']) && $_POST['publicar'] == 'SI'){
        //la entrada pasa a publicada o 1
        $entrada_publica = 1;
    }
    //se evalua si el form esta validado correctamente
    if($validador -> entrada_valida()){
        //se evalua si se ha iniciado sesion
        if(ControlSesion :: sesion_iniciada()){
            //insertamos los datos
            $entrada = new Entrada('', $_SESSION['id_usuario'], $validador->obtener_url(), $validador->obtener_titulo(),
                    $validador->obtener_texto(), '', $entrada_publica);
            $entrada_insertada = RepositorioEntrada :: insertar_entrada(Conexion :: obtener_conexion(), $entrada);
            //se evalua si todo a salido bien o no
            if($entrada_insertada){
                //si todo a salido bien se redirige
                Redireccion::redirigir(RUTA_GESTOR_ENTRADAS);
            }
        }  else {
            //si no se ha iniciado sesion se redirige al login
            Redireccion::redirigir(RUTA_LOGIN);
        }
        //cerramos la conexion
        Conexion :: cerrar_conexion();
    }
    
}
include_once 'plantillas/documento-apertura.inc.php';
include_once 'plantillas/barra_navegacion.inc.php';
?>
<!--creamos el form-->
<div class="container">
    <div class="jumbotron">
        <h1 class="text-center">Crear nueva entrada:</h1>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form class="form-nueva-entrada" method="post" action="<?php echo RUTA_NUEVA_ENTRADA; ?>">
<?php
                //evalua si se ha presionado guardar o no
                if(isset($_POST['guardar'])){
                    //si se presiono se le carga el form validado
                    include_once 'plantillas/nueva-entrada-validada.inc.php';
                }  else {
                    //si no se ha pulsado se muestra el form vacio
                    include_once 'plantillas/nueva-entrada-vacia.inc.php';
                }
?>
            </form>
        </div>
    </div>
</div>
<?php
include_once 'plantillas/documento-cierre.inc.php';
?>
