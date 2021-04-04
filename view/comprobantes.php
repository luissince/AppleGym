<?php
session_start();
if (!isset($_SESSION["IdEmpleado"])) {
    echo '<script>location.href = "./login.php";</script>';
} else {
    if ($_SESSION["Roles"][19]["ver"] == 1) {
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

                <!-- modal nuevo/update Productos  -->
                <div class="row">
                    <div class="modal fade" id="modalCategoria" data-backdrop="static">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h4 class="modal-title" id="titulo-modal">
                                    </h4>
                                    <button type="button" class="close" id="btnCloseModal">
                                        <i class="fa fa-close"></i>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <div class="tile p-0">

                                        <div class="overlay d-none" id="divOverlayCategoria">
                                            <div class="m-loader mr-4">
                                                <svg class="m-circular" viewBox="25 25 50 50">
                                                    <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle>
                                                </svg>
                                            </div>
                                            <h4 class="l-text" id="lblTextOverlayCategoria">Cargando información...</h4>
                                        </div>

                                        <div class="tile-body">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="txtNombre">Nombre: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                        <input id="txtNombre" type="text" class="form-control" placeholder="Ingrese el nombre" required="" minlength="8">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input class="form-check-input" id="cbEstado" type="checkbox" checked>Activo
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <p class="text-left text-danger">Todos los campos marcados con <i class="fa fa-fw fa-asterisk text-danger"></i> son obligatorios</p>
                                    <button type="button" class="btn btn-success" id="btnGuardarModal">
                                        <i class="fa fa-save"></i> Guardar</button>
                                    <button type="button" class="btn btn-danger" id="btnCancelModal">
                                        <i class="fa fa-remove"></i> Cancelar</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="app-title">
                    <div>
                        <h1><i class="fa fa-window-maximize"></i> Comprobantes</h1>
                    </div>
                </div>

                <div class="tile mb-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <p class="bs-component">
                                <button class="btn btn-info" type="button" id="btnAdd"><i class="fa fa-plus"></i>
                                    Nuevo</button>
                                <button class="btn btn-secondary" type="button" id="btnReload"><i class="fa fa-refresh"></i>
                                    Recargar</button>
                            </p>
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
                                                <th width="5%;">#</th>
                                                <th width="20%;">Nombre</th>
                                                <th width="10%;">Serie</th>
                                                <th width="10%;">Numeración</th>
                                                <th width="10%;">Estado</th>
                                                <th width="10%;">Editar</th>
                                                <th width="10%;">Eliminar</th>
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

                let state = false;
                let paginacion = 0;
                let opcion = 0;
                let totalPaginacion = 0;

                $(document).ready(function() {

                    $("#btnReload").click(function() {
                        loadInitImpuestos();
                    });

                    $("#btnReload").keypress(function(event) {
                        if (event.keyCode == 13) {
                            loadInitImpuestos();
                        }
                        event.preventDefault();
                    });

                    $("#txtSearch").keyup(function() {
                        if ($("#txtSearch").val().trim() != '') {
                            if (!sstate) {
                                paginacion = 1;
                                loadTableImpuestos($("#txtSearch").val().trim());
                                opcion = 1;
                            }
                        }
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

                });

                function onEventPaginacion() {
                    switch (opcion) {
                        case 0:
                            loadTableImpuestos("");
                            break;
                        case 1:
                            loadTableImpuestos($("#txtSearch").val().trim());
                            break;
                    }
                }

                function loadInitImpuestos() {
                    if (!state) {
                        paginacion = 1;
                        loadTableImpuestos("");
                        opcion = 0;
                    }
                }

                function loadTableImpuestos(datos) {
                    $.ajax({
                        url: "../app/compobante/ComprobanteController.php",
                        method: "GET",
                        data: {
                            "type": "lista",
                            "page": paginacion,
                            "datos": datos
                        },
                        beforeSend: function() {
                            state = true;
                            totalPaginacion = 0;
                            tbLista.empty();
                            tbLista.append(
                                '<tr role="row" class="odd"><td class="sorting_1" colspan="7" style="text-align:center"><img src="./images/loading.gif" width="100"/><p>Cargando información...</p></td></tr>'
                            );
                        },
                        success: function(result) {
                            tbLista.empty();
                            if (result.estado == 1) {
                                if (result.comprobantes.length == 0) {
                                    tbLista.append(
                                        '<tr role="row" class="odd"><td class="sorting_1" colspan="7" style="text-align:center"><p>No hay datos para mostrar.</p></td></tr>'
                                    );
                                    $("#lblPaginaActual").html(0);
                                    $("#lblPaginaSiguiente").html(0);
                                    state = false;
                                } else {
                                    for (let value of result.comprobantes) {
                                        let estado = value.estado == 1 ? '<span class="badge badge-pill badge-success">Activo</span>' : '<span class="badge badge-pill badge-danger">Inactivo</span>';
                                        tbLista.append('<tr role="row" class="odd">' +
                                            '<td>' + value.id + '</td>' +
                                            '<td>' + value.nombre + '</td>' +
                                            '<td>' + value.serie + '</td>' +
                                            '<td>' + value.numeracion + '</td>' +
                                            '<td>' + estado + '</td>' +
                                            '<td><button class="btn btn-warning btn-sm" onclick="updateComprobante(\'' + value.idTipoComprobante + '\')"><i class="fa fa-wrench"></i></button></td>' +
                                            '<td><button class="btn btn-danger btn-sm" onclick="deleteComprobante(\'' + value.idTipoComprobante + '\')"><i class="fa fa-trash"></i></button></td>' +
                                            '</tr>');
                                    }
                                    totalPaginacion = parseInt(Math.ceil((parseFloat(result.total) / parseInt(
                                        10))));
                                    $("#lblPaginaActual").html(paginacion);
                                    $("#lblPaginaSiguiente").html(totalPaginacion);
                                    state = false;
                                }
                            } else {
                                tbLista.append(
                                    '<tr role="row" class="odd"><td class="sorting_1" colspan="7" style="text-align:center"><p>' + result.mensaje + '</p></td></tr>'
                                );
                                $("#lblPaginaActual").html(0);
                                $("#lblPaginaSiguiente").html(0);
                                state = false;
                            }
                        },
                        error: function(error) {
                            tbLista.empty();
                            tbLista.append(
                                '<tr role="row" class="odd"><td class="sorting_1" colspan="7" style="text-align:center"><p>' + error.responseText + '</p></td></tr>'
                            );
                            $("#lblPaginaActual").html(0);
                            $("#lblPaginaSiguiente").html(0);
                            state = false;
                        }
                    });
                }

                function updateComprobante(){

                }

                function deleteComprobante(){

                }

            </script>
        </body>

        </html>

<?php
    } else {
        echo '<script>location.href = "./bienvenido.php";</script>';
    }
}
