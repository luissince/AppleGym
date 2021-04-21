<?php
session_start();
if (!isset($_SESSION["IdEmpleado"])) {
    echo '<script>location.href = "./login.php";</script>';
} else {
    if ($_SESSION["Roles"][6]["ver"] == 1) {
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
            <!-- Sidebar menu-->
            <?php include "./marcarentrada.php"; ?>
            <!-- modal historial de membresia -->
            <div class="row">
                <div class="modal fade show" id="modalDetalle" data-backdrop="static" aria-modal="true">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h4 class="modal-title">
                                    <i class="fa fa-bandcamp"></i> Historial Membresía
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
                                                            <th class="sorting" width="10%">Fecha Registro</th>
                                                            <th class="sorting" width="35%">Descripción</th>
                                                            <th class="sorting" width="15%">Mem. Fecha Inicio/Final</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbDetalleVenta">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <div class="col-md-8 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <div class="text-left">
                                            <button class="btn btn-primary" id="btnAnteriorDetalle">
                                                <i class="fa fa-arrow-circle-left"></i>
                                            </button>
                                            <span class="m-2" id="lblPaginaActualDetalle">0
                                            </span>
                                            <span class="m-2">
                                                de
                                            </span>
                                            <span class="m-2" id="lblPaginaSiguienteDetalle">0
                                            </span>
                                            <button class="btn btn-primary" id="btnSiguienteDetalle">
                                                <i class="fa fa-arrow-circle-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <div class="text-right">
                                            <button type="button" class="btn btn-danger" id="btnCerrarModalDetalle">
                                                <i class="fa fa-check"></i> Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!--  -->
            <!-- modal ajuste de membresia -->
            <div class="row">
                <div class="modal fade" id="modalAjuste" data-backdrop="static">
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

                                    <div class="overlay d-none" id="divOverlayAjuste">
                                        <div class="m-loader mr-4">
                                            <svg class="m-circular" viewBox="25 25 50 50">
                                                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle>
                                            </svg>
                                        </div>
                                        <h4 class="l-text" id="lblTextOverlayAjuste">Cargando información...</h4>
                                    </div>

                                    <div class="tile-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="txtFechaInicio">Fecha Inicio: </label>
                                                    <input id="txtFechaInicio" type="date" class="form-control" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="txtFechaFecha">Fecha Final: </label>
                                                    <input id="txtFechaFecha" type="date" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="text-left text-info"><i class="fa fa-info text-danger"></i> Ajustar la membresia modificando la fecha de finalización</p>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <button type="button" class="btn btn-success" id="btnAjustarFecha">
                                                    <i class="fa fa-save"></i> Ajustar</button>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 border-top">
                                                <div class="form-group">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="txtFreeze">Dias restanteste de Freeze : </label>
                                                    <input id="txtFreeze" type="text" class="form-control" placeholder="0" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="txtCongelar">Dias a congelar: </label>
                                                    <input id="txtCongelar" type="text" class="form-control" placeholder="0">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="text-left text-info"><i class="fa fa-info text-danger"></i> Ajusta la membresia congelando sus días usando el freeze</p>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <button type="button" class="btn btn-success" id="btnAjustarFreeze">
                                                    <i class="fa fa-save"></i> Ajustar</button>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" id="btnCancelModal">
                                    <i class="fa fa-remove"></i> Cancelar</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!--  -->

            <main class="app-content">
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
                                    <option value="4">Membresias Traspasadas</option>
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
                                                <th class="sorting" style="width: 20%;">Cliente</th>
                                                <th class="sorting" style="width: 10%;">Membresia</th>
                                                <th class="sorting" style="width: 15%;">Plan</th>
                                                <th class="sorting" style="width: 15%;">Duración</th>
                                                <th class="sorting" style="width: 5%;">Ajustar</th>
                                                <th class="sorting" style="width: 5%;">Historial</th>
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

                    modalCategoriaEventos();
                    loadInitMembresias();
                });

                function modalCategoriaEventos() {
                    $("#btnCloseModal").click(function() {
                        closeClearModal();
                    });

                    $("#btnCloseModal").keypress(function(event) {
                        if (event.keyCode == 13) {
                            closeClearModal();
                        }
                        event.preventDefault();
                    });

                    $("#btnCancelModal").click(function() {
                        closeClearModal();
                    });

                    $("#btnCancelModal").keypress(function(event) {
                        if (event.keyCode == 13) {
                            closeClearModal();
                        }
                        event.preventDefault();
                    });

                    $("#btnAjustarFecha").click(function() {

                    });

                    $("#btnAjustarFecha").keypress(function(event) {
                        if (event.keyCode == 13) {

                        }
                        event.preventDefault();
                    });
                }

                function onEventPaginacion() {
                    switch (opcion) {
                        case 0:
                            loadTableMembresias(0, "", 0);
                            break;
                        case 1:
                            loadTableMembresias(1, $("#txtSearch").val().trim(), 0);
                            break;
                        case 2:
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
                        url: "../app/membresias/MembresiaController.php",
                        method: "GET",
                        data: {
                            "type": "lista",
                            "page": paginacion,
                            "opcion": opcion,
                            "search": buscar,
                            "membresia": membresia
                        },
                        beforeSend: function() {
                            state = true;
                            tbLista.empty();
                            tbLista.append(
                                '<tr role="row" class="odd"><td class="sorting_1" colspan="7" style="text-align:center"><img src="./images/loading.gif" width="100"/><p>Cargando información...</p></td></tr>'
                            );
                            totalPaginacion = 0;
                        },
                        success: function(result) {
                            if (result.estado == 1) {
                                tbLista.empty();

                                if (result.membresias.length == 0) {
                                    tbLista.append(
                                        '<tr role="row" class="odd"><td class="sorting_1" colspan="7" style="text-align:center"><p>No hay datos para mostrar</p></td></tr>'
                                    );
                                    $("#lblPaginaActual").html(0);
                                    $("#lblPaginaSiguiente").html(0);
                                    state = false;
                                } else {

                                    for (let membresia of result.membresias) {
                                        let estadoMembresia = membresia.membresia == 1 ? '<span class="badge badge-pill badge-success">Activa</span>' : membresia.membresia == 2 ? '<span class="badge badge-pill badge-warning">Por Vencer</span>' : membresia.membresia == 3 ? '<span class="badge badge-pill badge-danger">Traspaso</span>' : '<span class="badge badge-pill badge-danger">Finalizada</span>';
                                        let btnAjustar = '<button class="btn btn-success" onclick="openModalAjustar(\'' + membresia.idMembresia + '\')" ><i class="fa fa-sign-in"></i></button>';
                                        let btnHistorial = '<button class="btn btn-info" onclick="openModalDetalle(\'' + membresia.idMembresia + '\')"><i class="fa fa fa-eye"></i> </button>';
                                        tbLista.append('<tr role="row" class="odd">' +
                                            '<td>' + membresia.id + '</td>' +
                                            '<td>' + membresia.dni + '<br>' + membresia.apellidos + '<br>' + membresia.nombres + '</td>' +
                                            '<td class="text-center">' + estadoMembresia + '</td>' +
                                            '<td>' + membresia.nombrePlan + '</td>' +
                                            '<td>' + 'Del ' + tools.getDateForma(membresia.fechaInicio) + ' al ' + tools.getDateForma(membresia.fechaFin) + '</td>' +
                                            '<td class="text-center"> ' + btnAjustar + '</td>' +
                                            '<td class="text-center"> ' + btnHistorial + '</td>' +
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
                                    '<tr role="row" class="odd"><td class="sorting_1" colspan="7" style="text-align:center"><p>' +
                                    result.mensaje + '</p></td></tr>');
                                $("#lblPaginaActual").html(0);
                                $("#lblPaginaSiguiente").html(0);
                                state = false;
                            }
                        },
                        error: function(error) {
                            tbLista.empty();
                            tbLista.append(
                                '<tr role="row" class="odd"><td class="sorting_1" colspan="7" style="text-align:center"><p>' +
                                error.responseText + '</p></td></tr>');
                            $("#lblPaginaActual").html(0);
                            $("#lblPaginaSiguiente").html(0);
                            state = false;
                        }
                    });
                }

                function openModalAjustar(idMembresia) {
                    $("#modalAjuste").modal("show");
                    $("#titulo-modal").append('<i class="fa fa-align-left"></i> Ajustar Membresia')

                    $.ajax({
                        url: "../app/membresias/MembresiaController.php",
                        method: 'GET',
                        data: {
                            "type": "getbyid",
                            "idMembresia": idMembresia
                        },
                        beforeSend: function() {
                            $("#lblTextOverlayAjuste").html("Cargando información...");
                            $("#divOverlayAjuste").removeClass("d-none");
                            $("#btnAjustarFecha").unbind();
                            $("#btnAjustarFreeze").unbind();
                        },
                        success: function(result) {
                            if (result.estado == 1) {
                                let freeze = parseInt(result.membresia.freeze);
                                let congelar = parseInt(result.membresia.congelar);
                                let totalFreeze = freeze - congelar;
                                let fechaFin = result.membresia.fechaFin;
                                $("#txtFechaInicio").val(result.membresia.fechaInicio);
                                $("#txtFechaFecha").val(result.membresia.fechaFin);
                                $("#txtFreeze").val(totalFreeze);
                                $("#divOverlayAjuste").addClass("d-none");

                                $("#btnAjustarFecha").bind("click", function() {
                                    if (!tools.validateDate($("#txtFechaFecha").val())) {
                                        tools.AlertWarning("Membresia: ", "Ingrese una fecha valida.");
                                        $("#txtFechaFecha").focus();
                                    } else {
                                        $.ajax({
                                            url: "../app/membresias/MembresiaController.php",
                                            method: 'POST',
                                            accepts: "application/json",
                                            contentType: "application/json",
                                            data: JSON.stringify({
                                                "type": "updateAjusteFecha",
                                                "idMembresia": idMembresia,
                                                "fecha": tools.getCurrentDate(),
                                                "hora": tools.getCurrentTime(),
                                                "fechaFin": $("#txtFechaFecha").val()
                                            }),
                                            beforeSend: function() {
                                                closeClearModal();
                                                tools.ModalAlertInfo('Membresia', 'Procesando petición...');
                                            },
                                            success: function(result) {
                                                if (result.estado == 1) {
                                                    tools.ModalAlertSuccess('Membresia', result.mensaje);
                                                    loadInitMembresias();
                                                } else {
                                                    tools.ModalAlertWarning('Membresia', result.mensaje);
                                                }
                                            },
                                            error: function(error) {
                                                tools.ModalAlertError('Membresia', error.responseText);
                                            }
                                        });
                                    }
                                });

                                $("#btnAjustarFreeze").bind("click", function() {
                                    console.log(totalFreeze)
                                    if (!tools.isNumeric($("#txtCongelar").val().trim())) {
                                        tools.AlertWarning("Membresia: ", "Ingrese los días a congelar.");
                                        $("#txtCongelar").focus();
                                    } else if (parseInt($("#txtCongelar").val().trim()) <= 0) {
                                        tools.AlertWarning("Membresia: ", "El valor ingresado debe ser mayor a 0.");
                                        $("#txtCongelar").focus();
                                    } else if (totalFreeze !== parseInt($("#txtCongelar").val().trim()) && totalFreeze < parseInt($("#txtCongelar").val().trim())) {
                                        tools.AlertWarning("Membresia: ", "Ingrese los días para congelar menos o igual a los días restantes.");
                                        $("#txtCongelar").focus();
                                    } else {
                                        $.ajax({
                                            url: "../app/membresias/MembresiaController.php",
                                            method: 'POST',
                                            accepts: "application/json",
                                            contentType: "application/json",
                                            data: JSON.stringify({
                                                "type": "updateAjusteFreeze",
                                                "idMembresia": idMembresia,
                                                "fecha": tools.getCurrentDate(),
                                                "hora": tools.getCurrentTime(),
                                                "fechaFin": fechaFin,
                                                "dias": parseInt($("#txtCongelar").val().trim())
                                            }),
                                            beforeSend: function() {
                                                closeClearModal();
                                                tools.ModalAlertInfo('Membresia', 'Procesando petición...');
                                            },
                                            success: function(result) {
                                                if (result.estado == 1) {
                                                    tools.ModalAlertSuccess('Membresia', result.mensaje);
                                                    loadInitMembresias();
                                                } else {
                                                    tools.ModalAlertWarning('Membresia', result.mensaje);
                                                }
                                            },
                                            error: function(error) {
                                                tools.ModalAlertError('Membresia', error.responseText);
                                            }
                                        });
                                    }
                                });
                            } else {
                                $("#lblTextOverlayAjuste").html(result.mensaje);
                            }
                        },
                        error: function(error) {
                            $("#lblTextOverlayAjuste").html(error.responseText);
                        }
                    });
                }

                function openModalDetalle(id) {
                    $("#modalDetalle").modal("show");

                    $("#btnCloseModalDetalle").unbind();
                    $("#btnCloseModalDetalle").bind('click', function() {
                        $("#modalDetalle").modal("hide");
                        $("#tbDetalleVenta").empty();
                    });

                    $("#btnCerrarModalDetalle").unbind();
                    $("#btnCerrarModalDetalle").bind('click', function() {
                        $("#modalDetalle").modal("hide");
                        $("#tbDetalleVenta").empty();
                    });

                    $.ajax({
                        url: "../app/membresias/MembresiaController.php",
                        method: 'GET',
                        data: {
                            "type": "listahistorialdetalle",
                            "idMembresia": id,
                        },
                        beforeSend: function() {
                            $("#tbDetalleVenta").empty();
                            $("#tbDetalleVenta").append(
                                '<tr role="row" class="odd"><td class="sorting_1" colspan="10" style="text-align:center"><img src="./images/loading.gif" width="100"/><p>Cargando información...</p></td></tr>'
                            );
                        },
                        success: function(result) {
                            $("#tbDetalleVenta").empty();
                            if (result.estado == 1) {
                                if (result.historial.length == 0) {
                                    $("#tbDetalleVenta").append(
                                        '<tr role="row" class="odd"><td class="sorting_1" colspan="10" style="text-align:center"><p>No hay datos para mostrar.</p></td></tr>'
                                    );
                                    $("#lblPaginaActualDetalle").html(0);
                                    $("#lblPaginaSiguienteDetalle").html(0);
                                } else {
                                    for (let value of result.historial) {
                                        $("#tbDetalleVenta").append('<tr>' +
                                            '<td>' + value.id + '</td>' +
                                            '<td>' + tools.getDateForma(value.fecha) + '<br>' + tools.getTimeForma24(value.hora) + '</td>' +
                                            '<td>' + value.descripcion + '</td>' +
                                            '<td>' + tools.getDateForma(value.fechaInicio) + '<br>' + tools.getDateForma(value.fechaFinal) + '</td>' +
                                            '</tr>');
                                    }
                                }
                            } else {
                                $("#tbDetalleVenta").append(
                                    '<tr role="row" class="odd"><td class="sorting_1" colspan="10" style="text-align:center"><p>' + result.mensaje + '</p></td></tr>'
                                );
                                $("#lblPaginaActualDetalle").html(0);
                                $("#lblPaginaSiguienteDetalle").html(0);
                            }
                        },
                        error: function(error) {
                            $("#tbDetalleVenta").empty();
                            $("#tbDetalleVenta").append(
                                '<tr role="row" class="odd"><td class="sorting_1" colspan="10" style="text-align:center"><p>' + error.responseText + '</p></td></tr>'
                            );
                            $("#lblPaginaActualDetalle").html(0);
                            $("#lblPaginaSiguienteDetalle").html(0);
                        }
                    });
                }

                function closeClearModal() {
                    $("#modalAjuste").modal("hide");
                    $("#titulo-modal").empty();
                    $("#txtCongelar").val("");
                }
            </script>
        </body>

        </html>

<?php
    } else {
        echo '<script>location.href = "./bienvenido.php";</script>';
    }
}
