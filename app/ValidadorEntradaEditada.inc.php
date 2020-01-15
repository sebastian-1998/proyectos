<?php
//incluimos los archivos necesarios
include_once 'app/RepositorioEntrada.inc.php';
include_once 'app/Validador.inc.php';
class ValidadorEntradaEditada extends Validador{
    //creamos los atributos necesarios
    //en las clases hijas no es necesario indicar un tipo de variable como protected ya que no tienen que pasar valores o metodos a la clase padre
    //pero si la clase es padre de otra entonces si deben ser protected
    private $cambios_realizados;
    private $checkbox;
    //se crean variables para comparar si se han echo cambios en la bd a los campos del form
    private $titulo_original;
    private $url_original;
    private $texto_original;
    private $checkbox_original;
    //sobreescribimos el constructor
    public function __construct($titulo, $titulo_original, $url, $url_original, $texto, $texto_original, $checkbox, $checkbox_original, $conexion){
        //se inician los valores
        $this-> titulo = $this-> devolver_variable_si_iniciada($titulo);
        $this-> url = $this-> devolver_variable_si_iniciada($url);
        $this-> texto = $this-> devolver_variable_si_iniciada($texto);
        $this-> checkbox = $this-> devolver_variable_si_iniciada($checkbox);
        
        $this-> titulo_original = $this-> devolver_variable_si_iniciada($titulo_original);
        $this-> url_original = $this-> devolver_variable_si_iniciada($url_original);
        $this-> texto_original = $this-> devolver_variable_si_iniciada($texto_original);
        $this-> checkbox_original = $this-> devolver_variable_si_iniciada($checkbox_original);
        //comprobamos si se han echo cambios o no
        if($this-> titulo == $this-> titulo_original 
                && $this-> url == $this-> url_original 
                && $this-> texto == $this-> texto_original 
                && $this-> checkbox == $this-> checkbox_original){
            //si lo anterior se cumple entonces el usuario no ha echo ningun cambio
            $this-> cambios_realizados = false;
        }  else {
            //en caso contrario si se han cambiado los valores entonces se retorna verdadero
            $this-> cambios_realizados = true;
        }
        //si se han echo cambios se valida todo otra vez
        if($this->cambios_realizados){
            $this-> aviso_inicio = "<br><div class='alert alert-danger' role='alert'>";
            $this-> aviso_cierre = "</div>";
            //se compara si los valores son iguales o no
            if($this-> titulo !== $this-> titulo_original){
                //llamamos a la funcion que valida el titulo
                $this-> error_titulo = $this-> validar_titulo($conexion, $titulo);
            }  else {
                $this-> error_titulo = "";
            }
            if($this-> url !== $this-> url_original){
                //llamamos a la funcion que valida la url
                $this-> error_url = $this-> validar_url($conexion, $url);
            }  else {
                $this-> error_url = "";
            }
            if($this-> texto !== $this-> texto_original){
                //llamamos a la funcion que valida el texto
                $this-> error_texto = $this-> validar_texto($conexion, $texto);
            }  else {
                $this-> error_texto = "";
            }
        }  else {
            //redirigimos
        }
        
    }
    //creamos una funcion que devuelve una variable siempre que lo que se pase como valor este iniciado
    private function devolver_variable_si_iniciada($variable){
        //se comprueba si la variable esta iniciada
        if($this-> variable_iniciada($variable)){
            //si el if se cumple se devuelve verdadero
            return $variable;
        }  else {
            //en caso contrario se devuelve un string vacio
            return "";
        }
    }
    //funcion que verifica si hay cambios o no
    public function hay_cambios(){
        //en caso de algun cambio se muestran
        return $this-> cambios_realizados;
    }
    //creamos los metodos para devolver los valores originales
    public function obtener_titulo_original(){
        return $this-> titulo_original;
    }
    public function obtener_url_original(){
        return $this-> url_original;
    }
    public function obtener_texto_original(){
        return $this-> texto_original;
    }
    public function obtener_checkbox_original(){
        return $this-> checkbox_original ;
    }
    public function obtener_checkbox(){
        return $this-> checkbox;
    }
    
}
?>