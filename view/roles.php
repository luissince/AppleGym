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
                <h1><i class="fa fa-id-badge"></i> Roles</h1>
            </div>
        </div>

        <!-- modal nuevo/update Rol  -->
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
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nombre">Nombre: <i
                                                class="fa fa-fw fa-asterisk text-danger"></i></label>
                                        <input id="nombre" type="text" name="nombre" class="form-control"
                                            placeholder="Ingrese el nombre" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="descripcion">Descripción: </label>
                                        <input id="descripcion" type="text" name="descripcion" class="form-control"
                                            placeholder="Ingrese la descripción" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="claveAlterna">Clave Alterna: </label>
                                        <input id="claveAlterna" type="text" name="claveAlterna" class="form-control"
                                            placeholder="Ingrese la clave alterna" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="estado">Estado: </label>
                                        <select id="estado" class="form-control">
                                            <option value="1">Activo</option>
                                            <option value="0">Inactivo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <p class="text-left text-danger">Todos los campos marcados con <i
                                    class="fa fa-fw fa-asterisk text-danger"></i> son obligatorios</p>
                            <button type="button" class="btn btn-success" id="btnGuardarModal">
                                <i class="fa fa-save"></i> Guardar</button>
                            <button type="button" class="btn btn-danger" id="btnCancelModal">
                                <i class="fa fa-remove"></i> Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal acceso -->
        <div class="row">
            <div class="modal fade" id="modalPrivilegio" data-backdrop="static">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">
                                <i class="fa fa-universal-access"></i> Modulos de acceso
                            </h4>
                            <button type="button" class="close" onclick="destroyModal(event)">
                                <i class="fa fa-close"></i>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1"
                                                style="width: 30px;">#</th>
                                            <th class="sorting_asc" aria-controls="sampleTable" rowspan="1" colspan="1"
                                                style="width: 180px;">Modulo</th>
                                            <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1"
                                                style="width: 30px;">Mostrar</th>
                                            <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1"
                                                style="width: 30px;">Insertar</th>
                                            <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1"
                                                style="width: 30px;">Actualizar</th>
                                            <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1"
                                                style="width: 30px;">Eliminar</th>
                                            <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1"
                                                style="width: 30px;">Reporte</th>

                                            <!-- <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1"
                                                style="width: 59px;">Lectura</th>
                                            <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1"
                                                style="width: 59px;">Escritura</th> -->

                                        </tr>
                                    </thead>

                                    <tbody id="tbPrivilegio">

                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="modal-footer">

                            <button type="button" class="btn btn-success btn-group-sm" id="btnSavePrivilegio">
                                <i class="fa fa-save"></i> Guardar</button>
                            <button type="button" class="btn btn-danger btn-group-sm" onclick="destroyModal(event)">
                                <i class="fa fa-remove"></i> Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tile mb-4">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
                        <input type="search" class="form-control" placeholder="Buscar por nombre"
                            aria-controls="sampleTable" id="txtSearch">
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
                                        <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1"
                                            style="width: 59px;">#</th>
                                        <th class="sorting_asc" aria-controls="sampleTable" rowspan="1" colspan="1"
                                            style="width: 107px;">Nombre</th>
                                        <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1"
                                            style="width: 250px;">Descripcion</th>
                                        <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1"
                                            style="width: 72px;">Clave alterna</th>
                                        <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1"
                                            style="width: 72px;">Estado</th>
                                        <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1"
                                            style="width: 69px;">Sistema</th>
                                        <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1"
                                            style="width: 59px;">Acceso</th>
                                        <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1"
                                            style="width: 59px;">Actualizar</th>
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

    let idRolCurrent = "";
    let sistema = '';

    let tbPrivilegio = $("#tbPrivilegio")

    $(document).ready(function() {

        loadInit();

        $('#modalRol').on('shown.bs.modal', function() {
            // $('#dni').trigger('focus')
        })

        $("#btnAdd").click(function() {
            $("#modalRol").modal("show");
            $("#titulo-modal").append('<i class="fa fa-list-alt"></i> Registrar Rol')

        })

        $("#btnCancelModal").click(function() {
            closeClearModal()
        })

        $("#btnCloseModal").click(function() {
            closeClearModal()
        })

        $("#btnReload").click(function() {
            loadInit()
        })

        $("#btnGuardarModal").click(function() {
            if ($("#nombre").val() == '' || $("#nombre").val().length < 3) {
                tools.AlertWarning("Advertencia", "Ingrese un nombre valido")
            } else {
                tools.ModalDialog('Roles', '¿Desea guardar los datos?', 'question', function(result) {
                    if (result) {
                        registrarRol($("#nombre").val(), $("#descripcion").val(), $(
                            "#claveAlterna").val(), $("#estado").val());
                    }
                });
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

        $("#txtSearch").keypress(function() {
            if ($("#txtSearch").val().trim() != '') {
                if (!state) {
                    paginacion = 1;
                    loadTable($("#txtSearch").val().trim());
                    opcion = 1;
                }
            }
        });

    });

    function loadInit() {
        if (!state) {
            paginacion = 1;
            loadTable("");
            opcion = 0;
        }
    }

    function onEventPaginacion() {
        switch (opcion) {
            case 0:
                loadTable("");
                break;
            case 1:
                loadTable($("#txtSearch").val().trim());
                break;
        }
    }

    function loadTable(buscar) {
        $.ajax({
            url: "../app/roles/Obtener_Roles.php",
            method: "",
            data: {
                opcion: 2,
                page: paginacion,
                datos: buscar
            },
            beforeSend: function() {
                state = true;
                tbLista.empty();
                tbLista.append(
                    '<tr role="row" class="odd"><td class="sorting_1" colspan="7" style="text-align:center"><img src="./images/loading.gif" width="100"/><p>cargando información...</p></td></tr>'
                );
                totalPaginacion = 0;
            },
            success: function(result) {
                // console.log(result)
                let data = result

                if (data.estado == 1) {
                    tbLista.empty();

                    for (let rol of data.roles) {

                        let btnUpdate =
                            '<button class="btn btn-warning btn-sm" onclick="loadUpdateRol(\'' +
                            rol.id + '\')">' +
                            '<i class="fa fa-wrench"></i> Editar' +
                            '</button>';
                        let btnModulo =
                            '<button class="btn btn-info btn-sm" onclick="loadDataModulos(\'' +
                            rol.id + '\')">' +
                            '<i class="fa fa-user-circle"></i> Ver' +
                            '</button>';

                        let estado = rol.estado == 1 ?
                            '<span class="badge badge-pill badge-success">Activo</span>' :
                            '<span class="badge badge-pill badge-danger">Inactivo</span>';
                        let predeterminado = rol.predeterminado == 1 ?
                            '<span class="badge badge-pill badge-success">Si</span>' :
                            '<span class="badge badge-pill badge-danger">No</span>';

                        tbLista.append('<tr role="row" class="odd">' +
                            '<td class="sorting_1">' + rol.count + '</td>' +
                            '<td>' + rol.nombre + '</td>' +
                            '<td>' + rol.descripcion + '</td>' +
                            '<td>' + rol.claveAlterna + '</td>' +
                            '<td>' + estado + '</td>' +
                            '<td>' + predeterminado + '</td>' +
                            '<td>' + btnModulo + '</td>' +
                            '<td>' + btnUpdate + '</td>' +
                            '</tr>');
                    }

                    totalPaginacion = parseInt(Math.ceil((parseFloat(data.total) / parseInt(
                        10))));
                    $("#lblPaginaActual").html(paginacion);
                    $("#lblPaginaSiguiente").html(totalPaginacion);
                    state = false;
                } else {
                    tbLista.empty();
                    tbLista.append(
                        '<tr role="row" class="odd"><td class="sorting_1" colspan="8" style="text-align:center"><p>' +
                        data.mensaje + '</p></td></tr>');
                    $("#lblPaginaActual").html(0);
                    $("#lblPaginaSiguiente").html(0);
                    state = false;
                }
            },
            error: function(error) {
                tbLista.empty();
                tbLista.append(
                    '<tr role="row" class="odd"><td class="sorting_1" colspan="8" style="text-align:center"><p>' +
                    error.responseText + '</p></td></tr>');
                $("#lblPaginaActual").html(0);
                $("#lblPaginaSiguiente").html(0);
                state = false;
            }
        });
    }

    function registrarRol(nombre, descripcion, claveAlterna, estado) {
        $.ajax({
            url: "../app/roles/Crud_Roles.php",
            method: "POST",
            accepts: "application/json",
            contentType: "application/json",
            data: JSON.stringify({
                "id": idRolCurrent,
                "nombre": (nombre.toUpperCase()).trim(),
                "descripcion": (descripcion.toUpperCase()).trim() == '' ? 'NINGUNA' : (descripcion
                    .toUpperCase()).trim(),
                "claveAlterna": (claveAlterna.toUpperCase()).trim(),
                "estado": estado,
                "predeterminado": sistema
            }),
            beforeSend: function() {
                closeClearModal();
                tools.ModalAlertInfo('Roles', 'Procesando petición...');
            },
            success: function(result) {
                if (result.estado == 1) {
                    tools.ModalAlertSuccess('Roles', result.mensaje);
                    loadInit();
                } else {
                    tools.ModalAlertWarning('Roles', result.mensaje);
                }
            },
            error: function(error) {
                tools.ModalAlertError("Roles", error.responseText);
            }
        });
    }

    function closeClearModal() {
        $("#modalRol").modal("hide")
        $("#titulo-modal").empty()

        $("#nombre").val('')
        $("#descripcion").val('')
        $("#claveAlterna").val('')
        document.getElementById("estado").selectedIndex = "0"

        idRolCurrent = ""
        sistema = ''
    }

    function loadUpdateRol(idRol) {
        $("#modalRol").modal("show");
        $("#titulo-modal").append('<i class="fa fa-list-alt"></i> Editar Rol')
        idRolCurrent = idRol;
        $.ajax({
            url: "../app/roles/Obtener_Roles_By_Id.php",
            method: "POST",
            accepts: "application/json",
            contentType: "application/json",
            data: JSON.stringify({
                "idRol": idRol
            }),
            beforeSend: function() {
                // $("#btnGuardarModal").empty();
                // $("#btnGuardarModal").append('<img src="./images/loading.gif" width="25" height="25" />')
            },
            success: function(result) {
                //console.log(result)
                if (result.estado == 1) {

                    let rol = result.objRol;
                    $("#nombre").val(rol.nombre)
                    $("#descripcion").val(rol.descripcion)
                    $("#claveAlterna").val(rol.claveAlterna)
                    $("#estado").val(rol.estado)
                    sistema = rol.predeterminado

                    tools.AlertSuccess("Mensaje", 'Se cargo correctamente los datos')

                } else {
                    tools.AlertWarning("Mensaje", result.mensaje)
                }
            },
            error: function(error) {
                tools.AlertError("Error", error.responseText);
            }
        });
    }

    function loadDataModulos(idRol) {
        $("#modalPrivilegio").modal("show");
    }

    function destroyModal(e) {
        $("#modalPrivilegio").modal("hide")
    }

    function loadDataModulos(idRol) {
        $("#modalPrivilegio").modal("show");
        idRolCurrent = idRol;

        $.ajax({
            url: "../app/roles/Obtener_Roles_By_Privilegios.php",
            method: "GET",
            data: {
                "id": idRol
            },
            beforeSend: function() {
                tbPrivilegio.empty();
                tbPrivilegio.append(
                    '<tr role="row" class="odd"><td class="sorting_1" colspan="7" style="text-align:center"><img src="./images/loading.gif" width="100"/><p>cargando información...</p></td></tr>'
                );
            },
            success: function(result) {
                console.log(result)

                if (result.estado == 1) {
                    let count = 0;
                    tbPrivilegio.empty();

                    // let objeto = []

                    // for (let priv of result.privilegios) {

                    //     // campos.nombre = priv.nombre
                    //     // campos.lectura = priv.lectura
                    //     // campos.escritura = priv.escritura
                    //     // campos.estado = priv.estado
                    //     // 
                    //     campos.nombre = priv.nombre
                    //     // campos.lectura = priv.lectura
                    //     objeto.push(campos)

                    //     // console.log(priv.nombre)

                    // }
                    // console.log(objeto)



                    for (let modulo of result.modulos) {
                        count++;
                        // let btnUpdate =
                        //     '<button class="btn btn-warning btn-sm" onclick="loadUpdateEmpleado(\'' +
                        //     empleado.idEmpleado + '\')">' +
                        //     '<i class="fa fa-pencil"></i> Editar' +
                        //     '</button>';
                        // let btnPrivilegio =
                        //     '<button class="btn btn-info btn-sm" onclick="loadPrivilegioEmpleado(\'' +
                        //     empleado.idEmpleado + '\')">' +
                        //     '<i class="fa fa-low-vision "></i> Acceso' +
                        //     '</button>';

                        let acceso = '<div class="form-group"> ' +
                            '<div class="form-check text-center">' +
                            '<input class="form-check-input" id="activo" type="checkbox">' +
                            '</div>' +
                            '</div>';

                        tbPrivilegio.append('<tr role="row" class="odd">' +
                            '<td class="sorting_1">' + count + '</td>' +
                            '<td>' + modulo.nombre + '</td>' +
                            '<td>' + acceso + '</td>' +
                            '<td>' + acceso + '</td>' +
                            '<td>' + acceso + '</td>' +
                            '<td>' + acceso + '</td>' +
                            '<td>' + acceso + '</td>' +
                            '</tr>');
                    }


                } else {
                    tools.AlertWarning("Mensaje", result.mensaje)
                    tbPrivilegio.empty();
                    tbPrivilegio.append(
                        '<tr role="row" class="odd"><td class="sorting_1" colspan="7" style="text-align:center"><p>' +
                        result.mensaje + '</p></td></tr>');
                    // setTimeout(function() {
                        
                    // }, 1000);
                }

            },
            error: function(error) {
                tools.AlertError("Error", error.responseText);
                tbPrivilegio.empty();
                tbPrivilegio.append(
                    '<tr role="row" class="odd"><td class="sorting_1" colspan="7" style="text-align:center"><p>' +
                    error.responseText + '</p></td></tr>');
            }
        });

    }

    </script>
</body>

</html>

<?php
}