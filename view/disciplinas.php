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
                    <h1><i class="fa fa-list"></i> Disciplinas</h1>
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
                                                <input id="descripción" type="text" name="descripción" class="form-control" placeholder="Ingrese la descripción" required="" minlength="8">
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
                        <input type="search" class="form-control" placeholder="Buscar por nombre" aria-controls="sampleTable" id="txtSearch">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="tile">
                            <div class="tile-body">
                                <div class="table-responsive">
                                    <div id="sampleTable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                                        <!-- <div class="row">
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
                                    </div> -->
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <table class="table table-hover table-bordered dataTable no-footer" id="sampleTable" role="grid" aria-describedby="sampleTable_info">
                                                    <thead>
                                                        <tr role="row">
                                                            <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1" style="width: 20px;">#</th>
                                                            <th class="sorting_asc" aria-controls="sampleTable" rowspan="1" colspan="1" style="width: 107px;">Nombre</th>
                                                            <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1" style="width: 75px;">Color
                                                            </th>
                                                            <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1" style="width: 250px;">Descripción</th>
                                                            <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1" style="width: 250px;">Estado</th>
                                                            <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1" style="width: 59px;">Opciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbLista">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <!-- <div class="col-sm-12 col-md-5">
                                                <div class="dataTables_info" id="sampleTable_info" role="status" aria-live="polite">Mostrando de 1 a 10 Disciplina(s) de (2)</div>
                                            </div> -->
                                            <div class="col-sm-12 col-md-12">
                                                <div class="dataTables_paginate paging_simple_numbers" id="sampleTable_paginate">
                                                    <ul class="pagination">
                                                        <li class="paginate_button page-item"><a id="lblPaginaActual" aria-controls="sampleTable" data-dt-idx="0" tabindex="0" class="page-link">0</a>
                                                        </li>
                                                        <li class="paginate_button page-item"><a aria-controls="sampleTable" data-dt-idx="1" tabindex="0" class="page-link">a</a></li>
                                                        <li class="paginate_button page-item"><a id="lblPaginaSiguiente" aria-controls="sampleTable" data-dt-idx="7" tabindex="0" class="page-link">0</a>
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
        <?php include "./layout/footer.php"; ?>
        <script>
            let tools = new Tools();

            let tbLista = $("#tbLista");
            let totalPaginacion = 0;
            let paginacion = 0;
            let opcion = 0;
            let state = false;

            $(document).ready(function() {

                //loadInitClientes();

                $('#modalCliente').on('shown.bs.modal', function(event) {

                    //$('#dni').trigger('focus')
                })

                $("#btnAdd").click(function() {
                    $("#modalCliente").modal("show");
                    $("#titulo-modal").append('<i class="fa fa-list"></i> Registrar Disciplinas')
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
                loadInitDisciplinas();
            });



            function loadInitDisciplinas() {
                if (!state) {
                    paginacion = 1;
                    loadTableDisciplinas();
                    opcion = 0;
                }
            }


            function loadTableDisciplinas() {
                $.ajax({
                    url: "../app/disciplinas/Obtener_Disciplinas.php",
                    method: "GET",
                    data: {
                        page: paginacion,
                    },
                    beforeSend: function() {
                        tbLista.empty();
                        tbLista.append(
                            '<tr role="row" class="odd"><td class="sorting_1" colspan="5" style="text-align:center"><img src="./images/loading.gif" width="100"/><p>cargando información...</p></td></tr>'
                        );
                    },
                    success: function(result) {
                        if (result.estado == 1) {
                            count = 0;
                            tbLista.empty();
                            for (disciplina of result.disciplinas) {
                                count++;
                                tbLista.append('<tr>' +
                                    '                 <td>' + count + '</td>' +
                                    '                 <td>' + disciplina.nombre + '</td>' +
                                    '                 <td>' +
                                    '             <input id="colorcito" type="color" value="#ffffff" onchange=""/>' +
                                    '         </td>' +
                                    '         <td>' + disciplina.descripcion + '</td>' +
                                    '         <td>' + (disciplina.estado == 1 ? "Habilitado" : "No Habilitado") + '</td>' +
                                    '         <td>' +
                                    '             <button class="btn btn-warning btn-sm"><i class="fa fa-wrench"></i> Editar</button>' +
                                    '         </td>' +
                                    '     </tr>');
                            }
                            totalPaginacion = parseInt(Math.ceil((parseFloat(result.total) / parseInt(
                                10))));
                            $("#lblPaginaActual").html(paginacion);
                            $("#lblPaginaSiguiente").html(totalPaginacion);
                        } else {
                            tbLista.empty();
                            tbLista.append(
                                '<tr role="row" class="odd"><td class="sorting_1" colspan="8" style="text-align:center"><p>' +
                                data.mensaje + '</p></td></tr>');
                        }
                        console.log(result)
                    },
                    error: function(error) {
                        tbLista.empty();
                        tbLista.append(
                            '<tr role="row" class="odd"><td class="sorting_1" colspan="8" style="text-align:center"><p>' +
                            error.responseText + '</p></td></tr>');
                    }
                });
            }

            function closeClearModal() {


            }
        </script>
    </body>

    </html>

<?php
}
