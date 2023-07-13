<?php
header('Content-Type: text/html; charset=UTF-8');
// error_reporting(0);

if (isset($_POST['iniciar'])) {
    include("./conexionbd.php");

    $usuario = rtrim($_POST['usuario']);
    $password = rtrim($_POST['password']);

    $resul = odbc_exec($conexion, "SELECT RTRIM(US.name) AS NOMBRE, RTRIM(US.email) AS EMAIL, RTRIM(US.password) AS CLAVE, [estadopassword], [sistemaClasificador]
    FROM [DUQUESA].[dbo].[users] AS US
    WHERE US.email = '$usuario'") or die(exit("Error al ejecutar consulta"));

    if (odbc_num_rows($resul) > 0) {
        $row = odbc_fetch_array($resul);
        $Nombre = $row['NOMBRE'];
        $usua = $row['EMAIL'];
        $pass = $row['CLAVE'];
        $sistemaClasificador = $row['sistemaClasificador'];

        if (($usua == 'karen.pimentel.m@gmail.com' && $password == $pass) || password_verify($password, $pass)) {
            // Contraseña válida
            session_start();
            $_SESSION['usuario'] = $usua;
            $_SESSION['NOMBRE'] = $Nombre;

            // Asignar perfil/rol basado en el valor de $sistemaClasificador
            if ($sistemaClasificador == 'OPERARIO') {
                $perfil = 'perfil1';
            } elseif ($sistemaClasificador == 'FACTURADOR') {
                $perfil = 'perfil2';
            } elseif ($usua == 'karen.pimentel.m@gmail.com') {
                $perfil = 'perfil3';
            } else {
                // Asignar un perfil predeterminado si el valor de sistemaClasificador no coincide con ninguno de los perfiles anteriores
                $perfil = 'perfil_predeterminado';
            }

            $_SESSION['perfil'] = $perfil;

            switch ($perfil) {
                case 'perfil1':
                    header("Location: view/inicio.php");
                    exit();
                    break;
                case 'perfil2':
                    header("Location: view/inicioFacturador.php");
                    exit();
                    break;
                case 'perfil3':
                    header("Location: view/administradordev.php");
                    exit();
                    break;
                default:
                    // Redirigir a una vista predeterminada si el perfil no coincide con ninguno de los perfiles anteriores
                    header("Location: view/administradordev.php");
                    exit();
                    break;
            }

            ?>
            <script>
                alert("Hola <?php echo $Nombre ?>");
            </script>
            <?php
        } else {
            // Contraseña incorrecta
            ?>
            <script>
                alert("Credenciales incorrectas");
                window.location.href = "login.php";
            </script>
            <?php
        }
    } else {
        // No se encontró el usuario en la base de datos
        ?>
        <script>
            alert("Credenciales incorrectas");
            window.location.href = "login.php";
        </script>
        <?php
    }
} else {
    ?>
    <script>
        alert("Ingreso Erroneo");
        window.location.href = "login.php";
    </script>
    <?php
}
?>