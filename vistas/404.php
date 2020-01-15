<?php
//creamos la cabezera http
header($_SERVER['SERVER_PROTOCOL'] . "404 Not Found", true, 404);
echo 'La página solicitada no existe';
