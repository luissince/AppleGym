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
                <div>
                    <h1><i class="fa fa-indent"></i> Disciplinas</h1>
                </div>
            </div>

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
                        <div class="tile">
                            <div class="tile-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                            <tr role="row">
                                                <th class="sorting" rowspan="1" colspan="1" style="width: 20px;">#</th>
                                                <th class="sorting" rowspan="1" colspan="1" style="width: 110px;">Nombre</th>
                                                <th class="sorting" rowspan="1" colspan="1" style="width: 75px;">Color</th>
                                                <th class="sorting" rowspan="1" colspan="1" style="width: 250px;">Descripción</th>
                                                <th class="sorting" rowspan="1" colspan="1" style="width: 100px;">Estado</th>
                                                <th class="sorting" rowspan="1" colspan="1" style="width: 59px;">Opciones</th>
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
                    url: "../app/disciplinas/Obtener_Disciplinas.php",
                    method: "GET",
                    data: {
                        page: paginacion,
                        datos: buscar
                    },
                    beforeSend: function() {
                        state = true;
                        tbLista.empty();
                        tbLista.append(
                            '<tr role="row" class="odd"><td class="sorting_1" colspan="6" style="text-align:center"><img src="./images/loading.gif" width="100"/><p>cargando información...</p></td></tr>'
                        );
                        totalPaginacion = 0;
                    },
                    success: function(result) {
                        if (result.estado == 1) {
                            tbLista.empty();
                            for (disciplina of result.disciplinas) {
                                tbLista.append('<tr>' +
                                    '                 <td>' + disciplina.id + '</td>' +
                                    '                 <td>' + disciplina.nombre + '</td>' +
                                    '                 <td>' +
                                    '             <input id="colorcito" type="color" value="#ffffff" onchange=""/>' +
                                    '         </td>' +
                                    '         <td>' + disciplina.descripcion + '</td>' +
                                    '         <td>' + (disciplina.estado == 1 ? "Habilitado" : "No Habilitado") + '</td>' +
                                    '         <td>' +
                                    '             <button class="btn btn-warning btn-sm" onclick="updateDisciplina(\'' + disciplina.idDisciplina + '\')"><i class="fa fa-wrench"></i> Editar</button>' +
                                    '         </td>' +
                                    '     </tr>');
                            }
                            totalPaginacion = parseInt(Math.ceil((parseFloat(result.total) / parseInt(
                                10))));
                            $("#lblPaginaActual").html(paginacion);
                            $("#lblPaginaSiguiente").html(totalPaginacion);
                            state = false;
                        } else {
                            tbLista.empty();
                            tbLista.append(
                                '<tr role="row" class="odd"><td class="sorting_1" colspan="6" style="text-align:center"><p>' +
                                data.mensaje + '</p></td></tr>');
                            $("#lblPaginaActual").html(0);
                            $("#lblPaginaSiguiente").html(0);
                            state = false;
                        }
                    },
                    error: function(error) {
                        tbLista.empty();
                        tbLista.append(
                            '<tr role="row" class="odd"><td class="sorting_1" colspan="6" style="text-align:center"><p>' +
                            error.responseText + '</p></td></tr>');
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
                        url: "../app/disciplinas/Crud_Disciplinas.php",
                        method: "POST",
                        accepts: "application/json",
                        contentType: "application/json",
                        data: JSON.stringify({
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

            function closeClearModal() {
                $("#modalDisciplina").modal('hide');
                $("#titulo-modal").empty();
                $("#nombre").val("");
                $("#descripcion").val("");
                $("#estado").attr("checked", false);
                idDisciplina = "";
            }

            function updateDisciplina(id) {
                $("#modalDisciplina").modal('show');               
                $("#titulo-modal").append('<i class="fa fa-list"></i> Actualizar Disciplinas');
                $.ajax({
                    url: "../app/disciplinas/Obtener_Disciplinas_By_Id.php",
                    method: 'POST',
                    accepts: "application/json",
                    contentType: "application/json",
                    data: JSON.stringify({
                        "idDisciplina": id
                    }),
                    beforeSend: function() {
                        tools.AlertInfo("Disciplina", "Cargando datos..");
                    },
                    success: function(result) {
                        if (result.estado == 1) {
                            tools.AlertSuccess("Disciplina", "Se cargo correctamento los datos.");
                            idDisciplina = id;
                            $("#nombre").val(result.disciplina.nombre);
                            $("#descripcion").val(result.disciplina.descripcion);
                            $("#estado").attr("checked", result.disciplina.estado == 1 ? true : false);
                        } else {
                            tools.AlertWarning("Disciplina", result.mensaje);
                        }
                    },
                    error: function(error) {
                        tools.AlertError("Disciplina", error.responseText);
                    }
                });
            }
        </script>
    </body>

    </html>

<?php
}
