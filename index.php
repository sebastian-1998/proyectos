<?php
//incluimos los archivos necesarios
include_once 'app/config.inc.php';
include_once 'app/Conexion.inc.php';
include_once 'app/Usuario.inc.php';
include_once 'app/Entrada.inc.php';
include_once 'app/Comentario.inc.php';
//incluimos los repositorios
include_once 'app/RepositorioUsuario.inc.php';
include_once 'app/RepositorioEntrada.inc.php';
include_once 'app/RepositorioComentario.inc.php';

global $gestor_actual;
//recuperamos la url
$componentes_url = parse_url($_SERVER["REQUEST_URI"]);
//recuperamos solo la ruta
$ruta = $componentes_url['path'];
//vemos que partes forman la ruta
$partes_ruta = explode("/", $ruta);
//cualquier indice del array que tenga elementos en blanco sera eliminado
$partes_ruta = array_filter($partes_ruta);
//array_slice elimina los elementos vacios del array
$partes_ruta = array_slice($partes_ruta, 0);
$ruta_elegida = 'vistas/404.php';
//hacemos comprobaciones para saber si realmente la pagina solicitada no existe
if($partes_ruta[0] == 'blog'){
    //contamos cuantas partes de la ruta existen
    if(count($partes_ruta) == 1){
        //incluimos el archivo necesario
        $ruta_elegida = 'vistas/home.php';
        //si hay algo despues de blog que en este caso es la parte 1 de la ruta
    }else if(count($partes_ruta) == 2) {
        //se evalua que es y en base a eso se le cargan las vistas necesarias
        switch ($partes_ruta[1]){
            case 'login';
                //incluimos el archivo necesario
                $ruta_elegida = 'vistas/login.php';
                //detenemos la sentencia
                break;
            case 'logout';
                //incluimos el archivo necesario
                $ruta_elegida = 'vistas/logout.php';
                //detenemos la sentencia
                break;
            case 'registro';
                //incluimos el archivo necesario
                $ruta_elegida = 'vistas/registro.php';
                //creamos una variable 
                $gestor_actual = '';
                //detenemos la sentencia
                break;
            case 'gestor';
                //incluimos el archivo necesario
                $ruta_elegida = 'vistas/gestor.php';
                //detenemos la sentencia
                break;
            case 'relleno';
                //incluimos el archivo necesario
                $ruta_elegida = 'script/script-relleno.php';
                //detenemos la sentencia
                break;
            case 'nueva-entrada';
                //incluimos el archivo necesario
                $ruta_elegida = 'vistas/nueva-entrada.php';
                //detenemos la sentencia
                break;
            case 'borrar-entrada';
                //incluimos el archivo necesario
                $ruta_elegida = 'script/borrar-entrada.php';
                //detenemos la sentencia
                break;
            case 'editar-entrada';
                //incluimos el archivo necesario
                $ruta_elegida = 'vistas/editar-entrada.php';
                //detenemos la sentencia
                break;
            case 'nuevo-comentario';
                //incluimos el archivo necesario
                $ruta_elegida = 'vistas/nuevo-comentario.php';
                //detenemos la sentencia
                break;
            case 'borrar-comentario';
                //incluimos el archivo necesario
                $ruta_elegida = 'vistas/borrar-comentario.php';
                //detenemos la sentencia
                break;
            case 'editar-comentario';
                //incluimos el archivo necesario
                $ruta_elegida = 'vistas/editar-comentario.php';
                //detenemos la sentencia
                break;
            case 'recuperar-clave';
                //incluimos el archivo necesario
                $ruta_elegida = 'vistas/recuperar-clave.php';
                //detenemos la sentencia
                break;
            case 'generar-url-secreta';
                //incluimos el archivo necesario
                $ruta_elegida = 'script/generar-url-secreta.php';
                //detenemos la sentencia
                break;
            case 'mail';
                //incluimos el archivo necesario
                $ruta_elegida = 'vistas/prueba-mail.php';
                //detenemos la sentencia
                break;
            case 'buscar';
                //incluimos el archivo necesario
                $ruta_elegida = 'vistas/buscar.php';
                //detenemos la sentencia
                break;
            case 'perfil';
                //incluimos el archivo necesario
                $ruta_elegida = 'vistas/perfil.php';
                //detenemos la sentencia
                break;
        }
        //si la parte 3 de la ruta es registro-correcto
    }  else if(count($partes_ruta) == 3){
        if($partes_ruta[1] == 'registro-correcto'){
            //incluimos el archivo necesario
            $nombre = $partes_ruta[2];
            $ruta_elegida = 'vistas/registro-correcto.php';
        }
        //mostramos las entradas al presionar el boton
        if($partes_ruta[1] == 'entrada'){
            //comprobamos si la url existe o no
            $url = $partes_ruta[2];
            //abrimos la conexion
            Conexion::abrir_conexion();
            //llamamos al metodo necesario
            $entrada = RepositorioEntrada :: obtener_entrada_por_url(Conexion::obtener_conexion(), $url);
            //comprobamos si la entrada no es vacia
            if($entrada != null){
                //llamamos al metodo para poder recuperar el autor de la entrada
                $autor = RepositorioUsuario::obtener_usuario_por_id(Conexion::obtener_conexion(), $entrada -> obtener_autor_id());
                //mostramos los comentarios
                $comentarios = RepositorioComentario::obtener_comentarios(Conexion::obtener_conexion(), $entrada -> obtener_id());
                //mostramos las entradas al azar y llamamos al metodo recien creado y le pasamos conexion y el limite
                $entradas_al_azar = RepositorioEntrada::obtener_entradas_azar(Conexion::obtener_conexion(), 3); 
                //mostramos la entrada
                $ruta_elegida = 'vistas/entrada.php';
            }
        }
        //se evalua si la primera parte de la ruta es igual a gestor
        if($partes_ruta[1] == 'gestor'){
           //si se cumple entra en el switch case
            switch ($partes_ruta[2]){
                //si la segunda parte es entradas
                case 'entradas';
                    //entonces a gestor_actual se le pasa como valor entradas
                    $gestor_actual = 'entradas';
                    //se redirecciona al gestor
                    $ruta_elegida = 'vistas/gestor.php';
                    break;
                case 'comentarios';
                    //entonces a gestor_actual se le pasa como valor comentarios
                    $gestor_actual = 'comentarios';
                    //se redirecciona al gestor
                    $ruta_elegida = 'vistas/gestor.php';
                    break;
                case 'favoritos';
                    //entonces a gestor_actual se le pasa como valor favoritos
                    $gestor_actual = 'favoritos';
                    //se redirecciona al gestor
                    $ruta_elegida = 'vistas/gestor.php';
                    break;
               
            }
        }
        if($partes_ruta[1] == 'recuperacion-clave'){
            $url_personal = $partes_ruta[2];
            $ruta_elegida = 'vistas/recuperacion-clave.php';
        }
    }
}

//llamamos a la ruta_elegida
include_once $ruta_elegida;
