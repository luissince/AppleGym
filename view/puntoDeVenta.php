<?php
session_start();
if (!isset($_SESSION["IdEmpleado"])) {
    echo '<script>location.href = "./login.php";</script>';
} else {
    if ($_SESSION["Roles"][20]["ver"] == 1) {
?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <?php include './layout/head.php'; ?>
        </head>

        <body class="app sidebar-mini">
            <!-- Navbar-->
            <?php include "./layout/header.php"; ?>
            <!-- Sidebar menu-->
            <?php include "./layout/menu.php"; ?>

            <main class="app-content">
                <div class="app-title">
                    <div>
                        <h1><i class="fa fa-shopping-cart"></i> Punto de Venta</h1>
                    </div>
                </div>

                <!-- Sidebar menu-->
                <?php include "./marcarentrada.php"; ?>

                <!-- modal pagar  -->
                <?php include('./layout/puntoventa/modalpagar.php'); ?>

                <!-- modal lista cliente -->
                <?php include('./layout/puntoventa/modalcliente.php'); ?>

                <!-- modal nuevo cliente -->
                <?php include('./layout/puntoventa/modaladdcliente.php'); ?>

                <!-- modal lista planes -->
                <?php include('./layout/puntoventa/modallistaplanes.php'); ?>

                <!-- modal lista Productos -->
                <?php include('./layout/puntoventa/modallistaproductos.php'); ?>

                <!-- modal clientes traspaso -->
                <?php include('./layout/puntoventa/modaltraspaso.php'); ?>

                <!-- modal clientes traspaso -->
                <?php include('./layout/puntoventa/modalactivacion.php'); ?>

                <!-- modal clientes traspaso -->
                <?php include('./layout/puntoventa/modalrenovacion.php'); ?>

                <div class="tile">

                    <div class="overlay" id="divOverlayPuntoVenta">
                        <div class="m-loader mr-4">
                            <svg class="m-circular" viewBox="25 25 50 50">
                                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle>
                            </svg>
                        </div>
                        <h4 class="l-text" id="lblTextOverlayPuntoVenta">Cargando información...</h4>
                    </div>

                    <div class="tile-body">
                        <div class="row">
                            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group text-left">
                                            <button class="btn btn-success" type="button" id="btnPlan"><i class="fa fa-file"></i>
                                                Planes</button>
                                            <button class="btn btn-success" type="button" id="btnProductos"><i class="fa fa-plus"></i>
                                                Producto/Servicio</button>
                                            <button class="btn btn-success" type="button" id="btnTraspaso"><i class="fa fa-sign-in"></i>
                                                Traspaso</button>
                                            <button class="btn btn-success" type="button" id="btnActivacion"><i class="fa fa-external-link-square"></i>
                                                Activación</button>
                                            <button class="btn btn-success" type="button" id="btnRenovar"><i class="fa fa-pencil-square-o"></i>
                                                Renovar</button>

                                        </div>
                                        <div class="form-group d-flex">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Cliente..." id="clienteDatos" disabled>
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning" type="button" id="btnOpenModalCliente"><i class="fa fa-plus"></i></button>
                                                </div>
                                                <div class="input-group-append">
                                                    <button class="btn btn-info" type="button" id="btnListaCliente"><i class="fa fa-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered">
                                                <thead>
                                                    <tr role="row">
                                                        <th class="sorting">Nombre</th>
                                                        <th class="sorting_asc">Cantidad</th>
                                                        <th class="sorting">Precio Plan ( - Descuento)</th>
                                                        <th class="sorting">Precio</th>
                                                        <th class="sorting">Importe</th>
                                                        <th class="sorting">Quitar</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbLista">
                                                    <!-- tbLista -->
                                                    <tr role="row" class="odd">

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <div class="form-group">
                                            <h4>Detalle del Cobro</h4>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button id="btnCobrar" class="btn btn-success btn-block">
                                                <div class="row justify-content-center">
                                                    <div class="col-md-6 text-left">
                                                        <h5>COBRAR</h5>
                                                    </div>
                                                    <div class="col-md-6 text-right">
                                                        <h5 id="lblSumaTotal">S/ 0.00</h5>
                                                    </div>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label>Comprobante:</label>
                                        <div class="form-group">
                                            <select id="comprobante" class="form-control">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label>Numeración</label>
                                        <div class="form-group d-flex">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="txtNumeracion" placeholder="Numeración Automatica" disabled>
                                                <div class="input-group-append">
                                                    <button class="btn btn-info" type="button" id="btnDesbloquear"><i class="fa fa-lock"></i></button>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group">

                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="text-danger" id="errorComprobante"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </main>
            <!-- Essential javascripts for application to work-->
            <?php include "./layout/footer.php"; ?>
            <script src="js/puntoventa/modalcliente.js"></script>
            <script src="js/puntoventa/modaladdcliente.js"></script>
            <script src="js/puntoventa/modallistaplanes.js"></script>
            <script src="js/puntoventa/modallistaproductos.js"></script>
            <script src="js/puntoventa/modaltraspaso.js"></script>
            <script src="js/puntoventa/modalactivacion.js"></script>
            <script src="js/puntoventa/modalrenovacion.js"></script>
            <script src="js/puntoventa/modalpagar.js"></script>
            <script>
                let tools = new Tools();
                let modalCliente = new ModalCliente();
                let modalAddCliente = new ModalAddCliente();
                let modalListaPlanes = new ModalListaPlanes();
                let modalListaProductos = new ModalListaProductos();
                let modalTraspaso = new ModalTraspaso();
                let modalActivacion = new ModalActivacion();
                let modalRenovacion = new ModalRenovacion();
                let mondalPagar = new ModalPagar();

                let listaVenta = [];
                let total = 0;

                let idCliente = "";

                let montoCambio = 0;

                let idEmpleado = "<?php echo $_SESSION["IdEmpleado"] ?>";

                $(document).ready(function() {

                    modalCliente.init();
                    modalAddCliente.init();
                    modalListaPlanes.init();
                    modalListaProductos.init();
                    modalTraspaso.init();
                    modalActivacion.init();
                    modalRenovacion.init();
                    mondalPagar.init();

                    $("#txtNumeracion").keypress(function() {
                        var key = window.Event ? event.which : event.keyCode;
                        var c = String.fromCharCode(key);
                        if ((c < '0' || c > '9') && (c != '\b')) {
                            event.preventDefault();
                        }
                    });

                    $("#btnDesbloquear").click(function() {
                        if ($("#txtNumeracion").is(':disabled')) {
                            $("#txtNumeracion").prop('disabled', false);
                            $("#btnDesbloquear").empty();
                            $("#btnDesbloquear").html('<i class="fa fa-unlock-alt"></i>');
                        } else {
                            $("#txtNumeracion").prop('disabled', true);
                            $("#btnDesbloquear").empty();
                            $("#btnDesbloquear").html('<i class="fa fa-lock"></i>');
                            $("#txtNumeracion").val("");
                        }
                    });

                    listaComprobantes();
                });


                function listarDetalleVenta() {
                    $("#tbLista").empty();
                    total = 0;
                    let suma = 0;
                    for (let detalle of listaVenta) {
                        suma = (detalle.precio - detalle.descuento) * detalle.cantidad;
                        $("#tbLista").append('<tr>' +
                            '<td>' + detalle.nombre + '</td>' +
                            '<td>' + detalle.cantidad + '</td>' +
                            '<td>' + tools.formatMoney(detalle.precio) + " ( - " + tools.formatMoney(detalle.descuento) + ")" + '</td>' +
                            '<td>' + tools.formatMoney(detalle.precio - detalle.descuento) + '</td>' +
                            // '<td>'+ tools.formatMoney(detalle.descuento) +'</td>' +
                            '<td>' + tools.formatMoney(suma) + '</td>' +
                            '<td>' +
                            '  <button onclick="removeDetalleVenta(\'' + detalle.idPlan + '\')" class="btn btn-danger btn-sm"> <i class="fa fa-trash"></i> Quitar</button>' +
                            '</td>' +
                            '</tr>');
                        total += suma;
                    }
                    $("#lblSumaTotal").html("S/ " + tools.formatMoney(total));
                    $("#lblTotalPagar").html("S/ " + tools.formatMoney(total));
                }

                function validateDatelleVenta(idPlan) {
                    let ret = false;
                    for (let i = 0; i < listaVenta.length; i++) {
                        if (listaVenta[i].idPlan == idPlan) {
                            ret = true;
                            break;
                        }
                    }
                    return ret;
                }

                function removeDetalleVenta(idPlan) {
                    for (let i = 0; i < listaVenta.length; i++) {
                        if (listaVenta[i].idPlan == idPlan) {
                            listaVenta.splice(i, 1);
                            i--;
                            break;
                        }
                    }
                    listarDetalleVenta();
                }

                function listaComprobantes() {
                    $.ajax({
                        url: "../app/venta/Listar_Tipo_Comprobante.php",
                        method: "GET",
                        data: {},
                        beforeSend: function() {
                            $("#comprobante").empty();
                        },
                        success: function(result) {
                            if (result.estado == 1) {
                                $("#comprobante").append('<option value="">- Selecciona -</option>');
                                for (let comprobante of result.comprobantes) {
                                    $("#comprobante").append('<option value="' + comprobante.idTipoComprobante + '">' + comprobante.nombre + '</option>');
                                }
                                for (let comprobante of result.comprobantes) {
                                    if (comprobante.predeterminado == 1) {
                                        $("#comprobante").val(comprobante.idTipoComprobante);
                                        break;
                                    }
                                }
                                $("#divOverlayPuntoVenta").addClass("d-none");
                            } else {
                                $("#lblTextOverlayPuntoVenta").html(result.mensaje);
                            }
                        },
                        error: function(error) {
                            $("#lblTextOverlayPuntoVenta").html(error.responseText);
                        }
                    });
                }

                function clearComponents() {
                    idCliente = "";
                    $("#clienteDatos").val("");
                    listaVenta = [];
                    listarPlanes = [];
                    planActivacion = {};
                    listarPlanesActivacion = [];
                    listarPlanNormal = [];
                    planNormal = {};
                    listaPlanesRenovar = [];
                    planRenovar = {};
                    listarDetalleVenta();
                    $("#monto").val("");
                    $("#vuelto").val("");
                    $("#montotarjeta").val("");
                    $("#numerotarjeta").val("");
                    $("#formapagocredito").val("");
                    $("#numerocreditotarjeta").val("");
                    $("#tvPlazos").empty();
                }

                function clearPlanes() {
                    $("#modalPlan").modal("hide");
                    $("#plan").val("");
                    $("#cantidad").val("1");
                    $("#descuento").val("0");

                    idPlan = "";
                    nombrePlan = "";
                    precioPlan = "";
                    mesesPlan = 0;
                    diasPlan = 0;
                    freezePlan = 0;
                    listarPlanes = [];
                    $("#lblNombrePlan").html("Nombre:");
                    $("#lblPrecioPlan").html("Precio:");
                    $("#lblDescripcionPlan").html("Descripcion:");
                    $("#lblTiempoPlan").html("Tiempo: ");
                    $("#lblDisciplinasPlan").html("Disciplinas: ");
                    $("#inicio").prop('checked', false)
                    $("#fechainicio").val("");
                    $("#fechainicio").prop('disabled', true);
                }
            </script>
        </body>

        </html>

<?php
    } else {
        echo '<script>location.href = "./bienvenido.php";</script>';
    }
}
