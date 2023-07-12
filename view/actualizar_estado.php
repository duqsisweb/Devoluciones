<?php
if (isset($_POST['estado']) && isset($_POST['email'])) {
  include '../conexionbd.php';
  $estado = $_POST['estado'];

  if ($estado == true) {
    $estado = 1;
  } else {
    $estado = 0;
  }

  $email = $_POST['email'];

  $consulta = odbc_prepare($conexion, "UPDATE [DUQUESA].[dbo].[users] SET Estado = ? WHERE email = ?");
  
  if ($consulta) {
    $result = odbc_execute($consulta, array($estado, $email));

    if ($result) {
      echo "Estado actualizado correctamente";
    } else {
      echo "Error al actualizar el estado: " . odbc_errormsg($conexion);
    }
  } else {
    echo "Error en la consulta: " . odbc_errormsg($conexion);
  }
} else {
  echo "Parámetros incorrectos";
}

?>

