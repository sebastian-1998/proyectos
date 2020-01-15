<?php
include_once 'plantillas/documento-apertura.inc.php';
include_once 'app/config.inc.php';
//cerramos la conexion
Conexion :: cerrar_conexion();
?>
<!--se llama a los archivos js-->
        <script src="<?php echo RUTA_JS ?>jquery.min.js"></script>
        <script src="<?php echo RUTA_JS ?>bootstrap.min.js"></script>
        
    </body>
</html>
