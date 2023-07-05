<?php header('Content-Type: text/html; charset=UTF-8');

session_start();
error_reporting(0);

include '../conexionbd.php';
if (isset($_SESSION['usuario'])) {

?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Devoluciones" />
        <meta name="author" content="Yon Gonzalez" />
        <title>Devoluciones</title>
        <link rel="icon" type="image/x-icon" href="../assets/image/faviconplanta.png" />
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="../css/bootstrap.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>


        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Plataforma Planta Beneficio" />
        <meta name="author" content="Yon Gonzalez" />
        <title>Proyeccion</title>
        <link rel="icon" type="image/x-icon" href="../Devoluciones/assets/image/faviconplanta.png" />

        <!-- CDN BOOSTRAP -->
        <link rel="stylesheet" href="../css/bootstrap.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>

        <!-- para exportar documentos -->

        <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css" rel="stylesheet" />

        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>

        <!-- SUM()  Datatables-->
        <script src="https://cdn.datatables.net/plug-ins/1.10.20/api/sum().js"></script>


    </head>

    <body>

        <nav class="navbar navbar-dark bg-dark fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand" href=""> <a href=""><img class="logo" src="../assets/image/faviconplanta.png"></a></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                    <div class="offcanvas-header">
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <div id="">
                            <a href="./inicio.php"><img id="inicioavatar" class="logo" src="../assets/image/perfil.png"></a>
                        </div>
                        <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">
                            <p class="user"> Usuario <br><?php echo utf8_encode($_SESSION['usuario']); ?></p>
                            <p class="user"> Nombre <br><?php echo utf8_encode($_SESSION['NOMBRE']); ?></p>
                        </h5>
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="./inicio.php">Inicio </a>
                            </li>
                            <a class="btn btn-danger btnCloseSesion" href="../closeSesion.php" role="button">Cerrar Sesión</a>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

    </body>

    </html>

<?php } else { ?>
    <script languaje "JavaScript">
        alert("Acceso Incorrecto");
        window.location.href = "../login.php";
    </script><?php
            } ?>