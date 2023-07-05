<?php

$usuario = "m";
$clave = "Duquesa2008";

if (!$conexion = odbc_connect('DRIVER={SQL Server};SERVER=192.168.10.1;DATABASE=CONTROL_OFIMAEnterprise', $usuario, $clave)) {
    die('Error al conectarse a la base de datos');
}

return $conexion;

?>


