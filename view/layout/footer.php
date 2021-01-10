<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
<script src="js/plugins/pace.min.js"></script>
<script src="js/plugins/bootstrap-notify.min.js"></script>
<script src="js/plugins/sweetalert.min.js"></script>
<script src="js/plugins/chart.js"></script>
<script src="js/tools.js"></script>

<!-- Page specific javascripts-->
<script src="js/plugins/moment.min.js"></script>
<script src="js/plugins/jquery-ui.custom.min.js"></script>
<script src="js/plugins/fullcalendar.min.js"></script>

<script>
    function openMarcarEntrada() {
        $("#modalMarcarEntrada").modal("show");
        $("#lblFecha").html('<i class="fa fa-calendar"></i> ' + tools.getCurrentDate());
        $("#lblHora").html('<i class="fa fa-clock-o"></i> ' + tools.getTimeForma(tools.getCurrentTime(), true));

        $("#modalMarcarEntrada").unbind();
        $('#modalMarcarEntrada').bind('shown.bs.modal', function(e) {
            $("#txtCliente").focus()
        });

        $("#btnCancelarMarcarEntrada").unbind();
        $("#btnCloseMarcarEntrada").unbind();
        $("#btnCloseMarcarEntrada").bind('click', function() {
            $("#modalMarcarEntrada").modal("hide");
            $("#txtCliente").val("");
            $("#lblDatosCompletos").html("Bienvenido --");
            $("#lblCodigo").html("--");
            $("#lblDni").html("--");
            $("#lblEmail").html("--");
            $("#lblCelular").html("--");
            $("#lblFechaNacimiento").html("--");
            $("#lblMembresias").html("--");
            $("#lblAsistencia").html("");
            $("#btnMarcarEntrada").unbind();
            $("#btnCerrarEntrada").unbind();
        });
        $("#btnCancelarMarcarEntrada").bind('click', function() {
            $("#modalMarcarEntrada").modal("hide");
            $("#txtCliente").val("");
            $("#lblDatosCompletos").html("Bienvenido --");
            $("#lblCodigo").html("--");
            $("#lblDni").html("--");
            $("#lblEmail").html("--");
            $("#lblCelular").html("--");
            $("#lblFechaNacimiento").html("--");
            $("#lblMembresias").html("--");
            $("#lblAsistencia").html("");
            $("#btnMarcarEntrada").unbind();
            $("#btnCerrarEntrada").unbind();
        });

        $("#btnBuscarAsistencia").unbind();
        $("#btnBuscarAsistencia").bind('click', function() {
            buscarAsistencia()
        });

        $("#txtCliente").unbind();
        $("#txtCliente").bind('keyup', function(event) {
            if (event.keyCode === 13) {
                buscarAsistencia()
            }
        });
        $("#txtCliente").bind('keypress', function(event) {
            var key = window.Event ? event.which : event.keyCode;
            var c = String.fromCharCode(key);
            if ((c < '0' || c > '9') && (c != '\b') && (c != '.')) {
                event.preventDefault();
            }
        });

    }

    function buscarAsistencia() {
        if ($("#rbCliente").is(":checked")) {
            if ($("#txtCliente").val().trim() != '') {
                $.ajax({
                    url: "../app/cliente/Obtener_Cliente_Membresia.php",
                    method: "GET",
                    data: {
                        "buscar": $("#txtCliente").val().trim()
                    },
                    beforeSend: function() {
                        $("#divOverlay").removeClass("d-none");
                    },
                    success: function(result) {
                        console.log(result)
                        if (result.estado == 1) {
                            $("#divOverlay").addClass("d-none");
                            $("#lblDatosCompletos").html("Bienvenido " + result.cliente.apellidos + " " + result.cliente.nombres);
                            $("#lblCodigo").html(result.cliente.codigo);
                            $("#lblDni").html(result.cliente.dni);
                            $("#lblEmail").html(result.cliente.email);
                            $("#lblCelular").html(result.cliente.celular);
                            $("#lblFechaNacimiento").html(tools.getDateForma(result.cliente.fechaNacimiento));
                            $("#lblMembresias").html(result.membresias.length == 0 ? "NO TIENE NINGUNA MEMBRESIA" : "TIENE ASOCIADO " + result.membresias.length + " MEMBRESIA(S)");
                            let idAsistencia = "";
                            if (typeof result.asistencia === 'object') {
                                $("#lblAsistencia").html("TIENE MARCADO UNA ASISTENCIA DE LA FECHA " + result.asistencia.fechaApertura + " Y LA HORA " + result.asistencia.horaApertura);
                                idAsistencia = result.asistencia.idAsistencia;
                            } else {
                                $("#lblAsistencia").html(result.asistencia);
                            }

                            $("#btnMarcarEntrada").unbind();
                            $("#btnMarcarEntrada").bind("click", function() {
                                if (result.membresias.length == 0) {
                                    tools.ModalAlertWarning('Venta', "No tiene ningúna membresia activada para marcar ingreso.");
                                } else {
                                    tools.ModalDialog('Marcar Entrada', '¿Está seguro de continuar?', 'question', function(value) {
                                        if (value) {
                                            $.ajax({
                                                url: "../app/asistencias/Registrar_Asistencias.php",
                                                method: 'POST',
                                                accepts: "application/json",
                                                contentType: "application/json",
                                                data: JSON.stringify({
                                                    'fechaApertura': tools.getCurrentDate(),
                                                    'fechaCierre': null,
                                                    'horaApertura': tools.getCurrentTime(),
                                                    'horaCierre': null,
                                                    'estado': 1,
                                                    'idPersona': result.cliente.idCliente,
                                                    'tipoPersona': 1,
                                                }),
                                                beforeSend: function() {
                                                    tools.ModalAlertInfo('Venta', 'Procesando petición...');
                                                },
                                                success: function(result) {
                                                    if (result.estado == 1) {
                                                        tools.ModalAlertWarning('Venta', result.mensaje);
                                                    } else if (result.estado == 2) {
                                                        $("#modalMarcarEntrada").modal("hide");
                                                        $("#txtCliente").val("");
                                                        $("#lblDatosCompletos").html("Bienvenido --");
                                                        $("#lblCodigo").html("--");
                                                        $("#lblDni").html("--");
                                                        $("#lblEmail").html("--");
                                                        $("#lblCelular").html("--");
                                                        $("#lblFechaNacimiento").html("--");
                                                        $("#lblMembresias").html("--");
                                                        $("#lblAsistencia").html("")
                                                        $("#btnMarcarEntrada").unbind();
                                                        $("#btnCerrarEntrada").unbind();
                                                        tools.ModalAlertSuccess('Venta', result.mensaje);
                                                    } else {
                                                        tools.ModalAlertWarning('Venta', result.mensaje);
                                                    }
                                                },
                                                error: function(error) {
                                                    tools.ModalAlertError('Venta', error.responseText);
                                                }
                                            });
                                        }
                                    });
                                }
                            });

                            $("#btnCerrarEntrada").unbind();
                            $("#btnCerrarEntrada").bind("click", function() {
                                $.ajax({
                                    url: "../app/asistencias/Actualizar_Asistencia.php",
                                    method: 'POST',
                                    accepts: "application/json",
                                    contentType: "application/json",
                                    data: JSON.stringify({
                                        'fechaCierre': tools.getCurrentDate(),
                                        'horaCierre': tools.getCurrentTime(),
                                        'estado': 0,
                                        'idPersona': result.cliente.idCliente,
                                        'idAsistencia': idAsistencia,
                                    }),
                                    beforeSend: function() {
                                        tools.ModalAlertInfo('Venta', 'Procsesando petición...');
                                    },
                                    success: function(result) {
                                        if (result.estado == 1) {
                                            tools.ModalAlertWarning('Venta', result.mensaje);
                                        } else if (result.estado == 2) {
                                            tools.ModalAlertSuccess('Venta', result.mensaje);
                                        } else {
                                            tools.ModalAlertWarning('Venta', result.mensaje);
                                        }
                                    },
                                    error: function(error) {
                                        tools.ModalAlertError('Venta', error.responseText);
                                    }
                                });
                            });
                        } else {
                            $("#divOverlay").addClass("d-none");
                            $("#lblDatosCompletos").html(result.mensaje);
                            $("#lblCodigo").html("--");
                            $("#lblDni").html("--");
                            $("#lblEmail").html("--");
                            $("#lblCelular").html("--");
                            $("#lblFechaNacimiento").html("--");
                            $("#lblMembresias").html("--");
                            $("#lblAsistencia").html("");
                        }
                    },
                    error: function(error) {
                        $("#divOverlay").addClass("d-none");
                        $("#lblDatosCompletos").html(error.responseText);
                        $("#lblCodigo").html("--");
                        $("#lblDni").html("--");
                        $("#lblEmail").html("--");
                        $("#lblCelular").html("--");
                        $("#lblFechaNacimiento").html("--");
                        $("#lblMembresias").html("--");
                        $("#lblAsistencia").html("");
                    }
                });
            }
        } else {
            if ($("#txtCliente").val().trim() != '') {
                $.ajax({
                    url: "../app/empleados/Obtener_Empleado_Membresia.php",
                    method: "GET",
                    data: {
                        "buscar": $("#txtCliente").val().trim()
                    },
                    beforeSend: function() {
                        $("#divOverlay").removeClass("d-none");
                    },
                    success: function(result) {
                        console.log(result)
                        if (result.estado == 1) {
                            $("#divOverlay").addClass("d-none");
                            $("#lblDatosCompletos").html("Bienvenido " + result.empleado.apellidos + " " + result.empleado.nombres);
                            $("#lblCodigo").html(result.empleado.codigo);
                            $("#lblDni").html(result.empleado.numeroDocumento);
                            $("#lblEmail").html(result.empleado.email);
                            $("#lblCelular").html(result.empleado.celular);
                            $("#lblFechaNacimiento").html(tools.getDateForma(result.empleado.fechaNacimiento));
                            $("#lblMembresias").html("");
                            let idAsistencia = "";
                            if (typeof result.asistencia === 'object') {
                                $("#lblAsistencia").html("TIENE MARCADO UNA ASISTENCIA DE LA FECHA " + result.asistencia.fechaApertura + " Y LA HORA " + result.asistencia.horaApertura);
                                idAsistencia = result.asistencia.idAsistencia;
                            } else {
                                $("#lblAsistencia").html(result.asistencia);
                            }

                            $("#btnMarcarEntrada").unbind();
                            $("#btnMarcarEntrada").bind("click", function() {
                                tools.ModalDialog('Marcar Entrada', '¿Está seguro de continuar?', 'question', function(value) {
                                    if (value) {
                                        $.ajax({
                                            url: "../app/asistencias/Registrar_Asistencias.php",
                                            method: 'POST',
                                            accepts: "application/json",
                                            contentType: "application/json",
                                            data: JSON.stringify({
                                                'fechaApertura': tools.getCurrentDate(),
                                                'fechaCierre': null,
                                                'horaApertura': tools.getCurrentTime(),
                                                'horaCierre': null,
                                                'estado': 1,
                                                'idPersona': result.empleado.idEmpleado,
                                                'tipoPersona': 2,
                                            }),
                                            beforeSend: function() {
                                                tools.ModalAlertInfo('Venta', 'Procesando petición...');
                                            },
                                            success: function(result) {
                                                if (result.estado == 1) {
                                                    tools.ModalAlertWarning('Venta', result.mensaje);
                                                } else if (result.estado == 2) {
                                                    $("#modalMarcarEntrada").modal("hide");
                                                    $("#txtCliente").val("");
                                                    $("#lblDatosCompletos").html("Bienvenido --");
                                                    $("#lblCodigo").html("--");
                                                    $("#lblDni").html("--");
                                                    $("#lblEmail").html("--");
                                                    $("#lblCelular").html("--");
                                                    $("#lblFechaNacimiento").html("--");
                                                    $("#lblMembresias").html("--");
                                                    $("#lblAsistencia").html("")
                                                    $("#btnMarcarEntrada").unbind();
                                                    $("#btnCerrarEntrada").unbind();
                                                    tools.ModalAlertSuccess('Venta', result.mensaje);
                                                } else {
                                                    tools.ModalAlertWarning('Venta', result.mensaje);
                                                }
                                            },
                                            error: function(error) {
                                                tools.ModalAlertError('Venta', error.responseText);
                                            }
                                        });
                                    }
                                });
                            });

                            $("#btnCerrarEntrada").unbind();
                            $("#btnCerrarEntrada").bind("click", function() {

                            });
                        } else {
                            $("#divOverlay").addClass("d-none");
                            $("#lblDatosCompletos").html(result.mensaje);
                            $("#lblCodigo").html("--");
                            $("#lblDni").html("--");
                            $("#lblEmail").html("--");
                            $("#lblCelular").html("--");
                            $("#lblFechaNacimiento").html("--");
                            $("#lblMembresias").html("--");
                            $("#lblAsistencia").html("");
                        }
                    },
                    error: function(error) {
                        $("#divOverlay").addClass("d-none");
                        $("#lblDatosCompletos").html(error.responseText);
                        $("#lblCodigo").html("--");
                        $("#lblDni").html("--");
                        $("#lblEmail").html("--");
                        $("#lblCelular").html("--");
                        $("#lblFechaNacimiento").html("--");
                        $("#lblMembresias").html("--");
                        $("#lblAsistencia").html("");
                    }
                });
            }
        }
    }
</script>