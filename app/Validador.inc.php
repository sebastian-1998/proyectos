<?php
//abstract impide que otras clases o forms puedan usar esta super clase por si mismas
abstract class Validador{
        
    //creamos los atributos de la clase
    //protected impide que otras clases que no hereden de la clase padre puedan acceder a los atributos
    protected $aviso_inicio;
    protected $aviso_cierre;
    protected $titulo;
    protected $url;
    protected $texto;
    
    //creamos errores por cada campo
    protected $error_titulo;
    protected $error_url;
    protected $error_texto;
    
    //creamos el constructor vacio ya que al tener la clase ValidadorEntrada un constructor se sobreescribe el del padre por el del hijo
    function __construct(){
        
    }
    //creamos las funciones necesarias
    protected function variable_iniciada($variable){
        //evaluamos si la variable a sido asignada a algo y si no esta vacia
        if(isset($variable) && !empty($variable)){
            //si se cumple el if entonces se retorna verdadero
            return true;
        }  else {
            //de lo contrario se devuelve falso
            return false;
        }
    }
    protected function validar_titulo($conexion, $titulo){
        //se evalua si no esta iniciado el titulo
        if(!$this-> variable_iniciada($titulo)){
            //si se cumple se muestra un mensaje
            return "¡Haz dejado el campo titulo vacio!";
        }  else {
            //se inicia el titulo con lo proporcionado por el usuario 
            $this-> titulo = $titulo;
        }
        //se evalua el largo del titulo
        if(strlen($titulo)<6 || strlen($titulo>255)){
            //se muestra un mensaje
            return "¡El titulo debe tener entre 6 y un maximo de 255 caracteres";
        }
        //se evalua si el titulo ya existe
        if(RepositorioEntrada :: titulo_existe($conexion, $titulo)){
            //se muestra un mensaje
            return "¡El titulo ingresado ya existe!";
        }
    }
    protected function validar_url($conexion, $url){
        //se evalua si no esta iniciada la url 
        if(!$this-> variable_iniciada($url)){
            //si se cumple se muestra un mensaje
            return "¡Haz dejado el campo url vacio!";
        }  else {
            //se inicia la url con lo proporcionado por el usuario 
            $this-> url = $url;
        }
        //con str_replace indicamos que caracter queremos reemplazar ademas de por cual lo deseamos reemplazar y se indica a que string se debe hacer esto
        // /\s+/-> permite identificar todos los caracteres en blanco o espacios
        $url_tratada = str_replace(' ', '', $url);
        $url_tratada = preg_replace('/\s+/', '', $url_tratada);
        //se valida que en la url no existan espacios en blanco
        //si la cantidad de caracteres de url no coinciden despues de quitar los espacios signfica que
        //no es valida
        if(strlen($url) != strlen($url_tratada)){
            return "¡La url no puede contener espacios en blanco!";
        }
        //se evalua que no exista otra entrada con esa url
        if(RepositorioEntrada :: url_existe($conexion, $url)){
            //se muestra un mensaje
            return "¡La url ingresada ya existe en otra entrada!";
        }
    }
    protected function validar_texto($conexion, $texto){
        //se evalua si no esta iniciado el texto 
        if(!$this-> variable_iniciada($texto)){
            //si se cumple se muestra un mensaje
            return "¡Haz dejado el campo texto vacio!";
        }  else {
            //se inicia el texto con lo proporcionado por el usuario 
            $this-> texto = $texto;
        }
    }
    //creamos los metodos necesarios para usar las validaciones
    public function obtener_titulo(){
        //devolvemos el valor
        return $this-> titulo;
    }
    public function obtener_url(){
        return $this-> url;
    }
    public function obtener_texto(){
        return $this-> texto;
    }
    //se crea un metodo para evitar que al enviar los datos el titulo no se borre
    public function mostrar_titulo(){
        //evaluamos si el usuario a dejado el titulo vacio o no
        if($this->titulo != ""){
            //si el if se cumple se inicia el titulo con el valor suministrado
            echo 'value="'. $this-> titulo .'"';
        }
    }
    public function mostrar_url(){
        //evaluamos si el usuario a dejado la url vacia o no
        if($this->url != ""){
            //si el if se cumple se inicia la url con el valor suministrado
            echo 'value="'. $this-> url .'"';
        }
    }
    public function mostrar_texto(){
        //evaluamos si el usuario a dejado el titulo vacio o no y si no contiene espacios en blanco
        if($this->texto != "" && strlen(trim($this->texto))> 0){
            //mostramos el texto
            echo $this-> texto;
        }
    }
    public function mostrar_error_titulo(){
        //se evalua si el error de titulo esta vacio osea no hay error
        if($this-> error_titulo != ""){
            //si se produjo un error entonces se muestra el mensaje
            echo $this-> aviso_inicio . $this-> error_titulo . $this-> aviso_cierre;
        }
    }
    public function mostrar_error_url(){
        //se evalua si el error de url esta vacio osea no hay error
        if($this-> error_url != ""){
            //si se produjo un error entonces se muestra el mensaje
            echo $this-> aviso_inicio . $this-> error_url . $this-> aviso_cierre;
        }
    }
    public function mostrar_error_texto(){
        //se evalua si el error de texto esta vacio osea no hay error
        if($this-> error_texto != ""){
            //si se produjo un error entonces se muestra el mensaje
            echo $this-> aviso_inicio . $this-> error_texto . $this-> aviso_cierre;
        }
    }
    public function entrada_valida(){
        //se evaluan todos los errores que no se produjera ninguno
        //=== evalua que el valor a evaluar debe ser del mismo tipo y debe tener el mismo vslor
        if($this-> error_titulo == "" && $this->error_url == "" 
                && $this-> error_texto == ""){
            //si el if se cumple se retorna verdadero
            return true;
        }  else {
            //si no se cumple se devuelve falso
            return false;
        }
    }
}