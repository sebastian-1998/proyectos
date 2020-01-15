<?php
include_once 'app/Usuario.inc.php';
class RepositorioRecuperacionClave{
    //creamos las funciones necesarias
    public static function generar_peticion($conexion, $id_usuario, $url_secreta) {
        //se crea una variable para saber si se a insertado o no
        $peticion_generada = false;
        //se evalua si tenemos conexion
        if (isset($conexion)) {
            try {
                //se crea la sentencia a realizar
                $sql = "INSERT INTO recuperacion_clave(usuario_id, url_secreta, fecha) VALUES (:usuario_id, :url_secreta, NOW())" ;
                //con prepare se evita la injeccion de codigo sql
                $sentencia = $conexion -> prepare($sql);
                //se indican los parametros
                $sentencia -> bindParam(':usuario_id', $id_usuario, PDO :: PARAM_STR);
                $sentencia -> bindParam(':url_secreta', $url_secreta, PDO :: PARAM_STR);
                //se ejecuta la sentencia si no no funcionara
                $peticion_generada = $sentencia -> execute();
            } catch(PDOException $ex) {
                //en caso de error se muestra un mensaje
                print 'ERROR' . $ex -> getMessage();
			}
		}
        return $peticion_generada;
	}
        
    //metodo para saber si existe la url o no
     public static function url_secreta_existe($conexion, $url_secreta){
         //creamos un boolean y lo iniciamos como verdadero
        $url_existe = false;
        //comprobamos si la conexion existe o no
        if(isset($conexion)){
            try {
                //creamos la sentencia sql a realizar
                $sql = "SELECT * FROM recuperacion_clave WHERE url_secreta = :url_secreta";
                //la variable sentencia se encarga de preparar el sql y evitar la sqlinjeccion
                $sentencia = $conexion -> prepare($sql);
                //indicamos el parametro
                $sentencia -> bindParam(':url_secreta', $url_secreta, PDO::PARAM_STR);
                //ejecutamos la sentencia
                $sentencia -> execute();
                //recuperamos todos los usuarios que cumplan con la condicion
                $resultado = $sentencia -> fetchAll();
                //contamos cuantos resultados existen
                if(count($resultado)){
                    //si el if se cumple osea existe un registro con ese email se deja como verdadero
                    $url_existe = true;
                }  else {
                    //si no se cumple entonces el email no existe
                    $url_existe = false;
                }
            } catch (PDOException $ex) {
                print "Error al obtener los datos" .$ex -> getMessage();
            }
        }
        //devolvemos el dato
        return $url_existe;
        
     }
     public static function obtener_id_usuario_mediante_url_secreta($conexion, $url_secreta){
         //creamos un boolean y lo iniciamos como null
        $id_usuario = null;
        //comprobamos si la conexion existe o no
        if(isset($conexion)){
            try {
                //incluimos el archivo necesario
                include_once 'RecuperacionClave.inc.php';
                //creamos la sentencia sql a realizar
                $sql = "SELECT * FROM recuperacion_clave WHERE url_secreta = :url_secreta";
                //la variable sentencia se encarga de preparar el sql y evitar la sqlinjeccion
                $sentencia = $conexion -> prepare($sql);
                //indicamos el parametro
                $sentencia -> bindParam(':url_secreta', $url_secreta, PDO::PARAM_STR);
                //ejecutamos la sentencia
                $sentencia -> execute();
                //recuperamos todos los usuarios que cumplan con la condicion
                $resultado = $sentencia -> fetch();
                //se evalua si el resultado no esta vacio
                if(!empty($resultado)){
                    //obtenemos la id
                    $id_usuario = $resultado['usuario_id'];
                }
            } catch (PDOException $ex) {
                print "Error al obtener los datos" .$ex -> getMessage();
            }
        }
        //devolvemos el dato
        return $id_usuario;
        
     }
}