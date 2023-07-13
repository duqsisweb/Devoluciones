<?php
session_start(); // Iniciar la sesión

// Verificar si se recibió el número de factura en la solicitud POST
if (isset($_POST['factura'])) {
  $factura = $_POST['factura'];
  include '../function/funciones.php';;
  // Realizar la consulta utilizando el método "buscarFactura" de la clase "funciones"
  $resultados = funciones::filtrarFactura($factura);
?>


  <!-- php para tomar los datos de la nota credito y luego realizar un update -->
  <?php
  if (isset($_POST['enviar'])) {
    include '../conexionbd.php';

    $notaCredito = $_POST['notaCredito'];
    $Usuarionotacredito = $_SESSION['usuario'];
    $fechanotacredito = $_SESSION['fechanotacredito'];
    $factura = $_POST['factura'];
    
    $SIGConsulta = odbc_exec($conexion, "UPDATE [sigcruge].[dbo].[servicio_cliente]
    SET notaCredito = '$notaCredito' WHERE factura = '$factura'");
    
    $Consulta = odbc_exec($conexion, "UPDATE [DUQUESA].[dbo].[DistribucionDevoluciones]
    SET notaCredito = '$notaCredito', Usuarionotacredito = '$Usuarionotacredito', fechanotacredito = Getdate()	
    WHERE factura = '$factura'");

    // redireccion luego de hacer la consulta
    header('Location: /Devoluciones/view/inicioFacturador.php');
    exit(); // Asegúrar de agregar exit() después de la redirección
  }
  ?>
  <!-- fin php -->


  <div class="">
    <div class="text-right mt-3">
      <div class="col-md-12">
        <!-- tbl info de productos -->
        <table class="table table-bordered dt-responsive table-hover display nowrap" id="infodetallefactura" cellspacing="0" style="text-align: center;">
          <thead>
            <tr class="encabezado table-dark">
              <th scope="col">Factura</th>
              <th scope="col">Código</th>
              <th scope="col">Tipo Factura</th>
              <th scope="col">Producto</th>
              <th scope="col">Nombre</th>
              <th scope="col">Cantidad</th>
              <th scope="col">C Original</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($resultados as $fila) { ?>
              <tr>
                <td><?= $fila['factura'] ?></td>
                <td><?= $fila['codigo'] ?></td>
                <td><?= $fila['TIPODEFACTURA'] ?></td>
                <td><?= $fila['PRODUCTO'] ?></td>
                <td><?= $fila['Nombre_Producto_Mvto'] ?></td>
                <td><?= round($fila['cantidad']) ?></td>
                <td><?= round($fila['cantidadOriginal']) ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
<?php } ?>





<!-- Nota credito dentro del modal -->
<?php
$resultados = funciones::filtrarFacuraNotacredito($factura);
?>
<div class="">
  <div class="text-right mt-3">
    <div class="col-md-12">
      <!-- Agrega un formulario que envuelva los elementos del formulario -->
      <form method="POST" action="consultaFactura.php"> <!-- Agrega el atributo action -->
        <!-- tbl info de productos -->
        <table class="table table-bordered dt-responsive table-hover display nowrap" id="notcredito" cellspacing="0" style="text-align: center;">
          <thead>
            <tr class="encabezado table-dark">
              <th scope="col">Nota Crédito</th>

            </tr>
          </thead>
          <tbody>
            <?php foreach ($resultados as $fila) { ?>
              <tr>
                <td><input type="number" name="notaCredito" value="<?= $fila['notaCredito'] ?>"></td>


                <button id="enviar" type="submit" class="btn btn-warning enviar" name="enviar" value="enviar" style="display:none"></button>
                <input type="hidden" name="factura" value="<?= $factura ?>">
                <input type="hidden" name="fechanotacredito" value="<?php echo date('Y-m-d H:i:s', strtotime('now')); ?>"></input>
                <input type="hidden" name="Usuarionotacredito" value="<?php echo utf8_encode($_SESSION['usuario']); ?>"></input>

              </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>

      <div class="container">
        <div class="row">
          <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4"></div>
          <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
            <div class="text-center">
              <button id="" class="btn btn-success showAlertButton" name="enviar">Guardar</button>
            </div>
          </div>
          <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4"></div>
        </div>
      </div>


    </div>
  </div>
</div>


<!-- script de alertas con redireccion onclick a enviar a los 2 segundos -->
<script>
  $(document).ready(function() {
    $('.showAlertButton').click(function() {
      Swal.fire({
        title: '¿Quieres Guardar La Nota Crédito?',
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