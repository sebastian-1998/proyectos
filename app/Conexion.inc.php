<?php
class Conexion{
    //creamos el atributo necesario
    private static $conexion;
    //creamos el metodo para abrir la conexion
    public static function abrir_conexion(){
        //evaluamos si existe o no conexion
        if(!isset(self::$conexion)){
            //si se cumple se entra en el try-catch
            try {
                include_once 'config.inc.php';
                //iniciamos la conexion
                self::$conexion = new PDO('mysql:host='.NOMBRE_SERVIDOR.'; dbname='.NOMBRE_BASE_DATOS, NOMBRE_USUARIO, PASSWORD);
                //configuramos el modo de errores
                self::$conexion-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //indicamos que use la codificacion utf8
                self::$conexion ->exec("SET CHARACTER SET utf8");
            } catch (PDOException $ex) {
                print "Error al conectar con la BD: ". $ex-> getMessage() . "<br>";
                die();
                
            }
            
        }
    }
    //metodo cerrar conexion
    public static function cerrar_0conexion(){
        //evaluamos si existe o no conexion
        if(isset(self::$conexion)){
            //si el if se cumple se destruye el objeto conexion
            self::$conexion = null;
            
        }
    }
    //metodo obtener conexion
    public static function obtener_conexion(){
        //obtenemos una instancia al objeto conexion
        return self::$conexion;
    }
}
?>
