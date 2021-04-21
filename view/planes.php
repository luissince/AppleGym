<?php
session_start();
if (!isset($_SESSION["IdEmpleado"])) {
    echo '<script>location.href = "./login.php";</script>';
} else {
    if ($_SESSION["Roles"][15]["ver"] == 1) {
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
            <!-- modal plaes  -->
            <div class="row">
                <div class="modal fade" id="modalPlan" data-backdrop="static">
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

                                    <div class="overlay d-none" id="divOverlayPlanes">
                                        <div class="m-loader mr-4">
                                            <svg class="m-circular" viewBox="25 25 50 50">
                                                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle>
                                            </svg>
                                        </div>
                                        <h4 class="l-text" id="lblTextOverlayPlanes">Cargando información...</h4>
                                    </div>

                                    <div class="tile-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-selected="true">Básico</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-selected="false">Disciplinas</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="tab-content" id="pills-tabContent">
                                                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="nombre">Nombre: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                                        <input id="nombre" type="text" name="nombre" class="form-control" placeholder="Ingrese el nombre" required="" minlength="8">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <div class="form-check">
                                                                            <label class="form-check-label">
                                                                                <input id="cbPlanLibre" class="form-check-input" type="checkbox">Plan libre
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="meses">Duración(Meses): <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                                        <input id="meses" type="text" class="form-control" placeholder="Ingrese la número de meses" required="" minlength="8">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="dias">Duración(Dias):</label>
                                                                        <input id="dias" type="text" class="form-control" placeholder="Ingrese la número de dias" required="" minlength="8">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="freeze">Freeze:</label>
                                                                        <input id="freeze" type="text" class="form-control" placeholder="Ingrese los dias libres" required="" minlength="8">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="precio">Precio: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                                        <input id="precio" type="text" class="form-control" placeholder="Ingrese el precio" required="" minlength="8">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="descripcion">Descripción: </label>
                                                                        <input id="descripcion" type="text" class="form-control" placeholder="Ingrese la descripción" required="" minlength="8">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <div class="form-check">
                                                                            <label class="form-check-label">
                                                                                <input class="form-check-input" id="activo" type="checkbox" checked>Activo
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <div class="form-check">
                                                                            <label class="form-check-label">
                                                                                <input class="form-check-input" id="prueba" type="checkbox">Prueba
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="pills-profile" role="tabpanel">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-md-12 text-center">
                                                                    <div class="form-group">
                                                                        <label>Tipo de Plan</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <div class="form-check">
                                                                            <label class="form-check-label">
                                                                                <input class="form-check-input" id="basico" type="radio" name="tipodisciplina" checked>Iliminato
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <div class="form-check">
                                                                            <label class="form-check-label">
                                                                                <input class="form-check-input" id="disciplina" type="radio" name="tipodisciplina">Sujeto por Disciplina
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row" id="divDisciplina" style="display: none;">
                                                                <div class="col-md-9">
                                                                    <div class="form-group">
                                                                        <select id="estado" class="form-control">
                                                                            <option value="">- Selecciona -</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <button type="button" class="btn btn-success" id="btnAgregar">Agregar</button>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <table class="table table-hover table-bordered dataTable no-footer" id="sampleTable" role="grid" aria-describedby="sampleTable_info">
                                                                        <thead>
                                                                            <tr role="row">
                                                                                <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1" style="width: 20px;">Nombre</th>
                                                                                <th class="sorting_asc" aria-controls="sampleTable" rowspan="1" colspan="1" style="width: 250px;">Sesiones
                                                                                </th>
                                                                                <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1" style="width: 75px;">Opción
                                                                                </th>

                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="tvDisciplinas">

                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
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

            <main class="app-content">

                <!-- Sidebar menu-->
                <?php include "./marcarentrada.php"; ?>

                <div class="app-title">
                    <div>
                        <h1><i class="fa fa-align-left"></i> Planes</h1>
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
                                                <th class="text-center" width="5%;">#</th>
                                                <th width="18%;">Nombre</th>
                                                <th width="10%;">Precio</th>
                                                <th width="15%;">Tiempo</th>
                                                <th width="10%;">Freeze</th>
                                                <th width="25%;">Descripción</th>
                                                <th width="10%;">Estado</th>
                                                <th width="10%;">Prueba</th>
                                                <th class="text-center" width="5%;">Editar</th>
                                                <th class="text-center" width="5%;">Eliminar</th>
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

                let idPlan = "";
                let arrayDisciplinas = [];
                let listaDisciplinas = []


                $(document).ready(function() {

                    $("#basico").change(function() {
                        $("#divDisciplina").css({
                            "display": "none"
                        });
                    });

                    $("#disciplina").change(function() {
                        $("#divDisciplina").css({
                            "display": "flex"
                        });
                    });

                    $("#meses").keypress(function() {
                        var key = window.Event ? event.which : event.keyCode;
                        var c = String.fromCharCode(key);
                        if ((c < '0' || c > '9') && (c != '\b')) {
                            event.preventDefault();
                        }
                    });

                    $("#dias").keypress(function() {
                        var key = window.Event ? event.which : event.keyCode;
                        var c = String.fromCharCode(key);
                        if ((c < '0' || c > '9') && (c != '\b')) {
                            event.preventDefault();
                        }
                    });

                    $("#freeze").keypress(function() {
                        var key = window.Event ? event.which : event.keyCode;
                        var c = String.fromCharCode(key);
                        if ((c < '0' || c > '9') && (c != '\b')) {
                            event.preventDefault();
                        }
                    });

                    $("#precio").keypress(function() {
                        var key = window.Event ? event.which : event.keyCode;
                        var c = String.fromCharCode(key);
                        if ((c < '0' || c > '9') && (c != '\b') && (c != '.')) {
                            event.preventDefault();
                        }
                        if (c == '.' && $("#precio").val().includes(".")) {
                            event.preventDefault();
                        }
                    });

                    $("#cbPlanLibre").change(function(event) {
                        if (event.currentTarget.checked) {
                            $("#meses").prop("disabled", true);
                            $("#dias").prop("disabled", true);
                            $("#freeze").prop("disabled", true);
                            $("#precio").prop("disabled", true);

                            $("#meses").val("");
                            $("#dias").val("");
                            $("#freeze").val("");
                            $("#precio").val("");
                        } else {
                            $("#meses").prop("disabled", false);
                            $("#dias").prop("disabled", false);
                            $("#freeze").prop("disabled", false);
                            $("#precio").prop("disabled", false);
                        }
                    });

                    $("#btnAdd").click(function() {
                        openPlan();
                    });

                    $("#btnGuardarModal").click(function() {
                        crudPlan();
                    });

                    $("#btnCancelModal").click(function() {
                        closeClearModal()
                    });

                    $("#btnCloseModal").click(function() {
                        closeClearModal()
                    });

                    $("#btnReload").click(function() {
                        loadInitPlanes();
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
                                loadTablePlanes($("#txtSearch").val().trim());
                                opcion = 1;
                            }
                        }
                    });

                    $("#btnAgregar").click(function() {
                        for (let i = 0; i < listaDisciplinas.length; i++) {
                            if (listaDisciplinas[i].idDisciplina == $("#estado").val()) {
                                if (!validateDisciplina(listaDisciplinas[i].idDisciplina)) {
                                    arrayDisciplinas.push({
                                        "idDisciplina": listaDisciplinas[i].idDisciplina,
                                        "nombre": listaDisciplinas[i].nombre,
                                        "monto": 0
                                    });
                                }
                                break;
                            }
                        }
                        renderTableDisciplinas();
                    });

                    loadInitPlanes();

                });

                function onEventPaginacion() {
                    switch (opcion) {
                        case 0:
                            loadTablePlanes("");
                            break;
                        case 1:
                            loadTablePlanes($("#txtSearch").val().trim());
                            break;
                    }
                }


                function loadInitPlanes() {
                    if (!state) {
                        paginacion = 1;
                        loadTablePlanes("");
                        opcion = 0;
                    }
                }

                function loadTablePlanes(datos) {
                    $.ajax({
                        url: "../app/plan/PlanController.php",
                        method: "GET",
                        data: {
                            "type": "lista",
                            "page": paginacion,
                            "datos": datos
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
                                for (let plan of result.planes) {
                                    let tiempo = plan.meses == 1 ? plan.meses + " Mes y " + (plan.dias == 1 ? plan.dias + " día" : plan.dias + " dias") : plan.meses + " Meses y " + (plan.dias == 1 ? plan.dias + " día" : plan.dias + " dias");
                                    let freeze = plan.freeze == 1 ? plan.freeze + " día" : plan.freeze + " dias";
                                    let estado = plan.estado == 1 ? '<span class="badge badge-pill badge-success">Activo</span>' : '<span class="badge badge-pill badge-danger">Inactivo</span>';
                                    tbLista.append('<tr>' +
                                        '<td class="text-center">' + plan.id + '</td>' +
                                        '<td>' + plan.nombre + '</td>' +
                                        '<td>S/ ' + tools.formatMoney(plan.precio) + '</td>' +
                                        '<td>' + tiempo + '</td>' +
                                        '<td>' + freeze + '</td>' +
                                        '<td>' + plan.descripcion + '</td>' +
                                        '<td>' + estado + '</td>' +
                                        '<td>' + (plan.prueba == 1 ? "Si" : "No") + '</td>' +
                                        '<td class="text-center"><button class="btn btn-warning" onclick="updatePlan(\'' + plan.idPlan + '\')"><i class="fa fa-wrench"></i></button></td>' +
                                        '<td class="text-center"><button class="btn btn-danger" onclick="deletePlan(\'' + plan.idPlan + '\')"><i class="fa fa-trash"></i></button></td>' +
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
                                    data.mensaje + '</p></td></tr>');
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

                function openPlan() {
                    $("#modalPlan").modal("show");
                    $("#titulo-modal").append('<i class="fa fa-align-left"></i> Registrar Plan');
                    $.ajax({
                        url: "../app/plan/PlanController.php",
                        method: 'GET',
                        data: {
                            "type": "getbycrud"
                        },
                        beforeSend: function() {
                            $("#divOverlayPlanes").removeClass("d-none");
                            $("#lblTextOverlayPlanes").html("Cargando información...");
                            $("#estado").empty();
                        },
                        success: function(result) {
                            if (result.estado == 1) {
                                listaDisciplinas = result.disciplinas;
                                $("#estado").append('<option value="">- Seleccione -</option>');
                                for (let value of listaDisciplinas) {
                                    $("#estado").append('<option value="' + value.idDisciplina + '">' + value.nombre + '</option>');
                                }
                                $("#divOverlayPlanes").addClass("d-none");
                            } else {
                                $("#estado").append('<option value="">- Seleccione -</option>');
                                $("#lblTextOverlayPlanes").html(result.mensaje);
                            }
                        },
                        error: function(error) {
                            $("#estado").append('<option value="">- Seleccione -</option>');
                            $("#lblTextOverlayPlanes").html(error.responseText);
                        }
                    });
                }

                function crudPlan() {
                    if ($("#nombre").val().trim() == '') {
                        tools.AlertWarning("Planes: ", "Ingrese el nombre del plan.");
                        $("#nombre").focus();
                    } else if (!$("#cbPlanLibre").is(":checked") && !tools.isNumeric($("#meses").val())) {
                        tools.AlertWarning("Planes: ", "Ingrese el tiempo de duración en meses.");
                        $("#meses").focus();
                    } else if (!$("#cbPlanLibre").is(":checked") && !tools.isNumeric($("#precio").val().trim())) {
                        tools.AlertWarning("Planes: ", "Ingrese el precio del plan.");
                        $("#precio").focus();
                    } else if (!$("#cbPlanLibre").is(":checked") && parseFloat($("#precio").val().trim()) <= 0) {
                        tools.AlertWarning("Planes: ", "El precio del plan no puede ser menor que 0.");
                        $("#precio").focus();
                    } else {
                        $.ajax({
                            url: "../app/plan/PlanController.php",
                            method: "POST",
                            accepts: "application/json",
                            contentType: "application/json",
                            data: JSON.stringify({
                                "type": "crud",
                                "idPlan": idPlan,
                                "nombre": $("#nombre").val(),
                                "tipoDisciplina": $("#basico").is(":checked") ? 1 : 2,
                                "tipoPlan": $("#cbPlanLibre").is(":checked"),
                                "sesiones": 0,
                                "meses": $("#meses").val().trim(),
                                "dias": !tools.isNumeric($("#dias").val()) ? 0 : $("#dias").val(),
                                "freeze": !tools.isNumeric($("#freeze").val()) ? 0 : $("#freeze").val(),
                                "precio": $("#precio").val().trim(),
                                "descripcion": $("#descripcion").val(),
                                "estado": $("#activo").is(":checked"),
                                "prueba": $("#prueba").is(":checked"),
                                "arrdisciplinas": arrayDisciplinas
                            }),
                            beforeSend: function() {
                                closeClearModal();
                                tools.ModalAlertInfo('Planes', 'Procesando petición...');
                            },
                            success: function(result) {
                                if (result.estado == 1) {
                                    tools.ModalAlertSuccess('Planes', result.mensaje);
                                    loadInitPlanes();
                                } else {
                                    tools.ModalAlertWarning('Planes', result.mensaje);
                                }
                            },
                            error: function(error) {
                                tools.ModalAlertError('Planes', error.responseText);
                            }
                        });
                    }
                }

                function updatePlan(id) {
                    $("#modalPlan").modal('show');
                    $("#titulo-modal").append('<i class="fa fa-align-left"></i> Actualizar Plan')
                    $.ajax({
                        url: "../app/plan/PlanController.php",
                        method: 'GET',
                        data: {
                            "type": "getbyid",
                            "idPlan": id
                        },
                        beforeSend: function() {
                            $("#divOverlayPlanes").removeClass("d-none");
                            $("#lblTextOverlayPlanes").html("Cargando información...");
                            $("#estado").empty();
                        },
                        success: function(result) {
                            if (result.estado == 1) {
                                console.log(result.planes)
                                idPlan = id;
                                $("#nombre").val(result.planes.nombre);
                                $("#meses").val(result.planes.meses);
                                $("#dias").val(result.planes.dias);
                                $("#freeze").val(result.planes.freeze);
                                $("#precio").val(result.planes.precio);
                                $("#descripcion").val(result.planes.descripcion);
                                $("#activo").prop("checked", result.planes.estado == 1 ? true : false);
                                $("#prueba").prop("checked", result.planes.prueba == 1 ? true : false);
                                $("#basico").attr("checked", true);
                                $("#cbPlanLibre").prop("checked", result.planes.tipoPlan == 1 ? true : false);
                                if (result.planes.tipoPlan == 0) {
                                    $("#meses").prop("disabled", false);
                                    $("#dias").prop("disabled", false);
                                    $("#freeze").prop("disabled", false);
                                    $("#precio").prop("disabled", false);
                                } else {
                                    $("#meses").prop("disabled", true);
                                    $("#dias").prop("disabled", true);
                                    $("#freeze").prop("disabled", true);
                                    $("#precio").prop("disabled", true);
                                }

                                if (result.planes.tipoDisciplina == 1) {
                                    $("#basico").prop("checked", true);
                                    $("#divDisciplina").css({
                                        "display": "none"
                                    });
                                } else {
                                    $("#disciplina").prop("checked", true);
                                    $("#divDisciplina").css({
                                        "display": "flex"
                                    });
                                    for (let dis of result.planes.disciplinas) {
                                        arrayDisciplinas.push({
                                            "idDisciplina": dis.idDisciplina,
                                            "nombre": dis.nombre,
                                            "monto": dis.sesiones
                                        });
                                    }
                                    renderTableDisciplinas();
                                }

                                listaDisciplinas = result.disciplinas;
                                $("#estado").append('<option value="">- Seleccione -</option>');
                                for (let value of listaDisciplinas) {
                                    $("#estado").append('<option value="' + value.idDisciplina + '">' + value.nombre + '</option>');
                                }

                                $("#divOverlayPlanes").addClass("d-none");
                            } else {
                                $("#estado").append('<option value="">- Seleccione -</option>');
                                $("#lblTextOverlayPlanes").html(result.mensaje);
                            }
                        },
                        error: function(error) {
                            $("#estado").append('<option value="">- Seleccione -</option>');
                            $("#lblTextOverlayPlanes").html(error.responseText);
                        }
                    });
                }

                function deletePlan(id) {
                    tools.ModalDialog('Planes', '¿Desea eliminar el plan?', 'question', function(value) {
                        if (value) {
                            $.ajax({
                                url: "../app/plan/PlanController.php",
                                method: 'POST',
                                accepts: "application/json",
                                contentType: "application/json",
                                data: JSON.stringify({
                                    "type": "deleted",
                                    "idPlan": id
                                }),
                                beforeSend: function() {
                                    tools.ModalAlertInfo('Planes', 'Procesando petición...');
                                },
                                success: function(result) {
                                    if (result.estado == 1) {
                                        tools.ModalAlertSuccess('Planes', result.mensaje);
                                        loadInitPlanes();
                                    } else {
                                        tools.ModalAlertWarning('Planes', result.mensaje);
                                    }
                                },
                                error: function(error) {
                                    tools.ModalAlertError('Planes', error.responseText);
                                }
                            });
                        }
                    });
                }

                function renderTableDisciplinas() {
                    $("#tvDisciplinas").empty()
                    for (let value of arrayDisciplinas) {
                        $("#tvDisciplinas").append('<tr>' +
                            '<td> ' + value.nombre + '</td>' +
                            '<td> <input type="text" value="' + value.monto + '" onkeypress="onKeyPressTable(this)" onkeyup="onKeyUpTable(this,\'' + value.idDisciplina + '\')" class="form-control" placeholder="Ingrese el # de sesiones"> </td>' +
                            '<td> <button class="btn btn-danger btn-sm" onclick="removeDisciplina(\'' + value.idDisciplina + '\')"><i class="fa fa-times"></i></button>' +
                            '</td>' +
                            '</tr>');
                    }
                }

                function removeDisciplina(idDisciplina) {
                    for (let i = 0; i < arrayDisciplinas.length; i++) {
                        if (arrayDisciplinas[i].idDisciplina == idDisciplina) {
                            arrayDisciplinas.splice(i, 1);
                            i--;
                            break;
                        }
                    }
                    renderTableDisciplinas();
                }

                onKeyUpTable = function(value, idDisciplina) {
                    for (let i = 0; i < arrayDisciplinas.length; i++) {
                        if (arrayDisciplinas[i].idDisciplina == idDisciplina) {
                            arrayDisciplinas[i].monto = tools.isNumeric(value.value) ? value.value : 0;
                            break;
                        }
                    }
                }

                onKeyPressTable = function(value) {
                    var key = window.Event ? event.which : event.keyCode;
                    var c = String.fromCharCode(key);
                    if ((c < '0' || c > '9') && (c != '\b')) {
                        event.preventDefault();
                    }
                }

                function validateDisciplina(idDisciplina) {
                    let ret = false;
                    for (let i = 0; i < arrayDisciplinas.length; i++) {
                        if (arrayDisciplinas[i].idDisciplina == idDisciplina) {
                            ret = true;
                            break;
                        }
                    }
                    return ret;
                }

                function closeClearModal() {
                    $("#modalPlan").modal("hide");
                    $("#titulo-modal").empty();
                    $("#pills-home-tab").removeClass("active");
                    $("#pills-profile-tab").removeClass("active");
                    $("#pills-home-tab").addClass("active");

                    $("#pills-home").removeClass("active show");
                    $("#pills-profile").removeClass("active show");
                    $("#pills-home").addClass("active show");

                    $("#basico").prop("checked", true);
                    $("#divDisciplina").css({
                        "display": "none"
                    });


                    $("#nombre").val("");
                    $("#meses").val("");
                    $("#dias").val("");
                    $("#freeze").val("");
                    $("#precio").val("");
                    $("#descripcion").val("");
                    $("#activo").attr("checked", true);
                    $("#prueba").attr("checked", false);
                    $("#basico").attr("checked", true);
                    idPlan = "";
                    listaDisciplinas = [];
                    arrayDisciplinas = [];
                    $("#estado").empty();
                    $("#estado").append('<option value="">- Seleccione -</option>');
                    renderTableDisciplinas();
                }
            </script>
        </body>

        </html>

<?php
    } else {
        echo '<script>location.href = "./bienvenido.php";</script>';
    }
}
