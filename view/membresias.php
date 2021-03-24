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
                <div>
                    <h1><i class="fa fa-wpforms"></i> Membresias</h1>
                </div>
            </div>

            <div class="tile mb-4">
                <div class="row">
                    <div class="col-lg-4">
                        <label for="f-inicio">Estado de la Membresia: </label>
                        <div class="form-group">
                            <select class="form-control" id="cbMembresia">
                                <option value="0">- Seleccione -</option>
                                <option value="1">Membresias Activas <i class="fa fa-search"></i></option>
                                <option value="2">Membresias por Vencer a 10 días</option>
                                <option value="3">Membresias Vencidas</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <label for="f-fin">Opciones: </label>
                        <div class="form-group">
                            <button class="btn btn-secondary" type="button" id="btnReload"><i class="fa fa-refresh"></i>
                                Recargar</button>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-8 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <input type="search" class="form-control" placeholder="Buscar por plan o cliente" aria-controls="sampleTable" id="txtSearch">
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12">
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
                                        <tr>
                                            <th class="sorting" style="width: 5%;">#</th>
                                            <th class="sorting" style="width: 15%;">Cliente</th>
                                            <th class="sorting" style="width: 10%;">Membresia</th>
                                            <th class="sorting" style="width: 10%;">Plan</th>
                                            <th class="sorting" style="width: 10%;">Comprobante</th>
                                            <th class="sorting" style="width: 10%;">Duración</th>
                                            <th class="sorting" style="width: 10%;">Pago</th>
                                            <th class="sorting" style="width: 7%;">Total</th>
                                            <!-- <th class="sorting" style="width: 10%;">Eliminar</th> -->
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
            <!-- modal nuevo/update Cliente  -->

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

                $("#cbMembresia").change(function() {
                    if (!state) {
                        paginacion = 1;
                        loadTableMembresias(2, "", $(this).val());
                        opcion = 2;
                    }
                });

                $("#btnReload").click(function() {
                    loadInitMembresias();
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


                $("#txtSearch").keyup(function() {
                    if ($("#txtSearch").val().trim() != '') {
                        if (!state) {
                            paginacion = 1;
                            loadTableMembresias(1, $("#txtSearch").val().trim(), 0);
                            opcion = 1;
                        }
                    }
                });

                loadInitMembresias();
            });

            function onEventPaginacion() {
                switch (opcion) {
                    case 0:
                        loadTableMembresias(0, "", 0);
                        break;
                    case 1:
                        loadTableMembresias(1, $("#txtSearch").val().trim(), 0);
                        break;
                    case 1:
                        loadTableMembresias(2, "", $("#cbMembresia").val());
                        break;
                }
            }

            function loadInitMembresias() {
                if (!state) {
                    paginacion = 1;
                    loadTableMembresias(0, "", 0);
                    opcion = 0;
                }
            }

            function loadTableMembresias(opcion, buscar, membresia) {
                $.ajax({
                    url: "../app/membresias/Obtener_Membresias.php",
                    method: "GET",
                    data: {
                        "page": paginacion,
                        "opcion": opcion,
                        "search": buscar,
                        "membresia": membresia
                    },
                    beforeSend: function() {
                        state = true;
                        tbLista.empty();
                        tbLista.append(
                            '<tr role="row" class="odd"><td class="sorting_1" colspan="8" style="text-align:center"><img src="./images/loading.gif" width="100"/><p>Cargando información...</p></td></tr>'
                        );
                        totalPaginacion = 0;
                    },
                    success: function(result) {
                        if (result.estado == 1) {
                            tbLista.empty();

                            if (result.membresias.length == 0) {
                                tbLista.append(
                                    '<tr role="row" class="odd"><td class="sorting_1" colspan="8" style="text-align:center"><p>No hay datos para mostrar</p></td></tr>'
                                );
                                $("#lblPaginaActual").html(0);
                                $("#lblPaginaSiguiente").html(0);
                                state = false;
                            } else {

                                for (let membresia of result.membresias) {
                                    let estadoMembresia = membresia.membresia == 1 ? '<span class="badge badge-pill badge-success">Activa</span>' : membresia.membresia == 2 ? '<span class="badge badge-pill badge-warning">Por Vencer</span>' : '<span class="badge badge-pill badge-danger">Finalizada</span>';
                                    let estado = membresia.estadoventa == 1 ? '<span class="badge badge-pill badge-success">PAGADO</span>' : '<span class="badge badge-pill badge-danger">PENDIENTE</span>';
                                    let btnOpcionTraspaso =
                                        '<button class="btn btn-success id="opciones" >' +
                                        '<i class="fa fa-sign-in"></i> Traspaso' +
                                        '</button>';

                                    tbLista.append('<tr role="row" class="odd">' +
                                        '<td>' + membresia.id + '</td>' +
                                        '<td>' + membresia.dni + '<br>' + membresia.apellidos + ', ' + membresia.nombres + '</td>' +
                                        '<td class="text-center">' + estadoMembresia + '</td>' +
                                        '<td>' + membresia.nombrePlan + '</td>' +
                                        '<td>' + membresia.serie + '-' + membresia.numeracion + '</td>' +
                                        '<td>' + 'Del ' + tools.getDateForma(membresia.fechaInicio) + ' al ' + tools.getDateForma(membresia.fechaFin) + '</td>' +
                                        '<td>' + estado + '</td>' +
                                        '<td>S/ ' + tools.formatMoney(membresia.total) + '</td>' +
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
                                '<tr role="row" class="odd"><td class="sorting_1" colspan="8" style="text-align:center"><p>' +
                                result.mensaje + '</p></td></tr>');
                            state = false;
                        }
                    },
                    error: function(error) {
                        tbLista.empty();
                        tbLista.append(
                            '<tr role="row" class="odd"><td class="sorting_1" colspan="8" style="text-align:center"><p>' +
                            error.responseText + '</p></td></tr>');
                        state = false;
                    }
                });
            }
        </script>
    </body>

    </html>

<?php
}
