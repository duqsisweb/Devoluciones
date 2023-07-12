<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
error_reporting(0);

include '../conexionbd.php';
if (isset($_SESSION['usuario'])) {
  require 'header.php';
  require '../function/funciones.php';

?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Administrador" />
    <meta name="author" content="Yon Gonzalez" />
    <title>Devoluciones</title>
    <link rel="icon" type="image/x-icon" href="../assets/image/faviconplanta.png" />
    <link rel="stylesheet" href="../css/bootstrap.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">

    <!-- para exportar documentos -->
    <!-- <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css" rel="stylesheet" /> -->

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <!-- <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script> -->

  </head>



  <body>
    <section class="sectionContenido">



      <!-- inicio de POST ENVIAR -->
      <?php
      if (isset($_POST['enviar'])) {
        include '../conexionbd.php';

        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sistemaClasificador = $_POST['sistemaClasificador'];
        $Estado = $_POST['Estado'];
        $TipoUsuario = $_POST['TipoUsuario'];
        $cod_vendedor = $_POST['cod_vendedor'];
        $estadopassword = $_POST['estadopassword'];


        // Encriptar el password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // echo "INSERT INTO [DUQUESA].[dbo].[users] (NOMBRE, EMAIL, password, CREATEAT, SISTEMACLASIFICADOR, ESTADO, TIPOUSUARIO) 
        // VALUES ( '$name', '$email', '$hashedPassword, '$created_at', '$sistemaClasificador', '$Estado','$TipoUsuario')";

        $Consulta = odbc_exec($conexion, "INSERT INTO DUQUESA..users (name, email, password, created_at, sistemaClasificador, Estado, TipoUsuario,cod_vendedor, estadopassword)
        VALUES ('$name', '$email', '$hashedPassword', GETDATE(), '$sistemaClasificador', '$Estado', '$TipoUsuario','$cod_vendedor','$estadopassword')");
      }

      ?>

      <div>
        <div class="alert alert-success" role="alert">
          <h4 class="alert-heading">ADMINISTRADOR</h4>
          <p><?php echo utf8_encode($_SESSION['NOMBRE']); ?></p>
          <hr>
          <p class="mb-0">Módulo administración de usuarios, creación y acceso a operarios,facturadores.</p>
        </div>
      </div>



      <div class="container" style="margin-top: 60px;">
        <div class="row">

          <div class="col-md-4">
            <div>
              <h4>Registro usuarios</h4>
            </div>
            <form method="POST">
              <div class="mb-3">
                <label for="" class="form-label">Nombre</label>
                <input name="name" type="text" class="form-control" id="" aria-describedby="" required>
              </div>
              <div class="mb-3">
                <label for="" class="form-label">Correo Electrónico</label>
                <input name="email" type="email" class="form-control" id="" aria-describedby="" autocomplete="off" required>
              </div>
              <div class="mb-3">
                <label for="" class="form-label">Password</label>
                <input name="password" type="password" class="form-control" id="" required>
              </div>
              <div class="mb-3">
                <label for="" class="form-label">Rol de usuario</label>
                <select name="sistemaClasificador" class="form-select" aria-label="Default select example" id="tipo-usuario" required aria-required="true">
                  <option value="FACTURADOR">FACTURADOR</option>
                  <option value="OPERARIO">OPERARIO</option>

                </select>
              </div>
              <button id="enviar" type="submit" class="btn btn-warning enviar" name="enviar" value="enviar" style="display:none"></button>

              <input type="hidden" name="created_at" value="<?php echo date('Y-m-d H:i:s', strtotime('now')); ?>"></input>
              <input type="hidden" name="Estado" value="1"></input>
              <input type="hidden" name="TipoUsuario" value="6"></input>
              <input type="hidden" name="cod_vendedor" value=""></input>
              <input type="hidden" name="estadopassword" value="1"></input>


            </form>



            <!-- btn guardar informacion  -->
            <div class="container">
              <div class="row">
                <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4"></div>
                <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                  <div class="text-center">
                    <button id="" class="btn btn-warning showAlertButton" name="enviar">Registrar</button>

                  </div>
                </div>
                <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4"></div>
              </div>
            </div>
          </div>




          <?php
          if (isset($_POST['enviarEstado'])) {


            include '../conexionbd.php';
            $estado = $_POST['estado'];

            if ($estado == "on") {
              $estado = 1;
            } else {
              $estado = 0;
            }

            $email = $_POST['email']; // 
            echo "UPDATE [DUQUESA].[dbo].[users] SET Estado = '$estado' WHERE email = '$email'";
            // $consulta = odbc_prepare($conexion, "UPDATE [DUQUESA].[dbo].[users] SET Estado = '$estado' WHERE email = '$email'");
            // $result = odbc_execute($consulta, array($estado, $email));

            header('Location: /Devoluciones/view/administradordev.php');
            exit(); // Asegúrar de agregar exit() después de la redirección
          }
          ?>



          <div class="col-md-8">
            <div>
              <h4>Listado de usuarios</h4>
            </div>


            <form method="POST">
              <?php
              $F = new funciones;
              if (count($F->usuarios()) !== 0) { ?>
                <!-- tbl info de productos -->
                <table class="table table-bordered dt-responsive table-hover display nowrap" id="mtable" cellspacing="0" style="text-align: center;">
                  <thead>
                    <tr class="encabezado table-dark">
                      <th scope="col">Nombre</th>
                      <th scope="col">Email</th>
                      <th scope="col">Rol</th>
                      <th scope="col">Estado</th>

                    </tr>
                  </thead>


                  <tbody style="text-align: center;">
                    <?php
                    foreach ($F->usuarios() as $a) :
                    ?>
                      <tr>
                        <td><?= utf8_encode($a['name']) ?></td>
                        <td><?= $a['email'] ?></td>
                        <td><?= $a['sistemaClasificador'] ?></td>
                        <td>
                          <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" name="estado" value="<?= $a['Estado'] ?>" <?php if ($a['Estado'] == 1) echo 'checked'; ?>>
                            <label class="form-check-label" for="flexSwitchCheckDefault"><?= ($a['Estado'] == 1) ? 'on' : 'off'; ?></label>
                          </div>
                        </td>


                        <input type="hidden" name="email" value="<?php echo ($a['email']) ?>"></input>
                        <input type="hidden" name="estado" value="<?php echo ($a['estado']) ?>"></input>
                      </tr>
                    <?php
                    endforeach;
                    // Generar una nueva variable con el total de iteraciones
                    ?>
                  </tbody>
                </table>
              <?php
              } ?>



          </div>
          <button id="enviarEstado" type="submit" class="btn btn-warning enviarEstado" name="enviarEstado" value="enviarEstado" style="display:none"></button>
          </form>

          <div class="container">
            <div class="row">
              <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4"></div>
              <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                <div class="text-center">
                  <button id="" class="btn btn-success showAlertButtonestado" name="enviarEstado">Guardar</button>
                </div>
              </div>
              <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4"></div>
            </div>
          </div>

        </div>
      </div>





  </body>

  </html>

  <!-- script de alertas con redireccion onclick a enviar a los 2 segundos -->
  <script>
    $(document).ready(function() {
      $('.showAlertButton').click(function() {
        Swal.fire({
          title: '¿Quieres guardar los cambios?',
          showDenyButton: true,
          showCancelButton: true,
          confirmButtonText: 'Guardar',
          denyButtonText: `No guardar`,
        }).then((result) => {
          if (result.isConfirmed) {
            Swal.fire('¡Guardado!', '', 'success');
            // Ejecutar el trigger después de 2 segundos
            setTimeout(function() {
              $('.enviar').trigger('click');
            }, 2000);
          } else if (result.isDenied) {
            Swal.fire('Los cambios no se guardaron', '', 'info');
          }
        });
      });
    });
  </script>


  <!-- alerta guardar estado update -->
  <script>
    $(document).ready(function() {
      $('.showAlertButtonestado').click(function() {
        Swal.fire({
          title: '¿Quieres guardar los cambios?',
          showDenyButton: true,
          showCancelButton: true,
          confirmButtonText: 'Guardar',
          denyButtonText: `No guardar`,
        }).then((result) => {
          if (result.isConfirmed) {
            Swal.fire('¡Guardado!', '', 'success');
            // Ejecutar el trigger después de 2 segundos
            setTimeout(function() {
              $('.enviarEstado').trigger('click');
            }, 2000);
          } else if (result.isDenied) {
            Swal.fire('Los cambios no se guardaron', '', 'info');
          }
        });
      });
    });
  </script>











<?php } else { ?>
  <script languaje "JavaScript">
    alert("Acceso Incorrecto");
    window.location.href = "../login.php";
  </script><?php
          } ?>