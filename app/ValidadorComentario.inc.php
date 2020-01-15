<?php
//incluimos los archivos necesarios
include_once 'RepositorioComentario.inc.php';
//creamos la clase
class ValidadorComentario{
    //atributos necesarios
    private $aviso_inicio;
    private $aviso_cierre;
    private $entrada_id;
    private $titulo;
    private $texto;
    private $error_entrada_id;
    private $error_titulo;
    private $error_texto;
    //creamos el constructor
    public function __construct($entrada_id, $titulo, $texto){
        //iniciamos los valores
        $this-> aviso_inicio = "<br><div class='alert alert-danger' role='alert'>";
        $this-> aviso_cierre = "</div>";
        //todos los demas atributos se inician en blanco
        $this-> entrada_id = "";
        $this-> titulo = "";
        $this-> texto = "";
        $this-> error_entrada_id = $this-> validar_entrada_id($entrada_id);
        $this-> error_titulo = $this-> validar_titulo($titulo);
        $this-> error_texto = $this-> validar_texto($texto);
        
    }
    //creamos las funciones necesarias
    private function variable_iniciada($variable){
        //evaluamos si la variable a sido asignada a algo y si no esta vacia
        if(isset($variable) && !empty($variable)){
            //si se cumple el if entonces se retorna verdadero
            return true;
        }  else {
            //de lo contrario se devuelve falso
            return false;
        }
    }
    private function validar_entrada_id($entrada_id){
        //comprobamos si se ha seleccionado algo o no en el combobox de entrada_id
        if (!$this-> variable_iniciada($_POST['entrada_id'])) {
            //mostramos un mensaje
            return "Debes seleccionar una ID de entrada";
        }  else {
            //iniciamos el valor con lo proporcionado por el usuario
            $this-> entrada_id = $entrada_id;
        }
    }
    private function validar_titulo($titulo){
        //comprobamos si se ha dejado el campo titulo vacio
        if (!$this-> variable_iniciada($titulo)) {
             //mostramos un mensaje
            return "Haz dejado el campo titulo vacio";
        }  else {
            //iniciamos el valor con lo proporcionado por el usuario
            $this-> titulo = $titulo;
        }
        //se evalua el largo del titulo
        if(strlen($titulo)> 255){
            return"Has sobrepasado el largo permitido";
        }
    }
    private function validar_texto($texto){
        //comprobamos si se ha dejado el campo texto vacio
        if (!$this-> variable_iniciada($texto)) {
             //mostramos un mensaje
            return "Haz dejado el campo texto vacio";
        }  else {
            //iniciamos el valor con lo proporcionado por el usuario
            $this-> texto = $texto;
        }
    }
    //metodos para obtener los valores que ingrese el usuario
    public function obtener_entrada_id(){
        return $this-> $entrada_id;
    }
    public function obtener_titulo(){
        return $this-> $titulo;
    }
    public function obtener_texto(){
        return $this-> $texto;
    }
    //metodos para mostrar lo ingresado
    public function mostrar_entrada_id(){
        //evaluamos si no esta vacio
        if ($this-> entrada_id != ""){
            //si se cumple el if se muestra el dato
            echo 'value = "' . $this-> entrada_id . '"';
        }
    }
    public function mostrar_titulo(){
        //evaluamos si no esta vacio
        if ($this-> titulo != ""){
            //si se cumple el if se muestra el dato
            echo 'value = "' . $this-> titulo . '"';
        }
    }
    public function mostrar_texto(){
        //evaluamos si no esta vacio
        if ($this-> texto != "" && strlen(trim($this-> texto)) > 0){
            //si se cumple el if se muestra el dato
            echo $this-> texto;
        }
    }
    //metodos para mostrar los errores
    public function mostrar_error_entrada_id(){
        if($this-> error_entrada_id != ""){
            echo $this-> aviso_inicio . $this-> error_entrada_id . $this-> aviso_cierre;
        }
    }
    public function mostrar_error_titulo(){
        if($this-> error_titulo != ""){
            echo $this-> aviso_inicio . $this-> error_titulo . $this-> aviso_cierre;
        }
    }
    public function mostrar_error_texto(){
        if($this-> error_texto != ""){
            echo $this-> aviso_inicio . $this-> error_texto . $this-> aviso_cierre;
        }
    }
    //en esta parte me da error
    //metodo para validar que no hayan errores
    public function comentario_valido(){
        //se evaluan todos los errores que no se produjera ninguno
        //=== evalua que el valor a evaluar debe ser del mismo tipo y debe tener el mismo vslor
        if($this-> error_entrada_id === "" && $this-> error_titulo === "" 
                && $this-> error_texto === ""){
            //si el if se cumple se retorna verdadero
            return true;
        }else {
            //si no se cumple se devuelve falso
            return false;
        }
    }
}