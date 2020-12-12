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
                <h1><i class="fa fa-calendar"></i> Planes</h1>
            </div>
        </div>
        <div class="tile mb-4">

            <!-- modal nuevo/update Productos  -->
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
                                    <button class="tablinks" onclick="selectTab(event, 'basico')">Básico</button>
                                    <button class="tablinks"
                                        onclick="selectTab(event, 'disciplina')">Disciplina</button>
                                </div>

                                <div id="basico" class="tabcontent">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="nombre">Nombre: <i
                                                        class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="nombre" type="text" name="nombre" class="form-control"
                                                    placeholder="Ingrese el nombre" required="" minlength="8">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="meses">Duración(Meses): <i
                                                        class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="meses" type="number" name="meses" class="form-control"
                                                    placeholder="Ingrese la número de meses" required="" minlength="8">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="dias">Duración(Dias): <i
                                                        class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="dias" type="number" name="dias" class="form-control"
                                                    placeholder="Ingrese la número de dias" required="" minlength="8">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="dias">Duración(Dias): <i
                                                        class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="dias" type="number" name="dias" class="form-control"
                                                    placeholder="Ingrese la número de dias" required="" minlength="8">
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="freeze">Freeze: <i
                                                        class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="freeze" type="number" name="freeze" class="form-control"
                                                    placeholder="Ingrese los dias libres" required="" minlength="8">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="precio">Precio: <i
                                                        class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                <input id="precio" type="number" name="precio" class="form-control"
                                                    placeholder="Ingrese el precio" required="" minlength="8">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="descripcion">Descripción: </label>
                                                <input id="descripcion" type="text" name="descripcion"
                                                    class="form-control" placeholder="Ingrese la descripción"
                                                    required="" minlength="8">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <label for="estado">Activo: </label>
                                                <input id="estado" type="checkbox" name="estado"
                                                    class="form-control form-form-control-sm">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="prueba">Prueba: </label>
                                                <input id="prueba" type="checkbox" name="prueba"
                                                    class="form-control form-form-control-sm">
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div id="disciplina" class="tabcontent">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="text-center">Tipos de Plan</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="ilimitado">Ilimitado: </label>
                                                <input id="ilimitado" type="radio" name="ilimitado"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-16">
                                            <div class="form-group">
                                                <label for="ilimitado">Sesiones por disciplina: </label>
                                                <input id="ilimitado" type="radio" name="ilimitado"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Disciplinas</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <select id="estado" class="form-control">
                                                    <option value="">Selecciona una disciplina</option>
                                                    <option value="Maquinas">Maquinas</option>
                                                    <option value="Baile">Baile</option>
                                                    <option value="Sauna">Sauna</option>
                                                    <option value="Otro">Otro...</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <button type="button" class="btn btn-success"
                                                    id="btnAgregar">Agregar</button>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-hover table-bordered dataTable no-footer"
                                                id="sampleTable" role="grid" aria-describedby="sampleTable_info">
                                                <thead>
                                                    <tr role="row">
                                                        <th class="sorting" aria-controls="sampleTable" rowspan="1"
                                                            colspan="1" style="width: 20px;">Nombre</th>
                                                        <th class="sorting_asc" aria-controls="sampleTable" rowspan="1"
                                                            colspan="1" style="width: 250px;">Sesiones
                                                        </th>
                                                        <th class="sorting" aria-controls="sampleTable" rowspan="1"
                                                            colspan="1" style="width: 75px;">Opción
                                                        </th>

                                                    </tr>
                                                </thead>
                                                <tbody id="">
                                                    <!-- tbLista -->
                                                    <tr>
                                                        <td>maquinas</td>
                                                        
                                                        <td>
                                                            <input type="number" class="form-control" placeholder="Ingrese el # de sesiones">
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-danger btn-sm"><i
                                                                    class="fa fa-times"></i></button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
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
                    <input type="search" class="form-control" placeholder="Buscar por nombre o codigo"
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
                                                            colspan="1" style="width: 250px;">Nombre</th>
                                                        <th class="sorting" aria-controls="sampleTable" rowspan="1"
                                                            colspan="1" style="width: 75px;">Precio
                                                        </th>
                                                        <th class="sorting" aria-controls="sampleTable" rowspan="1"
                                                            colspan="1" style="width: 72px;">Tiempo</th>
                                                        <th class="sorting" aria-controls="sampleTable" rowspan="1"
                                                            colspan="1" style="width: 72px;">Freeze</th>
                                                        <th class="sorting" aria-controls="sampleTable" rowspan="1"
                                                            colspan="1" style="width: 72px;">Descripción</th>
                                                        <th class="sorting" aria-controls="sampleTable" rowspan="1"
                                                            colspan="1" style="width: 72px;">Estado</th>
                                                        <th class="sorting" aria-controls="sampleTable" rowspan="1"
                                                            colspan="1" style="width: 72px;">Prueba</th>
                                                        <th class="sorting" aria-controls="sampleTable" rowspan="1"
                                                            colspan="1" style="width: 59px;">Opciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="">
                                                    <!-- tbLista -->
                                                    <tr>
                                                        <td>1</td>
                                                        <td>Premiun</td>
                                                        <td>S/ 10</td>
                                                        <td>1 Mes con 0 días</td>
                                                        <td>0</td>
                                                        <td>puede ingresar todos los días a cualquier horario</td>
                                                        <td>Activo</td>
                                                        <td>Si</td>
                                                        <td>
                                                            <button class="btn btn-warning btn-sm"><i
                                                                    class="fa fa-wrench"></i> Editar</button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-5">
                                            <div class="dataTables_info" id="sampleTable_info" role="status"
                                                aria-live="polite">Mostrando de 1 a 10 producto(s) de (2)</div>
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
            $("#titulo-modal").append('<i class="fa fa-calendar"></i> Registrar Planes')
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
            url: "../app/cliente/Obtener_Clientes.php",
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