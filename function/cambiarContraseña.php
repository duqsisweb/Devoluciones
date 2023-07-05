<?php 
    error_reporting(0);	
    session_start();
    include '../conexionbd.php'; 

    if (isset($_SESSION['usuario'])) {
        if (isset($_POST['changepassword'])) {

            $matchPassword = $_POST['matchPassword'];
            $email = $_POST['emailuser'];

            $passwordencrypt = password_hash($matchPassword,PASSWORD_DEFAULT);

            odbc_exec($conexion,"UPDATE DUQUESA..users SET password = '$passwordencrypt', updated_at = GETDATE(), estadopassword = 1 WHERE email = '$email'");

            if($estadopass = $_SESSION['estadopass'] == 0) {
                session_destroy();
                ?><script languaje="javascript">	
                    window.location="../login.php";	
                    alert("Contraseña cargada con exito");	
                </script><?php
            } else if($estadopass = $_SESSION['estadopass'] == 2) {   
                ?><script languaje="javascript">		
                    window.location="../view/administracion.php";	
                    alert("Contraseña cargada con exito");	
                </script><?php	
            } else {
                ?><script languaje="javascript">	
                    window.location="../view/inicio.php";	
                    alert("Contraseña cargada con exito");	
                </script><?php	
            }

        } else {
            ?><script languaje="javascript">	
            window.location="../view/inicio.php";	
            alert("Ah ocurrido un error");	
            </script><?php	
        }

    }else{ ?>
        <script languaje "JavaScript">	
            alert("Acceso Incorrecto");	
            window.location.href="../login.php"; 	
        </script><?php 
    }
?>