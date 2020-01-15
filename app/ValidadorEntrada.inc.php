<?php
//incluimos los archivos necesarios
include_once 'app/RepositorioEntrada.inc.php';
include_once 'app/Validador.inc.php';
//creamos la clase y se indica de que clase es heredera
class ValidadorEntrada extends Validador{

    //creamos el constructor
    public function __construct($titulo, $url, $texto, $conexion){
        //iniciamos los valores
        $this-> aviso_inicio = "<br><div class='alert alert-danger' role='alert'>";
        $this-> aviso_cierre = "</div>";
        $this-> titulo = "";
        $this-> url = "";
        $this-> texto = "";
        $this-> error_titulo = $this-> validar_titulo($conexion, $titulo);
        $this-> error_url = $this-> validar_url($conexion, $url);
        $this-> error_texto = $this-> validar_texto($conexion, $texto);
    }
    
}