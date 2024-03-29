function ModalListaPlanes() {

    let listarPlanes = [];
    let idPlan = "";
    let nombrePlan = "";
    let precioPlan = 0;
    let mesesPlan = 0;
    let diasPlan = 0;
    let freezePlan = 0;

    this.init = function () {
        $("#inicio").change(function () {
            $("#fechainicio").prop('disabled', !$("#inicio").is(':checked'));
        });

        $("#btnPlan").click(function () {
            $("#modalPlan").modal("show");
            listaPlanes();
        });

        $("#btnCloseModalPlanes").click(function () {
            clearPlanes();
        });

        $("#btnCancelarModalPlanes").click(function () {
            clearPlanes();
        });

        $("#plan").change(function () {
            for (let i = 0; i < listarPlanes.length; i++) {
                if (listarPlanes[i].idPlan == $(this).val()) {
                    idPlan = listarPlanes[i].idPlan;
                    nombrePlan = listarPlanes[i].nombre;
                    precioPlan = listarPlanes[i].precio;
                    mesesPlan = listarPlanes[i].meses;
                    diasPlan = listarPlanes[i].dias;
                    freezePlan = listarPlanes[i].freeze;
                    disciplinas = listarPlanes[i].disciplinas;

                    $("#lblNombrePlan").html("Nombre: " + nombrePlan);
                    $("#lblPrecioPlan").html("Precio: S/ " + tools.formatMoney(precioPlan));
                    $("#lblDescripcionPlan").html("Descripcion: " + listarPlanes[i].descripcion);
                    $("#lblTiempoPlan").html("Tiempo: " + (mesesPlan == 1 ? mesesPlan + " Mes y " + (diasPlan == 1 ? diasPlan + " día" : diasPlan + " días") : mesesPlan + " Meses y " + (diasPlan == 1 ? diasPlan + " día" : diasPlan + " días")) + " Libre: " + freezePlan + " día(s)");
                    if (disciplinas.length == 0) {
                        $("#lblDisciplinasPlan").html("Disciplinas: Ilimitadas");
                    } else {
                        let listDistData = "";
                        for (let i = 0; i < disciplinas.length; i++) {
                            if (i == disciplinas.length - 1) {
                                listDistData += disciplinas[i].nombre;
                            } else {
                                listDistData += disciplinas[i].nombre + ", ";
                            }
                        }
                        $("#lblDisciplinasPlan").html("Disciplinas: " + listDistData);
                    }
                    break;
                }
            }
        });


        $("#btnGuardarModalPlanes").click(function () {
            if (idPlan == '') {
                tools.AlertWarning("Ventas: ", "Seleccione un plan.")
                $("#plan").focus();
            } else if ($("#inicio").is(':checked') && !tools.validateDate($("#fechainicio").val())) {
                tools.AlertWarning("Ventas: ", "Ingre la fecha de inicio.")
                $("#fechainicio").focus()
            } else if (!tools.isNumeric($("#cantidad").val())) {
                tools.AlertWarning("Ventas: ", "Ingrese una cantidad.")
                $("#cantidad").focus();
            } else if ($("#Membresia").val() == '') {
                tools.AlertWarning("Ventas: ", "Seleccione el tipo de membresía.")
                $("#Membresia").focus();
            } else if (parseInt($("#cantidad").val()) <= 0) {
                tools.AlertWarning("Ventas: ", "Ingrese una cantidad mayor a 0.")
                $("#cantidad").focus();
            } else {
                if (!validateDatelleVenta(idPlan)) {

                    let cantidad = parseInt($("#cantidad").val());
                    let descuento = !tools.isNumeric($("#descuento").val()) ? 0 : parseFloat($("#descuento").val());

                    let fechaInicio = $("#inicio").is(':checked') ? $("#fechainicio").val() : tools.getCurrentDate();
                    let fechaFin = fechaInicio;
                    let fecha = new Date(fechaFin);

                    let dias = (parseInt(mesesPlan * cantidad) * 30) + (parseInt(diasPlan) * cantidad);
                    fecha.setDate(fecha.getDate() + dias);

                    let currentYear = fecha.getFullYear();
                    let currentMonth = (fecha.getMonth() + 1) > 9 ? (fecha.getMonth() + 1) : "0" + (fecha.getMonth() + 1);
                    let currentDays = fecha.getDate() > 9 ? fecha.getDate() : "0" + fecha.getDate();

                    fechaFin = currentYear + '-' + currentMonth + '-' + currentDays;

                    listaVenta.push({
                        "idPlan": idPlan,
                        "nombre": nombrePlan,
                        "membresia": $("#Membresia").val(),
                        "cantidad": cantidad,
                        "precio": precioPlan,
                        "descuento": descuento,
                        "fechaInico": fechaInicio,
                        "horaInicio": tools.getCurrentTime(),
                        "fechaFin": fechaFin,
                        "horaFin": tools.getCurrentTime(),
                        "procedencia": 1,
                    });
                    listarDetalleVenta();
                    clearPlanes();
                } else {
                    tools.AlertWarning("Ventas: ", "Ya existe una plan con las mismas caracteristicas.")
                }
            }
        });

        $("#descuento").keypress(function () {
            var key = window.Event ? event.which : event.keyCode;
            var c = String.fromCharCode(key);
            if ((c < '0' || c > '9') && (c != '\b') && (c != '.')) {
                event.preventDefault();
            }
            if (c == '.' && $("#descuento").val().includes(".")) {
                event.preventDefault();
            }
        });

        $("#cantidad").keypress(function () {
            var key = window.Event ? event.which : event.keyCode;
            var c = String.fromCharCode(key);
            if ((c < '0' || c > '9') && (c != '\b')) {
                event.preventDefault();
            }
        });


    }

    function listaPlanes() {
        $.ajax({
            url: "../app/plan/Obtener_Datos_Para_Select.php",
            method: "GET",
            data: {},
            beforeSend: function () {
                $("#lblTextOverlayActivacion").html("Cargando información...");
                $("#divOverlaActivacion").removeClass("d-none");
                listarPlanes = [];
                $("#plan").empty();
            },
            success: function (result) {
                if (result.estado == 1) {
                    listarPlanes = result.planes;
                    $("#plan").append('<option value="">- Selecciona -</option>');
                    for (let plan of listarPlanes) {
                        $("#plan").append('<option id="' + plan.precio + '" value="' + plan.idPlan + '">' + plan.nombre + '</option>');
                    }
                    $("#divOverlaActivacion").addClass("d-none");
                } else {
                    $("#lblTextOverlayActivacion").html(result.mensaje);
                }
            },
            error: function (error) {
                $("#lblTextOverlayActivacion").html(error.responseText);
            }
        });
    }



}