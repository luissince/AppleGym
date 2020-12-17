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
            <div class="app-title">
                <h1><i class="fa fa-money"></i> Ingresos</h1>
            </div>

            <div class="tile mb-4">
                <div class="row">
                    <div class="col-lg-4">
                        <label for="f-inicio">Fecha de inicio: </label>
                        <div class="form-group">
                            <input class="form-control" id="f-inicio" type="date" name="f-inicio">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <label for="f-fin">Fecha de fin: </label>
                        <div class="form-group">
                            <input class="form-control" id="f-fin" type="date" name="f-fin">
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
                                            <th class="sorting" rowspan="1" colspan="1" style="width: 20px;">#</th>
                                            <th class="sorting" rowspan="1" colspan="1" style="width: 75px;">Fecha</th>
                                            <th class="sorting" rowspan="1" colspan="1" style="width: 75px;">Comprobante</th>
                                            <th class="sorting" rowspan="1" colspan="1" style="width: 180px;">Cliente</th>
                                            <th class="sorting" rowspan="1" colspan="1" style="width: 72px;">Tipo</th>
                                            <th class="sorting" rowspan="1" colspan="1" style="width: 72px;">Estado</th>
                                            <th class="sorting" rowspan="1" colspan="1" style="width: 72px;">Metodo</th>
                                            <th class="sorting" rowspan="1" colspan="1" style="width: 72px;">Total</th>
                                            <th class="sorting" rowspan="1" colspan="1" style="width: 100px;">Vendedor</th>
                                            <th class="sorting" rowspan="1" colspan="1" style="width: 59px;">Detelle</th>
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

            $(document).ready(function() {

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

                $("#txtSearch").keypress(function() {
                    if ($("#txtSearch").val().trim() != '') {
                        if (!state) {
                            paginacion = 1;
                            loadTableIngresos($("#txtSearch").val().trim());
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
                        loadTableIngresos("");
                        break;
                    case 1:
                        loadTableIngresos($("#txtSearch").val().trim());
                        break;
                }
            }


            function loadInitIngresos() {
                if (!state) {
                    paginacion = 1;
                    loadTableIngresos("");
                    opcion = 0;
                }
            }


            function loadTableIngresos(datos) {
                $.ajax({
                    url: "../app/venta/Listar_Venta.php",
                    method: "GET",
                    data: {
                        opcion: 1,
                        page: paginacion,
                        datos: datos
                    },
                    beforeSend: function() {
                        state = true;
                        tbLista.empty();
                        tbLista.append(
                            '<tr role="row" class="odd"><td class="sorting_1" colspan="10" style="text-align:center"><img src="./images/loading.gif" width="100"/><p>cargando información...</p></td></tr>'
                        );
                    },
                    success: function(result) {
                        if (result.estado == 1) {
                            tbLista.empty();
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
                                    '<td>' + metodo + '<br>' + venta.numero + '</td>' +
                                    '<td>S/ ' + tools.formatMoney(venta.total) + '</td>' +
                                    '<td>' + venta.empleadoNombres + '<br>' + venta.empleadoApellidos + '</td>' +
                                    '<td><button class="btn btn-info" onclick="detalleVenta(\'' + venta.idVenta + '\')"><i class="fa fa-eye"></i></button></td>' +
                                    '</tr>');
                            }
                            totalPaginacion = parseInt(Math.ceil((parseFloat(result.total) / parseInt(
                                10))));
                            $("#lblPaginaActual").html(paginacion);
                            $("#lblPaginaSiguiente").html(totalPaginacion);
                            state = false;
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
                //                 SELECT 
                // case v.tipo when 1 then 'Contado' else 'Crédito' END as 'TipoVenta',
                // case v.forma when 1 then 'Efectivo' else 'Tarjeta' end as 'FormaPago',
                // sum(d.cantidad*d.precio) as 'Total' from detalleventatb as d 
                // INNER JOIN ventatb as v on v.idVenta = d.idVenta
                // where v.fecha = '2020-12-15' 
                // GROUP by v.hora
            }
        </script>
    </body>

    </html>

<?php
}
