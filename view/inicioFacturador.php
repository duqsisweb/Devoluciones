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

      <div>
        <br><br><br><br><br><br>
      </div>


      <div class="container" style="text-align: center;">
        <button class="btn btn-outline-danger" onclick="window.location.reload();">Actualizar registros</button>
      </div>



      <?php
      $F = new funciones;
      if (count($F->filtrarDevoluciones()) !== 0) { ?>
        <div class="">
          <div class="text-right mt-3">
            <div class="col-md-12">

              <!-- tbl info de productos -->
              <table class="table table-bordered dt-responsive table-hover display nowrap" id="mtable" cellspacing="0" style="text-align: center;">
                <thead>
                  <tr class="encabezado table-dark">
                    <th scope="col">Factura</th>
                    <th scope="col">Código</th>
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
                      <td>
                        <!-- Button trigger modal -->
                        <input name="ver" type="button" class="btn btn-warning ver-btn" data-bs-toggle="modal" data-bs-target="#exampleModal" data-factura="<?= $a['factura'] ?>" data-id="<?= $a['id'] ?>" value="VER"></input>
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




              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>

              </div>
            </div>
          </div>
        </div>





  </html>


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
    $('.ver-btn').on('click', function() {
      var factura = $(this).data('factura');
      var id = $(this).data('id');
      $('#exampleModalLabel').text('Factura: ' + factura);

      // Realizar la consulta AJAX
      $.ajax({
        url: 'consultaFactura.php', // Ruta del archivo PHP que realizará la consulta
        method: 'POST',
        data: {
          factura: factura
        }, // Enviar el número de factura como dato POST
        success: function(response) {
          // Colocar la respuesta en el cuerpo del modal
          $('.modal-body').html(response);
        },
        error: function() {
          alert('Error al realizar la consulta');
        }
      });
    });
  </script>

  <!-- Inicio DataTable -->
<script type="text/javascript">
  $(document).ready(function() {
    var lenguaje = $('#mtable').DataTable({
      info: false,
      select: true,
      destroy: true,
      jQueryUI: true,
      paginate: true,
      iDisplayLength: 30,
      searching: true,
      dom: 'Bfrtip',
      buttons: [
        // 'copy', 'csv', 'excel'
      ],
      language: {
        lengthMenu: 'Mostrar _MENU_ registros por página.',
        zeroRecords: 'Lo sentimos. No se encontraron registros.',
        info: 'Mostrando: _START_ de _END_ - Total registros: _TOTAL_',
        infoEmpty: 'No hay registros aún.',
        infoFiltered: '(filtrados de un total de _MAX_ registros)',
        search: 'Búsqueda',
        LoadingRecords: 'Cargando ...',
        Processing: 'Procesando...',
        SearchPlaceholder: 'Comience a teclear...',
        paginate: {
          previous: 'Anterior',
          next: 'Siguiente',
        }
      }
    });
  });
</script>
<!-- Fin DataTable -->





<?php } else { ?>
  <script languaje "JavaScript">
    alert("Acceso Incorrecto");
    window.location.href = "../login.php";
  </script><?php
          } ?>
