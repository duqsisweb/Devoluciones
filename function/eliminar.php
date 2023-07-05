<?php 
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    // error_reporting(0);

if (isset($_SESSION['usuario'])) {
    include '../conexionbd.php'; 

    $urldoc = $_POST['urldoc'];
    $id = $_POST['id'];

    odbc_exec($conexion,"DELETE FROM DUQUESA..FORMATOSEMP WHERE ID = '$id'");

    unlink($urldoc);
    
} else { ?>
    <script languaje "JavaScript">
        alert("Acceso Incorrecto");
         window.location.href = "../login.php";
    </script><?php
} ?>