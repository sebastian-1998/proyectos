<?php
//incluimos los archivos necesarios
$titulo = 'Gestor';
include_once 'plantillas/documento-apertura.inc.php';
include_once 'plantillas/barra_navegacion.inc.php';
include_once 'plantillas/panel_control_apertura.inc.php';
include_once 'app/RepositorioEntrada.inc.php';
include_once 'app/RepositorioComentario.inc.php';
include_once 'app/Conexion.inc.php';

switch ($gestor_actual){
    //si esta vacio se incluye un gestor generico
    case '';
        //creamos la variable necesaria y llamamos al metodo correspondiente
        $cantidad_entradas_activas = RepositorioEntrada :: contar_entradas_activas_usuario(Conexion::obtener_conexion(), $_SESSION['id_usuario']);
        $cantidad_entradas_inactivas = RepositorioEntrada :: contar_entradas_inactivas_usuario(Conexion::obtener_conexion(), $_SESSION['id_usuario']);
        $cantidad_comentarios = RepositorioComentario :: contar_comentarios_usuario(Conexion::obtener_conexion(), $_SESSION['id_usuario']);
        include_once 'plantillas/gestor-generico.inc.php';
        break;
    case 'entradas';
        //llamamos al metodo recien creado
        $array_entradas = RepositorioEntrada :: obtener_entradas_usuario_fecha_descendente(Conexion::obtener_conexion(), $_SESSION['id_usuario']);
        //incluimos el archivo necesario
        include_once 'plantillas/gestor-entradas.inc.php';
        break;
    case 'comentarios';
        //llamamos al metodo recien creado
        $array_comentarios = RepositorioComentario :: mostrar_comentarios_por_usuario(Conexion::obtener_conexion(), $_SESSION['id_usuario']);
        //incluimos el archivo necesario
        include_once 'plantillas/gestor-comentarios.inc.php';
        break;
    case 'favoritos';
        include_once 'plantillas/gestor-favoritos.inc.php';
        break;
}
include_once 'plantillas/panel_control_cierre.inc.php';