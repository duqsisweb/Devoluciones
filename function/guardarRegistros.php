<?php

header( "Refresh: 0; url='../view/inicio.php'", 'Content-Type: text/html; charset=UTF-8');
session_start();
error_reporting(0);

include '../conexionbd.php';
if (isset($_SESSION['usuario'])) {

    require '../function/funciones.php';


    if (isset($_POST['enviar'])) {

        $factura = $_POST['fac'];
        $codigoDevolucion = $_POST['cod'];
        $fechaRecibido = $_POST['fechaRecibido'] . "T" . date('H:i:s');
        // fechaenviada
        $usuario = $_SESSION['usuario'];
        $nombre = $_SESSION['NOMBRE'];
        $TIPODEFACTURA = $_POST['TIPODEFACTURA'];
        $PRODUCTO = $_POST['PRODUCTO'];
        $totalRecorridos = $_POST['recorrido'];

// echo  $totalRecorridos;



        for ($i = 0; $i < $totalRecorridos; $i++) {

            $PRODUCTO = $_POST['PRODUCTO'.$i];
            $cantidad = $_POST['cantidad'.$i];
            $cantidadOriginal = $_POST['cantidadOriginal'.$i];

            // echo "INSERT INTO DUQUESA..DistribucionDevoluciones (factura, codigo, fechaRecibido, fechaEnviado, usuario, NOMBRE, TIPODEFACTURA, PRODUCTO, cantidad, cantidadOriginal ) 
            // VALUES ('$factura', '$codigoDevolucion', '$fechaRecibido', Getdate(), '$usuario', '$nombre', '$TIPODEFACTURA', '$PRODUCTO', '$cantidad', '$cantidadOriginal')";
    
            $Consulta = odbc_exec($conexion, "INSERT INTO DUQUESA..DistribucionDevoluciones (factura, codigo, fechaRecibido, fechaEnviado, usuario, NOMBRE, TIPODEFACTURA, PRODUCTO, cantidad, cantidadOriginal ) 
            VALUES ('$factura', '$codigoDevolucion', '$fechaRecibido', Getdate(), '$usuario', '$nombre', '$TIPODEFACTURA', '$PRODUCTO', '$cantidad', '$cantidadOriginal' )");
        }

    }
?>

<?php } else { ?>
    <script languaje "JavaScript">
        alert("Acceso Incorrecto");
        window.location.href = "../login.php";
    </script><?php
            } ?>