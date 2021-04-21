<?php
session_start();
if (!isset($_SESSION["IdEmpleado"])) {
    echo '<script>location.href = "./login.php";</script>';
} else {
    if ($_SESSION["Roles"][3]["ver"] == 1) {
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
                    <h1><i class="fa fa-money"></i> Ingresos</h1>
                </div>

                <div class="tile mb-4">

                    <div class="row">
                        <div class="col-lg-4">
                            <label for="f-inicio">Fecha de inicio: </label>
                            <div class="form-group">
                                <input class="form-control" id="fechaInicio" type="date" name="f-inicio">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label for="f-fin">Fecha de fin: </label>
                            <div class="form-group">
                                <input class="form-control" id="fechaFin" type="date" name="f-fin">
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
                                                <th width="5%">#</th>
                                                <th width="15%;">Cliente</th>
                                                <th width="15%;">Transacción</th>
                                                <th width="10%;">Fecha</th>
                                                <th width="25%;">Detalle</th>
                                                <th width="10%;">Forma</th>
                                                <th width="10%;">Vendedor</th>
                                                <th width="10%;">Monto</th>
                                                <th width="5%;">Imprimir</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbLista">

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

                    $("#btnReporte").click(function() {
                        if (tools.validateDate(fechaInicio.val()) && tools.validateDate(fechaFinal.val())) {
                            openReporteIngresos(fechaInicio.val(), fechaFinal.val());
                        } else {
                            tools.AlertWarning("Mensaje: ", "El formato de fecha no es el correcto.");
                        }
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
                            "opcion": 5,
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
                                '<tr role="row" class="odd"><td colspan="9" style="text-align:center"><img src="./images/loading.gif" width="100"/><p>Cargando información...</p></td></tr>'
                            );
                            totalPaginacion = 0;
                        },
                        success: function(result) {
                            if (result.estado == 1) {
                                tbLista.empty();
                                if (result.ingresos.length == 0) {
                                    tbLista.append(
                                        '<tr role="row" class="odd"><td colspan="9" style="text-align:center"><p>No hay datos para mostrar</p></td></tr>'
                                    );
                                    $("#lblPaginaActual").html(0);
                                    $("#lblPaginaSiguiente").html(0);
                                    state = false;
                                } else {
                                    for (let ingreso of result.ingresos) {
                                        let procedencia = ingreso.procedencia == 1 ? 'VENTAS' : 'CUENTAS POR COBRAR';
                                        let metodo = ingreso.forma == 1 ? '<i class="fa fa-money"></i> EFECTIVO' : '<i class="fa fa-credit-card-alt"></i> TARJETA';
                                        tbLista.append('<tr>' +
                                            '<td>' + ingreso.id + '</td>' +
                                            '<td>' + ingreso.dni + '<br>' + ingreso.apcliente + ' ' + ingreso.nmcliente + '</td>' +
                                            '<td>' + procedencia + '</td>' +
                                            '<td>' + tools.getDateForma(ingreso.fecha) + '<br>' + tools.getTimeForma(ingreso.hora, true) + '</td>' +
                                            '<td>' + ingreso.detalle + '</td>' +
                                            '<td>' + metodo + '</td>' +
                                            '<td>' + ingreso.nombres + " " + ingreso.apellidos + '</td>' +
                                            '<td>S/ ' + tools.formatMoney(ingreso.monto) + '</td>' +
                                            '<td class="text-center"><button class="btn btn-info" onclick="openPrint(\'' + ingreso.idIngreso + '\')"><i class="fa fa-print"></i></button></td>' +
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
                                    '<tr role="row" class="odd"><td colspan="9" style="text-align:center"><p>' +
                                    result.mensaje + '</p></td></tr>');
                                state = false;
                            }
                        },
                        error: function(error) {
                            tbLista.empty();
                            tbLista.append(
                                '<tr role="row" class="odd"><td colspan="9" style="text-align:center"><p>' +
                                error.responseText + '</p></td></tr>');
                            state = false;
                        }
                    });
                }

                function openReporteIngresos(fechaInicial, fechaFinal) {
                    window.open("../app/reportes/resumeningresos.php?fechaInicial=" + fechaInicial + "&fechaFinal=" + fechaFinal, "_blank");
                }

                function openPrint(idIngreso) {
                    window.open("../app/reportes/comprobanteingreso.php?idIngreso=" + idIngreso, "_blank");

                }
            </script>
        </body>

        </html>

<?php
    } else {
        echo '<script>location.href = "./bienvenido.php";</script>';
    }
}
