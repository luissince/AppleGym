<?php
session_start();
if (isset($_SESSION["IdEmpleado"])) {
    echo '<script>location.href = "./index.php";</script>';
} else {
    ?>
<!DOCTYPE html>
<html>

<head>
    <?php include './layout/head.php';?>
</head>

<body>
    <section class="material-half-bg">
        <div class="cover"></div>
    </section>
    <section class="login-content">
        <div class="logo">
            <h1>AppleGym</h1>
        </div>
        <div class="login-box">
            <div class="login-form">
                <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>Credenciales de Acceso</h3>
                <div class="form-group">
                    <label class="control-label">Usuario</label>
                    <input class="form-control" type="text" placeholder="Dijite el usuario" id="txtUsuario" autofocus>
                </div>
                <div class="form-group">
                    <label class="control-label">Contraseña</label>
                    <input class="form-control" type="password" placeholder="Dijite la contraseña" id="txtClave">
                </div>
                <div class="form-group btn-container">
                    <button class="btn btn-primary btn-block" id="btnAceptar"><i
                            class="fa fa-sign-in fa-lg fa-fw"></i>ACEPTAR</button>
                </div>
            </div>
        </div>
    </section>
    <?php include("./layout/footer.php"); ?>
    <script type="text/javascript">
    let tools = new Tools();
    let state = false;
    $(document).ready(function() {

        $("#btnAceptar").click(function() {
            login()
        })

        $("#txtClave").keydown(function(e) {
            if (e.keyCode === 13) {
                login()
            }
            // e.preventDefault();
        })
    })

    function login() {
        if ($("#txtUsuario").val() == '') {
            tools.AlertWarning('Mensaje: ', "Ingrese un usuario por favor");
            $("#txtUsuario").focus();
        } else if ($("#txtClave").val() == '') {
            tools.AlertWarning('Mensaje: ', "Ingrese una contraseña por favor");
            $("#txtClave").focus();
        } else {

            $.ajax({
                url: "../app/empleados/Obtener_Empleados_For_Login.php",
                method: "GET",
                data: {
                    "usuario": ($("#txtUsuario").val()).trim(),
                    "clave": ($("#txtClave").val()).trim()
                },
                beforeSend: function() {
                    state = true;
                },
                success: function(result) {
                    if (result.estado == 1) {
                        let empleado = result.empleado;
                        tools.AlertSuccess("Mensaje: ",'Bienvenido al Sistema '+empleado.nombres+' '+empleado.apellidos);
                        state = false;
                        setTimeout(function() {
                            location.href = "./index.php"
                     }, 2000);
                    } else if (result.estado == 2) {
                        tools.AlertWarning('Mensaje: ', result.message);
                        $("#txtUsuario").val('')
                        $("#txtClave").val('')
                        $("#txtUsuario").focus();
                        state = false;
                    } else {
                        tools.AlertError('Mensaje: ', result.message);
                        $("#txtUsuario").val('')
                        $("#txtClave").val('')
                        $("#txtUsuario").focus();
                        state = false;
                    }
                },
                error: function(error) {
                    tools.AlertError('Mensaje: ', error.responseText);
                    $("#txtUsuario").val('')
                    $("#txtClave").val('')
                    $("#txtUsuario").focus();
                    state = false;
                }
            });
        }
    }
    </script>
</body>

</html>
<?php
}