function ModalPagar() {

    this.init = function () {

        $("#btnCobrar").click(function () {
            if (listaVenta.length == 0) {
                tools.AlertWarning("Ventas: ", "Agregué un plan o producto/servicio para continuar.");
            } else if (idCliente == '') {
                tools.AlertWarning("Ventas: ", "Seleccione un cliente.");
            } else if ($("#comprobante").val() == '') {
                tools.AlertWarning("Venta: ", "Seleccione un comprobante.");
                $("#comprobante").focus();
            } else if (!$("#txtNumeracion").is(':disabled') && !tools.isNumeric($("#txtNumeracion").val())) {
                tools.AlertWarning("Venta: ", "La numeración del comprobante no es un valor numérico.");
                $("#txtNumeracion").focus();
            } else {
                $("#modalCobro").modal("show");
                $("#vuelto").val(tools.formatMoney(total));
                $("#montotarjeta").val(tools.formatMoney(total));
            }
        });

        $("#btnCancelModal").click(function () {
            $("#modalCobro").modal("hide")
        });

        $("#btnCloseModal").click(function () {
            $("#modalCobro").modal("hide")
        });

        $("#monto").keypress(function () {
            var key = window.Event ? event.which : event.keyCode;
            var c = String.fromCharCode(key);
            if ((c < '0' || c > '9') && (c != '\b') && (c != '.')) {
                event.preventDefault();
            }
            if (c == '.' && $("#monto").val().includes(".")) {
                event.preventDefault();
            }
        });

        $("#montocreditotarjeta").keypress(function () {
            var key = window.Event ? event.which : event.keyCode;
            var c = String.fromCharCode(key);
            if ((c < '0' || c > '9') && (c != '\b') && (c != '.')) {
                event.preventDefault();
            }
            if (c == '.' && $("#montocreditotarjeta").val().includes(".")) {
                event.preventDefault();
            }
        });

        $("#monto").keyup(function (event) {
            if (tools.isNumeric($("#monto").val())) {
                montoCambio = Math.abs(parseFloat(total) - parseFloat($("#monto").val()));
                $("#vuelto").val(tools.formatMoney(montoCambio));
                if (parseFloat($("#monto").val()) >= total) {
                    $("#lblPorCobrar").html("Su Vuelto: ");
                } else {
                    $("#lblPorCobrar").html("Por Cobrar: ");
                }
            } else {
                $("#vuelto").val(tools.formatMoney(total));
                $("#lblPorCobrar").html("Por Cobrar: ");
            }
        });

        $("#btnGuardarModal").click(function () {
            registrarVenta();
        });

        $("#btnPlazos").click(function () {
            let currentDate = Date.now();
            $("#tvPlazos").append('<tr id="' + currentDate + '">' +
                '<td><input class="form-control form-control-sm" type="number" /></td>' +
                '<td><input class="form-control form-control-sm" type="date" /></td>' +
                '<td><div class="text-center"><input type="checkbox" /></div></td>' +
                '<td><button class="btn btn-danger" onclick="removePlazos(\'' + currentDate + '\')"><i class="fa fa-trash"></i></button></td>' +
                '</tr>');
        });

    }

    removePlazos = function (idPlazos) {
        $("#" + idPlazos).remove();
    }

    function registrarVenta() {
        if ($("#pills-home-tab").hasClass("active")) {
            if ($("#btnEfectivo").attr('aria-expanded') == 'true') {
                if (!tools.isNumeric($("#monto").val())) {
                    tools.AlertWarning("Venta: ", "Ingrese el monto por favor.");
                    $("#monto").focus();
                } else if (parseFloat($("#monto").val()) < total) {
                    tools.AlertWarning("Venta: ", "El monto ingresado es menor que el total.");
                    $("#monto").focus();
                } else {
                    tools.ModalDialog('Venta', '¿Está seguro de continuar?', 'question', function (value) {
                        if (value) {
                            $.ajax({
                                url: "../app/venta/RegistrarVenta.php",
                                method: 'POST',
                                accepts: "application/json",
                                contentType: "application/json",
                                data: JSON.stringify({
                                    "tipoDocumento": $("#comprobante").val(),
                                    "estadoNumeracion": $("#txtNumeracion").is(':disabled'),
                                    "numracion": $("#txtNumeracion").val(),
                                    "cliente": idCliente,
                                    "vendedor": idEmpleado,
                                    "fecha": tools.getCurrentDate(),
                                    "hora": tools.getCurrentTime(),
                                    "tipo": 1,
                                    "forma": 1,
                                    "numero": "",
                                    "pago": $("#monto").val(),
                                    "vuelto": $("#vuelto").val(),
                                    "estado": 1,
                                    "lista": listaVenta,
                                }),
                                beforeSend: function () {
                                    $("#modalCobro").modal("hide");
                                    clearComponents();
                                    clearPlanes();
                                    tools.ModalAlertInfo('Venta', 'Procesando petición...');
                                },
                                success: function (result) {
                                    if (result.estado == 1) {
                                        tools.ModalAlertSuccess('Venta', result.mensaje);
                                    } else {
                                        tools.ModalAlertWarning('Venta', result.mensaje);
                                    }
                                },
                                error: function (error) {
                                    tools.ModalAlertError('Venta', error.responseText);
                                }
                            });
                        }
                    });
                }
            } else if ($("#btnTarjeta").attr('aria-expanded') == 'true') {
                if (!tools.isNumeric($("#montotarjeta").val())) {
                    tools.AlertWarning("Venta: ", "Ingrese el monto por favor.");
                    $("#montotarjeta").focus();
                } else if ($("#numerotarjeta").val() == '') {
                    tools.AlertWarning("Venta: ", "Ingrese número de la operación.");
                    $("#numerotarjeta").focus();
                } else {
                    tools.ModalDialog('Venta', '¿Está seguro de continuar?', 'question', function (value) {
                        if (value) {
                            $.ajax({
                                url: "../app/venta/RegistrarVenta.php",
                                method: 'POST',
                                accepts: "application/json",
                                contentType: "application/json",
                                data: JSON.stringify({
                                    "tipoDocumento": $("#comprobante").val(),
                                    "estadoNumeracion": $("#txtNumeracion").is(':disabled'),
                                    "numracion": $("#txtNumeracion").val(),
                                    "cliente": idCliente,
                                    "vendedor": idEmpleado,
                                    "fecha": tools.getCurrentDate(),
                                    "hora": tools.getCurrentTime(),
                                    "tipo": 1,
                                    "forma": 2,
                                    "numero": $("#numerotarjeta").val(),
                                    "pago": $("#montotarjeta").val(),
                                    "vuelto": 0,
                                    "estado": 1,
                                    "lista": listaVenta
                                }),
                                beforeSend: function () {
                                    $("#modalCobro").modal("hide");
                                    clearComponents();
                                    clearPlanes();
                                    tools.ModalAlertInfo('Venta', 'Procesando petición...');
                                },
                                success: function (result) {
                                    if (result.estado == 1) {
                                        tools.ModalAlertSuccess('Venta', result.mensaje);
                                    } else {
                                        tools.ModalAlertWarning('Venta', result.mensaje);
                                    }
                                },
                                error: function (error) {
                                    tools.ModalAlertError('Venta', error.responseText);
                                }
                            });
                        }
                    });
                }
            }
        } else {
            if ($("#tvPlazos tr").length == 0) {
                tools.AlertWarning("Ventas: ", "No hay registro registro de plazos para continuar.");
            } else {
                let listaCredito = [];
                let valueMonto = 0;
                let valueFecha = 0;
                let valueInicial = 0;
                let sumMonto = 0;
                $("#tvPlazos tr").each(function (row, tr) {
                    let montoet = $(tr).find("td:eq(0)").find("input").val();
                    let fechet = $(tr).find("td:eq(1)").find("input").val();
                    let initet = $(tr).find("td:eq(2)").find('input[type="checkbox"]').is(':checked');
                    let monto = tools.isNumeric(montoet) ? parseFloat(montoet) : 0;
                    valueMonto += tools.isNumeric(montoet) ? 0 : 1;
                    valueFecha += tools.validateDate(fechet) ? 0 : 1;
                    valueInicial += initet ? 1 : 0;
                    sumMonto += monto;
                    listaCredito.push({
                        "monto": parseFloat(montoet),
                        "fecha": fechet,
                        "hora": tools.getCurrentTime(),
                        "inicial": initet
                    });
                });
                if (valueMonto > 0) {
                    tools.AlertWarning("Ventas: ", "Hay campos en la tabla con valores 0 o no númericos.");
                } else if (valueFecha > 0) {
                    tools.AlertWarning("Ventas: ", "Hay campos de tipo fecha en la tablas sin ingresar.");
                } else if (sumMonto != total) {
                    tools.AlertWarning("Ventas: ", "La suma total no es igual al monto de la tabla.");
                } else if ($("#formapagocredito").val() == '' && valueInicial > 0) {
                    tools.AlertWarning("Ventas: ", "Selecciona la forma de pago.");
                    $("#formapagocredito").focus();
                } else if ($("#numerocreditotarjeta").val() == '' && $("#formapagocredito").val() == '2') {
                    tools.AlertWarning("Ventas: ", "Ingrese el número de la operación");
                    $("#numerocreditotarjeta").focus();
                } else {
                    tools.ModalDialog('Venta', '¿Está seguro de continuar?', 'question', function (value) {
                        if (value) {
                            $.ajax({
                                url: "../app/venta/RegistrarVenta.php",
                                method: 'POST',
                                accepts: "application/json",
                                contentType: "application/json",
                                data: JSON.stringify({
                                    "tipoDocumento": $("#comprobante").val(),
                                    "estadoNumeracion": $("#txtNumeracion").is(':disabled'),
                                    "numracion": $("#txtNumeracion").val(),
                                    "cliente": idCliente,
                                    "vendedor": idEmpleado,
                                    "fecha": tools.getCurrentDate(),
                                    "hora": tools.getCurrentTime(),
                                    "tipo": 2,
                                    "forma": $("#formapagocredito").val(),
                                    "numero": $("#numerocreditotarjeta").val(),
                                    "pago": "0",
                                    "vuelto": "0",
                                    "estado": 2,
                                    "lista": listaVenta,
                                    "credito": listaCredito
                                }),
                                beforeSend: function () {
                                    $("#modalCobro").modal("hide");
                                    clearComponents();
                                    clearPlanes();
                                    tools.ModalAlertInfo('Venta', 'Procesando petición...');
                                },
                                success: function (result) {
                                    if (result.estado == 1) {
                                        tools.ModalAlertSuccess('Venta', result.mensaje);
                                    } else {
                                        tools.ModalAlertWarning('Venta', result.mensaje);
                                    }
                                },
                                error: function (error) {
                                    tools.ModalAlertError('Venta', error.responseText);
                                }
                            });
                        }
                    });
                }
            }
        }
    }


}