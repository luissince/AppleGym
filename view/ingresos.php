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
                <h1><i class="fa fa-align-left"></i> Ingresos</h1>
            </div>

            <!-- modal nuevo/update Productos  -->
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
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="meses">Duración(Meses): <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                            <input id="meses" type="number" name="meses" class="form-control" placeholder="Ingrese la número de meses" required="" minlength="8">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="dias">Duración(Dias):</label>
                                                            <input id="dias" type="number" name="dias" class="form-control" placeholder="Ingrese la número de dias" required="" minlength="8">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="freeze">Freeze:</label>
                                                            <input id="freeze" type="number" name="freeze" class="form-control" placeholder="Ingrese los dias libres" required="" minlength="8">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="precio">Precio: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                            <input id="precio" type="number" name="precio" class="form-control" placeholder="Ingrese el precio" required="" minlength="8">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="descripcion">Descripción: </label>
                                                            <input id="descripcion" type="text" name="descripcion" class="form-control" placeholder="Ingrese la descripción" required="" minlength="8">
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

                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <div class="form-group">
                                                            <select id="estado" class="form-control">
                                                                <option value="">Selecciona una disciplina</option>
                                                                <option value="Maquinas">Maquinas</option>
                                                                <option value="Baile">Baile</option>
                                                                <option value="Sauna">Sauna</option>
                                                                <option value="Otro">Otro...</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-success" id="btnAgregar">Agregar</button>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">
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
                                                            <tbody id="">
                                                                <!-- tbLista -->
                                                                <tr>
                                                                    <td>maquinas</td>

                                                                    <td>
                                                                        <input type="number" class="form-control" placeholder="Ingrese el # de sesiones">
                                                                    </td>
                                                                    <td>
                                                                        <button class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
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
                                            <th class="sorting" rowspan="1" colspan="1" style="width: 20px;">#</th>
                                            <th class="sorting" rowspan="1" colspan="1" style="width: 150px;">Nombre</th>
                                            <th class="sorting" rowspan="1" colspan="1" style="width: 75px;">Precio</th>
                                            <th class="sorting" rowspan="1" colspan="1" style="width: 72px;">Tiempo</th>
                                            <th class="sorting" rowspan="1" colspan="1" style="width: 72px;">Freeze</th>
                                            <th class="sorting" rowspan="1" colspan="1" style="width: 200px;">Descripción</th>
                                            <th class="sorting" rowspan="1" colspan="1" style="width: 72px;">Estado</th>
                                            <th class="sorting" rowspan="1" colspan="1" style="width: 72px;">Prueba</th>
                                            <th class="sorting" rowspan="1" colspan="1" style="width: 59px;">Editar</th>
                                            <th class="sorting" rowspan="1" colspan="1" style="width: 59px;">Eliminar</th>
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


            $(document).ready(function() {

                $("#btnAdd").click(function() {
                    $("#modalPlan").modal("show");
                    $("#titulo-modal").append('<i class="fa fa-align-left"></i> Registrar Plane')
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

                $("#txtSearch").keypress(function() {
                    if ($("#txtSearch").val().trim() != '') {
                        if (!state) {
                            paginacion = 1;
                            loadTablePlanes($("#txtSearch").val().trim());
                            opcion = 1;
                        }
                    }
                });

                loadInitPlanes();

            });

            function onEventPaginacion() {
                switch (opcion) {
                    case 0:
                        loadInitPlanes("");
                        break;
                    case 1:
                        loadInitPlanes($("#txtSearch").val().trim());
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
                    url: "../app/plan/Obtener_Planes.php",
                    method: "",
                    data: {
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
                            for (let plan of result.planes) {
                                let tiempo = plan.meses == 1 ? plan.meses + " Mes y " + (plan.dias == 1 ? plan.dias + " día" : plan.dias + " dias") : plan.meses + " Meses y " + (plan.dias == 1 ? plan.dias + " día" : plan.dias + " dias");
                                let freeze = plan.freeze == 1 ? plan.freeze + " día" : plan.freeze + " dias";
                                let estado = plan.estado == 1 ? '<span class="badge badge-pill badge-success">Activo</span>' : '<span class="badge badge-pill badge-danger">Inactivo</span>';
                                tbLista.append('<tr>' +
                                    '<td>' + plan.id + '</td>' +
                                    '               <td>' + plan.nombre + '</td>' +
                                    '               <td>S/ ' + tools.formatMoney(plan.precio) + '</td>' +
                                    '               <td>' + tiempo + '</td>' +
                                    '               <td>' + freeze + '</td>' +
                                    '               <td>' + plan.descripcion + '</td>' +
                                    '               <td>' + estado + '</td>' +
                                    '               <td>' + (plan.prueba == 1 ? "No" : "Si") + '</td>' +
                                    '               <td>' +
                                    '                   <button class="btn btn-warning btn-sm" onclick="updateplan(\'' + plan.idPlan + '\')"><i class="fa fa-wrench"></i> Editar</button>' +
                                    '               </td>' +
                                    '               <td>' +
                                    '                   <button class="btn btn-danger btn-sm" onclick="deleteplan(\'' + plan.idPlan + '\')"><i class="fa fa-trash"></i> Eliminar</button>' +
                                    '               </td>' +
                                    '           </tr>');
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

            function crudPlan() {
                if ($("#nombre").val().trim() == '') {
                    tools.AlertWarning("Planes: ", "Ingrese el nombre del plan.");
                    $("#nombre").focus();
                } else if (!tools.isNumeric($("#meses").val())) {
                    tools.AlertWarning("Planes: ", "Ingrese el tiempo de duración en meses.");
                    $("#meses").focus();
                } else if (!tools.isNumeric($("#precio").val().trim())) {
                    tools.AlertWarning("Planes: ", "Ingrese el precio del plan.");
                    $("#precio").focus();
                } else {
                    $.ajax({
                        url: "../app/plan/Crud_Planes.php",
                        method: "POST",
                        accepts: "application/json",
                        contentType: "application/json",
                        data: JSON.stringify({
                            "idPlan": idPlan,
                            "nombre": $("#nombre").val(),
                            "tipoDisciplina": $("#basico").is(":checked"),
                            "sesiones": 0,
                            "meses": $("#meses").val().trim(),
                            "dias": !tools.isNumeric($("#dias").val()) ? 0 : $("#dias").val(),
                            "freeze": !tools.isNumeric($("#freeze").val()) ? 0 : $("#freeze").val(),
                            "precio": $("#precio").val().trim(),
                            "descripcion": $("#descripcion").val(),
                            "estado": $("#activo").is(":checked"),
                            "prueba": $("#prueba").is(":checked"),
                            "arrdisciplinas": []
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

            function closeClearModal() {
                $("#modalPlan").modal("hide");
                $("#titulo-modal").empty();

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
            }

            function updateplan(id) {
                $("#modalPlan").modal('show');
                $("#titulo-modal").append('<i class="fa fa-align-left"></i> Actualizar Plan')
                $.ajax({
                    url: "../app/plan/Obtener_Planes_By_Id.php",
                    method: 'POST',
                    accepts: "application/json",
                    contentType: "application/json",
                    data: JSON.stringify({
                        "idPlan": id
                    }),
                    beforeSend: function() {
                        tools.AlertInfo("Planes", "Cargando datos..");
                    },
                    success: function(result) {
                        if (result.estado == 1) {
                            tools.AlertSuccess("Planes", "Se cargo correctamento los datos.");
                            idPlan = id;
                            $("#nombre").val(result.planes.nombre);
                            $("#meses").val(result.planes.meses);
                            $("#dias").val(result.planes.dias);
                            $("#freeze").val(result.planes.freeze);
                            $("#precio").val(result.planes.precio);
                            $("#descripcion").val(result.planes.descripcion);
                            $("#activo").attr("checked", result.planes.estado == 1 ? true : false);
                            $("#prueba").attr("checked", result.planes.prueba == 1 ? false : true);
                            $("#basico").attr("checked", true);
                        } else {
                            tools.AlertWarning("Planes", result.mensaje);
                        }
                    },
                    error: function(error) {
                        tools.AlertError("Planes", error.responseText);
                    }
                });
            }

            function deleteplan(id) {

                tools.ModalDialog('Empresa', '¿Desea guardar los datos?', 'question', function(value) {
                    if (value) {
                        $.ajax({
                            url: "../app/plan/Eliminar_Planes.php",
                            method: 'POST',
                            accepts: "application/json",
                            contentType: "application/json",
                            data: JSON.stringify({
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
        </script>
    </body>

    </html>

<?php
}
