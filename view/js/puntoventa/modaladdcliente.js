function ModalAddCliente() {


    this.init = function () {
        $("#btnOpenModalCliente").click(function () {
            $("#modalCliente").modal("show");
            $("#titulo-modal-cliente").append('<i class="fa fa-user-plus"></i> Registrar Cliente')
        });

        $("#btnGuardarModalNewCliente").click(function () {
            if ($("#dni").val() == '' || $("#dni").val().length < 8) {
                tools.AlertWarning("Advertencia", "Ingrese un número de dni valido")
            } else if ($("#apellidos").val() == '' || $("#apellidos").val().length < 1) {
                tools.AlertWarning("Advertencia", "Ingrese un apellido de 2 o mas letras.")
            } else if ($("#nombres").val() == '' || $("#nombres").val().length < 1) {
                tools.AlertWarning("Advertencia", "Ingrese un nombre de 2 o mas letras.")
            } else if ($("#genero").val() == '') {
                tools.AlertWarning("Advertencia", "Seleccione su sexo.")
            } else if ($("#nacimiento").val() == '') {
                tools.AlertWarning("Advertencia", "Ingrese un fecha de nacimiento.")
            } else if ($("#celular").val() == '' || $("#celular").val().length < 6) {
                tools.AlertWarning("Advertencia", "Ingrese un número de celular valido")
            } else {
                tools.ModalDialog('Cliente', '¿Desea guardar los datos?', 'question', function (result) {
                    if (result) {
                        registrarCliente($("#dni").val(),
                            $("#apellidos").val(),
                            $("#nombres").val(),
                            $("#genero").val(),
                            $("#nacimiento").val(),
                            $("#codigo").val(),
                            $("#email").val(),
                            $("#celular").val(),
                            $("#direccion").val(),
                            $("#descripcion").val());
                    }
                });
            }
        });

        $("#btnCloseModalNewCliente").click(function () {
            $("#modalCliente").modal("hide");
            $("#titulo-modal-cliente").empty();
            closeClearModal();
        });

        $("#btnCancelModalNewCliente").click(function () {
            $("#modalCliente").modal("hide");
            $("#titulo-modal-cliente").empty();
            closeClearModal();
        });

    }

    function registrarCliente(dni, apellidos, nombres, genero, nacimiento, codigo, email, celular, direccion, descripcion) {
        $.ajax({
            url: "../app/cliente/ClienteController.php",
            method: "POST",
            accepts: "application/json",
            contentType: "application/json",
            data: JSON.stringify({
                "type": "crud",
                "idCliente": '',
                "dni": dni,
                "apellidos": (apellidos.toUpperCase()).trim(),
                "nombres": (nombres.toUpperCase()).trim(),
                "sexo": genero,
                "fechaNacimiento": nacimiento,
                "codigo": (codigo.toUpperCase()).trim(),
                "email": email.trim(),
                "celular": celular,
                "direccion": (direccion.toUpperCase()).trim(),
                "descripcion": (descripcion.toUpperCase()).trim()
            }),
            beforeSend: function () {
                closeClearModal();
                tools.ModalAlertInfo('Cliente', 'Procesando petición...');
            },
            success: function (result) {
                if (result.estado == 1) {
                    tools.ModalAlertSuccess('Cliente', result.mensaje);
                } else {
                    tools.ModalAlertWarning('Cliente', result.mensaje);
                }
            },
            error: function (error) {
                tools.ModalAlertError("Cliente", error.responseText);
            }
        });
    }


    function closeClearModal() {
        $("#modalCliente").modal("hide")
        $("#titulo-modal-cliente").empty();
        $("#dni").val("")
        $("#apellidos").val("")
        $("#nombres").val("")
        $("#genero").val("1")
        $("#nacimiento").val("")
        $("#codigo").val("")
        $("#email").val("")
        $("#celular").val("")
        $("#direccion").val("")
        $("#descripcion").val("")
    }


}