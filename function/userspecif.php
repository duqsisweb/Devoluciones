<?php 
    header('Content-Type: text/html; charset=UTF-8');

    session_start();
    error_reporting(0);

    if (isset($_SESSION['usuario'])) {

    include 'funciones.php';

    $CODIGO = $_POST['CODIGO'];

    $result = funciones::usuarioEspecifico($CODIGO);
    print_r($result);

} else { ?>
    <script languaje "JavaScript">
        alert("Acceso Incorrecto");
         window.location.href = "../login.php";
    </script><?php
} ?>