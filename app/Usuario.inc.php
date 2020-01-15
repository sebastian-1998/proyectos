<?php
class Usuario{
    //creamos los atributos de la clase
    private $id;
    private $nombre;
    private $email;
    private $password;
    private $fecha_registro;
    private $activo;
    //creamos el constructor
    public function __construct($id, $nombre, $email, $password, $fecha_registro, $activo){
        //hacemos que tanto el atributo de la clase como del constructor tengan el mismo valor
        $this-> id = $id;
        $this-> nombre = $nombre;
        $this-> email = $email;
        $this-> password = $password;
        $this-> fecha_registro = $fecha_registro;
        $this-> activo = $activo;
    }
    //creamos los metodos para obtener los valores
    public function obtener_id(){
        return $this-> id;
    }
    public function obtener_nombre(){
        return $this-> nombre;
    }
    public function obtener_email(){
        return $this-> email;
    }
    public function obtener_password(){
        return $this-> password;
    }
    public function obtener_fecha_registro() {
        return $this -> fecha_registro;
    }
    public function esta_activo(){
        return $this-> activo;
    }
    //creamos los metodos para cambiar los valores
    public function cambiar_nombre($nombre){
        $this-> nombre = $nombre;
    }
    public function cambiar_email($email){
        $this-> email = $email;
    }
    public function cambiar_password($password){
        $this-> password = $password;
    }
    public function cambiar_activo($activo){
        $this-> activo = $activo;
    }
    
}
