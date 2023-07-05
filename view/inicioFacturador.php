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
    <meta name="description" content="Devoluciones Operador" />
    <meta name="author" content="Yon Gonzalez" />
    <title>Devoluciones</title>
    <link rel="icon" type="image/x-icon" href="../assets/image/faviconplanta.png" />
    <link rel="stylesheet" href="../css/bootstrap.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">

  </head>


  <body>
    <section class="sectionContenido">

      <div>
        <br><br><br><br><br><br>
      </div>





      <?php
      $F = new funciones;
      if (count($F->filtrarDevoluciones()) !== 0) { ?>
        <div class="">
          <div class="text-right mt-3">
            <div class="col-md-12">

              <!-- tbl info de productos -->
              <table class="table table-bordered dt-responsive table-hover display nowrap" id="infoproductos" cellspacing="0" style="text-align: center;">
                <thead>
                  <tr class="encabezado table-dark">
                    <th scope="col">Factura</th>
                    <th scope="col">Codigo</th>
                    <th scope="col">Usuario</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Tipo Factura</th>
                    <th scope="col">Acciones</th>
                  </tr>
                </thead>


                <tbody>
                  <?php
                  $count = 0;
                  foreach ($F->filtrarDevoluciones() as $a) :
                  ?>
                    <tr>
                      <td><?= $a['factura'] ?></td>
                      <td><?= $a['codigo'] ?></td>
                      <td><?= $a['usuario'] ?></td>
                      <td><?= $a['nombre'] ?></td>
                      <td><?= $a['TIPODEFACTURA'] ?></td>


                      <td><!-- Button trigger modal -->
                        <input name="ver" type="button" class="btn btn-warning ver-btn" data-bs-toggle="modal" data-bs-target="#exampleModal" data-factura="<?= $a['factura'] ?>" value="VER"></input>
                      </td>

                    </tr>
                  <?php
                    $count++;
                  endforeach;
                  // Generar una nueva variable con el total de iteraciones
                  ?>
                  <?php $totalRecorridos = $count; ?>
                  <input type="hidden" name="recorrido" value=<?php echo $totalRecorridos = $count; ?>></input>
                  <input type="hidden" name="cantidad" value=<?php echo $totalRecorridos = $count; ?>></input>
                  <input type="hidden" name="cantidadOriginal" value=<?php echo $totalRecorridos = $count; ?>></input>
                </tbody>
              </table>
            <?php
          } ?>
            </div>
          </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">




                <?php
                $F = new funciones;
                // if (isset($_POST['consultar'])) {
                $factura =  $a['factura'];
                echo $factura;
                if (count($F->filtrarFactura($factura)) !== 0) { ?>
                  <div class="">
                    <div class="text-right mt-3">
                      <div class="col-md-12">
                        <!-- tbl info de productos -->
                        <table class="table table-bordered dt-responsive table-hover display nowrap" id="infodetallefactura" cellspacing="0" style="text-align: center;">
                          <thead>
                            <tr class="encabezado table-dark">
                              <th scope="col">Factura</th>
                              <th scope="col">Codigo</th>
                              <th scope="col">fechaRecibido</th>
                              <th scope="col">fechaEnviado</th>
                              <th scope="col">Usuario</th>
                              <th scope="col">Nombre</th>
                              <th scope="col">Tipo Factura</th>
                              <th scope="col">PRODUCTO</th>
                              <th scope="col">cantidad</th>
                              <th scope="col">cantidadOriginal</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $count = 0;
                            foreach ($F->filtrarFactura($factura) as $a) :
                            ?>
                              <tr>
                                <td><?= $a['factura'] ?></td>
                                <td><?= $a['codigo'] ?></td>
                                <td><?= $a['fechaRecibido'] ?></td>
                                <td><?= $a['fechaEnviado'] ?></td>
                                <td><?= $a['usuario'] ?></td>
                                <td><?= $a['nombre'] ?></td>
                                <td><?= $a['TIPODEFACTURA'] ?></td>
                                <td><?= $a['PRODUCTO'] ?></td>
                                <td><?= round($a['cantidad']) ?></td>
                                <td><?= round($a['cantidadOriginal']) ?></td>
                              </tr>
                            <?php
                              $count++;
                            endforeach;
                            // Generar una nueva variable con el total de iteraciones
                            ?>
                            <?php $totalRecorridos = $count; ?>
                            <input type="hidden" name="recorrido" value=<?php echo $totalRecorridos = $count; ?>></input>
                            <input type="hidden" name="cantidad" value=<?php echo $totalRecorridos = $count; ?>></input>
                            <input type="hidden" name="cantidadOriginal" value=<?php echo $totalRecorridos = $count; ?>></input>
                          </tbody>
                        </table>
                      <?php
                    } ?>
                      </div>
                    </div>
                  </div>


              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
              </div>
            </div>
          </div>
        </div>

  </body>



  <!-- script modal -->
  <script>
    const myModal = document.getElementById('myModal')
    const myInput = document.getElementById('myInput')

    myModal.addEventListener('shown.bs.modal', () => {
      myInput.focus()
    })
  </script>


  <!-- Agrega este código dentro de la etiqueta <script> existente -->
  <script>
    $(document).ready(function() {
      $('.ver-btn').on('click', function() {
        var factura = $(this).data('factura');
        $('#exampleModalLabel').text('Factura: ' + factura);

        // Aquí puedes realizar una llamada AJAX para cargar más información relacionada con la factura seleccionada
        // y actualizar el contenido del modal según tus necesidades.
      });
    });
  </script>




  </html>

<?php } else { ?>
  <script languaje "JavaScript">
    alert("Acceso Incorrecto");
    window.location.href = "../login.php";
  </script><?php
          } ?>