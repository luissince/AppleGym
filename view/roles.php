<?php
session_start();
if (!isset($_SESSION["IdEmpleado"])) {
    echo '<script>location.href = "./login.php";</script>';
} else {
    if ($_SESSION["Roles"][9]["ver"] == 1) {
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

                <!-- modal Rol -->
                <div class="row">
                    <div class="modal fade" id="modalRol" data-backdrop="static">
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

                                        <div class="overlay d-none" id="divOverlayRol">
                                            <div class="m-loader mr-4">
                                                <svg class="m-circular" viewBox="25 25 50 50">
                                                    <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle>
                                                </svg>
                                            </div>
                                            <h4 class="l-text" id="lblTextOverlayRol">Cargando información...</h4>
                                        </div>

                                        <div class="tile-body">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="txtNombre">Nombre: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                        <input id="txtNombre" type="text" class="form-control" placeholder="Ingrese el nombre del producto">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="txtDescripcion">Descripción:</label>
                                                        <input id="txtDescripcion" type="text" class="form-control" placeholder="Ingrese el nombre del producto">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="cbEstado">Categoria: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                        <select id="cbEstado" class="form-control">
                                                            <option value="1">Activo</option>
                                                            <option value="0">Inactivo</option>
                                                        </select>
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
                <!-- end modal Rol-->

                <!-- modal Modulo -->
                <div class="modal fade" id="modalModulos" data-backdrop="static">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h4 class="modal-title">
                                    <i class="fa fa-clone">
                                    </i> Lista de Modulos
                                </h4>
                                <button type="button" class="close" data-dismiss="modal">
                                    <i class="fa fa-close"></i>
                                </button>
                            </div>

                            <div class="modal-body">
                                <div class="tile p-0">

                                    <div class="overlay d-none" id="divOverlayModulo">
                                        <div class="m-loader mr-4">
                                            <svg class="m-circular" viewBox="25 25 50 50">
                                                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle>
                                            </svg>
                                        </div>
                                        <h4 class="l-text" id="lblTextOverlayModulo">Cargando información...</h4>
                                    </div>

                                    <div class="tile-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table class="table table-hover table-bordered">
                                                        <thead>
                                                            <tr role="row">
                                                                <th width="5%">#</th>
                                                                <th width="30%">Nombre</th>
                                                                <th width="15%">Ver/Visualizar</th>
                                                                <th width="15%">Crear/Ingresar/Generar</th>
                                                                <th width="15%">Editar/Cobrar/Pagar</th>
                                                                <th width="15%">Eliminar/Anular/Quitar</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tbModulos">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning" id="btnAceptarModulos">
                                    <i class="fa fa-check"></i> Aceptar</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal">
                                    <i class="fa fa-remove"></i> Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                <!--end modal Modulo  -->

                <div class="app-title">
                    <h1><i class="fa fa-check-square "></i> Roles</h1>
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
                                                <th class="sorting" width="5%;">#</th>
                                                <th class="sorting" width="15%;">Nombre</th>
                                                <th class="sorting" width="30%;">Descripción</th>
                                                <th class="sorting" width="10%;">Estado</th>
                                                <th class="sorting" width="10%;">Modulos</th>
                                                <th class="sorting" width="10%;">Editar</th>
                                                <th class="sorting" width="10%;">Eliminar</th>
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
                let paginacion = 0;
                let totalPaginacion = 0;
                let opcion = 0;
                let state = false;

                let idRol = 0;

                $(document).ready(function() {

                    $("#btnAdd").click(function() {
                        $("#titulo-modal").append("Registrar Rol");
                        $("#modalRol").modal("show");
                    });

                    $("#btnAdd").keypress(function(event) {
                        if (event.keyCode == 13) {
                            $("#titulo-modal").append("Registrar Rol");
                            $("#modalRol").modal("show");
                        }
                        event.preventDefault();
                    });

                    $("#btnReload").click(function() {
                        loadInitRoles();
                    });

                    $("#btnReload").keypress(function(event) {
                        if (event.keyCode == 13) {
                            loadInitRoles();
                        }
                        event.preventDefault();
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
                                loadTableRoles($("#txtSearch").val().trim());
                                opcion = 1;
                            }
                        }
                    });

                    //--------------------------------------------------------------------------------- 
                    $("#btnGuardarModal").click(function() {
                        crudRol();
                    });

                    $("#btnGuardarModal").keypress(function(event) {
                        if (event.keyCode === 13) {
                            crudRol();
                        }
                        event.preventDefault();
                    });

                    $("#btnCancelModal").click(function() {
                        clearComponents();
                    });

                    $("#btnCancelModal").keypress(function(event) {
                        if (event.keyCode === 13) {
                            clearComponents();
                        }
                        event.preventDefault();
                    });

                    $("#btnCloseModal").click(function() {
                        clearComponents();
                    });

                    $("#btnCloseModal").keypress(function() {
                        if (event.keyCode === 13) {
                            clearComponents();
                        }
                        event.preventDefault();
                    });
                    //--------------------------------------------------------------------------------- 

                    $("#btnAceptarModulos").click(function() {
                        updateModules();
                    });

                    $("#btnAceptarModulos").keypress(function(event) {
                        if (event.keyCode === 13) {
                            updateModules();
                        }
                        event.preventDefault();
                    });
                    //--------------------------------------------------------------------------------- 

                    loadInitRoles();
                });

                function onEventPaginacion() {
                    switch (opcion) {
                        case 0:
                            loadTableRoles('');
                            break;
                        case 1:
                            loadTableRoles($("#txtSearch").val().trim());
                            break;
                    }
                }

                function loadInitRoles() {
                    if (!state) {
                        paginacion = 1;
                        loadTableRoles('');
                        opcion = 0;
                    }
                }

                function loadTableRoles(text) {
                    $.ajax({
                        url: "../app/roles/RolController.php",
                        method: "GET",
                        data: {
                            "type": "allData",
                            "page": paginacion,
                            "datos": text
                        },
                        beforeSend: function() {
                            state = false;
                            tbLista.empty();
                            tbLista.append(
                                '<tr role="row" class="odd"><td class="sorting_1" colspan="7" style="text-align:center"><img src="./images/loading.gif" width="100"/><p>cargando información...</p></td></tr>'
                            );
                            totalPaginacion = 0;
                        },
                        success: function(result) {
                            let data = result;
                            if (data.estado == 1) {
                                tbLista.empty();
                                if (data.roles.length == 0) {
                                    tbLista.append(
                                        '<tr role="row" class="odd"><td class="sorting_1" colspan="7" style="text-align:center"><p>No hay datos para mostrar.</p></td></tr>');
                                    $("#lblPaginaActual").html(0);
                                    $("#lblPaginaSiguiente").html(0);
                                    state = false;
                                } else {
                                    for (let rol of data.roles) {
                                        let estado = rol.estado == 1 ? '<span class="badge badge-pill badge-success"> Activo </span>' : '<span class="badge badge-pill badge-danger"> Inactivo </span>';
                                        tbLista.append('<tr role="row" class="odd">' +
                                            '<td class="text-center">' + rol.id + '</td>' +
                                            '<td>' + rol.nombre + '</td>' +
                                            '<td>' + rol.descripcion + '</td>' +
                                            '<td class="text-center">' + estado + '</td>' +
                                            '<td class="text-center"><button class="btn btn-info btn-sm" onclick="updatePermisos(\'' + rol.idRol + '\')"><i class="fa fa-eye"></i> Permisos</button></td>' +
                                            '<td class="text-center"><button class="btn btn-warning btn-sm" onclick="updateRol(\'' + rol.idRol + '\')"><i class="fa fa-edit"></i> Editar</button></td>' +
                                            '<td class="text-center"><button class="btn btn-danger btn-sm" onclick="deleteRol(\'' + rol.idRol + '\')"><i class="fa fa-trash"></i> Eliminar</button></td>' +
                                            '</tr>');
                                    }
                                    totalPaginacion = parseInt(Math.ceil((parseFloat(data.total) / parseInt(
                                        10))));
                                    $("#lblPaginaActual").html(paginacion);
                                    $("#lblPaginaSiguiente").html(totalPaginacion);
                                    state = false;
                                }
                            } else {
                                tbLista.empty();
                                tbLista.append(
                                    '<tr role="row" class="odd"><td class="sorting_1" colspan="7" style="text-align:center"><p>' +
                                    data.mensaje + '</p></td></tr>');
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

                function crudRol() {
                    if ($("#txtNombre").val() == '') {
                        tools.AlertWarning("Rol: ", "Ingrese el nombre del rol.");
                        $("#txtNombre").focus();
                    } else if ($("#cbEstado").val() == '') {
                        tools.AlertWarning("Rol: ", "Selecciona el estado.");
                        $("#cbEstado").focus();
                    } else {
                        tools.ModalDialog('Producto', '¿Está seguro de continuar?', 'question', function(result) {
                            if (result) {
                                $.ajax({
                                    url: "../app/roles/RolController.php",
                                    method: "POST",
                                    accepts: "application/json",
                                    contentType: "application/json",
                                    data: JSON.stringify({
                                        "type": "crud",
                                        "idRol": idRol,
                                        "nombre": $("#txtNombre").val().trim(),
                                        "descripcion": $("#txtDescripcion").val().trim(),
                                        "estado": $("#cbEstado").val()
                                    }),
                                    beforeSend: function() {
                                        clearComponents()
                                        tools.ModalAlertInfo('Rol', 'Procesando petición...');
                                    },
                                    success: function(result) {
                                        if (result.estado == 1) {
                                            tools.ModalAlertSuccess('Rol', result.mensaje);
                                            loadInitRoles();
                                        } else if (result.estado == 2) {
                                            tools.ModalAlertWarning('Rol', result.mensaje);
                                        } else if (result.estado == 3) {
                                            tools.ModalAlertWarning('Rol', result.mensaje);
                                        } else {
                                            tools.ModalAlertWarning('Rol', result.mensaje);
                                        }
                                    },
                                    error: function(error) {
                                        tools.ModalAlertError("Rol", error.responseText);
                                    }
                                });
                            }
                        });
                    }
                }

                function updateRol(id) {
                    $("#titulo-modal").append("Actualizar Rol");
                    $("#modalRol").modal("show");
                    $.ajax({
                        url: "../app/roles/RolController.php",
                        method: "GET",
                        data: {
                            "type": "data",
                            "idRol": id,
                        },
                        beforeSend: function() {
                            $("#lblTextOverlayProducto").html("Cargando información...");
                            $("#divOverlayProducto").removeClass("d-none");
                        },
                        success: function(result) {
                            if (result.estado == 1) {
                                idRol = id;
                                $("#txtNombre").val(result.rol.nombre);
                                $("#txtDescripcion").val(result.rol.descripcion);
                                $("#cbEstado").val(result.rol.estado);
                                $("#divOverlayProducto").addClass("d-none");
                            } else {
                                $("#lblTextOverlayProducto").html(result.mensaje);
                            }
                        },
                        error: function(error) {
                            $("#lblTextOverlayProducto").html(error.responseText);
                        }
                    });
                }

                function deleteRol(idRol) {
                    tools.ModalDialog('Eliminar', '¿Está seguro de continuar?', 'question', function(value) {
                        if (value) {
                            $.ajax({
                                url: "../app/roles/RolController.php",
                                method: 'POST',
                                accepts: "application/json",
                                contentType: "application/json",
                                data: JSON.stringify({
                                    "type": "deleterol",
                                    "idRol": idRol
                                }),
                                beforeSend: function() {
                                    tools.ModalAlertInfo("Rol", "Procesando petición..");
                                },
                                success: function(result) {
                                    if (result.estado == 1) {
                                        tools.ModalAlertSuccess("Rol", result.mensaje);
                                        loadInitRoles();
                                    } else {
                                        tools.ModalAlertWarning("Rol", result.mensaje);
                                    }
                                },
                                error: function(error) {
                                    tools.ModalAlertError("Rol", error.responseText);
                                }
                            });
                        }
                    });
                }

                function updatePermisos(id) {
                    $("#modalModulos").modal("show");
                    $.ajax({
                        url: "../app/roles/RolController.php",
                        method: "GET",
                        data: {
                            "type": "permisobyidrol",
                            "idRol": id,
                        },
                        beforeSend: function() {
                            $("#lblTextOverlayModulo").html("Cargando información...");
                            $("#divOverlayModulo").removeClass("d-none");
                            $("#tbModulos").empty();
                            $("#tbModulos").append('<tr role="row" class="odd"><td colspan="6" style="text-align:center"><p>Cargando información...</p></td></tr>');
                        },
                        success: function(result) {
                            $("#tbModulos").empty();
                            if (result.estado == 1) {
                                for (let value of result.permisos) {
                                    $("#tbModulos").append('<tr id="' + value.idPermiso + '">' +
                                        '<td>' + value.id + '</td>' +
                                        '<td>' + value.nombre + '</td>' +
                                        '<td>' + (value.ver == 1 ? '<input class="form-group checkbox" type="checkbox" checked>' : '<input class="form-group checkbox" type="checkbox" >') + '</td>' +
                                        '<td>' + (value.crear == 1 ? '<input class="form-group checkbox" type="checkbox" checked>' : '<input class="form-group checkbox" type="checkbox" >') + '</td>' +
                                        '<td>' + (value.actualizar == 1 ? '<input class="form-group checkbox" type="checkbox" checked>' : '<input class="form-group checkbox" type="checkbox" >') + '</td>' +
                                        '<td>' + (value.eliminar == 1 ? '<input class="form-group checkbox" type="checkbox" checked>' : '<input class="form-group checkbox" type="checkbox" >') + '</td>' +
                                        '</tr>');
                                }
                                $("#divOverlayModulo").addClass("d-none");
                            } else {
                                $("#lblTextOverlayModulo").html(result.mensaje);
                            }
                        },
                        error: function(error) {
                            $("#tbModulos").empty();
                            $("#lblTextOverlayModulo").html(error.responseText);
                        }
                    });
                }

                function updateModules() {
                    let modulos = [];
                    $("#tbModulos tr").each(function(row, tr) {
                        modulos.push({
                            "idPermiso": $(this).attr('id'),
                            "ver": $(tr).find("td:eq(2)").find('input[type="checkbox"]').is(':checked'),
                            "crear": $(tr).find("td:eq(3)").find('input[type="checkbox"]').is(':checked'),
                            "actualizar": $(tr).find("td:eq(4)").find('input[type="checkbox"]').is(':checked'),
                            "eliminar": $(tr).find("td:eq(5)").find('input[type="checkbox"]').is(':checked'),
                        });
                    });
                    tools.ModalDialog('Modulos', '¿Está seguro de continuar?', 'question', function(value) {
                        if (value) {
                            $.ajax({
                                url: "../app/roles/RolController.php",
                                method: 'POST',
                                accepts: "application/json",
                                contentType: "application/json",
                                data: JSON.stringify({
                                    "type": "updateModulo",
                                    "modulos": modulos
                                }),
                                beforeSend: function() {
                                    $("#modalModulos").modal("hide");
                                    tools.ModalAlertInfo("Modulos", "Procesando petición..");
                                },
                                success: function(result) {
                                    if (result.estado == 1) {
                                        tools.ModalAlertSuccess("Modulos", result.mensaje);
                                    } else {
                                        tools.ModalAlertWarning("Modulos", result.mensaje);
                                    }
                                },
                                error: function(error) {
                                    tools.ModalAlertError("Modulos", error.responseText);
                                }
                            });
                        }
                    });

                }

                function clearComponents() {
                    $("#titulo-modal").empty();
                    $("#modalRol").modal("hide");
                    $("#txtNombre").val("");
                    $("#txtDescripcion").val("");
                    $("#cbEstado").val("1");
                    $("#lblTextOverlayProducto").html("");
                    idRol = 0;
                }
            </script>
        </body>

        </html>

<?php
    } else {
        echo '<script>location.href = "./bienvenido.php";</script>';
    }
}
