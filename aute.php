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

    $resul = odbc_exec($conexion, "SELECT RTRIM(US.name) AS NOMBRE ,RTRIM(US.email) AS EMAIL ,RTRIM(US.password) AS CLAVE,[estadopassword] FROM [DUQUESA].[dbo].[users] AS US 
    WHERE  (US.email = '$usuario' AND US.email IN ('karen.pimentel.m@gmail.com')) AND US.password = '$password'") or die(exit("Error al ejecutar consulta"));

    $Nombre = odbc_result($resul, 'NOMBRE');
    $usua = rtrim(odbc_result($resul, 'EMAIL'));
    $pass = rtrim(odbc_result($resul, 'CLAVE'));

    $usua = strtoupper($usua);
    $usuario = strtoupper($usuario);

    if (strcasecmp($usua, $usuario) == 0 && strcasecmp($pass, $password) == 0) {
        session_start();
        $_SESSION['usuario'] = $usua;
        $_SESSION['NOMBRE'] = $Nombre;

        // Asignar perfil/rol basado en el valor de $user
        if ($usua == '') {
            $perfil = 'perfil1';
        } elseif ($usua == '') {
            $perfil = 'perfil2';
        } elseif ($usua == 'karen.pimentel.m@gmail.com') {
            $perfil = 'perfil3';
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
        } elseif ($perfil == 'perfil3') {
            header("Location: view/administradordev.php");
            exit();
        } else {
            // Redirigir a una vista predeterminada si el perfil no coincide con ninguno de los perfiles anteriores
            header("Location: view/administradordev.php");
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



