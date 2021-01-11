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

            <div class="app-title">
                <h1><i class="fa fa-folder"></i> Ventas</h1>
            </div>

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
                                                            <th class="sorting" width="35%">Descripción</th>
                                                            <th class="sorting" width="15%">Cantidad</th>
                                                            <th class="sorting" width="15%">Precio</th>
                                                            <th class="sorting" width="15%">Descuento</th>
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

            <div class="tile mb-4">
                <div class="row">
                    <div class="col-lg-4">
                        <label for="f-inicio">Fecha de inicio: </label>
                        <div class="form-group">
                            <input class="form-control" id="fechaInicio" type="date">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <label for="f-fin">Fecha de fin: </label>
                        <div class="form-group">
                            <input class="form-control" id="fechaFin" type="date">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <label for="f-fin">Opciones: </label>
                        <div class="form-group">
                            <button class="btn btn-info" type="button" id="btnReporte"><i class="fa fa-file"></i>
                                Reporte</button>
                            <button class="btn btn-secondary" type="button" id="btnReload"><i class="fa fa-refresh"></i>
                                Recargar</button>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                        <div class="form-group">
                            <input type="search" class="form-control" placeholder="Buscar por nombre" id="txtSearch">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                        <div class="form-group">
                            <div class="text-right">
                                <button class="btn btn-primary" id="btnAnterior">
                                    <i class="fa fa-arrow-circle-left"></i>
                                </button>
                                <span class="m-2" id="lblPaginaActual">0
                                </span>
                                <span class="m-2">
                                    de
                                </span>
                                <span class="m-2" id="lblPaginaSiguiente">0
                                </span>
                                <button class="btn btn-primary" id="btnSiguiente">
                                    <i class="fa fa-arrow-circle-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="tile-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting" width="20px">#</th>
                                            <th class="sorting" width="75px">Fecha</th>
                                            <th class="sorting" width="75px">Comprobante</th>
                                            <th class="sorting" width="180px">Cliente</th>
                                            <th class="sorting" width="72px">Tipo</th>
                                            <th class="sorting" width="72px">Estado</th>
                                            <th class="sorting" width="72px">Total</th>
                                            <th class="sorting" width="100px;">Vendedor</th>
                                            <th class="sorting" width="59px">Detelle</th>
                                            <th class="sorting" width="59px">Anular</th>
                                            <!-- <th class="sorting" rowspan="1" colspan="1" style="width: 59px;">Eliminar</th>  -->

                                        </tr>
                                    </thead>
                                    <tbody id="tbLista">
                                        <!-- tbLista -->
                                        <!-- <tr>
                                        <td>1</td>
                                        <td>13/12/2020</td>
                                        <td>B001-12345678</td>
                                        <td>CL0001 - Usuario usuario</td>
                                        <td>Contado</td>
                                        <td>Pagado</td>
                                        <td>Tarjeta</td>
                                        <td>S/ 10.00</td>                                
                                        <td>
                                            <button class="btn btn-warning btn-sm"><i class="fa fa-wrench"></i> Editar</button>
                                        </td>
                                        <td>
                                            <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Eliminar</button>
                                        </td>
                                    </tr> -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <!-- Essential javascripts for application to work-->
        <?php include "./layout/footer.php"; ?>
        <script>
            let tools = new Tools();

            let tbLista = $("#tbLista");
            let totalPaginacion = 0;
            let paginacion = 0;
            let opcion = 0;
            let state = false;

            let fechaInicio = $("#fechaInicio");
            let fechaFinal = $("#fechaFin");

            $(document).ready(function() {

                $("#fechaInicio").val(tools.getCurrentDate());
                $("#fechaFin").val(tools.getCurrentDate());

                $("#btnCloseModalDetalle").click(function() {
                    $("#modalDetalle").modal("hide");
                });

                $("#btnCerrarModalDetalle").click(function() {
                    $("#modalDetalle").modal("hide");
                });


                $("#btnReporte").click(function() {
                    window.open("../app/reportes/resumeningresos.php", "_blank");
                });

                $("#btnReload").click(function() {
                    loadInitIngresos();
                });

                $("#btnAnterior").click(function() {
                    if (!state) {
                        if (paginacion > 1) {
                            paginacion--;
                            onEventPaginacion();
                        }
                    }
                });
                $("#btnSiguiente").click(function() {
                    if (!state) {
                        if (paginacion < totalPaginacion) {
                            paginacion++;
                            onEventPaginacion();
                        }
                    }
                });

                fechaInicio.on("change", function() {
                    if (tools.validateDate(fechaInicio.val()) && tools.validateDate(fechaFinal.val())) {
                        if (!state) {
                            paginacion = 1;
                            loadTableIngresos(0, "", fechaInicio.val(), fechaFinal.val());
                            opcion = 0;
                        }
                    }
                });

                fechaFinal.on("change", function() {
                    if (tools.validateDate(fechaInicio.val()) && tools.validateDate(fechaFinal.val())) {
                        if (!state) {
                            paginacion = 1;
                            loadTableIngresos(0, "", fechaInicio.val(), fechaFinal.val());
                            opcion = 0;
                        }
                    }
                });

                $("#txtSearch").keypress(function() {
                    if ($("#txtSearch").val().trim() != '') {
                        if (!state) {
                            paginacion = 1;
                            loadTableIngresos(1, $("#txtSearch").val().trim(), "", "");
                            opcion = 1;
                        }
                    }
                });

                $("#btnReload").click(function() {
                    loadInitIngresos();
                });

                loadInitIngresos();

            });

            function onEventPaginacion() {
                switch (opcion) {
                    case 0:
                        loadTableIngresos(0, "", fechaInicio.val(), fechaFinal.val());
                        break;
                    case 1:
                        loadTableIngresos(1, $("#txtSearch").val().trim(), "", "");
                        break;
                }
            }


            function loadInitIngresos() {
                if (tools.validateDate(fechaInicio.val()) && tools.validateDate(fechaFinal.val())) {
                    if (!state) {
                        paginacion = 1;
                        loadTableIngresos(0, "", fechaInicio.val(), fechaFinal.val());
                        opcion = 0;
                    }
                }
            }


            function loadTableIngresos(tipo, datos, fechaInicio, fechaFinal) {
                $.ajax({
                    url: "../app/venta/Listar_Venta.php",
                    method: "GET",
                    data: {
                        "opcion": 1,
                        "tipo": tipo,
                        "page": paginacion,
                        "datos": datos,
                        "fechaInicial": fechaInicio,
                        "fechaFinal": fechaFinal
                    },
                    beforeSend: function() {
                        state = true;
                        tbLista.empty();
                        tbLista.append(
                            '<tr role="row" class="odd"><td class="sorting_1" colspan="10" style="text-align:center"><img src="./images/loading.gif" width="100"/><p>cargando información...</p></td></tr>'
                        );
                        totalPaginacion = 0;
                    },
                    success: function(result) {
                        if (result.estado == 1) {
                            tbLista.empty();
                            if (result.ventas.length == 0) {
                                tbLista.append(
                                    '<tr role="row" class="odd"><td class="sorting_1" colspan="10" style="text-align:center"><p>No hay datos para mostrar.</p></td></tr>'
                                );
                                $("#lblPaginaActual").html(paginacion);
                                $("#lblPaginaSiguiente").html(totalPaginacion);
                                state = false;
                            } else {
                                for (let venta of result.ventas) {
                                    let estado = venta.estado == 3 ? '<span class="badge badge-pill badge-danger">ANULADO</span>' : venta.estado == 2 ? '<span class="badge badge-pill badge-warning">POR PAGAR</span>' : '<span class="badge badge-pill badge-success">PAGADO</span>';
                                    let metodo = venta.forma == 1 ? '<i class="fa fa-money"></i> EFECTIVO' : '<i class="fa fa-credit-card-alt"></i> TARJETA';
                                    tbLista.append('<tr>' +
                                        '<td>' + venta.id + '</td>' +
                                        '<td>' + tools.getDateForma(venta.fecha) + '<br>' + tools.getTimeForma(venta.hora, true) + '</td>' +
                                        '<td>' + venta.nombre + '<br>' + venta.serie + '-' + venta.numeracion + '</td>' +
                                        '<td>' + venta.nombres + '<br>' + venta.apellidos + '</td>' +
                                        '<td>' + (venta.tipo == 1 ? "CONTADO" : "CRÉDITO") + '</td>' +
                                        '<td>' + estado + '</td>' +
                                        '<td>S/ ' + tools.formatMoney(venta.total) + '</td>' +
                                        '<td>' + venta.empleadoNombres + '<br>' + venta.empleadoApellidos + '</td>' +
                                        '<td><button class="btn btn-info" onclick="detalleVenta(\'' + venta.idVenta + '\')"><i class="fa fa-eye"></i></button></td>' +
                                        '<td><button class="btn btn-danger" onclick="anularVenta(\'' + venta.idVenta + '\')"><i class="fa fa-trash"></i></button></td>' +
                                        '</tr>');
                                }
                                totalPaginacion = parseInt(Math.ceil((parseFloat(result.total) / parseInt(
                                    10))));
                                $("#lblPaginaActual").html(paginacion);
                                $("#lblPaginaSiguiente").html(totalPaginacion);
                                state = false;
                            }

                        } else {
                            tbLista.empty();
                            tbLista.append(
                                '<tr role="row" class="odd"><td class="sorting_1" colspan="10" style="text-align:center"><p>' +
                                result.mensaje + '</p></td></tr>');
                            state = false;
                        }
                    },
                    error: function(error) {
                        tbLista.empty();
                        tbLista.append(
                            '<tr role="row" class="odd"><td class="sorting_1" colspan="10" style="text-align:center"><p>' +
                            error.responseText + '</p></td></tr>');
                        state = false;
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
                        // console.log(result)
                        if (result.estado == 1) {
                            $("#tbDetalleVenta").empty();
                            for (let det of result.detalle) {
                                $("#tbDetalleVenta").append('<tr>' +
                                    '<td>' + det.id + '</td>' +
                                    '<td>' + det.detalle + '</td>' +
                                    '<td>' + tools.formatMoney(det.cantidad) + '</td>' +
                                    '<td>' + tools.formatMoney(det.precio) + '</td>' +
                                    '<td>' + tools.formatMoney(det.descuento) + '</td>' +
                                    '<td>' + tools.formatMoney((det.cantidad * (det.precio-det.descuento) )) + '</td>' +
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

            function anularVenta(idVenta) {
                tools.ModalDialog('Venta', '¿Está seguro de enular la venta?', 'question', function(value) {
                    if (value) {
                        $.ajax({
                            url: "../app/venta/Listar_Venta.php",
                            method: "GET",
                            data: {
                                "opcion": 7,
                                "idVenta": idVenta
                            },
                            beforeSend: function() {
                                tools.ModalAlertInfo('Venta', 'Procesando petición...');
                            },
                            success: function(result) {
                                if (result.estado == 1) {
                                    tools.ModalAlertSuccess('Venta', result.mensaje);
                                } else if (result.estado == 2) {
                                    tools.ModalAlertWarning('Venta', result.mensaje);
                                } else if (result.estado == 3) {
                                    tools.ModalAlertWarning('Venta', result.mensaje);
                                } else {
                                    tools.ModalAlertWarning('Venta', result.mensaje);
                                }
                            },
                            error: function(error) {
                                tools.ModalAlertError('Venta', error.responseText);
                            }
                        });
                    }
                });
            }
        </script>
    </body>

    </html>

<?php
}
