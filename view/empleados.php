<?php
session_start();
if (!isset($_SESSION["IdEmpleado"])) {
    echo '<script>location.href = "./login.php";</script>';
} else {
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include './layout/head.php';?>
</head>

<style>
/* Style the tab */
.tab {
    overflow: hidden;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
    background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
    font-size: 14px;
}

/* Change background color of buttons on hover */
.tab button:hover {
    background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
    background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
    display: none;
    padding: 6px 12px;
    border: 1px solid #ccc;
    border-top: none;
}
</style>

<body class="app sidebar-mini">
    <!-- Navbar-->
    <?php include "./layout/header.php";?>
    <!-- Sidebar menu-->
    <?php include "./layout/menu.php";?>
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-users"></i> Empleados</h1>
            </div>
        </div>
        <div class="tile mb-4">
            <!-- modal nuevo/update Empleado  -->
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
                                <div class="tab">
                                    <button class="tablinks" onclick="selectTab(event, 'basico')">Básicos</button>
                                    <button class="tablinks" onclick="selectTab(event, 'contacto')">Contacto</button>
                                    <button class="tablinks" onclick="selectTab(event, 'laboral')">Laborales</button>
                                    <button class="tablinks"
                                        onclick="selectTab(event, 'acceso-sistema')">Acceso</button>
                                </div>

                                <div id="basico" class="tabcontent">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="tipoDocumento">Tipo de documento: <i
                                                        class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <select id="tipoDocumento" class="form-control">
                                                    <option value="DNI">DNI</option>
                                                    <option value="Carnet de extranjeria">Carnet de extranjeria</option>
                                                    <option value="Pasaporte">Pasaporte</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="numeroDocumento">Número de documento: <i
                                                        class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="numeroDocumento" type="number" name="numeroDocumento" class="form-control"
                                                    placeholder="Ingrese el número de documento" required="" minlength="8">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="apellidos">Apellidos: <i
                                                        class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="apellidos" type="text" name="apellidos" class="form-control"
                                                    placeholder="Ingrese los apellidos" required="" minlength="2">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="nombres">Nombres: <i
                                                        class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="nombres" type="text" name="nombres" class="form-control"
                                                    placeholder="Ingrese los nombres" required="" minlength="2">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="sexo">Sexo: </label>
                                                <select id="sexo" class="form-control">
                                                    <option value="Masculino">Masculino</option>
                                                    <option value="Femenino">Femenino</option> 
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="contacto" class="tabcontent">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nacimiento">Fecha de Nacimiento: </label>
                                                <input id="nacimiento" type="date" name="nacimiento" class="form-control"
                                                    required="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="telefono">Teléfono: </label>
                                                <input id="telefono" type="number" name="telefono" class="form-control"
                                                    placeholder="Ingrese el número de teléfono" required="" minlength="6">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="celular">Celular: <i
                                                        class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="celular" type="number" name="celular" class="form-control"
                                                    placeholder="Ingrese el número de celular" required="" minlength="6">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="email">Email: </label>
                                                <input id="email" type="email" name="email" class="form-control"
                                                    placeholder="Ingrese el email" required="" minlength="6">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="direccion">Dirección: </label>
                                                <input id="direccion" type="text" name="direccion" class="form-control"
                                                    placeholder="Ingrese la dirección" required="" minlength="6">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="laboral" class="tabcontent">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="ocupacion">Ocupación: </label>
                                                <select id="ocupacion" class="form-control">
                                                    <option value="Sin Ocupación">Sin Ocupación</option>
                                                    <option value="Administrador">Administrador</option>
                                                    <option value="Instructor">Instructor</option>
                                                    <option value="Recepcionista">Recepcionista</option>  
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="pago">Formas de pago: </label>
                                                <select id="pago" class="form-control">
                                                    <option value="Deposito a cuenta">Deposito a cuenta</option>
                                                    <option value="Efectivo">Efectivo</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="banco">Entidad bancaria: </label>
                                                <input id="banco" type="text" name="banco" class="form-control"
                                                    placeholder="Ingrese la entidad bancaria" required="" minlength="2">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="numeroCuenta">Número de cuenta: </label>
                                                <input id="numeroCuenta" type="number" name="numeroCuenta" class="form-control"
                                                    placeholder="Ingrese el numero de cuenta" required="" minlength="2">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="acceso-sistema" class="tabcontent">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="codigo">Codigo: </label>
                                                <input id="codigo" type="text" name="codigo" class="form-control"
                                                    placeholder="Ingrese el codigo de empleado" required="" minlength="2">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="pago">Rol: </label>
                                                <select id="pago" class="form-control">
                                                    <option value="Ninguno">Ninguno</option>
                                                    <option value="Cajero(a)">Cajero(a)</option>
                                                    <option value="Administrador(a)">Administrador(a)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="usuario">Usuario: </label>
                                                <input id="usuario" type="text" name="usuario" class="form-control"
                                                    placeholder="Ingrese el nombre de usuario" required="" minlength="2">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for=pass>Contraseña: </label>
                                                <input id="pass" type="password" name="pass" class="form-control"
                                                    placeholder="Ingrese la contraseña de usuario" required="" minlength="2">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="estado">Estado: </label>
                                                <select id="estado" class="form-control">
                                                    <option value="Activo">Activo</option>
                                                    <option value="Inactivo">Inactivo</option>
                                                </select>
                                            </div>
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

            <div class="row">
                <div class="col-lg-6">
                    <p class="bs-component">
                        <button class="btn btn-info" type="button" id="btnAdd"><i class="fa fa-plus"></i>
                            Nuevo</button>
                        <button class="btn btn-secondary" type="button" id="btnReload"><i class="fa fa-refresh"></i>
                            Recargar</button>
                    </p>
                </div>
                <div class="col-lg-6">
                    <input type="search" class="form-control" placeholder="Buscar por apellidos, nombres o dni"
                        aria-controls="sampleTable" id="txtSearch">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="tile">
                        <div class="tile-body">
                            <div class="table-responsive">
                                <div id="sampleTable_wrapper"
                                    class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <div class="dataTables_length" id="sampleTable_length">
                                                <label>Mostrar <select name="sampleTable_length"
                                                        aria-controls="sampleTable"
                                                        class="form-control form-control-sm">
                                                        <option value="10">10</option>
                                                        <option value="25">25</option>
                                                        <option value="50">50</option>
                                                        <option value="100">100</option>
                                                    </select> filas
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table table-hover table-bordered dataTable no-footer"
                                                id="sampleTable" role="grid" aria-describedby="sampleTable_info">
                                                <thead>
                                                    <tr role="row">
                                                        <th class="sorting" aria-controls="sampleTable" rowspan="1"
                                                            colspan="1" style="width: 20px;">#</th>
                                                        <th class="sorting_asc" aria-controls="sampleTable" rowspan="1"
                                                            colspan="1" style="width: 107px;">Dni</th>
                                                        <th class="sorting" aria-controls="sampleTable" rowspan="1"
                                                            colspan="1" style="width: 250px;">Apellidos y Nombres
                                                        </th>
                                                        <th class="sorting" aria-controls="sampleTable" rowspan="1"
                                                            colspan="1" style="width: 72px;">Celular</th>
                                                        <th class="sorting" aria-controls="sampleTable" rowspan="1"
                                                            colspan="1" style="width: 72px;">Ocupación</th>
                                                        <th class="sorting" aria-controls="sampleTable" rowspan="1"
                                                            colspan="1" style="width: 59px;">Opciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="">
                                                    <!-- tbLista -->
                                                    <tr>
                                                        <td>1</td>
                                                        <td>88888888</td>
                                                        <td>Nombres Completos</td>
                                                        <td>999999999</td>
                                                        <td>Administrador</td>
                                                        <td>
                                                            <button class="btn btn-info btn-sm"><i
                                                                    class="fa fa-sticky-note"></i>
                                                                Información</button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-5">
                                            <div class="dataTables_info" id="sampleTable_info" role="status"
                                                aria-live="polite">Mostrando de 1 a 10 empleado(s) de (2)</div>
                                        </div>
                                        <div class="col-sm-12 col-md-7">
                                            <div class="dataTables_paginate paging_simple_numbers"
                                                id="sampleTable_paginate">
                                                <ul class="pagination">
                                                    <li class="paginate_button page-item previous"><a
                                                            id="lblPaginaActual" aria-controls="sampleTable"
                                                            data-dt-idx="0" tabindex="0" class="page-link">Anterior</a>
                                                    </li>
                                                    <li class="paginate_button page-item active"><a href="#"
                                                            aria-controls="sampleTable" data-dt-idx="1" tabindex="0"
                                                            class="page-link">a</a></li>
                                                    <li class="paginate_button page-item next"><a
                                                            id="lblPaginaSiguiente" aria-controls="sampleTable"
                                                            data-dt-idx="7" tabindex="0" class="page-link">Siguiente</a>
                                                    </li>
                                                </ul>
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
    </main>
    <!-- Essential javascripts for application to work-->
    <?php include "./layout/footer.php";?>
    <script>
    let tools = new Tools();

    let tbLista = $("#tbLista");
    let totalPaginacion = 0;
    let paginacion = 0;
    let opcion = 0;
    let state = false;

    let idClienteUpdate = "";


    $(document).ready(function() {

        //loadInitClientes();

        $('#modalCliente').on('shown.bs.modal', function(event) {
            selectTab(event, 'basico')
            //$('#dni').trigger('focus')
        })

        $("#btnAdd").click(function() {
            $("#modalCliente").modal("show");
            $("#titulo-modal").append('<i class="fa fa-user-plus"></i> Registrar Empleado')
            //$('#dni').trigger('focus')
        })

        $("#btnCancelModal").click(function() {
            closeClearModal()
        })

        $("#btnCloseModal").click(function() {
            closeClearModal()
        })

        $("#btnReload").click(function() {
            //loadInitClientes()
        })

        // $("#btnGuardarModal").click(function() {
        //     if ($("#dni").val() == '' || $("#dni").val().length < 8) {
        //         tools.AlertWarning("Advertencia", "Ingrese un número de dni valido")
        //     } else if ($("#apellidos").val() == '' || $("#apellidos").val().length < 1) {
        //         tools.AlertWarning("Advertencia", "Ingrese un apellido de 2 o mas letras.")
        //     } else if ($("#nombres").val() == '' || $("#nombres").val().length < 1) {
        //         tools.AlertWarning("Advertencia", "Ingrese un nombre de 2 o mas letras.")
        //     } else if ($("#nacimiento").val() == '') {
        //         tools.AlertWarning("Advertencia", "Ingrese un fecha de nacimiento.")
        //     } else if ($("#celular").val() == '' || $("#celular").val().length < 6) {
        //         tools.AlertWarning("Advertencia", "Ingrese un número de celular valido")
        //     } else {
        //         registrarCliente($("#dni").val(), $("#apellidos").val(), $("#nombres").val(), $(
        //                 "#genero").val(),
        //             $("#nacimiento").val(), $("#codigo").val(), $("#email").val(), $("#celular")
        //             .val(),
        //             $("#direccion").val())
        //     }
        // });

    });

    function selectTab(evt, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    function loadInitClientes() {
        if (!state) {
            paginacion = 1;
            loadTableClientes();
            opcion = 0;
        }
    }


    function loadTableClientes() {
        $.ajax({
            url: "../SistemGymBackEnd/cliente/Obtener_Clientes.php",
            method: "",
            data: {
                opcion: 1,
                page: paginacion,
                datos: ''
            },
            beforeSend: function() {
                state = true;
                tbLista.empty();
                tbLista.append(
                    '<tr role="row" class="odd"><td class="sorting_1" colspan="6" style="text-align:center"><img src="./images/loading.gif" width="100"/><p>cargando información...</p></td></tr>'
                );
            },
            success: function(result) {
                let data = JSON.parse(result);
                if (data.estado == 1) {
                    let count = 0;
                    tbLista.empty();
                    for (let cliente of data.clientes) {

                        let btnUpdate =
                            '<button class="btn btn-warning btn-sm" onclick="loadUpdateCliente(\'' +
                            cliente.idCliente + '\')">' +
                            '<i class="fa fa-wrench"></i> Editar' +
                            '</button>';

                        count++;
                        tbLista.append('<tr role="row" class="odd">' +
                            '<td class="sorting_1">' + count + '</td>' +
                            '<td>' + cliente.dni + '</td>' +
                            '<td>' + cliente.apellidos + " " + cliente.nombres + '</td>' +
                            '<td>' + cliente.celular + '</td>' +
                            '<td>' + cliente.membresia + '</td>' +
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
                        '<tr role="row" class="odd"><td class="sorting_1" colspan="6" style="text-align:center"><p>' +
                        data.mensaje + '</p></td></tr>');
                    state = false;
                }
            },
            error: function(error) {
                tbLista.empty();
                tbLista.append(
                    '<tr role="row" class="odd"><td class="sorting_1" colspan="6" style="text-align:center"><p>' +
                    error.responseText + '</p></td></tr>');
                state = false;
            }
        });
    }

    function registrarCliente(dni, apellidos, nombres, genero, nacimiento, codigo, email, celular, direccion) {

        $.ajax({
            url: "../SistemGymBackEnd/cliente/Crud_Clientes.php",
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
                $("#btnGuardarModal").empty();
                $("#btnGuardarModal").append('<img src="./images/loading.gif" width="25" height="25" />')
            },
            success: function(result) {
                console.log(result)
                if (result.estado == 1) {
                    tools.AlertSuccess("Mensaje", result.mensaje)
                    setTimeout(function() {
                        location.href = "./clientes.php"
                    }, 1000);
                    closeClearModal();
                } else {
                    tools.AlertWarning("Mensaje", result.mensaje)
                    setTimeout(function() {
                        $("#btnGuardarModal").empty();
                        $("#btnGuardarModal").append('<i class="fa fa-save"></i> Guardar')
                    }, 1000);

                }
            },
            error: function(error) {
                tools.AlertError("Error", error.responseText);
                $("#btnGuardarModal").empty();
                $("#btnGuardarModal").append('<i class="fa fa-save"></i> Guardar')

            }
        });
    }

    function closeClearModal() {
        $("#modalCliente").modal("hide")
        $("#titulo-modal").empty()
        $("#btnAccion").empty()

        $("#dni").val("")
        $("#apellidos").val("")
        $("#nombres").val("")
        $("#genero").val("")
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
            url: "../SistemGymBackEnd/cliente/Obtener_Clientes_By_Id.php",
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
                    setTimeout(function() {
                        $("#btnGuardarModal").empty();
                        $("#btnGuardarModal").append('<i class="fa fa-save"></i> Guardar')
                    }, 1000);
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