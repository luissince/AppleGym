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
            <h1><i class="fa fa-shopping-cart"></i> Punto de Venta</h1>
        </div>

        <!-- modal nuevo/update Cliente  -->
        <div class="row">
            <div class="modal fade" id="modalCobro" data-backdrop="static">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">
                                <i class="fa fa-handshake-o"></i> Cobrar
                            </h4>
                            <button type="button" class="close" id="btnCloseModal">
                                <i class="fa fa-close"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="col-md-12">
                                <div class="form-group text-center">
                                    <p class="h5">TOTAL A PAGAR: <b class="h5 text-info">S/ 100.00</b></p>
                                </div>
                            </div>
                            <p>Tipos de pago</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group text text-center">
                                        <button type="button" class="btn btn-info" id="btnContado">
                                            <i class="fa fa-money"></i> Contado</button>
                                        <button type="button" class="btn btn-light" id="btnCredito">
                                            <i class="fa fa-hourglass-half"></i> Credito</button>
                                    </div>
                                    <div class="accordion" id="accordionExample">
                                        <div class="card">
                                            <div class="card-header" id="headingOne">
                                                <h2 class="mb-0">
                                                    <button class="btn btn-link btn-block text-left" type="button"
                                                        data-toggle="collapse" data-target="#collapseOne"
                                                        aria-expanded="true" aria-controls="collapseOne">
                                                        Efectivo
                                                    </button>
                                                </h2>
                                            </div>

                                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                                data-parent="#accordionExample">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <div class="form-group text-right">
                                                                <h6 class="form-control-sm">Monto: <i
                                                                        class="fa fa-fw fa-asterisk text-danger"></i>
                                                                </h6>
                                                                
                                                                <h6 class="form-control-sm">vuelto</h6>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <div class="form-group">
                                                                <input id="monto" type="number" name="monto"
                                                                    class="form-control  form-control-sm" required="">
                                                                
                                                                <h6 class="form-control-sm">vuelto</h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="headingTwo">
                                                <h2 class="mb-0">
                                                    <button class="btn btn-link btn-block text-left collapsed"
                                                        type="button" data-toggle="collapse" data-target="#collapseTwo"
                                                        aria-expanded="false" aria-controls="collapseTwo">
                                                        Tarjeta
                                                    </button>
                                                </h2>
                                            </div>
                                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                                data-parent="#accordionExample">
                                                <div class="card-body">
                                                    Descripción de la tarjeta
                                                </div>
                                            </div>
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


        <div class="row bg-white  pt-3 pb-3">
            <div class="col-md-9">

                <div class="form-group text-left">
                    <button class="btn btn-success" type="button" id="btnPlan"><i class="fa fa-file"></i>
                        Planes</button>
                    <button class="btn btn-success" type="button" id="btnProducto"><i class="fa fa-plus"></i>
                        Productos</button>
                </div>
                <div class="form-group d-flex">
                    <input type="search" class="form-control" placeholder="Cliente..." aria-controls="sampleTable"
                        id="txtCliente" disabled>
                    <button class="btn btn-info" type="button" id="btnBuscar"><i class="fa fa-search"></i></button>
                </div>

                <table class="table table-hover table-bordered dataTable no-footer" id="sampleTable" role="grid"
                    aria-describedby="sampleTable_info">
                    <thead>
                        <tr role="row">
                            <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1"
                                style="width: 100px;">Nombre</th>
                            <th class="sorting_asc" aria-controls="sampleTable" rowspan="1" colspan="1"
                                style="width: 72px;">Cantidad</th>
                            <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1"
                                style="width: 72px;">Precio</th>
                            <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1"
                                style="width: 72px;">Descuento</th>
                            <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1"
                                style="width: 72px;">Total</th>
                            <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1"
                                style="width: 50px;">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="">
                        <!-- tbLista -->
                        <tr role="row" class="odd">
                            <td class="sorting_1">Airi Satou</td>
                            <td>10</td>
                            <td>S/ 20.00</td>
                            <td>0</td>
                            <td>S/ 200.00</td>
                            <td>
                                <button class="btn btn-warning btn-sm"> <i class="fa fa-wrench"></i> Editar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
            <div class="col-md-3">
                <p><b>Dettall del Cobro</b></p>
                <hr>

                <div class="form-group">
                    <button class="form-control btn btn-success d-flex" id="btnCobrar">
                        <label>Cobrar: </label>
                        <div class="text-right">
                            <label>S/ 200.00</label>
                        </div>
                    </button>
                </div>

                <div class="form-group">
                    <!-- <label for="genero">Seleccione el comprobante: <i class="fa fa-fw fa-asterisk text-danger"></i></label> -->
                    <select id="comprobante" class="form-control form-control-sm">
                        <option value="0">Seleccione comprobante</option>
                        <option value="0">Tiket</option>
                        <option value="1">Boleta</option>
                        <option value="2">Factura</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="subTotal">Sub total: </label> <span>S/ 10.00</span>
                </div>
                <div class="form-group">
                    <label for="subTotal">Descuento: </label> <span>S/ 00.00</span>
                </div>
                <div class="form-group">
                    <label for="subTotal">Total: </label> <span>S/ 10.00</span>
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

    $(document).ready(function() {

        loadInitClientes();

        $('#modalCobro').on('shown.bs.modal', function() {
            // $('#dni').trigger('focus')
        })

        $("#btnCobrar").click(function() {
            $("#modalCobro").modal("show");
            // $("#titulo-modal").append('<i class="fa fa-user-plus"></i> Registrar Cliente')
            // $('#dni').trigger('focus')
        })

        $("#btnCancelModal").click(function() {
            //closeClearModal()
            $("#modalCobro").modal("hide")
        })

        $("#btnCloseModal").click(function() {
            //closeClearModal()
            $("#modalCobro").modal("hide")

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
                registrarCliente($("#dni").val(), $("#apellidos").val(), $("#nombres").val(), $(
                        "#genero").val(),
                    $("#nacimiento").val(), $("#codigo").val(), $("#email").val(), $("#celular")
                    .val(),
                    $("#direccion").val())
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
                loadTableClientes($("#txtSearch").val().trim());
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

                        tbLista.append('<tr role="row" class="odd">' +
                            '<td class="sorting_1">' + cliente.id + '</td>' +
                            '<td>' + cliente.dni + '</td>' +
                            '<td>' + cliente.apellidos + " " + cliente.nombres + '</td>' +
                            '<td>' + cliente.celular + '</td>' +
                            '<td>' + cliente.email + '</td>' +
                            '<td>' + cliente.direccion + '</td>' +
                            '<td>' + (cliente.membresia == 1 ? cliente.membresia + " MEMBRESIA(S)" :
                                "NINGUNA") + "<br>" + (cliente.venta == 1 ? cliente.venta +
                                " deuda(s)" : "0 deudas") + '</td>' +
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
                    state = false;
                }
            },
            error: function(error) {
                tbLista.empty();
                tbLista.append(
                    '<tr role="row" class="odd"><td class="sorting_1" colspan="8" style="text-align:center"><p>' +
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
                if (result.estado == 1) {
                    tools.AlertSuccess("Mensaje", result.mensaje);
                    loadInitClientes();
                    $("#btnGuardarModal").empty();
                    $("#btnGuardarModal").append('<i class="fa fa-save"></i> Guardar');
                    closeClearModal();
                } else {
                    tools.AlertWarning("Mensaje", result.mensaje);
                    $("#btnGuardarModal").empty();
                    $("#btnGuardarModal").append('<i class="fa fa-save"></i> Guardar');
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