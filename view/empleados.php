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
            <h1><i class="fa fa-users"></i> Empleados</h1>
        </div>

        <!-- modal nuevo/update Empleado  -->
        <div class="row">
            <div class="modal fade" id="modalEmpleado" data-backdrop="static">
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
                                <button class="tablinks" onclick="selectTab(event, 'acceso-sistema')">Acceso</button>
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
                                            <input id="numeroDocumento" type="number" name="numeroDocumento"
                                                class="form-control" placeholder="Ingrese el número de documento"
                                                required="" minlength="8">
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
                                            <input id="numeroCuenta" type="number" name="numeroCuenta"
                                                class="form-control" placeholder="Ingrese el numero de cuenta"
                                                required="" minlength="2">
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
                                            <label for="rol">Rol: </label>
                                            <select id="rol" class="form-control">
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
                                            <div class="d-flex">
                                                <input id="pass" type="password" name="pass" class="form-control"
                                                    placeholder="Ingrese la contraseña de usuario" required=""
                                                    minlength="2">
                                                <button type="button" class="btn btn-info btn-group-sm" id="btnVer">
                                                    <i class="fa fa-eye"></i></button>
                                            </div>

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
                            <button type="button" class="btn btn-success btn-group-sm" id="btnGuardarModal">
                                <i class="fa fa-save"></i> Guardar</button>
                            <button type="button" class="btn btn-danger btn-group-sm" id="btnCancelModal">
                                <i class="fa fa-remove"></i> Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal privilegio -->
        <div class="row">
            <div class="modal fade" id="modalPrivilegio" data-backdrop="static">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">
                                <i class="fa fa-universal-access"></i> Privilegio de empleado
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
                                                style="width: 59px;">#</th>
                                            <th class="sorting_asc" aria-controls="sampleTable" rowspan="1" colspan="1"
                                                style="width: 180px;">Modulo</th>
                                            <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1"
                                                style="width: 59px;">Acceso</th>
                                            <!-- <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1"
                                                style="width: 59px;">Lectura</th>
                                            <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1"
                                                style="width: 59px;">Escritura</th> -->

                                        </tr>
                                    </thead>

                                    <tbody id="">
                                        
                                        <tr role="row" class="odd">
                                            <td>1</td>
                                            <td>Empleado</td>
                                            <td>
                                                <div class="form-group">
                                                    <div class="form-check text-center">
                                                        <input class="form-check-input" id="activo" type="checkbox">
                                                    </div>
                                                </div>
                                            </td>
                                            
                                        </tr>
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
                        <input type="search" class="form-control" placeholder="Buscar por apellidos, nombres o dni"
                            id="txtSearch">
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
                                        <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1"
                                            style="width: 20px;">#</th>
                                        <th class="sorting_asc" aria-controls="sampleTable" rowspan="1" colspan="1"
                                            style="width: 59px;">Dni</th>
                                        <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1"
                                            style="width: 180px;">Apellidos y Nombres
                                        </th>
                                        <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1"
                                            style="width: 59px;">Celular</th>
                                        <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1"
                                            style="width: 59px;">Ocupación</th>
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
    <?php include "./layout/footer.php";?>
    <script>
    let tools = new Tools();

    let tbLista = $("#tbLista");
    let totalPaginacion = 0;
    let paginacion = 0;
    let opcion = 0;
    let state = false;

    let idEmpleadoUpdate = "";


    $(document).ready(function() {

        loadInitEmpleados();


        $("#btnVer").on('mouseover', function() {
            // console.log( $("#pass").val())

        });

        $('#modalEmpleado').on('shown.bs.modal', function(event) {
            selectTab(event, 'basico')
            $('#numeroDocumento').trigger('focus')
        })

        $("#btnAdd").click(function() {
            $("#modalEmpleado").modal("show");
            $("#titulo-modal").append('<i class="fa fa-user-plus"></i> Registrar Empleado')

        })

        $("#btnCancelModal").click(function() {
            closeClearModal()
        })

        $("#btnCloseModal").click(function() {
            closeClearModal()
        })

        $("#btnReload").click(function() {
            loadInitEmpleados()
        })

        $("#modalPrivilegio").on('shown.bs.modal', function(event) {
            // selectTab(event, 'basico')
            // $('#numeroDocumento').trigger('focus')
        })

        $("#btnGuardarModal").click(function() {

            if ($("#numeroDocumento").val() == '' || $("#numeroDocumento").val().length < 8) {
                tools.AlertWarning("Advertencia", "Ingrese un número de documento valido")
            } else if ($("#apellidos").val() == '' || $("#apellidos").val().length < 2) {
                tools.AlertWarning("Advertencia", "Ingrese un apellido de 2 o mas letras.")
            } else if ($("#nombres").val() == '' || $("#nombres").val().length < 2) {
                tools.AlertWarning("Advertencia", "Ingrese un nombre de 2 o mas letras.")
            } else if ($("#celular").val() == '' || $("#celular").val().length < 6) {
                tools.AlertWarning("Advertencia", "Ingrese un número de celular valido.")
            } else {
                registrarEmpleado($("#tipoDocumento").val(), $("#numeroDocumento").val(), $(
                        "#apellidos").val(), $("#nombres").val(), $("#sexo").val(),
                    $("#nacimiento").val(), $("#telefono").val(), $("#celular").val(), $("#email")
                    .val(), $("#direccion").val(),
                    $("#ocupacion").val(), $("#pago").val(), $("#banco").val(), $("#numeroCuenta")
                    .val(),
                    $("#codigo").val(), $("#rol").val(), $("#usuario").val(), $("#pass").val(), $(
                        "#estado").val(), )
            }

        });

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

    function loadInitEmpleados() {
        if (!state) {
            paginacion = 1;
            loadTableEmpleados();
            opcion = 0;
        }
    }


    function loadTableEmpleados() {
        $.ajax({
            url: "../app/empleados/Obtener_Empleados.php",
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

                if (result.estado == 1) {
                    let count = 0;
                    tbLista.empty();
                    for (let empleado of result.empleados) {
                        count++;
                        let btnUpdate =
                            '<button class="btn btn-warning btn-sm" onclick="loadUpdateEmpleado(\'' +
                            empleado.idEmpleado + '\')">' +
                            '<i class="fa fa-pencil"></i> Editar' +
                            '</button>';
                        let btnPrivilegio =
                            '<button class="btn btn-info btn-sm" onclick="loadPrivilegioEmpleado(\'' +
                            empleado.idEmpleado + '\')">' +
                            '<i class="fa fa-low-vision "></i> Acceso' +
                            '</button>';

                        tbLista.append('<tr role="row" class="odd">' +
                            '<td class="sorting_1">' + count + '</td>' +
                            '<td>' + empleado.numeroDocumento + '</td>' +
                            '<td>' + empleado.apellidos + " " + empleado.nombres + '</td>' +
                            '<td>' + empleado.celular + '</td>' +
                            '<td>' + empleado.ocupacion + '</td>' +
                            '<td>' + btnUpdate + ' ' + btnPrivilegio + '</td>' +
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
                        '<tr role="row" class="odd"><td class="sorting_1" colspan="6" style="text-align:center"><p>' +
                        result.mensaje + '</p></td></tr>');
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

    function registrarEmpleado(tipoDocumento, numeroDocumento, apellidos, nombres, sexo,
        nacimiento, telefono, celular, email, direccion,
        ocupacion, pago, banco, numeroCuenta,
        codigo, rol, usuario, pass, estado) {

        $.ajax({
            url: "../app/empleados/Crud_Empleados.php",
            method: "POST",
            accepts: "application/json",
            contentType: "application/json",
            data: JSON.stringify({
                "idEmpleado": idEmpleadoUpdate,
                "tipoDocumento": tipoDocumento,
                "numeroDocumento": numeroDocumento,
                "apellidos": (apellidos.toUpperCase()).trim(),
                "nombres": (nombres.toUpperCase()).trim(),
                "sexo": sexo,
                "fechaNacimiento": nacimiento,
                "telefono": telefono,
                "celular": celular,
                "email": email,
                "direccion": (direccion.toUpperCase()).trim(),

                "codigo": (codigo.toUpperCase()).trim(),

                "ocupacion": ocupacion,
                "formaPago": pago,
                "entidadBancaria": (banco.toUpperCase()).trim(),
                "numeroCuenta": numeroCuenta,

                "rol": rol,
                "usuario": usuario,
                "clave": pass,
                "estado": estado,

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
                        location.href = "./empleados.php"
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

        $("#modalEmpleado").modal("hide")
        $("#titulo-modal").empty()

        document.getElementById("tipoDocumento").selectedIndex = "0"
        $("#numeroDocumento").val('')
        $("#apellidos").val('')
        $("#nombres").val('')
        document.getElementById("sexo").selectedIndex = "0"

        $("#nacimiento").val('')
        $("#telefono").val('')
        $("#celular").val('')
        $("#email").val('')
        $("#direccion").val('')

        document.getElementById("ocupacion").selectedIndex = "0"
        document.getElementById("pago").selectedIndex = "0"
        $("#banco").val('')
        $("#numeroCuenta").val('')

        $("#codigo").val('')
        document.getElementById("rol").selectedIndex = "0"
        $("#usuario").val('')
        $("#pass").val('')
        document.getElementById("estado").selectedIndex = "0"

        idEmpleadoUpdate = "";
    }

    function loadUpdateEmpleado(idEmpleado) {
        $("#modalEmpleado").modal("show");
        $("#titulo-modal").append('<i class="fa fa-user"></i> Editar Empleado');
        idEmpleadoUpdate = idEmpleado;

        $.ajax({
            url: "../app/empleados/Obtener_Empleados_By_Id.php",
            method: "POST",
            accepts: "application/json",
            contentType: "application/json",
            data: JSON.stringify({
                "idEmpleado": idEmpleado
            }),
            beforeSend: function() {
                // $("#btnGuardarModal").empty();
                // $("#btnGuardarModal").append('<img src="./images/loading.gif" width="25" height="25" />')
            },
            success: function(result) {

                if (result.estado == 1) {
                    let empleado = result.empleados[0];
                    // console.log(empleado)

                    $("#tipoDocumento").val(empleado.tipoDocumento)
                    $("#numeroDocumento").val(empleado.numeroDocumento)
                    $("#apellidos").val(empleado.apellidos)
                    $("#nombres").val(empleado.nombres)
                    $("#sexo").val(empleado.sexo)

                    $("#nacimiento").val(empleado.fechaNacimiento)
                    $("#telefono").val(empleado.telefono)
                    $("#celular").val(empleado.celular)
                    $("#email").val(empleado.email)
                    $("#direccion").val(empleado.direccion)

                    $("#ocupacion").val(empleado.ocupacion)
                    $("#pago").val(empleado.formaPago)
                    $("#banco").val(empleado.entidadBancaria)
                    $("#numeroCuenta").val(empleado.numeroCuenta)

                    $("#codigo").val(empleado.codigo)
                    $("#rol").val(empleado.rol)
                    $("#usuario").val(empleado.usuario)
                    $("#pass").val(empleado.clave)
                    $("#estado").val(empleado.estado)


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

    function loadPrivilegioEmpleado(idEmpleado) {
        $("#modalPrivilegio").modal("show");
    }

    function destroyModal(e) {
        $("#modalPrivilegio").modal("hide")
    }
    </script>
</body>

</html>

<?php
}