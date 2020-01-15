<?php
class RecuperacionClave{
    //creamos sus atributos
    private $id;
    private $usuario_id;
    private $url_secreta;
    private $fecha;
    //creamos el constructor
    public function __construct($id, $usuario_id, $url_secreta, $fecha){
        //iniciamos los valores en el constructor
        $this-> id = $id;
        $this-> usuario_id = $usuario_id;
        $this-> url_secreta = $url_secreta;
        $this-> fecha = $fecha;
    }
}