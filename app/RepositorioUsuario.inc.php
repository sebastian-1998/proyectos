<?php
//se incluyen los archivos necesarios
include_once 'app/Usuario.inc.php';
class RepositorioUsuario{
    //creamos un metodo para obtener el total de usuarios
    public static function obtener_numero_usuarios($conexion){
        $total_usuarios = null;
        if(isset($conexion)){
            try {
                //creamos la sentencia sql a realizar
                $sql = "SELECT COUNT(*) AS total FROM usuarios";
                //la variable sentencia se encarga de preparar el sql y evitar la sqlinjeccion
                $sentencia = $conexion -> prepare($sql);
                //ejecutamos la sentencia
                $sentencia -> execute();
                //recuperamos el dato
                $resultado = $sentencia -> fetch();
                //iniciamos el total_usuarios con el valor de resultado que es en este caso el alias total
                $total_usuarios = $resultado['total'];
                
            } catch (PDOException $ex) {
                print "Error al obtener los datos" .$ex -> getMessage();
            }
        }
        //devolvemos el valor
        return $total_usuarios;
    }
    //creamos un metodo para insertar datos
    public static function insertar_usuario($conexion, $usuario){
        //creamos un boolean y lo iniciamos como falso
        $usuario_insertado = false;
        //comprobamos si la conexion existe o no
        if(isset($conexion)){
            try {
                //creamos la sentencia sql a realizar
                $sql = "INSERT INTO usuarios(nombre, email, password, fecha_registro, activo) VALUES(:nombre, :email, :password, NOW(), 0)";
                //la variable sentencia se encarga de preparar el sql y evitar la sqlinjeccion
                $sentencia = $conexion -> prepare($sql);
                //indicamos los parametros a insertar con variables temporales
                $nombretemp = $usuario -> obtener_nombre();
                $emailtemp = $usuario->obtener_email();
                $passwordtemp = $usuario-> obtener_password();
                $sentencia -> bindParam(':nombre', $nombretemp, PDO::PARAM_STR);
                $sentencia -> bindParam(':email', $emailtemp, PDO::PARAM_STR);
                $sentencia -> bindParam(':password', $passwordtemp, PDO::PARAM_STR);
                //ejecutamos la sentencia y se lo pasamos como valor al usuario_insertado
                $usuario_insertado = $sentencia -> execute();
            } catch (PDOException $ex) {
                 print "Error al insertar los datos" .$ex -> getMessage();
            }
        }
        //devolvemos el valor de usuario_insertado
        return $usuario_insertado;
        
    }
    //creamos los metodos para evaluar si el e-mail y el nombre existen
    public function nombre_existe($conexion, $nombre){
        //creamos un boolean y lo iniciamos como verdadero
        $nombre_existe = true;
        //comprobamos si la conexion existe o no
        if(isset($conexion)){
            try {
                //creamos la sentencia sql a realizar
                $sql = "SELECT * FROM usuarios WHERE nombre = :nombre";
                //la variable sentencia se encarga de preparar el sql y evitar la sqlinjeccion
                $sentencia = $conexion -> prepare($sql);
                //indicamos el parametro
                $sentencia -> bindParam(':nombre', $nombre, PDO::PARAM_STR);
                //ejecutamos la sentencia
                $sentencia -> execute();
                //recuperamos todos los usuarios que cumplan con la condicion
                $resultado = $sentencia -> fetchAll();
                //contamos cuantos resultados existen
                if(count($resultado)){
                    //si el if se cumple osea existe un registro con ese nombre se deja como verdadero
                    $nombre_existe = true;
                }  else {
                    //si no se cumple entonces el nombre no existe
                    $nombre_existe = false;
                }
            } catch (PDOException $ex) {
                print "Error al obtener los datos" .$ex -> getMessage();
            }
        }
        //devolvemos el nombre_existe
        return $nombre_existe;
        
    }
    //metodo email_existe
    public function email_existe($conexion, $email){
        //creamos un boolean y lo iniciamos como verdadero
        $email_existe = true;
        //comprobamos si la conexion existe o no
        if(isset($conexion)){
            try {
                //creamos la sentencia sql a realizar
                $sql = "SELECT * FROM usuarios WHERE email = :email";
                //la variable sentencia se encarga de preparar el sql y evitar la sqlinjeccion
                $sentencia = $conexion -> prepare($sql);
                //indicamos el parametro
                $sentencia -> bindParam(':email', $email, PDO::PARAM_STR);
                //ejecutamos la sentencia
                $sentencia -> execute();
                //recuperamos todos los usuarios que cumplan con la condicion
                $resultado = $sentencia -> fetchAll();
                //contamos cuantos resultados existen
                if(count($resultado)){
                    //si el if se cumple osea existe un registro con ese email se deja como verdadero
                    $email_existe = true;
                }  else {
                    //si no se cumple entonces el email no existe
                    $email_existe = false;
                }
            } catch (PDOException $ex) {
                print "Error al obtener los datos" .$ex -> getMessage();
            }
        }
        //devolvemos el email_existe
        return $email_existe;
        
    }
    //creamos una funcion para validar el login
    public static function obtener_usuario_por_email($conexion, $email){
        //creamos una variable para recuperar el usuario y la iniciamos como null
        $usuario = null;
        //comprobamos si la conexion existe o no
        if(isset($conexion)){
            try {
                //creamos la sentencia sql a realizar
                $sql = "SELECT * FROM usuarios WHERE email = :email";
                //la variable sentencia se encarga de preparar el sql y evitar la sqlinjeccion
                $sentencia = $conexion -> prepare($sql);
                //indicamos el parametro
                $sentencia -> bindParam(':email', $email, PDO::PARAM_STR);
                //ejecutamos la sentencia
                $sentencia -> execute();
                //recuperamos el usuario
                $resultado = $sentencia -> fetch();
                //se evalua si resultado esta vacio o no
                if(!empty($resultado)){
                    //si el if se cumple osea no esta vacio el resultado entonces se recuperan los datos
                    $usuario = new Usuario($resultado['id'], 
                            $resultado['nombre'], 
                            $resultado['email'],
                            $resultado['password'],
                            $resultado['fecha_registro'], 
                            $resultado['activo']);
                    
                }
            } catch (PDOException $ex) {
                print "Error al obtener los datos" .$ex -> getMessage();
            }
        }
        //devolvemos el usuario
        return $usuario;
    }
    //metodo recuperar usuario por id
    public static function obtener_usuario_por_id($conexion, $id){
        //creamos una variable para recuperar el usuario y la iniciamos como null
        $usuario = null;
        //comprobamos si la conexion existe o no
        if(isset($conexion)){
            try {
                //creamos la sentencia sql a realizar
                $sql = "SELECT * FROM usuarios WHERE id = :id";
                //la variable sentencia se encarga de preparar el sql y evitar la sqlinjeccion
                $sentencia = $conexion -> prepare($sql);
                //indicamos el parametro
                $sentencia -> bindParam(':id', $id, PDO::PARAM_STR);
                //ejecutamos la sentencia
                $sentencia -> execute();
                //recuperamos el usuario
                $resultado = $sentencia -> fetch();
                //se evalua si resultado esta vacio o no
                if(!empty($resultado)){
                    //si el if se cumple osea no esta vacio el resultado entonces se recuperan los datos
                    $usuario = new Usuario($resultado['id'], 
                            $resultado['nombre'], 
                            $resultado['email'],
                            $resultado['password'],
                            $resultado['fecha_registro'], 
                            $resultado['activo']);
                    
                }
            } catch (PDOException $ex) {
                print "Error al obtener los datos" .$ex -> getMessage();
            }
        }
        //devolvemos el usuario
        return $usuario;
    }
    //funcion para actualizar la contraseña
    public static function actualizar_clave($conexion, $id_usuario, $nueva_clave){
        //creamos las variables necesarias
        $actualizacion_correcta = false;
        //comprobamos si la conexion existe o no
        if(isset($conexion)){
            try {
                //creamos la sentencia sql a realizar
                $sql = "UPDATE usuarios SET password = :password WHERE id = :id";
                //la variable sentencia se encarga de preparar el sql y evitar la sqlinjeccion
                $sentencia = $conexion -> prepare($sql);
                //indicamos el parametro
                $sentencia -> bindParam(':password', $nueva_clave, PDO::PARAM_STR);
                $sentencia -> bindParam(':id', $id_usuario, PDO::PARAM_STR);
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
}
