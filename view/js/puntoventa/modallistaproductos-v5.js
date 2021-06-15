function ModalListaProductos() {


    let tbListaProductos = $("#tbListaProductos");
    let totalPaginacionProducto = 0;
    let paginacionProducto = 0;
    let opcionProducto = 0;
    let stateProducto = false;

    this.init = function() {

        $("#modalProductos").on('shown.bs.modal', function() {
            $("#txtSearProducto").focus();
        });

        $("#txtSearProducto").keyup(function() {
            if ($("#txtSearProducto").val().trim() != '') {
                if (!stateProducto) {
                    paginacionProducto = 1;
                    loadTableProductos($("#txtSearProducto").val().trim());
                    opcionProducto = 1;
                }
            }
        });

        $("#btnReloadProductos").click(function() {
            loadInitProductos();
        });

        $("#btnProductos").click(function() {
            $("#modalProductos").modal("show")
            loadTableProductos($("#txtSearProducto").val())
        });

        $("#btnAnteriorProductos").click(function() {
            if (!stateProducto) {
                if (paginacionProducto > 1) {
                    paginacionProducto--;
                    onEventPaginacion();
                }
            }
        });

        $("#btnSiguienteProductos").click(function() {
            if (!stateProducto) {
                if (paginacionProducto < totalPaginacionProducto) {
                    paginacionProducto++;
                    onEventPaginacion();
                }
            }
        });


        $("#btnCloseModalProductos").click(function() {
            $("#modalProductos").modal("hide")
        });


        loadInitProductos();
    }

    function onEventPaginacion() {
        switch (stateProducto) {
            case 0:
                loadTableProductos("");
                break;
            case 1:
                loadTableProductos($("#txtSearch").val().trim());
                break;
        }
    }

    function loadInitProductos() {
        if (!stateProducto) {
            paginacionProducto = 1;
            loadTableProductos("");
            opcionProducto = 0;
        }
    }


    function loadTableProductos(text) {
        $.ajax({
            url: "../app/productos/ProductoController.php",
            method: "GET",
            data: {
                "type": "lista",
                "page": paginacionProducto,
                "datos": text
            },
            beforeSend: function() {
                stateProducto = true;
                totalPaginacionProducto = 0;
                tbListaProductos.empty();
                tbListaProductos.append(
                    '<tr role="row" class="odd"><td class="sorting_1" colspan="5" style="text-align:center"><img src="./images/loading.gif" width="100"/><p>Cargando información...</p></td></tr>'
                );
            },
            success: function(result) {
                tbListaProductos.empty();
                let data = result;
                if (data.estado == 1) {

                    if (data.productos.length == 0) {
                        tbListaProductos.append(
                            '<tr role="row" class="odd"><td class="sorting_1" colspan="5" style="text-align:center">No datos para mostrar.<p></p></td></tr>'
                        );
                        $("#lblPaginaActualProductos").html(0);
                        $("#lblPaginaSiguienteProductos").html(0);
                        stateProducto = false;
                    } else {
                        for (let producto of data.productos) {
                            tbListaProductos.append('<tr role="row" class="odd" ondblclick="onSelectProducto(\'' + producto.idProducto + '\',\'' + producto.nombre + '\',\'' + producto.precio + '\')">' +
                                '<td class="text-center">' + producto.id + '</td>' +
                                '<td>' + producto.clave + '<br>' + producto.nombre + '</td>' +
                                '<td>' + producto.categoria + '</td>' +
                                '<td class="text-right">' + tools.formatMoney(producto.cantidad) + '</td>' +
                                '<td class="text-right">' + tools.formatMoney(producto.precio) + '</td>' +
                                '</tr>');
                        }
                        totalPaginacionProducto = parseInt(Math.ceil((parseFloat(data.total) / parseInt(
                            10))));
                        $("#lblPaginaActualProductos").html(paginacionProducto);
                        $("#lblPaginaSiguienteProductos").html(totalPaginacionProducto);
                        stateProducto = false;
                    }

                } else {
                    tbListaProductos.append(
                        '<tr role="row" class="odd"><td class="sorting_1" colspan="5" style="text-align:center"><p>' +
                        data.mensaje + '</p></td></tr>');
                    $("#lblPaginaActualProductos").html(0);
                    $("#lblPaginaSiguienteProductos").html(0);
                    stateProducto = false;
                }
            },
            error: function(error) {
                tbListaProductos.empty();
                tbListaProductos.append(
                    '<tr role="row" class="odd"><td class="sorting_1" colspan="5" style="text-align:center"><p>' +
                    error.responseText + '</p></td></tr>');
                $("#lblPaginaActualProductos").html(0);
                $("#lblPaginaSiguienteProductos").html(0);
                stateProducto = false;
            }
        });
    }


    onSelectProducto = function(idProducto, nombre, precio) {
        if (!validateDatelleVenta(idProducto)) {
            listaVenta.push({
                "idPlan": idProducto,
                "nombre": nombre,
                "membresia": 0,
                "cantidad": 1,
                "precio": parseFloat(precio),
                "descuento": 0,
                "fechaInico": tools.getCurrentDate(),
                "horaInicio": tools.getCurrentTime(),
                "fechaFin": tools.getCurrentDate(),
                "horaFin": tools.getCurrentTime(),
                "procedencia": 2,
            });
            listarDetalleVenta();
        } else {

            for (let i = 0; i < listaVenta.length; i++) {
                if (listaVenta[i].idPlan == idProducto) {
                    let currenteObject = listaVenta[i];
                    currenteObject.cantidad += 1;
                    break;
                }
            }
            listarDetalleVenta();
        }
        $("#modalProductos").modal("hide");
    }

}