<?php
class Redireccion{
    //creamos el metodo
    public static function redirigir($url){
        //creamos los parametros necesarios para redirigir
        //indicamos la location y concatenamos la url con el .
        //true hace que la direccion cabie sin esto la direccion se mantiene igual
        //301 indica redireccion
        header('Location: ' . $url, true, 301);
        //detenemos la ejecucion
        exit();
    }
}
