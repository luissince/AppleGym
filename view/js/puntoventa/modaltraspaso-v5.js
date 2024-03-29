function ModalTraspaso() {

    let tbMembresiaTraspaso = $("#tbMembresiaTraspaso");
    let cbListaMembresiaCliente = $("#cbListaMembresiaCliente");

    this.init = function () {
        $("#btnCloseModalTraspaso").click(function () {
            $("#modalTraspaso").modal("hide")
        });

        $("#btnTraspaso").click(function () {
            if (idCliente == '') {
                tools.AlertWarning("Ventas: ", "Seleccione un cliente.");
            } else {
                $("#modalTraspaso").modal("show");
                listaClientesTraspaso();
            }
        });

        $("#cbClienteTraspaso").append('<option value="">- Seleccione un Cliente-</option>');

        $('#cbClienteTraspaso').on('select2:select', function (e) {
            var data = e.params.data;
            tablaCLienteTraspaso(data.id);
        });

        $("#cbUsarMembresia").change(function () {
            if ($("#cbUsarMembresia").is(":checked")) {
                $("#cbListaMembresiaCliente").prop("disabled", false);
            } else {
                $("#cbListaMembresiaCliente").prop("disabled", true);
            }
        });

    }

    function listaClientesTraspaso() {
        $.ajax({
            url: "../app/cliente/ClienteController.php",
            method: "GET",
            data: {
                "type": "listatraspaso",
                "idCliente": idCliente
            },
            beforeSend: function () {
                $("#lblTextOverlayTraspaso").html("Cargando información...");
                $("#divOverlayTraspaso").removeClass("d-none");
                $('#cbClienteTraspaso').empty();
                tbMembresiaTraspaso.empty();
                cbListaMembresiaCliente.empty();
            },
            success: function (result) {
                let data = result;
                if (data.estado == 1) {
                    $("#cbClienteTraspaso").append('<option value="">- Seleccione un Cliente -</option>');
                    for (let cliente of data.clientes) {
                        $("#cbClienteTraspaso").append('<option value="' + cliente.idCliente + '">' + cliente.apellidos + ', ' + cliente.nombres + '</option>');
                    }
                    $('#cbClienteTraspaso').select2();

                    $("#divOverlayTraspaso").addClass("d-none");
                } else {
                    $("#cbClienteTraspaso").append('<option value="">- Seleccione un Cliente -</option>');
                    $("#lblTextOverlayTraspaso").html(result.mensaje);
                }
            },
            error: function (error) {
                $("#cbClienteTraspaso").append('<option value="">- Seleccione un Cliente -</option>');
                $("#lblTextOverlayTraspaso").html(error.responseText);
            }
        });
    }

    function tablaCLienteTraspaso(dni) {
        $.ajax({
            url: "../app/cliente/ClienteController.php",
            method: "GET",
            data: {
                "type": "listatraspasomem",
                "dni": dni,
                "idCliente": idCliente
            },
            beforeSend: function () {
                tbMembresiaTraspaso.empty();
                tbMembresiaTraspaso.append(
                    '<tr role="row" class="odd"><td class="sorting_1" colspan="7" style="text-align:center"><img src="./images/loading.gif" width="100"/><p>Cargando información...</p></td></tr>'
                );
                cbListaMembresiaCliente.empty();
            },
            success: function (result) {
                let data = result;
                tbMembresiaTraspaso.empty();
                if (data.estado == 1) {
                    if (data.traspasos.length == 0) {
                        tbMembresiaTraspaso.append(
                            '<tr role="row" class="odd"><td class="sorting_1" colspan="7" style="text-align:center"><p>No hay datos para mostrar.</p></td></tr>'
                        );
                    } else {
                        for (let value of data.traspasos) {
                            let Costo = '<input class= "form-control" type="text" onkeypress="onKeyPressTable(this)" placeholder="Precio S/." id="txt' + value.idMembresia + '">';
                            let traspaso = '<button class="btn btn-success" type="button" onclick="addTraspaso(\'' + value.idMembresia + '\',\'' + value.plan + '\',\'' + value.fechaInicio + '\',\'' + value.fechaFin + '\')"><i class="fa fa-sign-in"></i>Traspaso</button>';
                            tbMembresiaTraspaso.append('<tr role="row" class="odd">' +
                                '<td>' + value.id + '</td>' +
                                '<td>' + value.plan + '</td>' +
                                '<td>' + value.fechaInicio + '</td>' +
                                '<td>' + value.fechaFin + '</td>' +
                                '<td>' + value.dias + '</td>' +
                                '<td>' + Costo + '</td>' +
                                '<td>' + traspaso + '</td>' +
                                '</tr>');
                        }

                        cbListaMembresiaCliente.append('<option value="">- Seleccione una membresia -</option>');
                        for (let value of data.membresias) {
                            cbListaMembresiaCliente.append('<option value="' + value.idMembresia + '">' + value.plan + " (" + (value.membresia == 1 ? 'ACTIVO' : value.membresia == 2 ? 'POR VENCER' : value.membresia == 3 ? 'TRASPASO' : 'VENCIDO') + ")" + '</option>');
                        }
                        cbListaMembresiaCliente.select2();
                    }
                } else {
                    tbMembresiaTraspaso.append(
                        '<tr role="row" class="odd"><td class="sorting_1" colspan="7" style="text-align:center"><p>' + result.mensaje + '</p></td></tr>'
                    );
                }
            },
            error: function (error) {
                tbMembresiaTraspaso.empty();
                tbMembresiaTraspaso.append(
                    '<tr role="row" class="odd"><td class="sorting_1" colspan="7" style="text-align:center"><p>' + error.responseText + '</p></td></tr>'
                );
            }
        });
    }

    onKeyPressTable = function (value) {
        var key = window.Event ? event.which : event.keyCode;
        var c = String.fromCharCode(key);
        if ((c < '0' || c > '9') && (c != '\b') && (c != '.')) {
            event.preventDefault();
        }
        if (c == '.' && value.value.includes(".")) {
            event.preventDefault();
        }
    }


    addTraspaso = function (idMembresia, plan, fechaInicio, fechaFinal) {
        let txtCosto = $("#txt" + idMembresia);
        if (!tools.isNumeric(txtCosto.val())) {
            tools.AlertWarning("Traspaso: ", "Ingrese un Precio.")
            txtCosto.focus();
        } else if ($("#cbUsarMembresia").is(":checked") && $('#cbListaMembresiaCliente').has('option').length <= 0 || $("#cbUsarMembresia").is(":checked") && $('#cbListaMembresiaCliente').val() == '') {
            tools.AlertWarning("Traspaso: ", "Seleccione la membresia a utilizar.")
            $('#cbListaMembresiaCliente').focus();
        } else {
            if (!validateDatelleVenta(idMembresia)) {
                listaVenta.push({
                    "idPlan": idMembresia,
                    "nombre": "Traspaso de " + plan,
                    "membresia": $("#cbUsarMembresia").is(":checked") ? $('#cbListaMembresiaCliente').val() : "",
                    "cantidad": 1,
                    "precio": parseFloat(txtCosto.val()),
                    "descuento": 0,
                    "fechaInico": fechaInicio,
                    "horaInicio": tools.getCurrentTime(),
                    "fechaFin": fechaFinal,
                    "horaFin": tools.getCurrentTime(),
                    "procedencia": 3,
                });
                listarDetalleVenta();
                $("#modalTraspaso").modal("hide");
            } else {
                tools.AlertWarning("Ventas: ", "Ya existe un traspaso con las mismas caracteristicas.")
            }
        }
    }

}