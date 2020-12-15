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

            <!-- <div class="app-title">
            <h1><i class="fa fa-user"></i> Perfil del Cliente</h1>
        </div> -->

            <div class="row">

                <div class="col-xl-4 col-lg-5 col-md-12 col-sm-12 col-12 bg-secondary text-center">
                    <div class="p-2">
                        <img class="img-fluid rounded-circle" src="./images/noimage.png" style="width:100%;max-width: 260px;">
                        <div class="text-center">
                            <h6 class="text-white pt-2" id="nombreCompleto"></h6>
                        </div>
                    </div>
                </div>

                <div class="col-xl-8 col-lg-7 col-md-12 col-sm-12 col-12">
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
                <div class="col-xl-2 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="tile p-0">
                        <ul class="nav flex-column nav-tabs user-tabs">
                            <li class="nav-item"><a class="nav-link active" href="#menbresia" data-toggle="tab">Membresias</a></li>
                            <li class="nav-item"><a class="nav-link" href="#asistencias" data-toggle="tab">Asistencias</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-10 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="tab-content">

                        <div class="tab-pane active " id="menbresia">
                            <div class="tile p-3">
                                <div class="bs-component text-right">
                                    <button class="btn btn-success" type="button" id="btnReporte"><i class="fa fa-file"></i>
                                        Reporte</button>
                                    <button class="btn btn-success" type="button" id="btnRenovar"><i class="fa fa-line-chart"></i>
                                        Renovar</button>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="table-responsive pl-3 pr-3">
                                        <table class="table table-hover table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1" style="width: 5%;">#</th>
                                                    <th class="sorting_asc" aria-controls="sampleTable" rowspan="1" colspan="1" style="width: 15%;">Membresia</th>
                                                    <th class="sorting_asc" aria-controls="sampleTable" rowspan="1" colspan="1" style="width: 15%;">Plan</th>
                                                    <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1" style="width: 15%;">Comprobante</th>
                                                    <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1" style="width: 20%;">Duración</th>
                                                    <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1" style="width: 10%;">Estado</th>
                                                    <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1" style="width: 15%;">Importe</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbListaMembresia">
                                                <!-- tbLista -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="tab-pane fade" id="asistencias">
                            <div class="tile p-3">
                                <div class="bs-component text-right">
                                    <button class="btn btn-success" type="button" id="btnRecargar"><i class="fa fa-refresh"></i>
                                        Recargar</button>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="table-responsive pl-3 pr-3">
                                        <table class="table table-hover table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1" style="width: 5%;">#</th>
                                                    <th class="sorting_asc" aria-controls="sampleTable" rowspan="1" colspan="1" style="width: 10%;">Plan</th>
                                                    <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1" style="width: 15%;">Duración</th>
                                                    <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1" style="width: 10%;">Fecha/Hora de Ingreso</th>
                                                    <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1" style="width: 10%;">Fecha/Hora de Salida</th>
                                                </tr>
                                            </thead>
                                            <tbody id="">
                                                <!-- tbLista -->
                                            </tbody>
                                        </table>
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

            // let tbLista = $("#tbLista");
            // let opcion = 0;
            // let state = false;

            let tbListaMembresia = $("#tbListaMembresia")
            let totalPaginacion = 0;
            let paginacion = 0;
            let idCliente = "<?php echo  $_GET["idCliente"]; ?>"

            $(document).ready(function() {

                loadDataCliente(idCliente);
                initTableMembresia()
            })

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
                        "idCliente": idCurrentClient
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

            function initTableMembresia() {
                paginacion = 1;
                loadTableMembresias(idCliente);
            }

            function loadTableMembresias(id) {

                $.ajax({
                    url: "../app/membresias/Obtener_Membresia_Por_Cliente.php",
                    method: "GET",
                    data: {
                        page: paginacion,
                        idCliente: id
                    },
                    beforeSend: function() {
                        // state = true;
                        tbListaMembresia.empty();
                        tbListaMembresia.append(
                            '<tr role="row" class="odd"><td class="sorting_1" colspan="9" style="text-align:center"><img src="./images/loading.gif" width="100"/><p>cargando información...</p></td></tr>'
                        );

                    },
                    success: function(result) {
                        if (result.estado == 1) {
                            let count = 0;
                            tbListaMembresia.empty();
                            for (let membresia of result.membresias) {
                                let estadoMembresia = membresia.membresia == 1 ? '<span class="badge badge-pill badge-success">Activa</span>' : '<span class="badge badge-pill badge-danger">Finalizada</span>';
                                let estado = membresia.estadoventa == 1 ? '<span class="badge badge-pill badge-success">pagado</span>' : '<span class="badge badge-pill badge-danger">Pendiente</span>';

                                count++;
                                tbListaMembresia.append('<tr role="row" class="odd">' +
                                    '<td class="sorting_1">' + count + '</td>' +
                                    '<td>' + estadoMembresia + '</td>' +
                                    '<td>' + membresia.nombre + '</td>' +
                                    '<td>' + membresia.serie + "-" + membresia.numeracion + '</td>' +
                                    '<td>Del ' + tools.getDateForma(membresia.fechaInicio) + ' al ' + tools.getDateForma(membresia.fechaFin) + '</td>' +
                                    '<td>' + estado + '</td>' +
                                    '<td>' + tools.formatMoney(membresia.total, 2) + '</td>' +
                                    '</tr>');
                            }
                            totalPaginacion = parseInt(Math.ceil((parseFloat(result.total) / parseInt(
                                10))));
                            $("#lblPaginaActual").html(paginacion);
                            $("#lblPaginaSiguiente").html(totalPaginacion);
                            // state = false;
                        } else {
                            tbListaMembresia.empty();
                            tbListaMembresia.append(
                                '<tr role="row" class="odd"><td class="sorting_1" colspan="9" style="text-align:center"><p>' +
                                result.mensaje + '</p></td></tr>');
                            // state = false;
                        }
                    },
                    error: function(error) {
                        tbListaMembresia.empty();
                        tbListaMembresia.append(
                            '<tr role="row" class="odd"><td class="sorting_1" colspan="9" style="text-align:center"><p>' +
                            error.responseText + '</p></td></tr>');
                        // state = false;
                    }
                });
            }
        </script>
    </body>

    </html>

<?php
}
