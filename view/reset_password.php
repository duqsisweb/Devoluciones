<?php
if (isset($_GET['userId']) && isset($_GET['password'])) {
  $userId = $_GET['userId'];
  $newPassword = $_GET['password'];

  // Realiza la actualización en la base de datos
  include '../conexionbd.php';

  // Encripta la nueva contraseña con password_hash()
  $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

  // Modifica la consulta para usar la contraseña encriptada
  $query = "UPDATE [DUQUESA].[dbo].[users] SET [password] = '$hashedPassword' WHERE [id] = $userId";
  $consulta = odbc_exec($conexion, $query);

  if ($consulta) {
    echo json_encode('success');
  } else {
    echo json_encode('error');
  }
}
?>