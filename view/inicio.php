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



        <section id="sectionContenido">
            <!-- btn para consultar -->
            <div class="container">
                <form autocomplete="off" class="row" method="POST">
                    <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4"></div>
                    <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                        <h5 style="text-align: center;margin-top: 50px;">
                            </h><br><br>
                            <input class="form-control" type="text" name="fac" style="width: 100%;" id="fac" required><br>
                            <button type="submit" class="btn btn-success" name="consultar" value="Consultar" id="btncolor">Consultar</button>
                    </div>
                    <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4"></div>
                </form>
            </div>




            <!-- inicio de POST ENVIAR -->
            <?php
            if (isset($_POST['enviar'])) {

                $factura = $_POST['fac'];
                $codigoDevolucion = $_POST['cod'];
                $fechaRecibido = $_POST['fechaRecibido'] . "T" . date('H:i:s');
                // fechaenviada
                $usuario = $_SESSION['usuario'];
                $nombre = $_SESSION['NOMBRE'];
                $TIPODEFACTURA = $_POST['TIPODEFACTURA'];
                $totalRecorridos = $_POST['recorrido'];
                // echo  $totalRecorridos;
                for ($i = 0; $i < $totalRecorridos; $i++) {

                    $PRODUCTO = $_POST['PRODUCTO' . $i];
                    $cantidad = $_POST['cantidad' . $i];
                    $cantidadOriginal = $_POST['cantidadOriginal' . $i];

                    // echo "INSERT INTO DUQUESA..DistribucionDevoluciones (factura, codigo, fechaRecibido, fechaEnviado, usuario, NOMBRE, TIPODEFACTURA, PRODUCTO, cantidad, cantidadOriginal ) 
                    // VALUES ('$factura', '$codigoDevolucion', '$fechaRecibido', Getdate(), '$usuario', '$nombre', '$TIPODEFACTURA', '$PRODUCTO', '$cantidad', '$cantidadOriginal')";

                    $Consulta = odbc_exec($conexion, "INSERT INTO DUQUESA..DistribucionDevoluciones (factura, codigo, fechaRecibido, fechaEnviado, usuario, NOMBRE, TIPODEFACTURA, PRODUCTO, cantidad, cantidadOriginal ) 
                    VALUES ('$factura', '$codigoDevolucion', '$fechaRecibido', Getdate(), '$usuario', '$nombre', '$TIPODEFACTURA', '$PRODUCTO', '$cantidad', '$cantidadOriginal' )");
                }
            }
            ?>

            <!-- Fin de POST ENVIAR -->
            <?php
            $F = new funciones;
            if (isset($_POST['consultar'])) {

                $factura = $_POST['fac'];

                // AL REALIZAR LA CONSULTA VALIDAR LA TABLA DistribucionDevoluciones LA FACTURA SI EXISTE QUE MUESTRE UN ERROR
                $existeFactura = odbc_exec($conexion, "SELECT factura FROM DUQUESA..DistribucionDevoluciones WHERE factura = '$factura'");
                if (odbc_fetch_row($existeFactura)) {
                    // La factura ya existe, muestra un mensaje o realiza alguna acción
                    echo "<div class='alert alert-danger' role='alert' style='text-align: center;'> El número de Factura  <strong>$factura</strong> ya esta inscrita </div>";
                } else if (count($F->buscarCodigo($factura)) !== 0) {
            ?>

                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">

                                <form method="POST">
                                    <!-- Muestra la factura -->
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4"></div>
                                            <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4" style="text-align: center;">
                                                <hr>
                                                <p>PARA LA FACTURA N° <strong><?php $factura = $_POST['fac'];
                                                                                echo $factura; ?></strong></p>

                                                <input type="hidden" id="fac" name="fac" value=<?php $factura = $_POST['fac'];
                                                                                                echo $factura; ?>></input>
                                            </div>
                                            <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4"></div>
                                        </div>
                                    </div>



                                    <!-- tbl fecha y quien recibe -->
                                    <table class="table table-bordered dt-responsive table-hover display nowrap" id="mtable" cellspacing="0" style="text-align: center;">
                                        <thead>
                                            <tr class="encabezado table-dark">
                                                <th scope="col">CÓDIGO DE DEVOLUCIÓN</th>
                                                <th scope="col">NIT CLIENTE</th>
                                                <th scope="col">NOMBRE CLIENTE</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php foreach ($F->buscarCliente($factura) as $a) : ?>
                                                <tr>
                                                    <td style="width:10%"><?= $a['codigo'] ?></td>
                                                    <td style="width:10%"><?= $a['nit'] ?></td>
                                                    <td style="width:10%"><?= $a['nombre'] ?></td>

                                                    <input type="hidden" name="cod" value=<?php echo ($a['codigo']) ?>></input>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <!-- tbl fecha y quien recibe -->

                                    <table class="table table-bordered dt-responsive table-hover display nowrap" id="infocliente" cellspacing="0" style="text-align: center;">
                                        <thead>
                                            <tr class="encabezado table-dark">
                                                <th scope="col">FECHA DE RECIBIDO BODEGA</th>
                                                <th scope="col">USUARIO</th>
                                                <th scope="col">NOMBRE DE QUIEN RECIBE BODEGA</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?php echo date('d/m/Y H:i:s', strtotime('now')); ?></td>
                                                <td><?php echo utf8_encode($_SESSION['usuario']); ?></td>
                                                <td><?php echo utf8_encode($_SESSION['NOMBRE']); ?></td>

                                                <input type="hidden" name="fechaRecibido" value=<?php echo date('Y-m-d H:i:s', strtotime('now')); ?>></input>
                                                <input type="hidden" name="usuario" value=<?php echo utf8_encode($_SESSION['usuario']); ?>></input>
                                                <input type="hidden" name="NOMBRE" value=<?php echo utf8_encode($_SESSION['NOMBRE']); ?>></input>


                                            </tr>
                                        </tbody>
                                    </table>

                                    <!-- tbl tipo de factura -->

                                    <table class="table table-bordered dt-responsive table-hover display nowrap" id="infotipofactura" cellspacing="0" style="text-align: center;">
                                        <thead>
                                            <tr class="encabezado table-dark">
                                                <th scope="col">TIPO DE FACTURA</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col-md-4"></div>
                                                            <div class="col-md-4">
                                                                <select name="TIPODEFACTURA" class="form-select" aria-label="Default select example" id="tipo-factura" required aria-required="true">
                                                                    <option value="PARCIAL">PARCIAL</option>
                                                                    <option value="COMPLETA">COMPLETA</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <!-- tbl info de productos -->
                                    <table class="table table-bordered dt-responsive table-hover display nowrap" id="infoproductos" cellspacing="0" style="text-align: center;">
                                        <thead>
                                            <tr class="encabezado table-dark">
                                                <th scope="col">DESCRIPCIÓN</th>
                                                <th scope="col">ID PRODUCTO</th>
                                                <th scope="col">NOMBRE DE PRODUCTO</th>
                                                <th scope="col">CANTIDAD</th>
                                            </tr>
                                        </thead>


                                        <tbody>
                                            <?php
                                            $count = 0;
                                            foreach ($F->buscarCodigo($factura) as $a) :
                                            ?>
                                                <tr>
                                                    <td><?= utf8_encode($a['descripcion']) ?></td>
                                                    <td><?= utf8_encode($a['PRODUCTO']) ?></td>
                                                    <td><?= utf8_encode($a['Nombre_Producto_Mvto']) ?></td>
                                                    <td><input class="caracteres" type="number" name="cantidad<?php echo $count; ?>" value="<?php echo round(($a['cantidad'])) ?>" readonly></input></td>

                                                    <input type="hidden" name="PRODUCTO<?php echo $count; ?>" value="<?php echo ($a['PRODUCTO']) ?>""></input>
                                                    <input type="hidden" name="Nombre_Producto_Mvto<?php echo $count; ?>" value="<?php echo ($a['Nombre_Producto_Mvto']) ?>"></input>
                                                    <input type="hidden" name="cantidadOriginal<?php echo $count; ?>" value="<?php echo ($a['cantidad']) ?>"></input>
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
                                    <button id="enviar" type="submit" class="btn btn-warning enviar" name="enviar" value="enviar" style="display:none"></button>
                                </form>
                                <!-- btn guardar informacion  -->
                                <div class="container">
                                    <div class="row">
                                        <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4"></div>
                                        <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                            <div class="text-center">
                                                <button id="" class="btn btn-success showAlertButton" name="enviar">Guardar recibo de devolución</button> | <button type="button" class="btn btn-danger" onclick="redirectToInicio()">Cancelar</button>

                                                <script>
                                                    function redirectToInicio() {
                                                        window.location.href = '../view/inicio.php';
                                                    }
                                                </script>

                                            </div>
                                        </div>
                                        <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4"></div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>

                <?php } else { ?>

            <?php }
            } ?>
        </section>


    </body>



    <script>
        jQuery('.caracteres').keypress(function(tecla) {
            if (tecla.charCode < 48 || tecla.charCode > 57) return false;
        });
    </script>

    <!-- script para el select habilitar y deshabilitar campos -->
    <script>
        const tipoFacturaSelect = document.getElementById('tipo-factura');
        const infoproductosTable = document.getElementById('infoproductos');

        tipoFacturaSelect.addEventListener('change', function() {
            const selectedOption = this.value;

            if (selectedOption === 'COMPLETA') {
                // Deshabilitar los campos de la segunda tabla
                const inputFields = infoproductosTable.getElementsByTagName('input');
                for (let i = 0; i < inputFields.length; i++) {
                    inputFields[i].readOnly = true;
                }
            } else if (selectedOption === 'PARCIAL') {
                // Habilitar los campos de la segunda tabla
                const inputFields = infoproductosTable.getElementsByTagName('input');
                for (let i = 0; i < inputFields.length; i++) {
                    inputFields[i].readOnly = false;
                }
            }
        });
    </script>


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


    </html>

<?php } else { ?>
    <script languaje "JavaScript">
        alert("Acceso Incorrecto");
        window.location.href = "../login.php";
    </script><?php
            } ?>