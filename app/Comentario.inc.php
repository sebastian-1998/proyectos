<?php
class Comentario{
    //creamos los atributos de la clase
    private $id;
    private $autor_id;
    private $entrada_id;
    private $titulo;
    private $texto;
    private $fecha;
    //creamos el constructor
    public function __construct($id, $autor_id, $entrada_id, $titulo, $texto, $fecha){
        //iniciamos los valores
        $this-> id = $id;
        $this-> autor_id = $autor_id;
        $this-> entrada_id = $entrada_id;
        $this-> titulo = $titulo;
        $this-> texto = $texto;
        $this-> fecha = $fecha;
    }
    
    //creamos los metodos para obtener los datos
    public function obtener_id(){
        return $this-> id;
    }
    public function obtener_autor_id(){
        return $this-> autor_id;
    }
    public function obtener_entrada_id(){
        return $this-> entrada_id;
    }
    public function obtener_titulo(){
        return $this-> titulo;
    }
    public function obtener_texto(){
        return $this-> texto;
    }
    public function obtener_fecha(){
        return $this-> fecha;
    }
    //creamos los metodos para cambiar los valores
    public function cambiar_titulo($titulo){
        $this-> titulo = $titulo;
    }
    public function cambiar_texto($texto){
        $this-> texto = $texto;
    }
}
?>
