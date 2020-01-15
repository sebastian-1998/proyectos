<?php
//incluimos los archivos necesarios
include_once 'app/config.inc.php';
include_once 'app/Conexion.inc.php';
include_once 'app/Entrada.inc.php';

class RepositorioEntrada{
    //creamos los metodos necesarios
    public static function insertar_entrada($conexion, $entrada){
        //creamos un boolean y lo iniciamos como falso
        $entrada_insertada = false;
        //comprobamos si la conexion existe o no
        if(isset($conexion)){
            try {
                //creamos la sentencia sql a realizar
                $sql = "INSERT INTO entradas(autor_id, url, titulo, texto, fecha, activa) VALUES(:autor_id, :url, :titulo, :texto, NOW(), :activa)";
                //creamos una nueva variable para insertar el dato del checkbox
                $activa = 0;
                //evaluamos si el metodo esta_activa nos devuelve true o false
                if($entrada -> esta_activa()){
                    //si el if se cumple se pasa el estado de la entrada de 0 a 1
                    $activa = 1;
                }
                //la variable sentencia se encarga de preparar el sql y evitar la sqlinjeccion
                $sentencia = $conexion -> prepare($sql);
                //indicamos los parametros a insertar con variables temporales
                $url_temp = $entrada -> obtener_url();
                $autor_idtemp = $entrada -> obtener_autor_id();
                $titulotemp = $entrada->obtener_titulo();
                $textotemp = $entrada-> obtener_texto();
                $sentencia -> bindParam(':autor_id', $autor_idtemp, PDO::PARAM_STR);
                $sentencia -> bindParam(':url', $url_temp, PDO::PARAM_STR);
                $sentencia -> bindParam(':titulo', $titulotemp, PDO::PARAM_STR);
                $sentencia -> bindParam(':texto', $textotemp, PDO::PARAM_STR);
                $sentencia -> bindParam(':activa', $activa, PDO::PARAM_STR);
                //ejecutamos la sentencia y se lo pasamos como valor al usuario_insertado
                $entrada_insertada = $sentencia -> execute();
            } catch (PDOException $ex) {
                 print "Error al insertar los datos" .$ex -> getMessage();
            }
        }
        //devolvemos el valor de usuario_insertado
        return $entrada_insertada;
        
    }
    //metodo para devolver las entradas
    public static function obtener_por_fecha_descendente($conexion){
        //creamos un array vacio
        $entradas = [];
        //comprobamos si la conexion existe o no
        if(isset($conexion)){
            try {
                 //creamos la sentencia sql a realizar
                $sql = "SELECT * FROM entradas ORDER BY fecha DESC";
                //la variable sentencia se encarga de preparar el sql y evitar la sqlinjeccion
                $sentencia = $conexion -> prepare($sql);
                //ejecutamos la sentencia
                $sentencia -> execute();
                //recuperamos todos los resultados
                $resultado = $sentencia -> fetchAll();
                //verificamos cuantas entradas se han recuperado
                if(count($resultado)){
                    //recorremos el array
                    foreach ($resultado as $fila){
                        //añadimos lo recuperado al array entradas
                        $entradas[] = new Entrada(
                                $fila['id'], $fila['autor_id'], $fila['url'], 
                                $fila['titulo'], $fila['texto'], $fila['fecha'], 
                                $fila['activa']
                        );
                        
                    }
                    
                   
                }
            } catch (PDOException $ex) {
                print "Error al consultar los datos" .$ex -> getMessage();
            }
            
        }
        return $entradas;
        
    }
    //creamos el metodo para redirigir a la entrada
    public static function obtener_entrada_por_url($conexion, $url){
        $entrada = null;
        //comprobamos si la conexion existe o no
        if(isset($conexion)){
            try {
                //creamos la sentencia sql a realizar
                $sql = "SELECT * FROM entradas WHERE url LIKE :url";
                //la variable sentencia se encarga de preparar el sql y evitar la sqlinjeccion
                $sentencia = $conexion -> prepare($sql);
                //indicamos el parametro necesario
                $sentencia -> bindParam(':url', $url, PDO::PARAM_STR);
                //ejecutamos la sentencia
                $sentencia -> execute();
                //recuperamos todos los resultados
                $resultado = $sentencia -> fetch();
                //verificamos si el resultado no esta vacio
                if(!empty($resultado)){
                    //iniciamos la entrada
                    $entrada = new Entrada(
                            $resultado['id'], $resultado['autor_id'], $resultado['url'],
                            $resultado['titulo'], $resultado['texto'], $resultado['fecha'], $resultado['activa']
                            );
                }
            } catch (PDOException $ex) {
                print "Error al consultar los datos" .$ex -> getMessage();
            }
            //devolvemos la entrada
            return $entrada;
        }
    }
    //metodo para recuperar datos al azar
    public static function obtener_entradas_azar($conexion, $limite){
        //creamos un array vacio
        $entradas = [];
        //comprobamos si la conexion existe o no
        if(isset($conexion)){
            try {
                //creamos la sentencia sql a realizar
                $sql = "SELECT * FROM entradas ORDER BY RAND() LIMIT $limite";
                //la variable sentencia se encarga de preparar el sql y evitar la sqlinjeccion
                $sentencia = $conexion -> prepare($sql);
                //ejecutamos la sentencia
                $sentencia -> execute();
                //recuperamos todos los resultados
                $resultado = $sentencia -> fetchAll();
                //contamos si la cantidad de resultados es mayor a 0
                if(count($resultado)){
                    //recorremos el array
                    foreach ($resultado as $fila){
                        //llenamos el array
                        $entradas[] = new Entrada(
                                $fila['id'], $fila['autor_id'], $fila['url'], 
                                $fila['titulo'], $fila['texto'], $fila['fecha'], 
                                $fila['activa']
                                );
                    }
                }
                
            } catch (PDOException $ex) {
                print "Error al consultar los datos" .$ex -> getMessage();
            }
        }
        //devolvemos el valor
        return $entradas;
    }
    //creamos metodos para recuperar entradas activas e inactivas
    public static function contar_entradas_activas_usuario($conexion, $id_usuario){
        $total_entradas = 0;
        //comprobamos si la conexion existe o no
        if(isset($conexion)){
            try {
                //creamos la sentencia sql a realizar
                $sql = "SELECT COUNT(*) as total_entradas FROM entradas WHERE autor_id = :autor_id AND activa = 1";
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
                    $total_entradas = $resultado['total_entradas'];
                    
                }
            } catch (PDOException $ex) {
                print "Error al consultar los datos" .$ex -> getMessage();
            }
            //devolvemos total_entradas
            return $total_entradas;
        }
    }
    //metodo entradas_inactivas
    public static function contar_entradas_inactivas_usuario($conexion, $id_usuario){
        $total_entradas = 0;
        //comprobamos si la conexion existe o no
        if(isset($conexion)){
            try {
                //creamos la sentencia sql a realizar
                $sql = "SELECT COUNT(*) as total_entradas FROM entradas WHERE autor_id = :autor_id AND activa = 0";
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
                    $total_entradas = $resultado['total_entradas'];
                    
                }
            } catch (PDOException $ex) {
                print "Error al consultar los datos" .$ex -> getMessage();
            }
            //devolvemos total_entradas
            return $total_entradas;
        }
    }
    public static function obtener_entradas_usuario_fecha_descendente($conexion, $id_usuario){
        //creamos un array vacio
        $entradas_obtenidas = [];
        //comprobamos si la conexion existe o no
        if(isset($conexion)){
            try {
                //creamos la sentencia sql a realizar
                $sql = "SELECT a.id, a.autor_id, a.url, a.titulo, a.texto, a.fecha, a.activa, COUNT(b.id) AS 'cantidad_comentarios' ";
                $sql .= "from entradas a ";
                $sql .="LEFT JOIN comentarios b ON a.id = b.entrada_id ";
                $sql .= "WHERE a.autor_id = :autor_id ";
                $sql .= "GROUP by a.id ";
                $sql .= "ORDER by a.fecha DESC";
                //la variable sentencia se encarga de preparar el sql y evitar la sqlinjeccion
                $sentencia = $conexion -> prepare($sql);
                //se pasa el parametro necesario
                $sentencia -> bindParam(':autor_id', $id_usuario, PDO::PARAM_STR);
                //ejecutamos la sentencia
                $sentencia -> execute();
                //recuperamos todos los resultados
                $resultado = $sentencia -> fetchAll();
                //contamos si la cantidad de resultados es mayor a 0
                if(count($resultado)){
                    //recorremos el array
                    foreach ($resultado as $fila){
                        //asignamos un elemento al array multidimensional
                        $entradas_obtenidas[] = array(
                            new Entrada(
                                $fila['id'], $fila['autor_id'], $fila['url'], 
                                $fila['titulo'], $fila['texto'], $fila['fecha'], 
                                $fila['activa']
                            ),
                            //creamos un segundo elemento con el alias del contador de b.id
                            $fila['cantidad_comentarios']
                        );
                    }
                }
                
            } catch (PDOException $ex) {
                print "Error al consultar los datos" .$ex -> getMessage();
            }
        }
        //devolvemos el valor
        return $entradas_obtenidas;
    }
    //metodo para evaluar si el titulo existe
    public static function titulo_existe($conexion, $titulo){
        //se crea un boleano
        $titulo_existe = true;
        //comprobamos si la conexion existe o no
        if(isset($conexion)){
            try {
                //creamos la sentencia sql a realizar
                $sql = "SELECT * FROM entradas WHERE titulo = :titulo";
                //la variable sentencia se encarga de preparar el sql y evitar la sqlinjeccion
                $sentencia = $conexion -> prepare($sql);
                //indicamos el parametro
                $sentencia -> bindParam(':titulo', $titulo, PDO::PARAM_STR);
                //ejecutamos la sentencia
                $sentencia -> execute();
                //recuperamos todos los usuarios que cumplan con la condicion
                $resultado = $sentencia -> fetchAll();
                //contamos cuantos resultados existen
                if(count($resultado)){
                    //si el if se cumple osea existe uno o mas registros con ese titulo se deja como verdadero
                    $titulo_existe = true;
                }  else {
                    //si no se cumple entonces el titulo no existe
                    $titulo_existe = false;
                }
 
            } catch (PDOException $ex) {
                print "Error al obtener los datos" .$ex -> getMessage();
                
            }
        }
        //devolvemos el valor
        return $titulo_existe;
    }
    //metodo para evaluar si la url existe
    public static function url_existe($conexion, $url){
        //se crea un boleano
        $url_existe = true;
        //comprobamos si la conexion existe o no
        if(isset($conexion)){
            try {
                //creamos la sentencia sql a realizar
                $sql = "SELECT * FROM entradas WHERE url = :url";
                //la variable sentencia se encarga de preparar el sql y evitar la sqlinjeccion
                $sentencia = $conexion -> prepare($sql);
                //indicamos el parametro
                $sentencia -> bindParam(':url', $url, PDO::PARAM_STR);
                //ejecutamos la sentencia
                $sentencia -> execute();
                //recuperamos todos los usuarios que cumplan con la condicion
                $resultado = $sentencia -> fetchAll();
                //contamos cuantos resultados existen
                if(count($resultado)){
                    //si el if se cumple osea existe uno o mas registros con ese titulo se deja como verdadero
                    $url_existe = true;
                }  else {
                    //si no se cumple entonces el titulo no existe
                    $url_existe = false;
                }
 
            } catch (PDOException $ex) {
                print "Error al obtener los datos" .$ex -> getMessage();
                
            }
        }
        //devolvemos el valor
        return $url_existe;
    }
    //metodo para borrar datos
    public static function eliminar_comentarios_y_entrada($conexion, $entrada_id) {
    	if (isset($conexion)) {
    		try {
    			$conexion -> beginTransaction();

    			$sql1 = "DELETE FROM comentarios WHERE entrada_id=:entrada_id";
    			$sentencia1 = $conexion -> prepare($sql1);
    			$sentencia1 -> bindParam(':entrada_id', $entrada_id, PDO::PARAM_STR);
    			$sentencia1 -> execute();

    			$sql2 = "DELETE FROM entradas WHERE id=:entrada_id";
    			$sentencia2 = $conexion -> prepare($sql2);
    			$sentencia2 -> bindParam(':entrada_id', $entrada_id, PDO::PARAM_STR);
    			$sentencia2 -> execute();

    			$conexion -> commit();
    		} catch (PDOException $ex) {
    			print 'ERROR' . $ex -> getMessage();
    			$conexion -> rollBack();
    		}
    	}
    }
    //metodo para obtener la entrada por id
    public static function obtener_entrada_por_id($conexion, $id){
        $entrada = null;
        //comprobamos si la conexion existe o no
        if(isset($conexion)){
            try {
                //creamos la sentencia sql a realizar
                $sql = "SELECT * FROM entradas WHERE id = :id";
                //la variable sentencia se encarga de preparar el sql y evitar la sqlinjeccion
                $sentencia = $conexion -> prepare($sql);
                //indicamos el parametro necesario
                $sentencia -> bindParam(':id', $id, PDO::PARAM_STR);
                //ejecutamos la sentencia
                $sentencia -> execute();
                //recuperamos todos los resultados
                $resultado = $sentencia -> fetch();
                //verificamos si el resultado no esta vacio
                if(!empty($resultado)){
                    //iniciamos la entrada
                    $entrada = new Entrada(
                            $resultado['id'], $resultado['autor_id'], $resultado['url'],
                            $resultado['titulo'], $resultado['texto'], $resultado['fecha'], $resultado['activa']
                            );
                }
            } catch (PDOException $ex) {
                print "Error al consultar los datos" .$ex -> getMessage();
            }
            //devolvemos la entrada
            return $entrada;
        }
    }
    //metodo actualizar entrada
    public static function actualizar_entrada($conexion, $id, $titulo, $url, $texto, $activa){
        //creamos las variables necesarias
        $actualizacion_correcta = false;
        //comprobamos si la conexion existe o no
        if(isset($conexion)){
            try {
                //creamos la sentencia sql a realizar
                $sql = "UPDATE entradas SET titulo = :titulo, url = :url, texto = :texto, activa = :activa WHERE id = :id";
                //la variable sentencia se encarga de preparar el sql y evitar la sqlinjeccion
                $sentencia = $conexion -> prepare($sql);
                //indicamos los parametros
                $sentencia -> bindParam(':titulo', $titulo, PDO::PARAM_STR);
                $sentencia -> bindParam(':url', $url, PDO::PARAM_STR);
                $sentencia -> bindParam(':texto', $texto, PDO::PARAM_STR);
                $sentencia -> bindParam(':activa', $activa, PDO::PARAM_STR);
                $sentencia -> bindParam(':id', $id, PDO::PARAM_STR);
                //ejecutamos la sentencia
                $sentencia -> execute();
                //verificamos cuantas filas han sido actualizadas
                $resultado = $sentencia -> rowCount();
                //contamos si el resultado es mayor a 0 es decir si se han actualizado o no los datos
                if(count($resultado)){
                    //si es mayor a 0 entonces se deja como verdadero si no como falso
                    $actualizacion_correcta = true;
                }  else {
                    $actualizacion_correcta = false;
                }
            } catch (PDOException $ex) {
                print "Error al actualizar los datos" .$ex -> getMessage();
            }
        }
        //devolvemos el valor 
        return $actualizacion_correcta;
    }
    //metodo para buscar
    public static function buscar_entradas_todos_los_campos($conexion, $termino_busqueda){
        $entradas = [];

        $termino_busqueda = '%' . $termino_busqueda . '%';

        if (isset($conexion)) {
            try {

                $sql = "SELECT * FROM entradas WHERE titulo LIKE :busqueda OR texto LIKE :busqueda ORDER BY fecha DESC LIMIT 25";

                $sentencia = $conexion -> prepare($sql);

                $sentencia -> bindParam(':busqueda', $termino_busqueda, PDO::PARAM_STR);
                $sentencia -> execute();
                $resultado = $sentencia -> fetchAll();

                if (count($resultado)) {
                    foreach ($resultado as $fila) {
                        $entradas[] = new Entrada(
                            $fila['id'], $fila['autor_id'], $fila['url'], $fila['titulo'], $fila['texto'], $fila['fecha'], $fila['activa']
                        );
                    }
                }

            } catch(PDOException $ex) {
                print 'ERROR ' . $ex -> getMessage();
            }
        }

        return $entradas;
    }
    //metodo busqueda avanzada por titulo
    public static function buscar_entradas_titulo($conexion, $termino_busqueda, $orden){
        $entradas = [];

        $termino_busqueda = '%' . $termino_busqueda . '%';

        if (isset($conexion)) {
            try {

                $sql = "SELECT * FROM entradas WHERE titulo LIKE :busqueda ORDER BY fecha DESC LIMIT 25";

                $sentencia = $conexion -> prepare($sql);

                $sentencia -> bindParam(':busqueda', $termino_busqueda, PDO::PARAM_STR);
                $sentencia -> execute();
                $resultado = $sentencia -> fetchAll();

                if (count($resultado)) {
                    foreach ($resultado as $fila) {
                        $entradas[] = new Entrada(
                            $fila['id'], $fila['autor_id'], $fila['url'], $fila['titulo'], $fila['texto'], $fila['fecha'], $fila['activa']
                        );
                    }
                }

            } catch(PDOException $ex) {
                print 'ERROR ' . $ex -> getMessage();
            }
        }

        return $entradas;
    }

    //busqueda avanzada por texto
    public static function buscar_entradas_texto($conexion, $termino_busqueda, $orden){
        $entradas = [];

        $termino_busqueda = '%' . $termino_busqueda . '%';

        if (isset($conexion)) {
            try {

                $sql = "SELECT * FROM entradas WHERE texto LIKE :busqueda ORDER BY fecha DESC LIMIT 25";

                $sentencia = $conexion -> prepare($sql);

                $sentencia -> bindParam(':busqueda', $termino_busqueda, PDO::PARAM_STR);
                $sentencia -> execute();
                $resultado = $sentencia -> fetchAll();

                if (count($resultado)) {
                    foreach ($resultado as $fila) {
                        $entradas[] = new Entrada(
                            $fila['id'], $fila['autor_id'], $fila['url'], $fila['titulo'], $fila['texto'], $fila['fecha'], $fila['activa']
                        );
                    }
                }

            } catch(PDOException $ex) {
                print 'ERROR ' . $ex -> getMessage();
            }
        }

        return $entradas;
    }
    //metodo para buscar por autor
    public static function buscar_entradas_autor($conexion, $termino_busqueda, $orden){
        $entradas = [];

        $termino_busqueda = '%' . $termino_busqueda . '%';

        if (isset($conexion)) {
            try {

                $sql = "SELECT * FROM entradas e JOIN usuarios u ON u.id = e.autor_id WHERE u.nombre LIKE :busqueda ORDER BY e.fecha DESC LIMIT 25";

                $sentencia = $conexion -> prepare($sql);

                $sentencia -> bindParam(':busqueda', $termino_busqueda, PDO::PARAM_STR);
                $sentencia -> execute();
                $resultado = $sentencia -> fetchAll();

                if (count($resultado)) {
                    foreach ($resultado as $fila) {
                        $entradas[] = new Entrada(
                            $fila['id'], $fila['autor_id'], $fila['url'], $fila['titulo'], $fila['texto'], $fila['fecha'], $fila['activa']
                        );
                    }
                }

            } catch(PDOException $ex) {
                print 'ERROR ' . $ex -> getMessage();
            }
        }

        return $entradas;
    }
}


