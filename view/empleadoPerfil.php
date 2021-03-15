<?php
session_start();
if (!isset($_SESSION["IdEmpleado"])) {
    echo '<script>location.href = "./login.php";</script>';
} else {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php include './layout/head.php'; ?>
    </head>

    <body class="app sidebar-mini">
        <!-- Navbar-->
        <?php include "./layout/header.php"; ?>
        <!-- Sidebar menu-->
        <?php include "./layout/menu.php"; ?>
        <main class="app-content">

            <!-- Sidebar menu-->
            <?php include "./marcarentrada.php"; ?>

            <!-- modal detelle de la venta -->
            <div class="row">
                <div class="modal fade show" id="modalDetalle" data-backdrop="static" aria-modal="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="titulo-modal">
                                    <i class="fa fa-bandcamp"></i> Detalle de la venta
                                </h4>
                                <button type="button" class="close" id="btnCloseModalDetalle">
                                    <i class="fa fa-close"></i>
                                </button>
                            </div>
                            <div class="modal-body">

                                <div class="row">
                                    <div class="col-md-12 ">

                                        <div class="tile-body">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th class="sorting" width="5%">#</th>
                                                            <th class="sorting" width="50%">Descripción</th>
                                                            <th class="sorting" width="15%">Cantidad</th>
                                                            <th class="sorting" width="15%">Precio </th>
                                                            <th class="sorting" width="15%">Importe</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbDetalleVenta">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" id="btnCerrarModalDetalle">
                                        <i class="fa fa-check"></i> Cerrar</button>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!--  -->

            <!-- modal detelle del credito -->
            <div class="row">
                <div class="modal fade show" id="modalCredito" data-backdrop="static" aria-modal="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="titulo-modal">
                                    <i class="fa fa-bandcamp"></i> Detalle del Crédito
                                </h4>
                                <button type="button" class="close" id="btnCloseModalCredito">
                                    <i class="fa fa-close"></i>
                                </button>
                            </div>
                            <div class="modal-body">

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group text-center">
                                            <p class="h6">MONTO TOTAL</p>
                                            <b class="h6 text-info" id="lblMontoTotal">S/ 0.00</b>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group text-center">
                                            <p class="h6">MONTO COBRADO</p>
                                            <b class="h6 text-info" id="lblMontoCobrado">S/ 0.00</b>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group text-center">
                                            <p class="h6">DIFERENCIA</p>
                                            <b class="h6 text-danger" id="lblDiferencia">S/ 0.00</b>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Forma de Pago:</label>
                                        <div class="form-group">
                                            <select id="formapagocredito" class="form-control form-control-sm">
                                                <option value="">- Selecciona -</option>
                                                <option value="1">EFECTIVO</option>
                                                <option value="2">TARJETA</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>N° Operación: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <div class="form-group">
                                                    <input id="numerocreditotarjeta" type="text" class="form-control form-control-sm">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 ">
                                        <div class="tile-body">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th class="sorting" width="5%">#</th>
                                                            <th class="sorting" width="20%">Monto</th>
                                                            <th class="sorting" width="20%">Fecha Cobro</th>
                                                            <th class="sorting" width="20%">Fecha Registro</th>
                                                            <th class="sorting" width="20%">Opción </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbDetalleCredito">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" id="btnAceptarModalCredito">
                                    <i class="fa fa-check"></i> Aceptar</button>
                                <button type="button" class="btn btn-danger" id="btnCerrarModalCredito">
                                    <i class="fa fa-check"></i> Cerrar</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!--  -->

            <!--  -->
            <div class="row">
                <div class="col-xl-4 col-lg-5 col-md-12 col-sm-12 col-12 bg-secondary text-center">
                    <div class="p-2">
                        <img class="img-fluid rounded-circle" src="./images/noimage.png" style="width:100%;max-width: 260px;">
                        <div class="text-center">
                            <h6 class="text-white pt-2" id="nombreCompleto"></h6>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-7 col-md-12 col-sm-12 col-12">
                    <div class="fondoImg p-3">
                        <div class="bg-white p-3 rounded font-weight-bold">
                            <h4><i class="fa fa-user"></i> Perfil del Empleado <span id="loading"></span></h4>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-text">DNI:</label>
                                </div>
                                <div class="col-md-9">
                                    <label class="form-text" id="dni"></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-text">Celular:</label>
                                </div>
                                <div class="col-md-9">
                                    <label class="form-text" id="celular"></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-text">Email:</label>
                                </div>
                                <div class="col-md-9">
                                    <label class="form-text" id="email"></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-text">Fecha de Nacimiento:</label>
                                </div>
                                <div class="col-md-9">
                                    <label class="form-text" id="nacimiento"></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-text">Dirección:</label>
                                </div>
                                <div class="col-md-9">
                                    <label class="form-text" id="direccion"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--  -->

            <!--  -->
            <div class="row user">
                <div class="col-xl-2 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="tile p-0">
                        <ul class="nav flex-column nav-tabs user-tabs">
                            <li class="nav-item"><a class="nav-link active" href="#ventas" data-toggle="tab">Ventas</a></li>
                            <li class="nav-item"><a class="nav-link" href="#asistencias" data-toggle="tab">Asistencias</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-10 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="tab-content">

                        <div class="tab-pane active " id="ventas">
                            <div class="tile p-3">
                                <br>
                                <div class="row">
                                    <div class="table-responsive pl-3 pr-3">
                                        <table class="table table-hover table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="sorting" style="width: 5%;">#</th>
                                                    <th class="sorting_asc" style="width: 15%;">Fecha</th>
                                                    <th class="sorting_asc" style="width: 20%;">Comprobante</th>
                                                    <th class="sorting" style="width: 10%;">Tipo</th>
                                                    <th class="sorting" style="width: 10%;">Estado</th>
                                                    <th class="sorting" style="width: 15%;">Total</th>
                                                    <th class="sorting" style="width: 10%;">Detalle</th>
                                                    <th class="sorting" style="width: 10%;">Cuotas</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbListaVentas">
                                                <!-- tbLista -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="tab-pane fade" id="asistencias">
                            <div class="tile p-3">
                                <div class="bs-component text-right">
                                    <button class="btn btn-success" type="button" id="btnRecargar"><i class="fa fa-refresh"></i>
                                        Recargar</button>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="table-responsive pl-3 pr-3">
                                        <table class="table table-hover table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%;">#</th>
                                                    <th style="width: 20%;">Fecha de Ingreso</th>
                                                    <th style="width: 20%;">Hora de Ingreso</th>
                                                    <th style="width: 20%;">Fecha de Salida</th>
                                                    <th style="width: 20%;">Hora de Salida</th>
                                                    <th style="width: 20%;">Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbListaAsistencia">
                                                <!-- tbLista -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!--  -->

        </main>
        <!-- Essential javascripts for application to work-->
        <?php include "./layout/footer.php"; ?>
        <script>
            let tools = new Tools();        
            let idEmpleado = "<?php echo $_GET["idEmpleado"]; ?>";

            $(document).ready(function() {
               
            });

            

           
        </script>
    </body>

    </html>

<?php
}
