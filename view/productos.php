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

            <!-- Sidebar menu-->
            <?php include "./marcarentrada.php"; ?>

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
                                <div class="tile p-0">

                                    <div class="overlay d-none" id="divOverlayCategoria">
                                        <div class="m-loader mr-4">
                                            <svg class="m-circular" viewBox="25 25 50 50">
                                                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle>
                                            </svg>
                                        </div>
                                        <h4 class="l-text" id="lblTextOverlayCategoria">Cargando información...</h4>
                                    </div>

                                    <div class="tile-body">
                                        <ul class="nav nav-tabs mb-2" role="tablist">
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
                                                            <label for="txtClave">Clave: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                            <input id="txtClave" type="text" class="form-control" placeholder="Ingrese la clave">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="txtClaveAlterna">Clave Alterna: </label>
                                                            <input id="txtClaveAlterna" type="text" class="form-control" placeholder="Ingrese la clave alterna">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="txtNombre">Nombre: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                            <input id="txtNombre" type="text" class="form-control" placeholder="Ingrese el nombre del producto">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="cbCategoria">Categoria: </label>
                                                            <select id="cbCategoria" class="form-control">
                                                                <option value="">- Selecciona -</option>
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
                                                            <label for="txtCosto">Costo: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                            <input id="txtCosto" type="text" class="form-control" placeholder="Ingrese el costo del producto">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="txtPrecio">Precio: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                            <input id="txtPrecio" type="text" class="form-control" placeholder="Ingrese el precio del producto">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="cbEstado">Estado: </label>
                                                            <select id="cbEstado" class="form-control">
                                                                <option value="Activo">Activo</option>
                                                                <option value="Inactivo">Inactivo</option>
                                                            </select>
                                                        </div>
                                                    </div>
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

            <div class="app-title">
                <div>
                    <h1><i class="fa fa-shopping-bag"></i> Productos</h1>
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

                $("#btnAdd").click(function() {
                    addProducto();
                });

                $("#btnAdd").keypress(function(event) {
                    if (event.keyCode == 13) {
                        addProducto();
                    }
                    event.preventDefault();
                });

                $("#btnReload").click(function() {
                    loadInitProductos();
                });

                $("#btnReload").keypress(function(event) {
                    if (event.keyCode == 13) {
                        loadInitProductos();
                    }
                    event.preventDefault();
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
                            loadTableProductos($("#txtSearch").val().trim());
                            opcion = 1;
                        }
                    }
                });

                modalProductosEventos();

                loadInitProductos();

            });

            function modalProductosEventos() {

                $("#txtCosto").keypress(function() {
                    var key = window.Event ? event.which : event.keyCode;
                    var c = String.fromCharCode(key);
                    if ((c < '0' || c > '9') && (c != '\b') && (c != '.')) {
                        event.preventDefault();
                    }
                    if (c == '.' && $("#txtCosto").val().includes(".")) {
                        event.preventDefault();
                    }
                });

                $("#txtPrecio").keypress(function() {
                    var key = window.Event ? event.which : event.keyCode;
                    var c = String.fromCharCode(key);
                    if ((c < '0' || c > '9') && (c != '\b') && (c != '.')) {
                        event.preventDefault();
                    }
                    if (c == '.' && $("#txtPrecio").val().includes(".")) {
                        event.preventDefault();
                    }
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
                    clearComponents();
                });

                $("#btnCancelModal").keypress(function(event) {
                    if (event.keyCode === 13) {
                        clearComponents();
                    }
                    event.preventDefault();
                });

                $("#btnCloseModal").click(function() {
                    clearComponents();
                });

                $("#btnCloseModal").keypress(function() {
                    if (event.keyCode === 13) {
                        clearComponents();
                    }
                    event.preventDefault();
                });

            }

            function onEventPaginacion() {
                switch (opcion) {
                    case 0:
                        loadTableProductos("");
                        break;
                    case 1:
                        loadTableProductos($("#txtSearch").val().trim());
                        break;
                }
            }

            function loadInitProductos() {
                if (!state) {
                    paginacion = 1;
                    loadTableProductos("");
                    opcion = 0;
                }
            }

            function loadTableProductos(text) {
                $.ajax({
                    url: "../app/productos/ProductoController.php",
                    method: "GET",
                    data: {
                        "type": "lista",
                        "page": paginacion,
                        "datos": text
                    },
                    beforeSend: function() {
                        state = true;
                        tbLista.empty();
                        tbLista.append(
                            '<tr role="row" class="odd"><td class="sorting_1" colspan="8" style="text-align:center"><img src="./images/loading.gif" width="100"/><p>cargando información...</p></td></tr>'
                        );
                        totalPaginacion = 0;
                    },
                    success: function(result) {
                        let data = result;
                        if (data.estado == 1) {
                            tbLista.empty();
                            if (data.productos.length == 0) {
                                tbLista.append(
                                    '<tr role="row" class="odd"><td class="sorting_1" colspan="8" style="text-align:center"><p>No hay datos para mostrar.</p></td></tr>');
                                $("#lblPaginaActual").html(0);
                                $("#lblPaginaSiguiente").html(0);
                                state = false;
                            } else {
                                for (let producto of data.productos) {
                                    let estado = producto.estado == "Activo" ? '<span class="badge badge-pill badge-success">' + producto.estado + '</span>' : '<span class="badge badge-pill badge-danger">' + producto.estado + '</span>';
                                    tbLista.append('<tr role="row" class="odd">' +
                                        '<td class="text-center">' + producto.id + '</td>' +
                                        '<td>' + producto.clave + '<br>' + producto.nombre + '</td>' +
                                        '<td class="text-right">' + tools.formatMoney(producto.cantidad) + '</td>' +
                                        '<td class="text-right">' + tools.formatMoney(producto.precio) + '</td>' +
                                        '<td>' + producto.categoria + '</td>' +
                                        '<td class="text-center">' + estado + '</td>' +
                                        '<td class="text-center"><button class="btn btn-warning btn-sm" onclick="updateProducto(\'' + producto.idProducto + '\')"><i class="fa fa-edit"></i> Editar</button></td>' +
                                        '<td class="text-center"><button class="btn btn-danger btn-sm" onclick="deleteProducto(\'' + producto.idProducto + '\')"><i class="fa fa-trash"></i> Eliminar</button></td>' +
                                        '</tr>');
                                }
                                totalPaginacion = parseInt(Math.ceil((parseFloat(data.total) / parseInt(
                                    5))));
                                $("#lblPaginaActual").html(paginacion);
                                $("#lblPaginaSiguiente").html(totalPaginacion);
                                state = false;
                            }
                        } else {
                            tbLista.empty();
                            tbLista.append(
                                '<tr role="row" class="odd"><td class="sorting_1" colspan="8" style="text-align:center"><p>' +
                                data.mensaje + '</p></td></tr>');
                            $("#lblPaginaActual").html(0);
                            $("#lblPaginaSiguiente").html(0);
                            state = false;
                        }
                    },
                    error: function(error) {
                        tbLista.empty();
                        tbLista.append(
                            '<tr role="row" class="odd"><td class="sorting_1" colspan="8" style="text-align:center"><p>' +
                            error.responseText + '</p></td></tr>');
                        $("#lblPaginaActual").html(0);
                        $("#lblPaginaSiguiente").html(0);
                        state = false;
                    }
                });
            }

            function addProducto() {
                $("#titulo-modal").empty();
                $("#titulo-modal").append("Registrar Producto");
                $("#modalCliente").modal("show");
                $.ajax({
                    url: "../app/productos/ProductoController.php",
                    method: "GET",
                    data: {
                        "type": "getregistro"
                    },
                    beforeSend: function() {
                        $("#lblTextOverlayCategoria").html("Cargando información...");
                        $("#divOverlayCategoria").removeClass("d-none");
                        $("#cbCategoria").empty();
                    },
                    success: function(result) {
                        if (result.estado == 1) {
                            $("#cbCategoria").append('<option value="">- Seleccione -</option>');
                            for (let categoria of result.categorias) {
                                $("#cbCategoria").append('<option value="' + categoria.idCategoria + '">' + categoria.nombre + '</option>');
                            }
                            $("#divOverlayCategoria").addClass("d-none");
                        } else {
                            $("#lblTextOverlayCategoria").html(result.mensaje);
                        }
                    },
                    error: function(error) {
                        $("#lblTextOverlayCategoria").html(error.responseText);
                    }
                });
            }

            function crudProducto() {
                if ($("#txtClave").val().trim() == '') {
                    $("#txtClave").focus();
                } else if ($("#txtNombre").val().trim() == '') {
                    $("#txtNombre").focus();
                } else if ($("#cbCategoria").val() == '') {
                    $("#cbCategoria").focus();
                } else if (!tools.isNumeric($("#txtCosto").val().trim())) {
                    $("#txtCosto").focus();
                } else if (!tools.isNumeric($("#txtPrecio").val().trim())) {
                    $("#txtPrecio").focus();
                } else {
                    tools.ModalDialog('Producto', '¿Está seguro de continuar?', 'question', function(result) {
                        if (result) {
                            $.ajax({
                                url: "../app/productos/ProductoController.php",
                                method: "POST",
                                accepts: "application/json",
                                contentType: "application/json",
                                data: JSON.stringify({
                                    "type": "crud",
                                    "idProducto": idProducto,
                                    "clave": $("#txtClave").val().trim(),
                                    "claveAlterna": $("#txtClaveAlterna").val().trim(),
                                    "nombre": $("#txtNombre").val().trim(),
                                    "categoria": $("#cbCategoria").val(),
                                    "impuesto": $("#impuesto").val(),
                                    "cantidad": 0,
                                    "costo": parseFloat($("#txtCosto").val()),
                                    "precio": parseFloat($("#txtPrecio").val()),
                                    "estado": $("#cbEstado").val(),
                                }),
                                beforeSend: function() {
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

            function updateProducto(id) {
                $("#titulo-modal").empty();
                $("#titulo-modal").append("Editar Producto");
                $("#modalCliente").modal("show");
                $.ajax({
                    url: "../app/productos/ProductoController.php",
                    method: "GET",
                    data: {
                        "type": "getbyid",
                        "idProducto": id
                    },
                    beforeSend: function() {
                        $("#lblTextOverlayCategoria").html("Cargando información...");
                        $("#divOverlayCategoria").removeClass("d-none");
                        $("#cbCategoria").empty();
                    },
                    success: function(result) {
                        if (result.estado == 1) {
                            $("#cbCategoria").append('<option value="">- Seleccione -</option>');
                            for (let categoria of result.categorias) {
                                $("#cbCategoria").append('<option value="' + categoria.idCategoria + '">' + categoria.nombre + '</option>');
                            }

                            idProducto = id;
                            $("#txtClave").val(result.producto.clave)
                            $("#txtClaveAlterna").val(result.producto.claveAlterna)
                            $("#txtNombre").val(result.producto.nombre)
                            $("#cbCategoria").val(result.producto.idCategoria)
                            $("#impuesto").val(result.producto.impuesto)
                            $("#txtCosto").val(result.producto.costo)
                            $("#txtPrecio").val(result.producto.precio)
                            $("#cbEstado").val(result.producto.estado)
                            $("#divOverlayCategoria").addClass("d-none");
                        } else {
                            $("#cbCategoria").append('<option value="">- Seleccione -</option>');
                            $("#lblTextOverlayCategoria").html(result.mensaje);
                        }
                    },
                    error: function(error) {
                        $("#cbCategoria").append('<option value="">- Seleccione -</option>');
                        $("#lblTextOverlayCategoria").html(error.responseText);
                    }
                });
            }

            function deleteProducto(idProducto) {
                tools.ModalDialog('Producto', '¿Está seguro de eliminar el producto?', 'question', function(result) {
                    if (result) {
                        $.ajax({
                            url: "../app/productos/ProductoController.php",
                            method: "POST",
                            accepts: "application/json",
                            contentType: "application/json",
                            data: JSON.stringify({
                                "type": "delete",
                                "idProducto": idProducto
                            }),
                            beforeSend: function() {
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
                $("#modalCliente").modal("hide");
                $("#titulo-modal").empty();
                $("#txtClave").val("")
                $("#txtClaveAlterna").val("")
                $("#txtNombre").val("")
                $("#impuesto").val("Ninguno")
                $("#txtCosto").val("")
                $("#txtPrecio").val("")
                $("#cbEstado").val("Activo")
                $("#cbCategoria").empty();
                $("#cbCategoria").append('<option value="">- Seleccione -</option>');
                idProducto = 0;
            }
        </script>
    </body>

    </html>

<?php
}
