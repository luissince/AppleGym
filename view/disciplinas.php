<?php
session_start();
if (!isset($_SESSION["IdEmpleado"])) {
    echo '<script>location.href = "./login.php";</script>';
} else {
    if ($_SESSION["Roles"][16]["ver"] == 1) {
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
            <!-- modal nuevo/update Empleado  -->
            <div class="row">
                <div class="modal fade" id="modalDisciplina" data-backdrop="static">
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

                                    <div class="overlay d-none" id="divOverlayDisciplina">
                                        <div class="m-loader mr-4">
                                            <svg class="m-circular" viewBox="25 25 50 50">
                                                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle>
                                            </svg>
                                        </div>
                                        <h4 class="l-text" id="lblTextOverlayDisciplina">Cargando información...</h4>
                                    </div>

                                    <div class="tile-body">
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
                                                    <label for="color">Color: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                    <input id="color" type="color" name="color" class="form-control">
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
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="descripcion">Estado: </label>
                                                    <div class="toggle-flip">
                                                        <label>
                                                            <input type="checkbox" id="estado"><span class="flip-indecator" data-toggle-on="ACTIVO" data-toggle-off="INACTIVO"></span>
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
            <main class="app-content">
                <!-- Sidebar menu-->
                <?php include "./marcarentrada.php"; ?>
                <div class="app-title">
                    <div>
                        <h1><i class="fa fa-indent"></i> Disciplinas</h1>
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
                        <div class="col-md-8 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <input type="search" class="form-control" placeholder="Buscar por nombre" id="txtSearch">
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
                                            <tr role="row">
                                                <th class="sorting text-center" style="width: 5%;">#</th>
                                                <th class="sorting" style="width: 20%;">Nombre</th>
                                                <th class="sorting" style="width: 15%;">Color</th>
                                                <th class="sorting" style="width: 30%;">Descripción</th>
                                                <th class="sorting" style="width: 10%;">Estado</th>
                                                <th class="sorting text-center" style="width: 5%;">Editar</th>
                                                <th class="sorting text-center" style="width: 5%;">Eliminar</th>
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

                let idDisciplina = "";

                $(document).ready(function() {

                    $("#btnAdd").click(function() {
                        $("#modalDisciplina").modal("show");
                        $("#titulo-modal").append('<i class="fa fa-list"></i> Registrar Disciplinas');
                    })

                    $("#btnGuardarModal").click(function() {
                        crudDisciplina();
                    });

                    $("#btnCancelModal").click(function() {
                        closeClearModal()
                    })

                    $("#btnCloseModal").click(function() {
                        closeClearModal()
                    })

                    $("#btnReload").click(function() {
                        loadInitDisciplinas();
                    })

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
                                loadTableDisciplinas($("#txtSearch").val().trim());
                                opcion = 1;
                            }
                        }
                    });

                    loadInitDisciplinas();
                });

                function onEventPaginacion() {
                    switch (opcion) {
                        case 0:
                            loadTableDisciplinas("");
                            break;
                        case 1:
                            loadTableDisciplinas($("#txtSearch").val().trim());
                            break;
                    }
                }


                function loadInitDisciplinas() {
                    if (!state) {
                        paginacion = 1;
                        loadTableDisciplinas("");
                        opcion = 0;
                    }
                }


                function loadTableDisciplinas(buscar) {
                    $.ajax({
                        url: "../app/disciplinas/DisciplinaController.php",
                        method: "GET",
                        data: {
                            "type": "lista",
                            "page": paginacion,
                            "datos": buscar
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
                                if (result.disciplinas.length == 0) {
                                    tbLista.append(
                                        '<tr role="row" class="odd"><td class="sorting_1" colspan="7" style="text-align:center"><p>No hay datos para mostrar.</p></td></tr>'
                                    );
                                    $("#lblPaginaActual").html(0);
                                    $("#lblPaginaSiguiente").html(0);
                                    state = false;
                                } else {
                                    for (disciplina of result.disciplinas) {
                                        let estado = disciplina.estado == 1 ? '<span class="badge badge-pill badge-success">Activo</span>' : '<span class="badge badge-pill badge-danger">Inactivo</span>';
                                        tbLista.append('<tr>' +
                                            '<td class="text-center">' + disciplina.id + '</td>' +
                                            '<td>' + disciplina.nombre + '</td>' +
                                            '<td> <input id="colorcito" type="color" value="#ffffff" onchange=""/> </td>' +
                                            '<td>' + disciplina.descripcion + '</td>' +
                                            '<td>' + estado + '</td>' +
                                            '<td class="text-center"> <button class="btn btn-warning" onclick="updateDisciplina(\'' + disciplina.idDisciplina + '\')"><i class="fa fa-wrench"></i></button>' +
                                            '<td class="text-center"> <button class="btn btn-danger" onclick="deleteDisciplina(\'' + disciplina.idDisciplina + '\')"><i class="fa fa-trash"></i></button>' +
                                            '</td>' +
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

                function crudDisciplina() {
                    if ($("#nombre").val().trim() == '') {
                        tools.AlertWarning("Mensaje", "Ingrese el nombre de la disciplina.");
                        $("#nombre").focus();
                    } else {
                        $.ajax({
                            url: "../app/disciplinas/DisciplinaController.php",
                            method: "POST",
                            accepts: "application/json",
                            contentType: "application/json",
                            data: JSON.stringify({
                                "type": "crud",
                                "idDisciplina": idDisciplina,
                                "nombre": $("#nombre").val().trim(),
                                "color": $("#color").val(),
                                "descripcion": $("#descripcion").val().trim(),
                                "estado": $("#estado").is(":checked")
                            }),
                            beforeSend: function() {
                                closeClearModal();
                                tools.ModalAlertInfo('Disciplinas', 'Procesando petición...');
                            },
                            success: function(result) {
                                if (result.estado == 1) {
                                    tools.ModalAlertSuccess('Disciplinas', result.mensaje);
                                    loadInitDisciplinas();
                                } else {
                                    tools.ModalAlertWarning('Disciplinas', result.mensaje);
                                }
                            },
                            error: function(error) {
                                tools.ModalAlertError('Disciplinas', error.responseText);
                            }
                        });
                    }
                }

                function updateDisciplina(id) {
                    $("#modalDisciplina").modal('show');
                    $("#titulo-modal").append('<i class="fa fa-list"></i> Actualizar Disciplinas');
                    $.ajax({
                        url: "../app/disciplinas/DisciplinaController.php",
                        method: 'GET',
                        data: {
                            "type": "getbyid",
                            "idDisciplina": id
                        },
                        beforeSend: function() {
                            $("#divOverlayDisciplina").removeClass("d-none");
                            $("#lblTextOverlayDisciplina").html("Cargando información...");
                        },
                        success: function(result) {
                            if (result.estado == 1) {
                                idDisciplina = id;
                                $("#nombre").val(result.disciplina.nombre);
                                $("#descripcion").val(result.disciplina.descripcion);
                                $("#estado").attr("checked", result.disciplina.estado == 1 ? true : false);
                                $("#divOverlayDisciplina").addClass("d-none");
                            } else {
                                $("#lblTextOverlayDisciplina").html(result.mensaje);
                            }
                        },
                        error: function(error) {
                            $("#lblTextOverlayDisciplina").html(error.responseText);
                        }
                    });
                }

                function deleteDisciplina(id) {
                    tools.ModalDialog('Disciplina', '¿Desea eliminar la disciplina?', 'question', function(value) {
                        if (value) {
                            $.ajax({
                                url: "../app/disciplinas/DisciplinaController.php",
                                method: 'POST',
                                accepts: "application/json",
                                contentType: "application/json",
                                data: JSON.stringify({
                                    "type": "delete",
                                    "idDisciplina": id
                                }),
                                beforeSend: function() {
                                    tools.ModalAlertInfo('Disciplina', 'Procesando petición...');
                                },
                                success: function(result) {
                                    if (result.estado == 1) {
                                        tools.ModalAlertSuccess('Disciplina', result.mensaje);
                                        loadInitDisciplinas();
                                    } else {
                                        tools.ModalAlertWarning('Disciplina', result.mensaje);
                                    }
                                },
                                error: function(error) {
                                    tools.ModalAlertError('Disciplina', error.responseText);
                                }
                            });
                        }
                    });
                }

                function closeClearModal() {
                    $("#modalDisciplina").modal('hide');
                    $("#titulo-modal").empty();
                    $("#nombre").val("");
                    $("#descripcion").val("");
                    $("#estado").attr("checked", false);
                    idDisciplina = "";
                }
            </script>
        </body>

        </html>

<?php
    } else {
        echo '<script>location.href = "./bienvenido.php";</script>';
    }
}
