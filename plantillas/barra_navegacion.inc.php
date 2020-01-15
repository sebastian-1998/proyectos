<?php
//incluimos los archivos necesarios
include_once 'app/RepositorioUsuario.inc.php';
include_once 'app/ControlSesion.inc.php';
include_once 'app/config.inc.php';
include_once 'app/Redireccion.inc.php';
//abrimos la conexion
Conexion :: abrir_conexion();
//llamamos al metodo
$total_usuarios = RepositorioUsuario :: obtener_numero_usuarios(Conexion::obtener_conexion());
?>
<!--se crea la barra de navegacion y se elige la clase por defecto
navbar-static-top hace que la barra este fija aunque el usuario baje o suba en la pagina-->
<nav class="navbar navbar-default navbar-static-top">
    <!--se crea un divisor--->
    <div class="container">
        <!--se crea la cabezera-->
        <div class="navbar-header">
            <!--se crea un boton invisible el cual se encargara 
            de desplegar los elementos de la barra cuando esta se contraiga
            #sirve para representar o referenciar una id-->
            <button type="button" class="navbar-toggle collased" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <!--llamamos al lector de pantalla-->
                <!--span sirve para colocar un texto de solo 1 linea de forma horizontal-->
                <span class="sr-only">Este boton despliega la barra</span>
                <!--dibujamos el boton-->
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!--se crea un enlace
            href indica a donde se debe redirigir-->
            <a class="navbar-brand" href="<?php
            echo SERVIDOR?>">Sebastian Carrasco</a>
        </div>
        <!--se crea el cuerpo de la barra-->
        <div id="navbar" class="navbar-collapse collapse">
            <?php
            if(!ControlSesion :: sesion_iniciada()){
                
                ?>
                <!--creamos una lista desordenada con los elementos de la barra-->
                <ul class="nav navbar-nav">
                    <!--nav navbar-nav hace que los elementos de la lista se comporten como un menu-->
                    <li><a href="<?php
                    echo RUTA_ENTRADAS?>"><i class="fa fa-tasks" aria-hidden="true"></i>  Entradas</a></li>
                    <li><a href="<?php
                    echo RUTA_FAVORITOS?>"><i class="fa fa-gratipay" aria-hidden="true"></i> Favoritos</a></li>
                    <li><a href="<?php 
                    echo RUTA_AUTORES?>"><span class="glyphicon glyphicon-education" aria-hidden="true"></span> Autores</a></li>
                </ul>
                <?php
                }
                ?>
            <!--creamos otra lista pero esta vez alineada a la derecha-->
            <ul class="nav navbar-nav navbar-right">
<?php
                //se evalua si se ha iniciado sesion 
                if (ControlSesion :: sesion_iniciada()) {
                    //si se a iniciado se muestran enlaces diferentes 
?>
                    <li>
                        <a href="<?php echo RUTA_PERFIL;?>">
                            <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                            <!--mostramos el nombre del usuario-->
                            <?php
                            echo ' ' . $_SESSION['nombre_usuario'];?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php
                        echo RUTA_GESTOR;?>">
                            <span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span> Gestor
                        </a>
                    </li>
                    
                    <li>
                        <a href="<?php
                        echo RUTA_LOGOUT;?>">
                            <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Cerrar sesión
                        </a>
                    </li>
<?php
                } else {
                    //si no se mantienen los mismos de siempre
?>
                    <li>
                        <a href="#">
                            <span class="glyphicon glyphicon-user" aria-hidden="true"></span> 
                            Usuarios registrados:
<?php
                            //mostramos el total de usuarios
                            echo $total_usuarios;
?>
                        </a>
                    </li>
                    <li><a href="<?php
                    echo RUTA_LOGIN?>"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Iniciar sesion</a></li>
                    <li><a href="<?php
                    echo RUTA_REGISTRO?>"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Registro</a></li>
<?php
                    }
?>
            </ul>
        </div>
    </div>
</nav>
