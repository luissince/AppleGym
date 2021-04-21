function ModalCliente() {

    let tbListaCliente = $("#tbListaCliente");
    let stateCliente = false;
    let totalPaginacionCliente = 0;
    let paginacionCliente = 0;
    let opcionCliente = 0;

    this.init = function() {

        $('#modalLista').on('shown.bs.modal', function() {
            $('#txtSearchLista').trigger('focus')
        })

        $("#btnListaCliente").click(function() {
            $("#modalLista").modal("show");
            loadInitClientes();
        });

        $("#btnCloseModalClientes").click(function() {
            clearModalClientes();
        });

        $("#txtSearchLista").keypress(function() {
            if ($("#txtSearchLista").val().trim() != '') {
                if (!stateCliente) {
                    paginacionCliente = 1;
                    loadTableClientes($("#txtSearchLista").val());
                    opcionCliente = 1;
                }
            }
        });

        $("#btnReloadCliente").click(function() {
            loadInitClientes();
        });

        $("#btnAnteriorCliente").click(function() {
            if (!stateCliente) {
                if (paginacionCliente > 1) {
                    paginacionCliente--;
                    onEventPaginacion();
                }
            }
        });

        $("#btnSiguienteCliente").click(function() {
            if (!stateCliente) {
                if (paginacionCliente < totalPaginacionCliente) {
                    paginacionCliente++;
                    onEventPaginacion();
                }
            }
        });

    }

    function onEventPaginacion() {
        switch (opcionCliente) {
            case 0:
                loadTableClientes("");
                break;
            case 1:
                loadTableClientes($("#txtSearch").val().trim());
                break;
        }
    }

    function loadInitClientes() {
        if (!stateCliente) {
            paginacionCliente = 1;
            loadTableClientes("");
            opcionCliente = 0;
        }
    }

    function loadTableClientes(text) {
        $.ajax({
            url: "../app/cliente/ClienteController.php",
            method: "GET",
            data: {
                "type": "lista",
                "page": paginacionCliente,
                "datos": text
            },
            beforeSend: function() {
                stateCliente = true;
                totalPaginacionCliente = 0;
                tbListaCliente.empty();
                tbListaCliente.append(
                    '<tr role="row" class="odd"><td class="sorting_1" colspan="6" style="text-align:center"><img src="./images/loading.gif" width="100"/><p>cargando información...</p></td></tr>'
                );
            },
            success: function(result) {
                let data = result;
                if (data.estado == 1) {
                    tbListaCliente.empty();
                    if (data.clientes.length == 0) {
                        tbListaCliente.append(
                            '<tr role="row" class="odd"><td class="sorting_1" colspan="6" style="text-align:center"><p>No hay datos para mostrar.</p></td></tr>'
                        );
                        $("#lblPaginaActualCliente").html(0);
                        $("#lblPaginaSiguienteCliente").html(0);
                        stateCliente = false;
                    } else {
                        for (let cliente of data.clientes) {

                            let membresia = cliente.membresia >= 1 ? '<span class="badge badge-pill badge-success">' + cliente.membresia + " ACTIVA(S)" + '</span><br>' : '';
                            let porvencer = cliente.porvencer >= 1 ? '<span class="badge badge-pill badge-warning">' + cliente.porvencer + " POR VENCER" + '</span><br>' : '';
                            let vencidas = cliente.vencidas >= 1 ? '<span class="badge badge-pill badge-danger">' + cliente.porvencer + " VENCIDA(S)" + '</span>' : '';
                            let traspaso = cliente.traspado >= 1 ? '<span class="badge badge-pill badge-danger">' + cliente.traspado + " TRASPASO(S)" + '</span>' : '';

                            tbListaCliente.append('<tr ondblclick="onSelectCliente(\'' + cliente.idCliente + '\',\'' + cliente.apellidos + '\',\'' + cliente.nombres + '\')" role="row" >' +
                                '<td class="sorting_1">' + cliente.id + '</td>' +
                                '<td>' + cliente.dni + '<br>' + cliente.apellidos + " " + cliente.nombres + '</td>' +
                                '<td>' + cliente.celular + '</td>' +
                                '<td>' + membresia + ' ' + porvencer + ' ' + vencidas + ' ' + traspaso + '</td>' +
                                '<td>' + (cliente.venta == 1 ? cliente.venta + " deuda(s)" : "0 deudas") + '</td>' +
                                '<td>' + cliente.descripcion + '</td>' +
                                '</tr>');
                        }
                        totalPaginacionCliente = parseInt(Math.ceil((parseFloat(data.total) / parseInt(
                            10))));
                        $("#lblPaginaActualCliente").html(paginacionCliente);
                        $("#lblPaginaSiguienteCliente").html(totalPaginacionCliente);
                        stateCliente = false;
                    }


                } else {
                    tbListaCliente.empty();
                    tbListaCliente.append(
                        '<tr role="row" class="odd"><td class="sorting_1" colspan="6" style="text-align:center"><p>' +
                        data.mensaje + '</p></td></tr>');
                    $("#lblPaginaActualCliente").html(0);
                    $("#lblPaginaSiguienteCliente").html(0);
                    stateCliente = false;
                }
            },
            error: function(error) {
                tbListaCliente.empty();
                tbListaCliente.append(
                    '<tr role="row" class="odd"><td class="sorting_1" colspan="6" style="text-align:center"><p>' +
                    error.responseText + '</p></td></tr>');
                $("#lblPaginaActualCliente").html(0);
                $("#lblPaginaSiguienteCliente").html(0);
                stateCliente = false;
            }
        });
    }

    onSelectCliente = function(id, apellidos, nombres) {
        idCliente = id;
        $("#clienteDatos").val(apellidos + " " + nombres)
        $("#modalLista").modal("hide")
    }

    function clearModalClientes() {
        $("#modalLista").modal("hide");
        tbListaCliente.empty();
    }

}