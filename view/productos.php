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
                    <h1><i class="fa fa-shopping-bag"></i> Productos</h1>
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

                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#profile" role="tab" data-toggle="tab">Información</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#buzz" role="tab" data-toggle="tab">Detalle</a>
                                        </li>
                                    </ul>

                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane fade in active show" id="profile">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="clave">Clave: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                        <input id="clave" type="text" class="form-control" placeholder="Ingrese la clave">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="claveAlterna">Clave Alterna: </label>
                                                        <input id="claveAlterna" type="text" class="form-control" placeholder="Ingrese la clave alterna">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="nombre">Nombre: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                        <input id="nombre" type="text" class="form-control" placeholder="Ingrese el nombre del producto">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="categoria">Categoria: </label>
                                                        <select id="categoria" class="form-control">
                                                            <option value="Golosinas">Golosinas</option>
                                                            <option value="Bebidas">Bebidas</option>
                                                            <option value="Snacks">Snacks</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="buzz">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="impuesto">Impuesto: </label>
                                                        <select id="impuesto" class="form-control">
                                                            <option value="Ninguno">Ninguno</option>
                                                            <option value="I.G.V.">I.G.V.</option>
                                                            <option value="I.S.C.">I.S.C.</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="costo">Costo: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                        <input id="costo" type="text" class="form-control" placeholder="Ingrese el costo del producto">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="precio">Precio: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                        <input id="precio" type="text" class="form-control" placeholder="Ingrese el precio del producto">
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
                </div>

                <div class="row">
                    <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                        <div class="form-group">
                            <input type="search" class="form-control" placeholder="Buscar por nombre" id="txtSearch">
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
                                <table class="table table-hover table-bordered ">
                                    <thead>
                                        <tr role="row">
                                            <th width="5%">#</th>
                                            <th width="20%">Clave / Nombre</th>
                                            <th width="10%">Cantidad</th>
                                            <th width="10%">Precio</th>
                                            <th width="10%">Categoria</th>
                                            <th width="10%">Estado</th>
                                            <th width="10%">Editar</th>
                                            <th width="10%">Eliminar</th>
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

            let idProducto = 0;

            $(document).ready(function() {

                loadInitProductos();

                $("#clave").keypress(function() {
                    var key = window.Event ? event.which : event.keyCode;
                    var c = String.fromCharCode(key);
                    if ((c < '0' || c > '9') && (c != '\b') && (c < 'a' || c > 'z') && (c < 'A' || c > 'Z')) {
                        event.preventDefault();
                    }
                });

                $("#claveAlterna").keypress(function() {
                    var key = window.Event ? event.which : event.keyCode;
                    var c = String.fromCharCode(key);
                    if ((c < '0' || c > '9') && (c != '\b') && (c < 'a' || c > 'z') && (c < 'A' || c > 'Z')) {
                        event.preventDefault();
                    }
                });

                $("#costo").keypress(function() {
                    var key = window.Event ? event.which : event.keyCode;
                    var c = String.fromCharCode(key);
                    if ((c < '0' || c > '9') && (c != '\b') && (c != '.')) {
                        event.preventDefault();
                    }
                    if (c == '.' && $("#costo").val().includes(".")) {
                        event.preventDefault();
                    }
                });

                $("#precio").keypress(function() {
                    var key = window.Event ? event.which : event.keyCode;
                    var c = String.fromCharCode(key);
                    if ((c < '0' || c > '9') && (c != '\b') && (c != '.')) {
                        event.preventDefault();
                    }
                    if (c == '.' && $("#precio").val().includes(".")) {
                        event.preventDefault();
                    }
                });

                $("#btnAdd").click(function() {
                    $("#titulo-modal").empty();
                    $("#titulo-modal").append("Registrar Producto");
                    $("#modalCliente").modal("show");
                });

                $("#btnGuardarModal").click(function() {
                    crudProducto()
                });

                $("#btnGuardarModal").keypress(function(event) {
                    if (event.keyCode === 13) {
                        crudProducto()
                    }
                    event.preventDefault();
                });

                $("#btnCancelModal").click(function() {
                    $("#modalCliente").modal("hide");
                    clearComponents();
                });

                $("#btnCloseModal").click(function() {
                    $("#modalCliente").modal("hide");
                    clearComponents();
                });

                $("#btnReload").click(function() {
                    loadInitProductos();
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
                            listaProductos($("#txtSearch").val().trim());
                            opcion = 1;
                        }
                    }
                });

            });

            function onEventPaginacion() {
                switch (opcion) {
                    case 0:
                        listaProductos("");
                        break;
                    case 1:
                        listaProductos($("#txtSearch").val().trim());
                        break;
                }
            }


            function loadInitProductos() {
                if (!state) {
                    paginacion = 1;
                    listaProductos("");
                    opcion = 0;
                }
            }


            function listaProductos(text) {
                $.ajax({
                    url: "../app/productos/Obtener_Productos.php",
                    method: "",
                    data: {
                        "page": paginacion,
                        "datos": text
                    },
                    beforeSend: function() {
                        state = true;
                        tbLista.empty();
                        tbLista.append(
                            '<tr role="row" class="odd"><td class="sorting_1" colspan="7" style="text-align:center"><img src="./images/loading.gif" width="100"/><p>cargando información...</p></td></tr>'
                        );
                    },
                    success: function(result) {
                        let data = result;
                        if (data.estado == 1) {
                            tbLista.empty();
                            for (let producto of data.productos) {
                                let estado = producto.estado == "Activo" ? '<span class="badge badge-pill badge-success">' + producto.estado + '</span>' : '<span class="badge badge-pill badge-danger">' + producto.estado + '</span>';
                                tbLista.append('<tr role="row" class="odd">' +
                                    '<td class="text-center">' + producto.id + '</td>' +
                                    '<td>' + producto.clave + '<br>' + producto.nombre + '</td>' +
                                    '<td class="text-right">' + tools.formatMoney(producto.cantidad) + '</td>' +
                                    '<td class="text-right">' + tools.formatMoney(producto.precio) + '</td>' +
                                    '<td>' + producto.categoria + '</td>' +
                                    '<td class="text-center">' + estado + '</td>' +
                                    '<td class="text-center"><button class="btn btn-warning btn-sm" onclick="loadUpdateProducto(\'' + producto.idProducto + '\')"><i class="fa fa-edit"></i> Editar</button></td>' +
                                    '<td class="text-center"><button class="btn btn-danger btn-sm" onclick="eliminarProducto(\'' + producto.idProducto + '\')"><i class="fa fa-trash"></i> Eliminar</button></td>' +
                                    '</tr>');
                            }
                            totalPaginacion = parseInt(Math.ceil((parseFloat(data.total) / parseInt(
                                5))));
                            $("#lblPaginaActual").html(paginacion);
                            $("#lblPaginaSiguiente").html(totalPaginacion);
                            state = false;
                        } else {
                            tbLista.empty();
                            tbLista.append(
                                '<tr role="row" class="odd"><td class="sorting_1" colspan="7" style="text-align:center"><p>' +
                                data.mensaje + '</p></td></tr>');
                            $("#lblPaginaActual").html(0);
                            $("#lblPaginaSiguiente").html(0);
                            state = false;
                        }
                    },
                    error: function(error) {
                        tbLista.empty();
                        tbLista.append(
                            '<tr role="row" class="odd"><td class="sorting_1" colspan="7" style="text-align:center"><p>' +
                            error.responseText + '</p></td></tr>');
                        $("#lblPaginaActual").html(0);
                        $("#lblPaginaSiguiente").html(0);
                        state = false;
                    }
                });
            }

            function crudProducto() {
                if ($("#clave").val().trim() == '') {
                    $("#clave").focus();
                } else if ($("#nombre").val().trim() == '') {
                    $("#nombre").focus();
                } else if (!tools.isNumeric($("#costo").val().trim())) {
                    $("#costo").focus();
                } else if (!tools.isNumeric($("#precio").val().trim())) {
                    $("#precio").focus();
                } else {
                    tools.ModalDialog('Producto', '¿Está seguro de continuar?', 'question', function(result) {
                        if (result) {
                            $.ajax({
                                url: "../app/productos/Crud_Productos.php",
                                method: "POST",
                                accepts: "application/json",
                                contentType: "application/json",
                                data: JSON.stringify({
                                    "idProducto": idProducto,
                                    "clave": $("#clave").val().trim(),
                                    "claveAlterna": $("#claveAlterna").val().trim(),
                                    "nombre": $("#nombre").val().trim(),
                                    "categoria": $("#categoria").val(),
                                    "impuesto": $("#impuesto").val(),
                                    "cantidad": 0,
                                    "costo": parseFloat($("#costo").val()),
                                    "precio": parseFloat($("#precio").val()),
                                    "estado": $("#estado").val(),
                                }),
                                beforeSend: function() {
                                    $("#modalCliente").modal("hide")
                                    clearComponents()
                                    tools.ModalAlertInfo('Producto', 'Procesando petición...');
                                },
                                success: function(result) {
                                    if (result.estado == 1) {
                                        tools.ModalAlertSuccess('Producto', result.mensaje);
                                        loadInitProductos();
                                    } else if (result.estado == 2) {
                                        tools.ModalAlertWarning('Producto', result.mensaje);
                                    } else if (result.estado == 3) {
                                        tools.ModalAlertWarning('Producto', result.mensaje);
                                    } else {
                                        tools.ModalAlertWarning('Producto', result.mensaje);
                                    }
                                },
                                error: function(error) {
                                    tools.ModalAlertError("Producto", error.responseText);
                                }
                            });
                        }
                    });
                }
            }

            function loadUpdateProducto(id) {
                $("#titulo-modal").empty();
                $("#titulo-modal").append("Editar Producto");
                $("#modalCliente").modal("show");
                $.ajax({
                    url: "../app/productos/Obtener_Productos_By_Id.php",
                    method: "POST",
                    accepts: "application/json",
                    contentType: "application/json",
                    data: JSON.stringify({
                        "idProducto": id
                    }),
                    beforeSend: function() {
                        tools.AlertInfo("Producto", "Cargando datos..");
                    },
                    success: function(result) {
                        if (result.estado == 1) {
                            idProducto = id;
                            $("#clave").val(result.producto.clave)
                            $("#claveAlterna").val(result.producto.claveAlterna)
                            $("#nombre").val(result.producto.nombre)
                            $("#categoria").val(result.producto.categoria)
                            $("#impuesto").val(result.producto.impuesto)
                            $("#costo").val(result.producto.costo)
                            $("#precio").val(result.producto.precio)
                            $("#estado").val(result.producto.estado)
                            tools.AlertSuccess("Producto", "Se cargo correctamento los datos.");
                        } else {
                            tools.AlertWarning("Producto", result.mensaje);
                        }
                    },
                    error: function(error) {
                        tools.AlertError("Producto", error.responseText);
                    }
                });
            }

            function eliminarProducto(idProducto) {
                tools.ModalDialog('Producto', '¿Está seguro de eliminar el producto?', 'question', function(result) {
                    if (result) {
                        $.ajax({
                            url: "../app/productos/Eliminar_Producto.php",
                            method: "POST",
                            accepts: "application/json",
                            contentType: "application/json",
                            data: JSON.stringify({
                                "idProducto": idProducto
                            }),
                            beforeSend: function() {
                                $("#modalCliente").modal("hide")
                                clearComponents()
                                tools.ModalAlertInfo('Producto', 'Procesando petición...');
                            },
                            success: function(result) {
                                if (result.estado == 1) {
                                    tools.ModalAlertSuccess('Producto', result.mensaje);
                                    loadInitProductos();
                                } else {
                                    tools.ModalAlertWarning('Producto', result.mensaje);
                                }
                            },
                            error: function(error) {
                                tools.ModalAlertError("Producto", error.responseText);
                            }
                        });
                    }
                });
            }

            function clearComponents() {
                $("#titulo-modal").empty();
                $("#clave").val("")
                $("#claveAlterna").val("")
                $("#nombre").val("")
                $("#categoria").val("Golosinas")
                $("#impuesto").val("Ninguno")
                $("#costo").val("")
                $("#precio").val("")
                $("#estado").val("Activo")
                idProducto = 0;
            }
        </script>
    </body>

    </html>

<?php
}
