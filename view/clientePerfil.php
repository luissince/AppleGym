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

<body class="app sidebar-mini">
    <!-- Navbar-->
    <?php include "./layout/header.php";?>
    <!-- Sidebar menu-->
    <?php include "./layout/menu.php";?>
    <main class="app-content">

        <!-- <div class="app-title">
            <h1><i class="fa fa-user"></i> Perfil del Cliente</h1>
        </div> -->

        <div class="row">

            <div class="col-md-3 bg-secondary">
                <div class="p-2">
                    <img class="img-fluid rounded-circle" src="./images/sport.jpg">
                    <div class="text-center">
                        <h6 class="text-white pt-2" id="nombreCompleto"></h6>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="fondoImg p-3">
                    <div class="bg-white p-3 rounded font-weight-bold">
                        <h4><i class="fa fa-user"></i> Perfil del Cliente <span id="loading"></span></h4>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-text">DNI:</label>
                            </div>
                            <div class="col-md-9">
                                <label class="form-text" id="dni"></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-text">Celular:</label>
                            </div>
                            <div class="col-md-9">
                                <label class="form-text" id="celular"></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-text">Email:</label>
                            </div>
                            <div class="col-md-9">
                                <label class="form-text" id="email"></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-text">Fecha de Nacimiento:</label>
                            </div>
                            <div class="col-md-9">
                                <label class="form-text" id="nacimiento"></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-text">Dirección:</label>
                            </div>
                            <div class="col-md-9">
                                <label class="form-text" id="direccion"></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row user">
            <div class="col-md-3">
                <div class="tile p-0">
                    <ul class="nav flex-column nav-tabs user-tabs">
                        <li class="nav-item"><a class="nav-link active" href="#menbresia"
                                data-toggle="tab">Membresias</a></li>
                        <li class="nav-item"><a class="nav-link" href="#asistencias" data-toggle="tab">Asistencias</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-9">
                <div class="tab-content">

                    <div class="tab-pane active " id="menbresia">
                        <div class="tile p-3">
                            <div class="bs-component text-right">
                                <button class="btn btn-success" type="button" id="btnReporte"><i class="fa fa-file"></i>
                                    Reporte</button>
                                <button class="btn btn-success" type="button" id="btnRenovar"><i
                                        class="fa fa-line-chart"></i>
                                    Renovar</button>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-text">Precio:</label>
                                </div>
                                <div class="col-md-9">
                                    <label class="form-text">S/ 10.00</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-text">Desde - Hasta:</label>
                                </div>
                                <div class="col-md-9">
                                    <label class="form-text">11/11/2020 - 12/12/2020</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-text">Tiempo:</label>
                                </div>
                                <div class="col-md-9">
                                    <label class="form-text">Meses, Días, Freeze</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-text">Desciplinas:</label>
                                </div>
                                <div class="col-md-9">
                                    <label class="form-text">...</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-text">Descripción:</label>
                                </div>
                                <div class="col-md-9">
                                    <label class="form-text">...</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-text">Estado:</label>
                                </div>
                                <div class="col-md-9">
                                    <label class="form-text">Inhabilitado</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="asistencias">
                        <div class="tile p-3">
                            <div class="bs-component text-right">
                                <button class="btn btn-success" type="button" id="btnRecargar"><i
                                        class="fa fa-refresh"></i>
                                    Recargar</button>
                            </div>
                            <br>
                            <div class="row">
                                <div class="table-responsive pl-3 pr-3">
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1"
                                                    style="width: 59px;">#</th>
                                                <th class="sorting_asc" aria-controls="sampleTable" rowspan="1"
                                                    colspan="1" style="width: 107px;">Dni</th>
                                                <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1"
                                                    style="width: 250px;">Apellidos y Nombres</th>
                                                <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1"
                                                    style="width: 72px;">Celular</th>
                                                <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1"
                                                    style="width: 72px;">Email</th>
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
                                        <tbody id="">
                                            <!-- tbLista -->
                                        </tbody>
                                    </table>
                                </div </div>
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

    // let tbLista = $("#tbLista");
    // let totalPaginacion = 0;
    // let paginacion = 0;
    // let opcion = 0;
    // let state = false;

    let idCliente = "<?php echo  $_GET["idCliente"]; ?>"

    $(document).ready(function() {

        $('#external-events .fc-event').each(function() {

            // store data so the calendar knows to render an event upon drop
            $(this).data('event', {
                title: $.trim($(this).text()), // use the element's text as the event title
                stick: true // maintain when user navigates (see docs on the renderEvent method)
            });

            // make the event draggable using jQuery UI
            $(this).draggable({
                zIndex: 999,
                revert: true, // will cause the event to go back to its
                revertDuration: 0 //  original position after the drag
            });

        });

        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            editable: true,
            droppable: true, // this allows things to be dropped onto the calendar
            drop: function() {
                // is the "remove after drop" checkbox checked?
                if ($('#drop-remove').is(':checked')) {
                    // if so, remove the element from the "Draggable Events" list
                    $(this).remove();
                }
            }
        });


        loadDataCliente(idCliente);

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

    // function loadInitClientes() {
    //     if (!state) {
    //         paginacion = 1;
    //         loadTableClientes();
    //         opcion = 0;
    //     }
    // }


    // function loadTableClientes() {
    //     $.ajax({
    //         url: "../app/cliente/Obtener_Clientes.php",
    //         method: "",
    //         data: {
    //             opcion: 1,
    //             page: paginacion,
    //             datos: ''
    //         },
    //         beforeSend: function() {
    //             state = true;
    //             tbLista.empty();
    //             tbLista.append(
    //                 '<tr role="row" class="odd"><td class="sorting_1" colspan="8" style="text-align:center"><img src="./images/loading.gif" width="100"/><p>cargando información...</p></td></tr>'
    //             );
    //         },
    //         success: function(result) {
    //             let data = JSON.parse(result);
    //             if (data.estado == 1) {
    //                 let count = 0;
    //                 tbLista.empty();
    //                 for (let cliente of data.clientes) {

    //                     let btnUpdate =
    //                         '<button class="btn btn-warning btn-sm" onclick="loadUpdateCliente(\'' +
    //                         cliente.idCliente + '\')">' +
    //                         '<i class="fa fa-wrench"></i> Editar' +
    //                         '</button>';

    //                     count++;
    //                     tbLista.append('<tr role="row" class="odd">' +
    //                         '<td class="sorting_1">' + count + '</td>' +
    //                         '<td>' + cliente.dni + '</td>' +
    //                         '<td>' + cliente.apellidos + " " + cliente.nombres + '</td>' +
    //                         '<td>' + cliente.celular + '</td>' +
    //                         '<td>' + cliente.email + '</td>' +
    //                         '<td>' + cliente.direccion + '</td>' +
    //                         '<td>' + cliente.membresia + '</td>' +
    //                         '<td>' + cliente.predeterminado + '</td>' +
    //                         '<td>' + btnUpdate + '</td>' +
    //                         '</tr>');
    //                 }
    //                 totalPaginacion = parseInt(Math.ceil((parseFloat(data.total) / parseInt(
    //                     10))));
    //                 $("#lblPaginaActual").html(paginacion);
    //                 $("#lblPaginaSiguiente").html(totalPaginacion);
    //                 state = false;
    //             } else {
    //                 tbLista.empty();
    //                 tbLista.append(
    //                     '<tr role="row" class="odd"><td class="sorting_1" colspan="8" style="text-align:center"><p>' +
    //                     data.mensaje + '</p></td></tr>');
    //                 state = false;
    //             }
    //         },
    //         error: function(error) {
    //             tbLista.empty();
    //             tbLista.append(
    //                 '<tr role="row" class="odd"><td class="sorting_1" colspan="8" style="text-align:center"><p>' +
    //                 error.responseText + '</p></td></tr>');
    //             state = false;
    //         }
    //     });
    // }


    // function registrarCliente(dni, apellidos, nombres, genero, nacimiento, codigo, email, celular, direccion) {

    //     $.ajax({
    //         url: "../app/cliente/Crud_Clientes.php",
    //         method: "POST",
    //         accepts: "application/json",
    //         contentType: "application/json",
    //         data: JSON.stringify({
    //             "idCliente": idClienteUpdate,
    //             "dni": dni,
    //             "apellidos": (apellidos.toUpperCase()).trim(),
    //             "nombres": (nombres.toUpperCase()).trim(),
    //             "sexo": genero,
    //             "fechaNacimiento": nacimiento,
    //             "codigo": (codigo.toUpperCase()).trim(),
    //             "email": email.trim(),
    //             "celular": celular,
    //             "direccion": (direccion.toUpperCase()).trim()
    //         }),
    //         beforeSend: function() {
    //             $("#btnGuardarModal").empty();
    //             $("#btnGuardarModal").append('<img src="./images/loading.gif" width="25" height="25" />')
    //         },
    //         success: function(result) {
    //             console.log(result)
    //             if (result.estado == 1) {
    //                 tools.AlertSuccess("Mensaje", result.mensaje)
    //                 setTimeout(function() {
    //                     location.href = "./clientes.php"
    //                 }, 1000);
    //                 closeClearModal();
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
    //             $("#btnGuardarModal").append('<i class="fa fa-save"></i> Guardar')

    //         }
    //     });
    // }

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

    function loadDataCliente(idCurrentClient) {
        // $("#modalCliente").modal("show");
        // $("#titulo-modal").append('<i class="fa fa-user"></i> Editar Cliente');
        // idCliente = idCurrentClient;

        $.ajax({
            url: "../app/cliente/Obtener_Clientes_By_Id.php",
            method: "POST",
            accepts: "application/json",
            contentType: "application/json",
            data: JSON.stringify({
                "idCliente": idCliente
            }),
            beforeSend: function() {
                $("#loading").empty();
                $("#loading").append('<img src="./images/loading.gif" width="25" height="25" />')
            },
            success: function(result) {
                // console.log(result)
                if (result.estado == 1) {

                    let cliente = result.cliente;
                    $("#nombreCompleto").append((cliente.nombres + ' ' + cliente.apellidos).toUpperCase())
                    $("#dni").append(cliente.dni)
                    $("#celular").append(cliente.celular)
                    $("#email").append(cliente.email)
                    document.getElementById("nacimiento").innerHTML = tools.getDateForma(cliente
                        .fechaNacimiento, 'yyyy-mm-dd')
                    $("#direccion").append(cliente.direccion)

                    tools.AlertSuccess("Mensaje", 'Se cargaron correctamente los datos')
                    $("#loading").empty();

                } else {
                    tools.AlertWarning("Mensaje", result.mensaje)
                    setTimeout(function() {
                        $("#loading").empty();

                    }, 1000);
                }

            },
            error: function(error) {
                tools.AlertError("Error", error.responseText);
                $("#loading").empty();
            }
        });
    }
    </script>
</body>

</html>

<?php
}