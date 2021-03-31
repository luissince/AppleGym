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
        <!-- Sidebar menu-->
        <?php include "./marcarentrada.php"; ?>
        <main class="app-content">
            <div class="row user">
                <div class="col-md-12">
                    <div class="profile">
                        <div class="info"><img class="user-img" src="./images/noimage.jpg">
                            <h4 id="lblInformacion">John Doe</h4>
                            <p id="lblPuesto">FrontEnd Developer</p>
                        </div>
                        <div class="cover-image"></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="tile p-0">
                        <ul class="nav flex-column nav-tabs user-tabs">
                            <li class="nav-item"><a class="nav-link active" href="#user-settings" data-toggle="tab">Datos</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="user-settings">
                            <div class="tile user-settings">
                                <h4 class="line-head">Datos</h4>
                                <div class="row mb-4">
                                    <div class="col-md-5">
                                        <label>Tipo de documento: </label>
                                        <select id="tipoDocumento" class="form-control">
                                            <option value="DNI">DNI</option>
                                            <option value="Carnet de extranjeria">Carnet de extranjeria</option>
                                            <option value="Pasaporte">Pasaporte</option>
                                        </select>
                                    </div>
                                    <div class="col-md-5">
                                        <label>Número de documento: </label>
                                        <input id="numeroDocumento" class="form-control" type="text">
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-5 mb-12">
                                        <label>Apellidos:</label>
                                        <input id="apellidos" class="form-control" type="text">
                                    </div>
                                    <div class="col-md-5 mb-12">
                                        <label>Nombres: </label>
                                        <input id="nombres" class="form-control" type="text">
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-5 mb-12">
                                        <label>Sexo:</label>
                                        <select id="sexo" class="form-control">
                                            <option value="Masculino">Masculino</option>
                                            <option value="Femenino">Femenino</option>
                                        </select>
                                    </div>
                                    <div class="col-md-5 mb-12">
                                        <label>Fecha de Nacimiento:</label>
                                        <input id="fechaNacimiento" class="form-control" type="date">
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-5 mb-12">
                                        <label>Teléfono:</label>
                                        <input id="telefono" class="form-control" type="text">
                                    </div>
                                    <div class="col-md-5 mb-12">
                                        <label>Celular:</label>
                                        <input id="celular" class="form-control" type="text">
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-5 mb-12">
                                        <label>Email:</label>
                                        <input id="email" class="form-control" type="text">
                                    </div>
                                    <div class="col-md-5 mb-12">
                                        <label>Codigo:</label>
                                        <input id="codigo" class="form-control" type="text">
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-10 mb-12">
                                        <label>Dirección:</label>
                                        <input id="direccion" class="form-control" type="text">
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-5 mb-12">
                                        <label>Usuario:</label>
                                        <input id="usuario" class="form-control" type="text">
                                    </div>
                                    <div class="col-md-5 mb-12">
                                        <label>Contraseña:</label>
                                        <input id="clave" class="form-control" type="password">
                                    </div>
                                </div>

                                <div class="row mb-10">
                                    <div class="col-md-12">
                                        <button class="btn btn-primary" type="button"  id="btnGuardar"><i class="fa fa-fw fa-lg fa-check-circle"></i> Guardar</button>
                                    </div>
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
            let idEmpleado = "<?php echo $_SESSION["IdEmpleado"]; ?>";
            let tbListaVenta = $("#tbListaVentas");
            let tbAsistencia = $("#tbListaAsistencia");

            $(document).ready(function() {
                $("#btnGuardar").click(function() {
                    crudPerfil();
                });

                $("#btnGuardar").keypress(function(event) {
                    if (event.keyCode == 13) {
                        crudPerfil();
                    }
                    event.preventDefault();
                });

                loadDataEmpleado(idEmpleado);
            });

            function loadDataEmpleado(idEmpleado) {
                $.ajax({
                    url: "../app/empleados/EmpleadoController.php",
                    method: "GET",
                    data: {
                        "type": "getbyid",
                        "idEmpleado": idEmpleado
                    },
                    beforeSend: function() {

                    },
                    success: function(result) {
                        if (result.estado == 1) {
                            let empleado = result.empleados;

                            $("#lblInformacion").html(empleado.apellidos + ' ' + empleado.nombres);
                            $("#lblPuesto").html(empleado.ocupacion);

                            $("#tipoDocumento").val(empleado.tipoDocumento);
                            $("#numeroDocumento").val(empleado.numeroDocumento);
                            $("#apellidos").val(empleado.apellidos);
                            $("#nombres").val(empleado.nombres);
                            $("#sexo").val(empleado.sexo);
                            $("#fechaNacimiento").val(empleado.fechaNacimiento);
                            $("#telefono").val(empleado.telefono);
                            $("#celular").val(empleado.celular);
                            $("#email").val(empleado.email);
                            $("#codigo").val(empleado.codigo);
                            $("#direccion").val(empleado.direccion);
                            $("#usuario").val(empleado.usuario);
                            $("#clave").val(empleado.clave);
                        }
                    },
                    error: function(error) {


                    }
                });
            }

            function crudPerfil() {
                if ($("#numeroDocumento").val() == '' || $("#numeroDocumento").val().length < 8) {
                    tools.AlertWarning("Advertencia", "Ingrese un número de documento valido");
                    $("#numeroDocumento").focus();
                } else if ($("#apellidos").val() == '' || $("#apellidos").val().length < 2) {
                    tools.AlertWarning("Advertencia", "Ingrese un apellido de 2 o mas letras.");
                    $("#apellidos").focus();
                } else if ($("#nombres").val() == '' || $("#nombres").val().length < 2) {
                    tools.AlertWarning("Advertencia", "Ingrese un nombre de 2 o mas letras.");
                    $("#nombres").focus();
                } else if ($("#celular").val() == '' || $("#celular").val().length < 6) {
                    tools.AlertWarning("Advertencia", "Ingrese un número de celular valido.");
                    $("#celular").focus();
                } else {
                    tools.ModalDialog('Perfil', '¿Desea guardar los datos?', 'question', function(result) {
                        if (result) {
                            $.ajax({
                                url: "../app/empleados/EmpleadoController.php",
                                method: "POST",
                                accepts: "application/json",
                                contentType: "application/json",
                                data: JSON.stringify({
                                    "type": "updateperdfil",
                                    "idEmpleado": idEmpleado,
                                    "tipoDocumento": $("#tipoDocumento").val(),
                                    "numeroDocumento": $("#numeroDocumento").val().trim(),
                                    "apellidos": $("#apellidos").val().trim(),
                                    "nombres": $("#nombres").val().trim(),
                                    "sexo": $("#sexo").val(),
                                    "fechaNacimiento": $("#fechaNacimiento").val(),
                                    "telefono": $("#telefono").val().trim(),
                                    "celular": $("#celular").val().trim(),
                                    "email": $("#email").val().trim(),
                                    "direccion": $("#direccion").val().trim(),
                                    "codigo": $("#codigo").val().trim(),
                                    "usuario": $("#usuario").val(),
                                    "clave": $("#clave").val()
                                }),
                                beforeSend: function() {                          
                                    tools.ModalAlertInfo('Empleados', 'Procesando petición...');
                                },
                                success: function(result) {
                                    if (result.estado == 1) {
                                        tools.ModalAlertSuccess('Empleados', result.mensaje);                                     
                                    } else {
                                        tools.ModalAlertWarning('Empleados', result.mensaje);
                                    }
                                },
                                error: function(error) {
                                    tools.ModalAlertError("Empleados", error.responseText);
                                }
                            });
                        }
                    });
                }
            }
        </script>
    </body>

    </html>

<?php

}
