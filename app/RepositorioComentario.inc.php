<?php
//incluimos los archivos necesarios
include_once 'app/config.inc.php';
include_once 'app/Conexion.inc.php';
include_once 'app/Comentario.inc.php';
include_once 'app/Entrada.inc.php';
class RepositorioComentario{
    //creamos los metodos necesarios
    public static function insertar_comentario($conexion, $comentario){
        //creamos un boolean y lo iniciamos como falso
        $comentario_insertado = false;
        //comprobamos si la conexion existe o no
        if(isset($conexion)){
            try {
                //creamos la sentencia sql a realizar
                $sql = "INSERT INTO comentarios(autor_id, entrada_id, titulo, texto, fecha) VALUES(:autor_id, :entrada_id, :titulo, :texto, NOW())";
                //la variable sentencia se encarga de preparar el sql y evitar la sqlinjeccion
                $sentencia = $conexion -> prepare($sql);
                //indicamos los parametros a insertar con variables temporales
                $autor_idtemp = $comentario -> obtener_autor_id();
                $entrada_idtemp = $comentario -> obtener_entrada_id();
                $titulotemp = $comentario->obtener_titulo();
                $textotemp = $comentario-> obtener_texto();
                $sentencia -> bindParam(':autor_id', $autor_idtemp, PDO::PARAM_STR);
                $sentencia -> bindParam(':entrada_id', $entrada_idtemp, PDO::PARAM_STR);
                $sentencia -> bindParam(':titulo', $titulotemp, PDO::PARAM_STR);
                $sentencia -> bindParam(':texto', $textotemp, PDO::PARAM_STR);
                //ejecutamos la sentencia y se lo pasamos como valor al usuario_insertado
                $comentario_insertado = $sentencia -> execute();
            } catch (PDOException $ex) {
                 print "Error al insertar los datos" .$ex -> getMessage();
            }
        }
        //devolvemos el valor de usuario_insertado
        return $comentario_insertado;
        
    }
    //metodo recuperar comentarios de entrada concreta
    public static function obtener_comentarios($conexion, $entrada_id){
        //creamos un array vacio
        $comentarios = array();
        //comprobamos si la conexion existe o no
        if(isset($conexion)){
            try {
                //creamos la sentencia sql a realizar
                $sql = "SELECT * FROM comentarios WHERE entrada_id = :entrada_id";
                //la variable sentencia se encarga de preparar el sql y evitar la sqlinjeccion
                $sentencia = $conexion -> prepare($sql);
                //indicamos el parametro necesario
                $sentencia -> bindParam(':entrada_id', $entrada_id, PDO::PARAM_STR);
                //ejecutamos la sentencia
                $sentencia -> execute();
                //recuperamos todos los resultados
                $resultado = $sentencia -> fetchAll();
                //verificamos cuantos comentarios se han recuperado
                if(count($resultado)){
                    //recorremos el array
                    foreach ($resultado as $fila){
                    //añadimos lo recuperado al array entradas
                        $comentarios[] = new Comentario(
                                $fila['id'], $fila['autor_id'], $fila['entrada_id'], $fila['titulo'],
                                $fila['texto'], $fila['fecha']
                                ); 
                    }
                } 
                
            } catch (PDOException $ex) {
                print "Error al consultar los datos" .$ex -> getMessage();
            }
        }
        //retornamos el valor
        return $comentarios;
    }
    //creamos los metodos para poder devolver los comentarios activos e inactivos
    public static function contar_comentarios_usuario($conexion, $id_usuario){
        $total_comentarios = 0;
        //comprobamos si la conexion existe o no
        if(isset($conexion)){
            try {
                //creamos la sentencia sql a realizar
                $sql = "SELECT COUNT(*) as total_comentarios FROM comentarios WHERE autor_id = :autor_id";
                //la variable sentencia se encarga de preparar el sql y evitar la sqlinjeccion
                $sentencia = $conexion -> prepare($sql);
                //indicamos el parametro necesario
                $sentencia -> bindParam(':autor_id', $id_usuario, PDO::PARAM_STR);
                //ejecutamos la sentencia
                $sentencia -> execute();
                //recuperamos todos los resultados
                $resultado = $sentencia -> fetch();
                //verificamos si el resultado no esta vacio
                if(!empty($resultado)){
                    //a total_entradas le pasamos como valor el array resultado que es un array asociativo por lo que se necesita el alias de la query
                    $total_comentarios= $resultado['total_comentarios'];
                    
                }
            } catch (PDOException $ex) {
                print "Error al consultar los datos" .$ex -> getMessage();
            }
            //devolvemos total_entradas
            return $total_comentarios;
        }
    }
    //metodo para mostrar los comentarios
   public static function mostrar_comentarios_por_usuario($conexion, $id_usuario){
        //creamos un array vacio
        $comentario_recuperado = [];
        //comprobamos si la conexion existe o no
        if(isset($conexion)){
            try {
                //creamos la sentencia sql a realizar
                $sql = "SELECT * FROM comentarios WHERE autor_id = :id";
                //la variable sentencia se encarga de preparar el sql y evitar la sqlinjeccion
                $sentencia = $conexion -> prepare($sql);
                //se pasa el parametro necesario
                $sentencia -> bindParam(':id', $id_usuario, PDO::PARAM_STR);
                //ejecutamos la sentencia
                $sentencia -> execute();
                //recuperamos todos los resultados
                $resultado = $sentencia -> fetchAll();
                //contamos si la cantidad de resultados es mayor a 0
                if(count($resultado)){
                    //creamos un array y lo recorremos
                    foreach ($resultado as $fila){
                        //recorremos la tabla
                        $comentario_recuperado[] =
                            new Comentario(
                                $fila['id'], $fila['autor_id'], $fila['entrada_id'], 
                                $fila['titulo'], $fila['texto'], $fila['fecha']
                            );
                    }
                }
                
            } catch (PDOException $ex) {
                print "Error al consultar los datos" .$ex -> getMessage();
            }
        }
        //devolvemos el valor
        return $comentario_recuperado;
    }   
}
