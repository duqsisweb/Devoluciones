<?php
header('Content-Type: text/html; charset=UTF-8');
error_reporting(0);

if ($_POST['iniciar']) {

    header("Cache-control: private");
    include("./conexionbd.php");
    $usuario1 = utf8_decode($_POST['usuario']);
    $usuario = rtrim($usuario1);
    $password1 = $_POST['password'];
    $password = rtrim($password1);
    $typeUser = $_POST['typeUser'];
    $result;

    $resul = odbc_exec($conexion, "SELECT MV.NOMBRE, RTRIM(MV.CODUSUARIO) AS CODUSUARIO, RTRIM(MV.PASSWORD) AS CLAVE FROM CONTROL_OFIMAEnterprise..MTUSUARIO AS MV WHERE (MV.CODUSUARIO = '$usuario' AND MV.CODUSUARIO IN ('HRODRIGUEZ','JQUINTERO', 'LPACHON', 'SVERA', 'YTANGARIFE', 'DHENAO', 'JYDIAZ', 'YCHAVERRA', 'SGUILLEN', 'JCASILIMAS', 'YFGONZALEZ' , 'ESOLANO', 'YALONSO')) AND MV.PASSWORD = '$password'") or die(exit("Error al ejecutar consulta"));
    $Nombre = odbc_result($resul, 'NOMBRE');
    $usua = rtrim(odbc_result($resul, 'CODUSUARIO'));
    $pass = rtrim(odbc_result($resul, 'CLAVE'));

    $usua = strtoupper($usua);
    $usuario = strtoupper($usuario);

    if ($usua == $usuario && $pass == $password) {
        session_start();
        $_SESSION['usuario'] = $usua;
        $_SESSION['NOMBRE'] = $Nombre;

        // Asignar perfil/rol basado en el valor de $user
        if ($usua == 'YFGONZALEZ') {
            $perfil = 'perfil1';
        } elseif ($usua == 'YALONSO') {
            $perfil = 'perfil2';
        } else {
            // Asignar un perfil predeterminado si el usuario no coincide con ninguno de los perfiles anteriores
            $perfil = 'perfil_predeterminado';
        }

        $_SESSION['perfil'] = $perfil;

        if ($perfil == 'perfil1') {
            header("Location: view/inicio.php");
            exit();
        } elseif ($perfil == 'perfil2') {
            header("Location: view/inicioFacturador.php");
            exit();
        } else {
            // Redirigir a una vista predeterminada si el perfil no coincide con ninguno de los perfiles anteriores
            header("Location: view/vista_predeterminada.php");
            exit();
        }
        
        ?><script>
            alert("Hola <?php echo $Nombre ?>");
            // Puedes agregar aquí cualquier otro código JavaScript necesario
        </script><?php
        
    } else {
        ?><script>
            alert("Credenciales incorrectas");
            window.location.href = "login.php";
        </script><?php
    }
} else {
    ?><script>
        alert("Ingreso Erroneo");
        window.location.href = "login.php";
    </script><?php
}
?>
