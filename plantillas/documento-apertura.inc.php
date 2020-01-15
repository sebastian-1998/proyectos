<?php
//se declara el metodo de codificacion que se usara
include_once 'app/config.inc.php';
?>
<!DOCTYPE html>
<!--se declara el archivo html y el idioma a usar-->
<html lang="es">
    <!--en el head va todo lo que se relaciona con el ccntenido pero que no es contenido-->
    <head>
        <link rel="shortcut icon" href="img/favicon.ico"/>
        <meta charset="UTF-8">
        <!--etiqueta de internet explorer-->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!--se desactiva el zoom y se hace que el ancho sea igual al de la pantalla-->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php
        //se evalua si el titulo no esta definido o esta vacio
        if(!isset($titulo) || empty($titulo)){
            //si se cumple cualquiera de las 2 condiciones entonces entra en esta parte
            $titulo = 'Blog de Sebastian Carrasco';
        }  else {
            echo "<title>$titulo</title>";
        }
        
        ?>
        
        <!--se llama a los archivos css y con rel se idica que tipo de archivo es-->
        <link href="<?php echo RUTA_CSS?>bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo RUTA_CSS?>font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo RUTA_CSS?>estilos.css" rel="stylesheet">
        
    </head>
    <!--en el body va todo el contenido-->
    <body>