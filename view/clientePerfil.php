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
                            <h4><i class="fa fa-user"></i> Perfil del Cliente <span id="loading"></span></h4>
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
                            <li class="nav-item"><a class="nav-link active" href="#comprobantes" data-toggle="tab">Comprobantes</a></li>
                            <li class="nav-item"><a class="nav-link" href="#menbresia" data-toggle="tab">Membresias</a></li>
                            <li class="nav-item"><a class="nav-link" href="#asistencias" data-toggle="tab">Asistencias</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-10 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="tab-content">

                        <div class="tab-pane active " id="comprobantes">
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

                        <div class="tab-pane fade " id="menbresia">
                            <div class="tile p-3">
                                <div class="bs-component text-right">
                                    <button class="btn btn-success" type="button" id="btnReporte"><i class="fa fa-file"></i>
                                        Reporte</button>
                                    <button class="btn btn-success" type="button" id="btnRenovar"><i class="fa fa-line-chart"></i>
                                        Renovar</button>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="table-responsive pl-3 pr-3">
                                        <table class="table table-hover table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1" style="width: 5%;">#</th>
                                                    <th class="sorting_asc" aria-controls="sampleTable" rowspan="1" colspan="1" style="width: 15%;">Membresia</th>
                                                    <th class="sorting_asc" aria-controls="sampleTable" rowspan="1" colspan="1" style="width: 15%;">Plan</th>
                                                    <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1" style="width: 15%;">Comprobante</th>
                                                    <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1" style="width: 20%;">Duración</th>
                                                    <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1" style="width: 10%;">Pago</th>
                                                    <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1" style="width: 15%;">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbListaMembresia">
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

            // let tbLista = $("#tbLista");
            // let opcion = 0;
            // let state = false;

            let tbListaMembresia = $("#tbListaMembresia");
            let tbListaVenta = $("#tbListaVentas");
            let tbListaAsistencia = $("#tbListaAsistencia");
            let idCliente = "<?php echo  $_GET["idCliente"]; ?>";

            let idEmpleado = "<?php echo $_SESSION["IdEmpleado"] ?>";

            let idVenta = "";

            $(document).ready(function() {

                $("#btnCloseModalDetalle").click(function() {
                    $("#modalDetalle").modal("hide");
                });

                $("#btnCerrarModalDetalle").click(function() {
                    $("#modalDetalle").modal("hide");
                });

                //--------------------------------------------------------

                $("#btnAceptarModalCredito").click(function() {
                    registrarCredito();
                });

                $("#btnAceptarModalCredito").keypress(function(event) {
                    if (event.keyCode === 13) {
                        registrarCredito();
                    }
                    event.preventDefault();
                });

                $("#btnCloseModalCredito").click(function() {
                    clearModalCredito()
                });

                $("#btnCerrarModalCredito").click(function() {
                    clearModalCredito()
                });

                $("#tbDetalleCredito").on("click", "tr", function(e) {
                    console.log($(this).find("td:eq(3)").find('input[type="checkbox"]').is(':checked'))
                });

                //----------------------------------------------------------

                loadDataCliente(idCliente);
                initTableMembresia();
                initTableVentas();
                initTableAsistencias();
            })

            function loadDataCliente(idCurrentClient) {
                $.ajax({
                    url: "../app/cliente/Obtener_Clientes_By_Id.php",
                    method: "POST",
                    accepts: "application/json",
                    contentType: "application/json",
                    data: JSON.stringify({
                        "idCliente": idCurrentClient
                    }),
                    beforeSend: function() {
                        $("#loading").empty();
                        $("#loading").append('<img src="./images/loading.gif" width="25" height="25" />')
                    },
                    success: function(result) {
                        if (result.estado == 1) {
                            let cliente = result.cliente;
                            $("#nombreCompleto").append((cliente.nombres + ' ' + cliente.apellidos).toUpperCase())
                            $("#dni").append(cliente.dni)
                            $("#celular").append(cliente.celular)
                            $("#email").append(cliente.email)
                            document.getElementById("nacimiento").innerHTML = tools.getDateForma(cliente
                                .fechaNacimiento, 'yyyy-mm-dd')
                            $("#direccion").append(cliente.direccion)

                            tools.AlertSuccess("Mensaje", 'Se cargaron correctamente los datos')
                            $("#loading").empty();

                        } else {
                            tools.AlertWarning("Mensaje", result.mensaje)
                            setTimeout(function() {
                                $("#loading").empty();

                            }, 1000);
                        }
                    },
                    error: function(error) {
                        tools.AlertError("Error", error.responseText);
                        $("#loading").empty();
                    }
                });
            }

            function initTableMembresia() {
                loadTableMembresias(idCliente);
            }

            function loadTableMembresias(id) {
                $.ajax({
                    url: "../app/membresias/Obtener_Membresia_Por_Cliente.php",
                    method: "GET",
                    data: {
                        "page": 1,
                        "idCliente": id
                    },
                    beforeSend: function() {
                        tbListaMembresia.empty();
                        tbListaMembresia.append(
                            '<tr role="row" class="odd"><td class="sorting_1" colspan="9" style="text-align:center"><img src="./images/loading.gif" width="100"/><p>cargando información...</p></td></tr>'
                        );
                    },
                    success: function(result) {
                        if (result.estado == 1) {
                            let count = 0;
                            tbListaMembresia.empty();
                            for (let membresia of result.membresias) {
                                let estadoMembresia = membresia.membresia == 1 ? '<span class="badge badge-pill badge-success">Activa</span>' : '<span class="badge badge-pill badge-danger">Finalizada</span>';
                                let estado = membresia.estadoventa == 1 ? '<span class="badge badge-pill badge-success">PAGADO</span>' : '<span class="badge badge-pill badge-danger">PENDIENTE</span>';
                                count++;
                                tbListaMembresia.append('<tr role="row" class="odd">' +
                                    '<td class="sorting_1">' + count + '</td>' +
                                    '<td>' + estadoMembresia + '</td>' +
                                    '<td>' + membresia.nombre + '</td>' +
                                    '<td>' + membresia.serie + "-" + membresia.numeracion + '</td>' +
                                    '<td>Del ' + tools.getDateForma(membresia.fechaInicio) + ' al ' + tools.getDateForma(membresia.fechaFin) + '</td>' +
                                    '<td>' + estado + '</td>' +
                                    '<td>S/ ' + tools.formatMoney(membresia.total, 2) + '</td>' +
                                    '</tr>');
                            }
                        } else {
                            tbListaMembresia.empty();
                            tbListaMembresia.append(
                                '<tr role="row" class="odd"><td class="sorting_1" colspan="9" style="text-align:center"><p>' +
                                result.mensaje + '</p></td></tr>');
                        }
                    },
                    error: function(error) {
                        tbListaMembresia.empty();
                        tbListaMembresia.append(
                            '<tr role="row" class="odd"><td class="sorting_1" colspan="9" style="text-align:center"><p>' +
                            error.responseText + '</p></td></tr>');
                    }
                });
            }

            function initTableVentas() {
                loadTableVentas(idCliente);
            }

            function loadTableVentas(id) {
                $.ajax({
                    url: "../app/venta/Listar_Venta.php",
                    method: "GET",
                    data: {
                        "opcion": 2,
                        "idCliente": id
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
                                    '<td><button class="btn btn-primary" onclick="detallePagos(\'' + venta.idVenta + '\')"><i class="fa fa-briefcase"></i></button></td>' +
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

            function initTableAsistencias() {
                loadTableAsistencias(idCliente);
            }

            function loadTableAsistencias(id) {
                $.ajax({
                    url: "../app/venta/Listar_Venta.php",
                    method: "GET",
                    data: {
                        "opcion": 6,
                        "idCliente": id
                    },
                    beforeSend: function() {
                        tbListaAsistencia.empty();
                        tbListaAsistencia.append(
                            '<tr role="row" class="odd"><td class="sorting_1" colspan="5" style="text-align:center"><img src="./images/loading.gif" width="100"/><p>cargando información...</p></td></tr>'
                        );
                    },
                    success: function(result) {
                        if (result.estado == 1) {
                            tbListaAsistencia.empty();
                            for (let asistencia of result.asistencias) {
                                let estado = asistencia.estado == 1 ? '<span class="badge badge-pill badge-success">APERTURADO</span>' : '<span class="badge badge-pill badge-danger">CERRADO</span>';
                                tbListaAsistencia.append('<tr>' +
                                    '<td>' + asistencia.id + '</td>' +
                                    '<td>' + asistencia.fechaApertura + '</td>' +
                                    '<td>' + asistencia.horaApertura + '</td>' +
                                    '<td>' + tools.getNull(asistencia.fechaCierre) + '</td>' +
                                    '<td>' + tools.getNull(asistencia.horaCierre) + '</td>' +
                                    '<td>' + estado + '</td>' +
                                    '</tr>');
                            }
                        } else {
                            tbListaAsistencia.empty();
                            tbListaAsistencia.append(
                                '<tr role="row" class="odd"><td class="sorting_1" colspan="5" style="text-align:center"><p>' +
                                result.mensaje + '</p></td></tr>');
                        }
                    },
                    error: function(error) {
                        tbListaAsistencia.empty();
                        tbListaAsistencia.append(
                            '<tr role="row" class="odd"><td class="sorting_1" colspan="5" style="text-align:center"><p>' +
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
                                    '<td>' + tools.formatMoney((det.cantidad * det.precio)) + '</td>' +
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

            function detallePagos(id) {
                $("#modalCredito").modal("show");
                $.ajax({
                    url: "../app/venta/Listar_Venta.php",
                    method: "GET",
                    data: {
                        "opcion": 4,
                        "idVenta": id
                    },
                    beforeSend: function() {
                        $("#tbDetalleCredito").empty();
                        $("#tbDetalleCredito").append('<tr role="row" class="odd"><td class="sorting_1" colspan="5" style="text-align:center"><p>Cargado información...</p></td></tr>');

                        $("#lblMontoTotal").html("S/ 0.00");
                        $("#lblMontoCobrado").html("S/ 0.00");
                        $("#lblDiferencia").html("S/ 0.00");
                    },
                    success: function(result) {
                        $("#tbDetalleCredito").empty();
                        if (result.estado == 1) {
                            if (result.detalle.length == 0) {
                                $("#tbDetalleCredito").append('<tr role="row" class="odd"><td class="sorting_1" colspan="5" style="text-align:center"><p>No hay registros para mostrar</p></td></tr>');
                            } else {
                                idVenta = id;
                                let montoTotal = 0;
                                let montoCobrado = 0;
                                for (let det of result.detalle) {
                                    montoTotal += det.monto;
                                    montoCobrado += det.estado == "0" ? 0 : det.monto;
                                    $("#tbDetalleCredito").append('<tr id="' + det.idVentaCredito + '">' +
                                        '<td>' + det.id + '</td>' +
                                        '<td><input class="form-control form-control-sm" type="text" value="' + tools.formatMoney(det.monto) + '" disabled></td>' +
                                        '<td>' + tools.getDateForma(det.fechaRegistro) + '</td>' +
                                        '<td>' + (det.estado == "0" ? '--' : tools.getDateForma(det.fechaPago)) + '</td>' +
                                        '<td class="text-center">' + (det.estado == "0" ? '<input type="checkbox" />' : 'Cobrado') + '</td>' +
                                        '</tr>');
                                }
                                $("#lblMontoTotal").html("S/ " + tools.formatMoney(montoTotal));
                                $("#lblMontoCobrado").html("S/ " + tools.formatMoney(montoCobrado));
                                $("#lblDiferencia").html("S/ " + tools.formatMoney(montoTotal - montoCobrado));
                            }
                        } else {
                            $("#tbDetalleCredito").append('<tr role="row" class="odd"><td class="sorting_1" colspan="5" style="text-align:center"><p>' + result.mensaje + '</p></td></tr>');
                        }
                    },
                    error: function(error) {
                        $("#tbDetalleCredito").empty();
                        $("#tbDetalleCredito").append('<tr role="row" class="odd"><td class="sorting_1" colspan="5" style="text-align:center"><p>' + error.responseText + '</p></td></tr>');
                    }
                });
            }

            function registrarCredito() {
                if ($("#tbDetalleCredito tr").length == 0) {
                    tools.AlertWarning("Credtio: ", "No hay registro registro de plazos para continuar.");
                } else {
                    let arrayCredito = [];
                    $("#tbDetalleCredito tr").each(function(row, tr) {
                        if ($(tr).find("td:eq(4)").find('input[type="checkbox"]').is(':checked')) {
                            arrayCredito.push({
                                "idCredito": parseInt($(tr).attr('id')),
                                "fechaPago": tools.getCurrentDate(),
                                "horaPago": tools.getCurrentTime(),
                                "monto": parseFloat($(tr).find("td:eq(1)").find("input").val()),
                                "estado": true
                            });
                        }
                    });

                    if (arrayCredito.length == 0) {
                        tools.AlertWarning("Credtio: ", "No hay cuotas seleccionas para cobrar.");
                    } else if ($("#formapagocredito").val() == '') {
                        tools.AlertWarning("Credtio: ", "Seleccione la forma de pago.");
                        $("#formapagocredito").focus();
                    } else if ($("#numerocreditotarjeta").val() == '' && $("#formapagocredito").val() == '2') {
                        tools.AlertWarning("Ventas: ", "Ingrese el número de la operación");
                        $("#numerocreditotarjeta").focus();
                    } else {
                        $.ajax({
                            url: "../app/venta/RegistrarVentaCredito.php",
                            method: "POST",
                            accepts: "application/json",
                            contentType: "application/json",
                            data: JSON.stringify({
                                "idVenta": idVenta,
                                "vendedor": idEmpleado,
                                "fecha": tools.getCurrentDate(),
                                "hora": tools.getCurrentTime(),
                                "forma": $("#formapagocredito").val(),
                                "arrayCredito": arrayCredito
                            }),
                            beforeSend: function() {
                                clearModalCredito();
                                tools.ModalAlertInfo('Cobro', 'Procesando petición...');
                            },
                            success: function(result) {
                                if (result.estado == 1) {
                                    tools.ModalAlertSuccess('Cobro', result.mensaje);
                                } else if (result.estado == 2) {
                                    tools.ModalAlertWarning('Cobro', result.mensaje);
                                } else {
                                    tools.ModalAlertWarning('Cobro', result.mensaje);
                                }
                            },
                            error: function(error) {
                                tools.ModalAlertError('Cobro', error.responseText);

                            }
                        });
                    }
                }
            }

            function clearModalCredito() {
                $("#modalCredito").modal("hide");
                $("#lblMontoTotal").html("S/ 0.00");
                $("#lblMontoCobrado").html("S/ 0.00");
                $("#lblDiferencia").html("S/ 0.00");
                $("#tbDetalleCredito").empty();
                $("#formapagocredito").val("");
                $("#numerocreditotarjeta").val("");
                idVenta = "";
            }
        </script>
    </body>

    </html>

<?php
}
