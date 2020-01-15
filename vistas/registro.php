<?php
include_once 'app/config.inc.php';
include_once 'app/Conexion.inc.php';
include_once 'app/Usuario.inc.php';
include_once 'app/RepositorioUsuario.inc.php';
include_once 'app/ValidadorRegistro.inc.php';
include_once 'app/Redireccion.inc.php';

//se evalua si se a presionado o no enviar
if(isset($_POST['enviar'])){
    //abrimos la conexion
    Conexion :: abrir_conexion();
    //creamos una variable y la iniciamos como un nuevo objeto de la clase ValidadorRegistro
    $validador = new ValidadorRegistro($_POST['nombre'], $_POST['email'], 
    //pasamos el metodo obtener_conexion
    $_POST['clave1'], $_POST['clave2'], Conexion :: obtener_conexion());
    
    //se evalua que el registro_valido sea verdadero
    if($validador -> registro_validado()){
        //si el if es verdadero osea no hay errores se inserta el usuario
        $usuario = new Usuario('', $validador -> obtener_nombre(), 
                $validador -> obtener_email(), 
                //password_hash-> PASSWORD_DEFAULT encripta la password en un solo sentido y es mas dificil adivinarla
                password_hash($validador -> obtener_clave(), PASSWORD_DEFAULT), 
                '', 
                '');
        //creamos un boolean y llamamos al metodo para insertar
        $usuario_insertado = RepositorioUsuario :: insertar_usuario(Conexion :: obtener_conexion(), $usuario);
        //comprobamos si se inserto o no el usuario
        if($usuario_insertado){
            //redirigimos a registro-correcto y le concatenamos el nombre proporcionado
            Redireccion::redirigir(RUTA_REGISTRO_CORRECTO. '/' . $usuario-> obtener_nombre());
        }
    }
    //cerramos la conexion
    Conexion:: cerrar_conexion();
    
}
$titulo = 'Registro';
include_once 'plantillas/documento-apertura.inc.php';
include_once 'plantillas/barra_navegacion.inc.php';
?>
<!--creamos el form-->
<div class="container">
    <div class="jumbotron">
        <h1 class="text-center">Formulario de registro</h1>
    </div>
</div>
<!--dividimos el form en 2 partes-->
<div class="container">
    <div class="row">
        <div class="col-md-6 text-center">
            <!--creamos las instrucciones-->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Instrucciones:
                    </h3>
                </div>
                <div class="panel-body">
                    <br>
                    <p class="text-justify">
                        Para unirte al blog, debes introducir un nombre 
                        de usuario, tu e-mail y una contraseña. El e-mail que ingreses
                        debe ser real ya que lo necesitaras para gestionar tu cuenta.
                        Te recomendamos que la contraseña que uses contenga letras en minúscula, mayúsculas
                        y simbolos.
                        ATTE: Administrador.
                    </p>
                    <br>
                    <a href="<?php echo RUTA_LOGIN; ?>">¿Ya posees cuenta?</a>
                    <br>
                    <br>
                    <a href="<?php echo RUTA_RECUPERAR_CLAVE; ?>">¿Olvidaste tu contraseña?</a>
                    <br>
                    <br>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 text-center">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Introduce tus datos:
                    </h3>
                </div>
                <div class="panel-body">
                    <form role="form" method="post" action="<?php echo RUTA_REGISTRO ?>">
<?php
                        //se evalua si se a presionado o no enviar
                        if(isset($_POST['enviar'])){
                            //si se presiono se le carga el form validado
                            include_once 'plantillas/registro_validado.inc.php';
                        }  else {
                            //si el if no se cumple se carga el form sin validar
                            include_once 'plantillas/registro_vacio.inc.php';
                        }
?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include_once 'plantillas/documento-cierre.inc.php';
