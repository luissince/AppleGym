<?php
session_start();
if (!isset($_SESSION["IdEmpleado"])) {
    echo '<script>location.href = "./login.php";</script>';
} else {
    if ($_SESSION["Roles"][19]["ver"] == 1) {
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

            <div class="app-title">
                <div>
                    <h1><i class="fa fa-calendar"></i> Datos de mi empresa <spam id="loading"></spam>
                    </h1>
                </div>
            </div>
            <div class="tile mb-4">

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-text">Representante: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <input id="representante" type="text" class="form-control" placeholder="Ingrese el nombre del representante">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-text">Nombre de la empresa: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <input id="empresa" type="text" class="form-control" placeholder="Ingrese el nombre de la empresa">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-text">R.U.C.: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <input id="ruc" type="number" class="form-control" placeholder="Ingrese el numero de RUC">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-text">Teléfono:</label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <input id="telefono" type="text" class="form-control" placeholder="Ingrese el numero de teléfono">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-text">Celular: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <input id="celular" type="number" class="form-control" placeholder="Ingrese el numero de celular">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-text">Email:</label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <input id="email" type="email" class="form-control" placeholder="Ingrese el email">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-text">Pagina web:</label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <input id="web" type="text" class="form-control" placeholder="Ingrese el dominio">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-text">Dirección: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <input id="direccion" type="text" class="form-control" placeholder="Ingrese la dirección">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-text">Términos y condiciones:</label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <input id="terminos" type="text" class="form-control" placeholder="Ingrese la descripción de los términos">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-text text-left text-danger">Todos los campos marcados con <i class="fa fa-fw fa-asterisk text-danger"></i> son obligatorios</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group text-right">
                            <button class="btn btn-success" type="button" id="btnGuardar"><i class="fa fa-save"></i>
                                Guardar</button>
                        </div>
                    </div>
                </div>
            </div>

        </main>
        <!-- Essential javascripts for application to work-->
        <?php include "./layout/footer.php"; ?>
        <script>
            let tools = new Tools();

            // let tbLista = $("#tbLista");
            // let totalPaginacion = 0;
            // let paginacion = 0;
            // let opcion = 0;
            // let idClienteUpdate = "";

            let loading = $("#loading");
            let idMiEmpresa = ''
            let state = false;

            $(document).ready(function() {

                loadDataEmpresa();

                $("#btnGuardar").click(function() {
                    if ($("#representante").val() == '' || $("#representante").val().length < 7) {
                        tools.AlertWarning("Advertencia", "Ingrese un nombre de representante.")
                    } else if ($("#empresa").val() == '' || $("#empresa").val().length < 4) {
                        tools.AlertWarning("Advertencia", "Ingrese un nombre de empresa.")
                    } else if ($("#ruc").val() == '' || $("#ruc").val().length < 8) {
                        tools.AlertWarning("Advertencia", "Ingrese un número de RUC valido.")
                    } else if ($("#celular").val() == '' || $("#celular").val().length < 9) {
                        tools.AlertWarning("Advertencia", "Ingrese un número de celular valido.")
                    } else if ($("#direccion").val() == '') {
                        tools.AlertWarning("Advertencia", "Ingrese una dirección.")
                    } else {

                        tools.ModalDialog('Empresa', '¿Desea guardar los datos?', 'question', function(result) {
                            if (result) {
                                registrarEmpresa($("#representante").val(), $("#empresa").val(), $("#ruc").val(), $("#telefono").val(),
                                    $("#celular").val(), $("#email").val(), $("#web").val(), $("#direccion").val(), $("#terminos").val())
                            }
                        })

                    }
                });

            });


            function loadDataEmpresa() {
                if (!state) {
                    getDataEmpresa();
                }
            }


            function getDataEmpresa() {
                $.ajax({
                    url: "../app/miempresa/Obtener_MiEmpresa.php",
                    method: "",
                    data: {},
                    beforeSend: function() {
                        state = true
                        loading.append('<img src="./images/loading.gif" width="25" height="25"/>')
                    },
                    success: function(result) {

                        let data = JSON.parse(result);
                        let empresa = data.datos[0];
                        if (data.estado == 1) {

                            idMiEmpresa = empresa.idMiEmpresa
                            $("#representante").val(empresa.representante)
                            $("#empresa").val(empresa.nombreEmpresa)
                            $("#ruc").val(empresa.ruc)
                            $("#telefono").val(empresa.telefono)
                            $("#celular").val(empresa.celular)
                            $("#email").val(empresa.email)
                            $("#web").val(empresa.web)
                            $("#direccion").val(empresa.direccion)
                            $("#terminos").val(empresa.terminos)

                            tools.AlertSuccess("Mensaje", 'Se cargaron correctamente los datos')
                            loading.empty();
                            state = false;
                        } else {
                            idMiEmpresa = ''
                            tools.AlertWarning("Mensaje", result.mensaje)
                            loading.empty();
                            state = false;
                        }
                    },
                    error: function(error) {
                        tools.AlertError("Error", error.responseText);
                        loading.empty();
                        state = false;
                    }
                });
            }

            function registrarEmpresa(representante, empresa, ruc, telefono, celular, email, web, direccion, terminos) {

                $.ajax({
                    url: "../app/miempresa/Crud_MiEmpresa.php",
                    method: "POST",
                    accepts: "application/json",
                    contentType: "application/json",
                    data: JSON.stringify({
                        "idMiEmpresa": idMiEmpresa,
                        "representante": (representante.toUpperCase()).trim(),
                        "nombreEmpresa": (empresa.toUpperCase()).trim(),
                        "ruc": ruc,
                        "telefono": telefono,
                        "celular": celular,
                        "email": email.trim(),
                        "paginaWeb": (web.toUpperCase()).trim(),
                        "direccion": (direccion.toUpperCase()).trim(),
                        "terminos": (terminos.toUpperCase()).trim()
                    }),
                    beforeSend: function() {
                        tools.ModalAlertInfo('Disciplinas', 'Procesando petición...');
                    },
                    success: function(result) {
                        if (result.estado == 1) {
                            tools.ModalAlertSuccess('Disciplinas', result.mensaje);

                        } else {
                            tools.ModalAlertWarning('Disciplinas', result.mensaje);
                        }
                    },
                    error: function(error) {
                        tools.ModalAlertError("Disciplinas", error.responseText);
                    }
                });
            }

            // function closeClearModal() {
            //     $("#modalCliente").modal("hide")
            //     $("#titulo-modal").empty()
            //     $("#btnAccion").empty()

            //     $("#dni").val("")
            //     $("#apellidos").val("")
            //     $("#nombres").val("")
            //     $("#genero").val("")
            //     $("#nacimiento").val("")
            //     $("#codigo").val("")
            //     $("#email").val("")
            //     $("#celular").val("")
            //     $("#direccion").val("")
            //     idClienteUpdate = "";
            // }

            // function loadUpdateCliente(idCliente) {
            //     $("#modalCliente").modal("show");
            //     $("#titulo-modal").append('<i class="fa fa-user"></i> Editar Cliente');
            //     idClienteUpdate = idCliente;
            //     $.ajax({
            //         url: "../app/cliente/Obtener_Clientes_By_Id.php",
            //         method: "POST",
            //         accepts: "application/json",
            //         contentType: "application/json",
            //         data: JSON.stringify({
            //             "idCliente": idCliente
            //         }),
            //         beforeSend: function() {
            //             // $("#btnGuardarModal").empty();
            //             // $("#btnGuardarModal").append('<img src="./images/loading.gif" width="25" height="25" />')
            //         },
            //         success: function(result) {
            //             if (result.estado == 1) {
            //                 let cliente = result.cliente;
            //                 $("#dni").val(cliente.dni)
            //                 $("#apellidos").val(cliente.apellidos)
            //                 $("#nombres").val(cliente.nombres)
            //                 $("#genero").val(cliente.sexo)
            //                 document.getElementById("nacimiento").value = tools.getDateForma(cliente
            //                     .fechaNacimiento, 'yyyy-mm-dd')
            //                 $("#codigo").val(cliente.codigo)
            //                 $("#email").val(cliente.email)
            //                 $("#celular").val(cliente.celular)
            //                 $("#direccion").val(cliente.direccion)

            //             } else {
            //                 tools.AlertWarning("Mensaje", result.mensaje)
            //                 setTimeout(function() {
            //                     $("#btnGuardarModal").empty();
            //                     $("#btnGuardarModal").append('<i class="fa fa-save"></i> Guardar')
            //                 }, 1000);
            //             }

            //         },
            //         error: function(error) {
            //             tools.AlertError("Error", error.responseText);
            //             $("#btnGuardarModal").empty();
            //             $("#btnGuardarModal").append('<img src="./images/loading.gif" width="25" height="25" />')
            //         }
            //     });
            // }
        </script>
    </body>

    </html>

<?php
  } else {
    echo '<script>location.href = "./bienvenido.php";</script>';
  }
}
