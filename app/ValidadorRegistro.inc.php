<?php
//incluimos el repositorio de usuario
include_once 'RepositorioUsuario.inc.php';
//creamos la clase 
class ValidadorRegistro{
    //creamos los atributos
    private $aviso_inicio;
    private $aviso_cierre;
    private $nombre;
    private $email;
    private $clave;
    private $error_nombre;
    private $error_email;
    private $error_clave1;
    private $error_clave2;
    //creamos el constructor
    public function __construct($nombre, $email, $clave1, $clave2, $conexion){
        $this-> aviso_inicio = "<br><div class='alert alert-danger' role='alert'>";
        $this-> aviso_cierre = "</div>";
        //iniciamos todo en blanco
        $this-> nombre = "";
        $this-> email = "";
        $this-> clave = "";
        $this-> error_nombre = $this-> validar_nombre($conexion, $nombre);
        $this-> error_email = $this-> validar_email($conexion, $email);
        $this-> error_clave1 = $this-> validar_clave1($clave1);
        $this-> error_clave2 = $this-> validar_clave2($clave1, $clave2);
        //se evalua que el error_clave1 y 2 sea igual a vacio si ambas se cumplen
        if($this-> error_clave1 === "" && $this-> error_clave2 === ""){
            //iniciamos la clave con cualquier valor ya sea de clave 1 o 2 ya que deben coincidir
            $this-> clave = $clave1;
        }
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
    
    private function validar_nombre($conexion, $nombre){
        //se evalua si el nombre no a sido iniciado
        if(!$this->variable_iniciada($nombre)){
            //si se cumple se muestra un mensaje
            return "¡Haz dejado el campo nombre vacio!";
            
        }  else {
            //si el if no se cumple se inicia el nombre con lo iniciado por el usuario
            $this-> nombre = $nombre;
        }
        //se evalua el largo de nombre
        if(strlen($nombre)<6 || strlen($nombre)>150){
            return "¡El nombre debe tener entre 6 a 150 caracteres!";
        }
        //evaluamos si el nombre existe o no
        if(RepositorioUsuario :: nombre_existe($conexion, $nombre)){
            return "¡El nombre ingresado ya existe!";
        }
        //si ninguno de los anteriores se cumple entonces se devuelve vacio
        return "";
    }
    
    private function validar_email($conexion, $email){
        //se evalua si el e-mail no a sido iniciado
        if(!$this->variable_iniciada($email)){
            //si se cumple se muestra un mensaje
            return "¡Haz dejado el campo e-mail vacio!";
            
        }  else {
            //si el if no se cumple se inicia el e-mail con lo iniciado por el usuario
            $this-> email = $email;
        }
        //se evalua si el e-mail existe o no
        if(RepositorioUsuario :: email_existe($conexion, $email)){
            return "¡El e-mail ingresado ya existe! <a href='#'>Recupere su contraseña</a>";
        }
        //si ninguno de los anteriores se cumple entonces se devuelve vacio
        return "";
    }
    
    private function validar_clave1($clave1){
        //se evalua si la clave no a sido iniciada
        if(!$this->variable_iniciada($clave1)){
            //si se cumple se muestra un mensaje
            return "¡Haz dejado el campo clave vacio!";
            
        }else {
            //si el if no se cumple se inicia el e-mail con lo iniciado por el usuario
            $this-> clave1 = $clave1;
        }
        //si ninguno de los anteriores se cumple entonces se devuelve vacio
        return "";
        
    }
    private function validar_clave2($clave1, $clave2){
        //se evalua si la clave no a sido iniciada
        if(!$this->variable_iniciada($clave1)){
            //si se cumple se muestra un mensaje
            return "¡Haz dejado el campo clave vacio!";
        }
        //se evalua si la clave no a sido iniciada
        if(!$this->variable_iniciada($clave2)){
            //si se cumple se muestra un mensaje
            return "¡Debes repetir tu contraseña!";  
        }
        if($clave1 !== $clave2){
            return "¡Ambas contrseñas deben coincidir!"; 
        }
    
        return "";
    }
    //creamos funciones para poder usar los metodos
    public function obtener_nombre(){
        //devolvemos el dato necesario
        return $this->nombre;
    }
    public function obtener_email(){
        //devolvemos el dato necesario
        return $this->email;
    }
    public function obtener_clave(){
        //devolvemos el dato necesario
        return $this->clave;
    }
    //devolvemos los errores
    public function obtener_error_nombre(){
        //devolvemos el dato necesario
        return $this->error_nombre;
    }
    public function obtener_error_email(){
        //devolvemos el dato necesario
        return $this->error_email;
    }
    public function obtener_error_clave1(){
        //devolvemos el dato necesario
        return $this->error_clave1;
    }
    public function obtener_error_clave2(){
        //devolvemos el dato necesario
        return $this->error_clave2;
    }
    //se crea un metodo para evitar que al enviar los datos el nombre se borre
    public function mostrar_nombre(){
        //evaluamos si el usuario a dejado el nombre vacio o no
        if($this->nombre !== ""){
            //si el if se cumple se inicia el nombre con el valor suministrado
            echo 'value="'. $this-> nombre .'"';
        }
    }
    public function mostrar_error_nombre(){
       //se evalua si el error de nombre esta vacio osea no hay error
        if($this-> error_nombre !== ""){
            //si se produjo un error entonces se muestra el mensaje
            echo $this-> aviso_inicio . $this-> error_nombre . $this-> aviso_cierre;
        }
    }
    public function mostrar_email(){
        //evaluamos si el usuario a dejado el emailvacio o no
        if($this->email !== ""){
            //si el if se cumple se inicia el email con el valor suministrado
            echo 'value="'. $this-> email .'"';
        }
    }
    public function mostrar_error_email(){
       //se evalua si el error de email esta vacio osea no hay error
        if($this-> error_email !== ""){
            //si se produjo un error entonces se muestra el mensaje
            echo $this-> aviso_inicio . $this-> error_email . $this-> aviso_cierre;
        }
    }
    public function mostrar_error_clave1(){
       //se evalua si el error de clave1 esta vacio osea no hay error
        if($this-> error_clave1 !== ""){
            //si se produjo un error entonces se muestra el mensaje
            echo $this-> aviso_inicio . $this-> error_clave1 . $this-> aviso_cierre;
        }
    }
    public function mostrar_error_clave2(){
       //se evalua si el error de clave2 esta vacio osea no hay error
        if($this-> error_clave2 !== ""){
            //si se produjo un error entonces se muestra el mensaje
            echo $this-> aviso_inicio . $this-> error_clave2 . $this-> aviso_cierre;
        }
    }
    public function registro_validado(){
        //se evaluan todos los errores que no se produjera ninguno
        //=== evalua que el valor a evaluar debe ser del mismo tipo y debe tener el mismo vslor
        if($this-> error_nombre ==="" && $this->error_email ==="" 
                && $this-> error_clave1 === "" && $this-> error_clave2 === ""){
            //si el if se cumple se retorna verdadero
            return true;
        }  else {
            //si no se cumple se devuelve falso
            return false;
        }
    }
    
}
?>
