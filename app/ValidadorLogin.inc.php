<?php
class ValidadorLogin{
    //creamos los atributos
    private $usuario;
    private $error;
    //creamos el constructor
    public function __construct($email, $clave, $conexion){
        $this-> error = "";
        //evaluamos si tanto el e-mail como la clave no estan iniciados y no estan vacios
        if(!$this-> variable_iniciada($email) || !$this-> variable_iniciada($clave)){
            //si lo anterior se cumple entonces iniciamos el usuario como null
            $this-> usuario = null;
            //mostramos un mensaje de error si alguno de los input no a sido llenado por el usuario
            $this-> error = "¡Debes introducir tu e-mail y tu contraseña para poder acceder"; 
        }  else {
            //si el if no se cumple entonces se procede a comprobar si los datos son correctos
            $this-> usuario = RepositorioUsuario::obtener_usuario_por_email($conexion, $email);
            //se comprueba si el objeto usuario existe o no
            //se comprueba si el usuario es null osea no exite y se verifica la contraseña cifrada si es igusl s ls proporcionada
            if(is_null($this->usuario) || !password_verify($clave, $this-> usuario -> obtener_password())){
                //se muestra un mensaje en caso de que no exista
                $this-> error = "Datos incorrectos";
            }
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
    //se crean los metodos necesarios
    public function obtener_usuario() {
        return $this-> usuario;
    }
    public function obtener_error() {
        return $this-> error;
    }
    public function mostrar_error() {
        //se evalua si produjo algun error
        if($this-> error !== ''){
            //se crea un mensaje de error de bootstrap
            echo "<br><div class='alert alert-danger' role='alert'>";
            //mostramos el error
            echo $this-> error;
            //se cierra el div y se hace otro salto de linea
            echo "</div><br>";
        }
    }
    
}
?>
