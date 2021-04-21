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
                                                        <th width="5%">#</th>
                                                        <th width="20%">Monto</th>
                                                        <th width="20%">Fecha Cobro</th>
                                                        <th width="20%">Fecha Registro</th>
                                                        <th width="20%">Opción </th>
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
                                                        <th class="sorting" width="15%">Descuento </th>
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

        <main class="app-content">
            <!-- Sidebar menu-->
            <?php include "./marcarentrada.php"; ?>
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
                                                    <th style="width: 5%;">#</th>
                                                    <th style="width: 15%;">Fecha</th>
                                                    <th style="width: 20%;">Comprobante</th>
                                                    <th style="width: 10%;">Tipo</th>
                                                    <th style="width: 10%;">Estado</th>
                                                    <th style="width: 15%;">Total</th>
                                                    <th style="width: 10%;">Detalle</th>
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
            let tbListaVenta = $("#tbListaVentas");
            let tbAsistencia = $("#tbListaAsistencia");

            $(document).ready(function() {
                $("#btnCloseModalDetalle").click(function() {
                    $("#modalDetalle").modal("hide");
                });

                $("#btnCerrarModalDetalle").click(function() {
                    $("#modalDetalle").modal("hide");
                });

                loadDataEmpleado(idEmpleado);
                loadVentas();
                loadAsistencias();
            });

            function loadDataEmpleado(idEmpleado) {
                $.ajax({
                    url: "../app/empleados/EmpleadoController.php",
                    method: "GET",
                    data: {
                        "type": "getbyid",
                        "idEmpleado": idEmpleado
                    },
                    beforeSend: function() {
                        $("#loading").empty();
                        $("#loading").append('<img src="./images/loading.gif" width="25" height="25" />')
                    },
                    success: function(result) {
                        $("#loading").empty();
                        if (result.estado == 1) {
                            let empleado = result.empleados;

                            $("#nombreCompleto").html(empleado.nombres + ' ' + empleado.apellidos)
                            $("#dni").html(empleado.numeroDocumento)
                            $("#celular").html(empleado.celular == '' ? '-' : empleado.celular)
                            $("#email").html(empleado.email == '' ? '-' : empleado.email)
                            $("#nacimiento").html(empleado.fechaNacimiento)
                            $("#direccion").html(empleado.direccion == '' ? '-' : empleado.direccion)
                        }
                    },
                    error: function(error) {
                        console.log(error.responseText)
                        $("#loading").empty();
                    }
                });
            }

            function loadVentas() {
                $.ajax({
                    url: "../app/venta/Listar_Venta.php",
                    method: "GET",
                    data: {
                        "opcion": 8,
                        "idEmpleado": idEmpleado
                    },
                    beforeSend: function() {
                        tbListaVenta.empty();
                        tbListaVenta.append(
                            '<tr role="row" class="odd"><td class="sorting_1" colspan="8" style="text-align:center"><img src="./images/loading.gif" width="100"/><p>cargando información...</p></td></tr>'
                        );
                    },
                    success: function(result) {
                        if (result.estado == 1) {
                            tbListaVenta.empty();
                            for (let venta of result.ventas) {
                                let estado = venta.estado == 3 ? '<span class="badge badge-pill badge-danger">ANULADO</span>' : venta.estado == 2 ? '<span class="badge badge-pill badge-warning">POR PAGAR</span>' : '<span class="badge badge-pill badge-success">PAGADO</span>';
                                tbListaVenta.append('<tr>' +
                                    '<td>' + venta.id + '</td>' +
                                    '<td>' + tools.getDateForma(venta.fecha) + '<br>' + tools.getTimeForma(venta.hora) + '</td>' +
                                    '<td>' + venta.nombre + '<br>' + venta.serie + '-' + venta.numeracion + '</td>' +
                                    '<td>' + (venta.tipo == 1 ? 'CONTADO' : 'CRÉDITO') + '</td>' +
                                    '<td>' + estado + '</td>' +
                                    '<td>S/ ' + tools.formatMoney(venta.total) + '</td>' +
                                    '<td><button class="btn btn-info" onclick="detalleVenta(\'' + venta.idVenta + '\')"><i class="fa fa-eye"></i></button></td>' +
                                    '</tr>');
                            }
                        } else {
                            tbListaVenta.empty();
                            tbListaVenta.append(
                                '<tr role="row" class="odd"><td class="sorting_1" colspan="8" style="text-align:center"><p>' +
                                result.mensaje + '</p></td></tr>');
                        }
                    },
                    error: function(error) {
                        tbListaVenta.empty();
                        tbListaVenta.append(
                            '<tr role="row" class="odd"><td class="sorting_1" colspan="8" style="text-align:center"><p>' +
                            error.responseText + '</p></td></tr>');
                    }
                });
            }

            function loadAsistencias() {
                $.ajax({
                    url: "../app/venta/Listar_Venta.php",
                    method: "GET",
                    data: {
                        "opcion": 9,
                        "idEmpleado": idEmpleado
                    },
                    beforeSend: function() {
                        tbAsistencia.empty();
                        tbAsistencia.append(
                            '<tr role="row" class="odd"><td class="sorting_1" colspan="6" style="text-align:center"><img src="./images/loading.gif" width="100"/><p>cargando información...</p></td></tr>'
                        );
                    },
                    success: function(result) {
                        if (result.estado == 1) {
                            tbAsistencia.empty();
                            for (let asistencia of result.asistencias) {
                                let estado = asistencia.estado == 1 ? '<span class="badge badge-pill badge-success">APERTURADO</span>' : '<span class="badge badge-pill badge-danger">CERRADO</span>';
                                tbAsistencia.append('<tr>' +
                                    '<td>' + asistencia.id + '</td>' +
                                    '<td>' + asistencia.fechaApertura + '</td>' +
                                    '<td>' + asistencia.horaApertura + '</td>' +
                                    '<td>' + tools.getNull(asistencia.fechaCierre) + '</td>' +
                                    '<td>' + tools.getNull(asistencia.horaCierre) + '</td>' +
                                    '<td>' + estado + '</td>' +
                                    '</tr>');
                            }
                        } else {
                            tbAsistencia.empty();
                            tbAsistencia.append(
                                '<tr role="row" class="odd"><td class="sorting_1" colspan="6" style="text-align:center"><p>' +
                                result.mensaje + '</p></td></tr>');
                        }
                    },
                    error: function(error) {
                        tbAsistencia.empty();
                        tbAsistencia.append(
                            '<tr role="row" class="odd"><td class="sorting_1" colspan="6" style="text-align:center"><p>' +
                            error.responseText + '</p></td></tr>');
                    }
                });
            }

            function detalleVenta(idVenta) {
                $("#modalDetalle").modal("show");
                $.ajax({
                    url: "../app/venta/Listar_Venta.php",
                    method: "GET",
                    data: {
                        "opcion": 3,
                        "idVenta": idVenta
                    },
                    beforeSend: function() {
                        $("#tbDetalleVenta").empty();
                        $("#tbDetalleVenta").append('<tr role="row" class="odd"><td class="sorting_1" colspan="9" style="text-align:center"><img src="./images/loading.gif" width="100"/><p>Cargando información...</p></td></tr>');
                    },
                    success: function(result) {
                        if (result.estado == 1) {
                            $("#tbDetalleVenta").empty();
                            for (let det of result.detalle) {
                                $("#tbDetalleVenta").append('<tr>' +
                                    '<td>' + det.id + '</td>' +
                                    '<td>' + det.detalle + '</td>' +
                                    '<td>' + tools.formatMoney(det.cantidad) + '</td>' +
                                    '<td>' + tools.formatMoney(det.precio) + '</td>' +
                                    '<td>' + tools.formatMoney(det.descuento) + '</td>' +
                                    '<td>' + tools.formatMoney((det.cantidad * (det.precio - det.descuento))) + '</td>' +
                                    '</tr>');
                            }
                        } else {
                            $("#tbDetalleVenta").empty();
                            $("#tbDetalleVenta").append('<tr role="row" class="odd"><td class="sorting_1" colspan="9" style="text-align:center"><p>' + result.mensaje + '</p></td></tr>');
                        }
                    },
                    error: function(error) {
                        $("#tbDetalleVenta").empty();
                        $("#tbDetalleVenta").append('<tr role="row" class="odd"><td class="sorting_1" colspan="9" style="text-align:center"><p>' + error.responseText + '</p></td></tr>');
                    }
                });
            }
        </script>
    </body>

    </html>

<?php
}
