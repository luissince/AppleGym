function ModalActivacion() {

    let listarPlanesActivacion = [];
    let planActivacion = {};
    let planNormal = {};
    let listarPlanNormal = [];

    this.init = function() {

        $("#btnActivacion").click(function() {
            openModal();
        });

        $("#btnAceptarModalActivacion").click(function() {
            addPlanActivacion();
        });

        $("#btnCloseModalActivacion").click(function() {
            closeClearModal();
        });

        $("#btnCancelModalActivacion").click(function() {
            closeClearModal();
        });

        $("#txtPrecioActivacion").keypress(function() {
            var key = window.Event ? event.which : event.keyCode;
            var c = String.fromCharCode(key);
            if ((c < '0' || c > '9') && (c != '\b') && (c != '.')) {
                event.preventDefault();
            }
            if (c == '.' && $("#txtPrecioActivacion").val().includes(".")) {
                event.preventDefault();
            }
        });

        $("#cbPlanNormal").change(function(event) {
            if (!event.currentTarget.checked) {
                $("#cbPlanNormalActivacion").prop("disabled", true);
                $("#txtCantidadPlanNormal").prop("disabled", true);
                $("#txtDescuentoPlanNormal").prop("disabled", true);
            } else {
                $("#cbPlanNormalActivacion").prop("disabled", false);
                $("#txtCantidadPlanNormal").prop("disabled", false);
                $("#txtDescuentoPlanNormal").prop("disabled", false);
            }
        });

        $("#txtDescuentoPlanNormal").keypress(function() {
            var key = window.Event ? event.which : event.keyCode;
            var c = String.fromCharCode(key);
            if ((c < '0' || c > '9') && (c != '\b') && (c != '.')) {
                event.preventDefault();
            }
            if (c == '.' && $("#txtDescuentoPlanNormal").val().includes(".")) {
                event.preventDefault();
            }
        });

        $("#txtCantidadPlanNormal").keypress(function() {
            var key = window.Event ? event.which : event.keyCode;
            var c = String.fromCharCode(key);
            if ((c < '0' || c > '9') && (c != '\b')) {
                event.preventDefault();
            }
        });

        $("#cbPlanesActivacion").change(function() {
            for (let i = 0; i < listarPlanesActivacion.length; i++) {
                if (listarPlanesActivacion[i].idPlan == $(this).val()) {
                    planActivacion = listarPlanesActivacion[i];
                    break;
                }
            }
        });

        $("#cbPlanNormalActivacion").change(function() {
            for (let i = 0; i < listarPlanNormal.length; i++) {
                if (listarPlanNormal[i].idPlan == $(this).val()) {
                    planNormal = listarPlanNormal[i];

                    $("#lblNombrePlanNormal").html("Nombre: " + planNormal.nombre);
                    $("#lblPrecioPlanNormal").html("Precio: S/ " + tools.formatMoney(planNormal.precio));
                    $("#lblTiempoPlanNormal").html("Tiempo: " + (planNormal.meses == 1 ? planNormal.meses + " Mes y " + (planNormal.dias == 1 ? planNormal.dias + " día" : planNormal.dias + " días") : planNormal.meses + " Meses y " + (planNormal.dias == 1 ? planNormal.dias + " día" : planNormal.dias + " días")) + " Libre: " + planNormal.freeze + " día(s)");
                    $("#lblDisciplinasPlanNormal").html("Disciplinas: Ilimitadas");
                    break;
                }
            }
        });

    }

    function openModal() {
        $("#modalActivacion").modal("show");
        $.ajax({
            url: "../app/plan/PlanController.php",
            method: "GET",
            data: {
                "type": "listaplanlibre"
            },
            beforeSend: function() {
                $("#lblTextOverlayActivacion").html("Cargando información...");
                $("#divOverlayActivacion").removeClass("d-none");
                listarPlanesActivacion = [];
                listarPlanNormal = [];
                $("#cbPlanesActivacion").empty();
                $("#cbPlanNormalActivacion").empty();
            },
            success: function(result) {
                if (result.estado == 1) {
                    listarPlanesActivacion = result.planesLibre;
                    $("#cbPlanesActivacion").append('<option value="">- Selecciona -</option>');
                    for (let plan of listarPlanesActivacion) {
                        $("#cbPlanesActivacion").append('<option value="' + plan.idPlan + '">' + plan.nombre + '</option>');
                    }

                    listarPlanNormal = result.planesNormales;
                    $("#cbPlanNormalActivacion").append('<option value="">- Selecciona -</option>');
                    for (let plan of listarPlanNormal) {
                        $("#cbPlanNormalActivacion").append('<option value="' + plan.idPlan + '">' + plan.nombre + '</option>');
                    }

                    $("#divOverlayActivacion").addClass("d-none");
                } else {
                    $("#lblTextOverlayActivacion").html(result.mensaje);
                }
            },
            error: function(error) {
                $("#lblTextOverlayActivacion").html(error.responseText);
            }
        });
    }

    function addPlanActivacion() {
        if (!tools.validateDate($("#txtFechaInicioActivacion").val())) {
            tools.AlertWarning("Ventas: ", "Ingrese la fecha de inicio.")
            $("#txtFechaInicioActivacion").focus();
        } else if (!tools.validateDate($("#txtFechaFinActivacion").val())) {
            tools.AlertWarning("Ventas: ", "Ingrese la fecha de fin.")
            $("#txtFechaFinActivacion").focus();
        } else if ($('#cbPlanesActivacion').has('option').length <= 0 || $("#cbPlanesActivacion").val() == '') {
            tools.AlertWarning("Ventas: ", "Seleccione un plan.")
            $("#cbPlanesActivacion").focus();
        } else if (!tools.isNumeric($("#txtPrecioActivacion").val().trim())) {
            tools.AlertWarning("Ventas: ", "Ingrese el precio.")
            $("#txtPrecioActivacion").focus();
        } else if (parseFloat($("#txtPrecioActivacion").val().trim()) < 0) {
            tools.AlertWarning("Ventas: ", "Ingrese un precio mayor que 0.")
            $("#txtPrecioActivacion").focus();
        } else if ($("#cbPlanNormal").is(":checked") && $("#cbPlanNormalActivacion").has('option').length <= 0 ||
            $("#cbPlanNormal").is(":checked") && $("#cbPlanNormalActivacion").val() == '') {
            tools.AlertWarning("Ventas: ", "Seleccione el plan a agregar.")
            $("#cbPlanNormalActivacion").focus();
        } else if (!tools.isNumeric($("#txtCantidadPlanNormal").val().trim())) {
            tools.AlertWarning("Ventas: ", "Ingrese la cantidad de planes.")
            $("#txtCantidadPlanNormal").focus();
        } else {
            if (!validateDatelleVenta(!$("#cbPlanNormal").is(":checked") ? planActivacion.idPlan : planNormal.idPlan)) {
                let fechaInicio = $("#txtFechaInicioActivacion").val();
                let fechaFin = $("#txtFechaFinActivacion").val();
                let precio = 0;
                if ($("#cbPlanNormal").is(":checked")) {
                    let cantidad = parseInt($("#txtCantidadPlanNormal").val().trim());
                    let descuento = !tools.isNumeric($("#txtDescuentoPlanNormal").val()) ? 0 : parseFloat($("#txtDescuentoPlanNormal").val());
                    precio = (parseFloat(planNormal.precio) - descuento) * cantidad;

                    let fecha = new Date(fechaFin);
                    let dias = (parseInt(planNormal.meses * cantidad) * 30) + parseInt(planNormal.dias);
                    fecha.setDate(fecha.getDate() + dias + 1);

                    let currentYear = fecha.getFullYear();
                    let currentMonth = (fecha.getMonth() + 1) > 9 ? (fecha.getMonth() + 1) : "0" + (fecha.getMonth() + 1);
                    let currentDays = fecha.getDate() > 9 ? fecha.getDate() : "0" + fecha.getDate();

                    fechaFin = currentYear + '-' + currentMonth + '-' + currentDays;
                }

                listaVenta.push({
                    "idPlan": !$("#cbPlanNormal").is(":checked") ? planActivacion.idPlan : planNormal.idPlan,
                    "nombre": "ACTIVACIÓN: " + planActivacion.nombre + (!$("#cbPlanNormal").is(":checked") ? '' : ' CON ' + planNormal.nombre),
                    "membresia": 4,
                    "cantidad": 1,
                    "precio": parseFloat($("#txtPrecioActivacion").val().trim()) + precio,
                    "descuento": 0,
                    "fechaInico": fechaInicio,
                    "horaInicio": tools.getCurrentTime(),
                    "fechaFin": fechaFin,
                    "horaFin": tools.getCurrentTime(),
                    "procedencia": 4,
                });
                listarDetalleVenta();
                closeClearModal();
            } else {
                tools.AlertWarning("Ventas: ", "Ya existe una plan con las mismas caracteristicas.")
            }
        }
    }

    function closeClearModal() {
        $("#modalActivacion").modal("hide");
        listarPlanesActivacion = [];
        planActivacion = {};
        planNormal = {};
        listarPlanNormal = [];
        $("#txtFechaInicioActivacion").val("");
        $("#txtFechaFinActivacion").val("");
        $("#cbPlanesActivacion").empty();
        $("#txtPrecioActivacion").val("");

        $("#cbPlanNormal").prop("checked", false);
        $("#cbPlanNormalActivacion").prop("disabled", true);
        $("#txtCantidadPlanNormal").prop("disabled", true);
        $("#txtDescuentoPlanNormal").prop("disabled", true);
        $("#cbPlanNormalActivacion").empty();
        $("#txtCantidadPlanNormal").val("1");
        $("#txtDescuentoPlanNormal").val("");

        $("#lblNombrePlanNormal").html("Nombre: ");
        $("#lblPrecioPlanNormal").html("Precio: ");
        $("#lblTiempoPlanNormal").html("Tiempo: ");
        $("#lblDisciplinasPlanNormal").html("Disciplinas: ");

    }


}