function ModalRenovacion() {
    let listaPlanesRenovar = [];
    let planRenovar = {};

    this.init = function() {
        $("#btnRenovar").click(function() {
            if (idCliente == '') {
                tools.AlertWarning("Ventas: ", "Seleccione un cliente.");
            } else {
                openModal();
            }
        });

        $("#btnAceptarModalRenovacion").click(function() {
            addRenovacion();
        });

        $("#btnCloseModalRenovar").click(function() {
            closeClearModal();
        });

        $("#btnCancelModalRenovacion").click(function() {
            closeClearModal();
        });

        $("#cbPlanRenovar").change(function() {
            for (let i = 0; i < listaPlanesRenovar.length; i++) {
                if (listaPlanesRenovar[i].idMembresia == $(this).val()) {
                    planRenovar = listaPlanesRenovar[i];

                    $("#lblNombrePlanRenovar").html("Nombre: " + planRenovar.nombre);
                    $("#lblPrecioPlanRenovar").html("Precio: S/ " + tools.formatMoney(planRenovar.precio));
                    $("#lblTiempoPlanRenovar").html("Tiempo: " + (planRenovar.meses == 1 ? planRenovar.meses + " Mes y " + (planRenovar.dias == 1 ? planRenovar.dias + " día" : planRenovar.dias + " días") : planRenovar.meses + " Meses y " + (planRenovar.dias == 1 ? planRenovar.dias + " día" : planRenovar.dias + " días")) + " Libre: " + planRenovar.freeze + " día(s)");
                    $("#lblDisciplinasPlanRenovar").html("Disciplinas: Ilimitadas");

                    $("#txtFechaInicioRenovar").val(planRenovar.fechaInicio);
                    $("#txtFechaTerminoRenovar").val(planRenovar.fechaFin);
                    $("#lblEstadoRenovar").html(planRenovar.estado == "1" ? "ACTIVO" : planRenovar.estado == "1" ? "POR VENCER" : planRenovar.estado == "3" ? "TRASPASO" : "VENCIDO");
                    break;
                }
            }
        });
    }

    function addRenovacion() {
        if ($("#cbPlanRenovar").has('option').length <= 0 || $("#cbPlanRenovar").val() == '') {
            tools.AlertWarning("Ventas: ", "Seleccione el plan a renovar.")
            $("#cbPlanRenovar").focus();
        } else if (!tools.isNumeric($("#txtCantidadPlanRenovar").val().trim())) {
            tools.AlertWarning("Ventas: ", "Ingrese la cantidad.")
            $("#txtCantidadPlanRenovar").focus();
        } else if (parseInt($("#txtCantidadPlanRenovar").val().trim()) <= 0) {
            tools.AlertWarning("Ventas: ", "Ingrese una cantidad mayor que 0.")
            $("#txtCantidadPlanRenovar").focus();
        } else {
            if (!validateDatelleVenta(planRenovar.idMembresia)) {

                let cantidad = parseInt($("#txtCantidadPlanRenovar").val());
                let descuento = !tools.isNumeric($("#txtDescuentoPlanRenovar").val()) ? 0 : parseFloat($("#txtDescuentoPlanRenovar").val());

                let fechaInicio = new Date(planRenovar.fechaFin);
                fechaInicio.setDate(fechaInicio.getDate() + 1);

                let fechaActual = new Date(tools.getCurrentDate());
                fechaActual.setDate(fechaActual.getDate() + 1);

                if (fechaActual.getTime() <= fechaInicio.getTime() && planRenovar.estado == "1" ||
                    fechaActual.getTime() <= fechaInicio.getTime() && planRenovar.estado == "2") {

                    let fechaFin = fechaInicio;
                    let fecha = new Date(fechaFin);

                    let dias = (parseInt(planRenovar.meses * cantidad) * 30) + (parseInt(planRenovar.dias) * cantidad);
                    fecha.setDate(fecha.getDate() + dias);

                    let currentYear = fecha.getFullYear();
                    let currentMonth = (fecha.getMonth() + 1) > 9 ? (fecha.getMonth() + 1) : "0" + (fecha.getMonth() + 1);
                    let currentDays = fecha.getDate() > 9 ? fecha.getDate() : "0" + fecha.getDate();

                    fechaFin = currentYear + '-' + currentMonth + '-' + currentDays;

                    listaVenta.push({
                        "idPlan": planRenovar.idMembresia,
                        "nombre": "RENOVAR " + planRenovar.nombre,
                        "membresia": 5,
                        "cantidad": cantidad,
                        "precio": parseFloat(planRenovar.precio),
                        "descuento": descuento,
                        "fechaInico": planRenovar.fechaInicio,
                        "horaInicio": tools.getCurrentTime(),
                        "fechaFin": fechaFin,
                        "horaFin": tools.getCurrentTime(),
                        "procedencia": 5,
                    });
                    listarDetalleVenta();
                    closeClearModal();
                } else {
                    fechaActual.setDate(fechaActual.getDate() - 1);
                    let fechaFin = fechaActual;
                    let fecha = new Date(fechaFin);

                    let dias = (parseInt(planRenovar.meses * cantidad) * 30) + (parseInt(planRenovar.dias) * cantidad);
                    fecha.setDate(fecha.getDate() + dias);

                    let currentYear = fecha.getFullYear();
                    let currentMonth = (fecha.getMonth() + 1) > 9 ? (fecha.getMonth() + 1) : "0" + (fecha.getMonth() + 1);
                    let currentDays = fecha.getDate() > 9 ? fecha.getDate() : "0" + fecha.getDate();

                    fechaFin = currentYear + '-' + currentMonth + '-' + currentDays;

                    listaVenta.push({
                        "idPlan": planRenovar.idMembresia,
                        "nombre": "RENOVAR " + planRenovar.nombre,
                        "membresia": 3,
                        "cantidad": cantidad,
                        "precio": parseFloat(planRenovar.precio),
                        "descuento": descuento,
                        "fechaInico": fechaActual,
                        "horaInicio": tools.getCurrentTime(),
                        "fechaFin": fechaFin,
                        "horaFin": tools.getCurrentTime(),
                        "procedencia": 5,
                    });
                    listarDetalleVenta();
                    closeClearModal();
                }
            } else {
                tools.AlertWarning("Ventas: ", "Ya existe una plan con las mismas caracteristicas.")
            }
        }
    }

    function openModal() {
        $("#modalRenovar").modal("show");
        $.ajax({
            url: "../app/membresias/MembresiaController.php",
            method: "GET",
            data: {
                "type": "getmembycliente",
                "idCliente": idCliente
            },
            beforeSend: function() {
                $("#lblTextOverlayRenovacion").html("Cargando información...");
                $("#divOverlayRenovacion").removeClass("d-none");
                $('#cbPlanRenovar').empty();
            },
            success: function(result) {
                let data = result;
                if (data.estado == 1) {
                    listaPlanesRenovar = data.membresias;
                    $("#cbPlanRenovar").append('<option value="">- Seleccione una Membresia -</option>');
                    for (let mem of listaPlanesRenovar) {
                        $("#cbPlanRenovar").append('<option value="' + mem.idMembresia + '">' + mem.nombre + '</option>');
                    }

                    $("#divOverlayRenovacion").addClass("d-none");
                } else {
                    $("#cbPlanRenovar").append('<option value="">- Seleccione una Membresia -</option>');
                    $("#lblTextOverlayRenovacion").html(result.mensaje);
                }
            },
            error: function(error) {
                $("#cbPlanRenovar").append('<option value="">- Seleccione una Membresia -</option>');
                $("#lblTextOverlayRenovacion").html(error.responseText);
            }
        });
    }

    function closeClearModal() {
        $("#modalRenovar").modal("hide")
        $('#cbPlanRenovar').empty();

        listaPlanesRenovar = [];
        planRenovar = {};

        $("#lblNombrePlanRenovar").html("Nombre: ");
        $("#lblPrecioPlanRenovar").html("Precio: ");
        $("#lblTiempoPlanRenovar").html("Tiempo: ");
        $("#lblDisciplinasPlanRenovar").html("Disciplinas: ");
        $("#lblEstadoRenovar").html("--");

        $("#txtCantidadPlanRenovar").val("1");
        $("#txtDescuentoPlanRenovar").val("");
    }

}