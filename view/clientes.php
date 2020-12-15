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
                <h1><i class="fa fa-users"></i> Clientes</h1>
            </div>
        </div>
        <!-- modal nuevo/update Cliente  -->
        <div class="row">
            <div class="modal fade" id="modalCliente" data-backdrop="static">
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
                                        <label for="dni">DNI: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                        <input id="dni" type="number" name="dni" class="form-control"
                                            placeholder="Ingrese el número DNI" required="" minlength="8">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="apellidos">Apellidos: <i
                                                class="fa fa-fw fa-asterisk text-danger"></i></label>
                                        <input id="apellidos" type="text" name="apellidos" class="form-control"
                                            placeholder="Ingrese los Apellidos" required="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nombres">Nombres: <i
                                                class="fa fa-fw fa-asterisk text-danger"></i></label>
                                        <input id="nombres" type="text" name="nombres" class="form-control"
                                            placeholder="Ingrese los Nombres" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="genero">Genero: <i
                                                class="fa fa-fw fa-asterisk text-danger"></i></label>
                                        <select id="genero" class="form-control">
                                            <option value="1">Maculino</option>
                                            <option value="0">Femenino</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nacimiento">Nacimiento: <i
                                                class="fa fa-fw fa-asterisk text-danger"></i></label>
                                        <input id="nacimiento" type="date" name="nacimiento" class="form-control"
                                            required="">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="codigo">Codigo: </label>
                                        <input id="codigo" type="text" name="codigo" class="form-control"
                                            placeholder="Ingrese el Codigo" required="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email: </label>
                                        <input id="email" type="email" name="email" class="form-control"
                                            placeholder="Ingrese el correo" required="">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="celular">Celular: <i
                                                class="fa fa-fw fa-asterisk text-danger"></i></label>
                                        <input id="celular" type="number" name="celular" class="form-control"
                                            placeholder="Ingrese el número de celular" required="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="direccion">Dirección: </label>
                                        <input id="direccion" type="text" name="direccion" class="form-control"
                                            placeholder="Ingrese la dirección" required="">
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
                        <input type="search" class="form-control" placeholder="Buscar por apellidos, nombres o dni"
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
                                            style="width: 107px;">Dni</th>
                                        <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1"
                                            style="width: 250px;">Apellidos y Nombres</th>
                                        <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1"
                                            style="width: 72px;">Celular</th>
                                        <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1"
                                            style="width: 72px;">Email</th>
                                        <!-- <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1" style="width: 29px;">Dirección</th> -->
                                        <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1"
                                            style="width: 69px;">Membresia</th>
                                        <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1"
                                            style="width: 59px;">Estado</th>
                                        <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1"
                                            style="width: 59px;">Perfil</th>
                                        <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1"
                                            style="width: 59px;">Opciones</th>
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

    let idClienteUpdate = "";

    let tbListaCliente = $("#tbListaCliente")

    $(document).ready(function() {

        loadInitClientes();

        $('#modalCliente').on('shown.bs.modal', function() {
            $('#dni').trigger('focus')
        })

        $("#btnAdd").click(function() {
            $("#modalCliente").modal("show");
            $("#titulo-modal").append('<i class="fa fa-user-plus"></i> Registrar Cliente')
            $('#dni').trigger('focus')
        })

        $("#btnCancelModal").click(function() {
            closeClearModal()
        })

        $("#btnCloseModal").click(function() {
            closeClearModal()
        })

        $("#btnReload").click(function() {
            loadInitClientes()
        })

        $("#btnGuardarModal").click(function() {
            if ($("#dni").val() == '' || $("#dni").val().length < 8) {
                tools.AlertWarning("Advertencia", "Ingrese un número de dni valido")
            } else if ($("#apellidos").val() == '' || $("#apellidos").val().length < 1) {
                tools.AlertWarning("Advertencia", "Ingrese un apellido de 2 o mas letras.")
            } else if ($("#nombres").val() == '' || $("#nombres").val().length < 1) {
                tools.AlertWarning("Advertencia", "Ingrese un nombre de 2 o mas letras.")
            } else if ($("#genero").val() == '') {
                tools.AlertWarning("Advertencia", "Seleccione su sexo.")
            } else if ($("#nacimiento").val() == '') {
                tools.AlertWarning("Advertencia", "Ingrese un fecha de nacimiento.")
            } else if ($("#celular").val() == '' || $("#celular").val().length < 6) {
                tools.AlertWarning("Advertencia", "Ingrese un número de celular valido")
            } else {
                tools.ModalDialog('Cliente', '¿Desea guardar los datos?', 'question', function(result) {
                    if (result) {
                        registrarCliente($("#dni").val(), $("#apellidos").val(), $("#nombres")
                            .val(), $(
                                "#genero").val(),
                            $("#nacimiento").val(), $("#codigo").val(), $("#email").val(),
                            $("#celular")
                            .val(),
                            $("#direccion").val());
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
                    loadTableClientes($("#txtSearch").val().trim());
                    opcion = 1;
                }
            }
        });

    });

    function loadInitClientes() {
        if (!state) {
            paginacion = 1;
            loadTableClientes("");
            opcion = 0;
        }
    }

    function onEventPaginacion() {
        switch (opcion) {
            case 0:
                loadTableClientes("");
                break;
            case 1:
                loadTableClientes($("#txtSearch").val().trim());
                break;
        }
    }


    function loadTableClientes(buscar) {
        $.ajax({
            url: "../app/cliente/Obtener_Clientes.php",
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
                    '<tr role="row" class="odd"><td class="sorting_1" colspan="8" style="text-align:center"><img src="./images/loading.gif" width="100"/><p>cargando información...</p></td></tr>'
                );
                totalPaginacion = 0;
            },
            success: function(result) {
                let data = JSON.parse(result);
                if (data.estado == 1) {
                    tbLista.empty();
                    for (let cliente of data.clientes) {

                        let btnUpdate =
                            '<button class="btn btn-warning btn-sm" onclick="loadUpdateCliente(\'' +
                            cliente.idCliente + '\')">' +
                            '<i class="fa fa-wrench"></i> Editar' +
                            '</button>';
                        let btnPerfil =
                            '<button class="btn btn-info btn-sm" onclick="loadDataPerfil(\'' +
                            cliente.idCliente + '\')">' +
                            '<i class="fa fa-user-circle"></i> Ver' +
                            '</button>';

                        tbLista.append('<tr role="row" class="odd">' +
                            '<td class="sorting_1">' + cliente.id + '</td>' +
                            '<td>' + cliente.dni + '</td>' +
                            '<td>' + cliente.apellidos + " " + cliente.nombres + '</td>' +
                            '<td>' + cliente.celular + '</td>' +
                            '<td>' + cliente.email + '</td>' +
                            '<td>' + (cliente.membresia >= 1 ? cliente.membresia + " MEMBRESIA(S)" :
                                "NINGUNA") + "<br>" + (cliente.venta == 1 ? cliente.venta +
                                " deuda(s)" : "0 deudas") + '</td>' +
                            '<td>Estado</td>' +
                            '<td>' + btnPerfil + '</td>' +
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

    function loadDataPerfil(idCliente){
        location.href = "clientePerfil.php?idCliente=" + idCliente
    }

    function registrarCliente(dni, apellidos, nombres, genero, nacimiento, codigo, email, celular, direccion) {
        $.ajax({
            url: "../app/cliente/Crud_Clientes.php",
            method: "POST",
            accepts: "application/json",
            contentType: "application/json",
            data: JSON.stringify({
                "idCliente": idClienteUpdate,
                "dni": dni,
                "apellidos": (apellidos.toUpperCase()).trim(),
                "nombres": (nombres.toUpperCase()).trim(),
                "sexo": genero,
                "fechaNacimiento": nacimiento,
                "codigo": (codigo.toUpperCase()).trim(),
                "email": email.trim(),
                "celular": celular,
                "direccion": (direccion.toUpperCase()).trim()
            }),
            beforeSend: function() {
                closeClearModal();
                tools.ModalAlertInfo('Disciplinas', 'Procesando petición...');
            },
            success: function(result) {
                if (result.estado == 1) {
                    tools.ModalAlertSuccess('Disciplinas', result.mensaje);
                    loadInitClientes();
                } else {
                    tools.ModalAlertWarning('Disciplinas', result.mensaje);
                }
            },
            error: function(error) {
                tools.ModalAlertError("Disciplinas", error.responseText);
            }
        });
    }

    function closeClearModal() {
        $("#modalCliente").modal("hide")
        $("#titulo-modal").empty()

        $("#dni").val("")
        $("#apellidos").val("")
        $("#nombres").val("")
        $("#genero").val("1")
        $("#nacimiento").val("")
        $("#codigo").val("")
        $("#email").val("")
        $("#celular").val("")
        $("#direccion").val("")
        idClienteUpdate = "";
    }

    function loadUpdateCliente(idCliente) {
        $("#modalCliente").modal("show");
        $("#titulo-modal").append('<i class="fa fa-user"></i> Editar Cliente');
        idClienteUpdate = idCliente;
        $.ajax({
            url: "../app/cliente/Obtener_Clientes_By_Id.php",
            method: "POST",
            accepts: "application/json",
            contentType: "application/json",
            data: JSON.stringify({
                "idCliente": idCliente
            }),
            beforeSend: function() {
                // $("#btnGuardarModal").empty();
                // $("#btnGuardarModal").append('<img src="./images/loading.gif" width="25" height="25" />')
            },
            success: function(result) {
                if (result.estado == 1) {
                    let cliente = result.cliente;
                    $("#dni").val(cliente.dni)
                    $("#apellidos").val(cliente.apellidos)
                    $("#nombres").val(cliente.nombres)
                    $("#genero").val(cliente.sexo)
                    document.getElementById("nacimiento").value = tools.getDateForma(cliente
                        .fechaNacimiento, 'yyyy-mm-dd')
                    $("#codigo").val(cliente.codigo)
                    $("#email").val(cliente.email)
                    $("#celular").val(cliente.celular)
                    $("#direccion").val(cliente.direccion)

                } else {
                    tools.AlertWarning("Mensaje", result.mensaje)
                    $("#btnGuardarModal").empty();
                    $("#btnGuardarModal").append('<i class="fa fa-save"></i> Guardar')
                }
            },
            error: function(error) {
                tools.AlertError("Error", error.responseText);
                $("#btnGuardarModal").empty();
                $("#btnGuardarModal").append('<img src="./images/loading.gif" width="25" height="25" />')
            }
        });
    }
    </script>
</body>

</html>

<?php
}