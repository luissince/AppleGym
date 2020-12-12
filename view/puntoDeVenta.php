<?php
session_start();
if (!isset($_SESSION["IdEmpleado"])) {
    echo '<script>location.href = "./login.php";</script>';
} else {
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

            <!-- modal nuevo/update Cliente  -->
            <div class="row">
                <div class="modal fade" id="modalCobro" data-backdrop="static">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">
                                    <i class="fa fa-handshake-o"></i> Cobrar
                                </h4>
                                <button type="button" class="close" id="btnCloseModal">
                                    <i class="fa fa-close"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="col-md-12">
                                    <div class="form-group text-center">
                                        <p class="h5">TOTAL A PAGAR: <b class="h5 text-info">S/ 100.00</b></p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <p>Tipos de pago</p>
                                    </div>
                                </div>

                                <div class="row ">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-selected="true">Contado</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-selected="false">Crédito</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="tab-content" id="pills-tabContent">
                                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel">

                                                <div class="accordion" id="accordionExample">
                                                    <div class="card">
                                                        <div class="card-header" id="headingOne">
                                                            <h2 class="mb-0">
                                                                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                                    Efectivo
                                                                </button>
                                                            </h2>
                                                        </div>

                                                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                            <div class="card-body">
                                                                <div class="row justify-content-center">
                                                                    <div class="col-md-6">
                                                                        <label>Monto: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                                        <div class="form-group">
                                                                            <input id="monto" type="number" class="form-control form-control-sm">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row justify-content-center">
                                                                    <div class="col-md-6">
                                                                        <label>Vuelto:</label>
                                                                        <div class="form-group">
                                                                            <input id="vuelto" type="number" class="form-control form-control-sm" disabled>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="card">
                                                        <div class="card-header" id="headingTwo">
                                                            <h2 class="mb-0">
                                                                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                                    Tarjeta
                                                                </button>
                                                            </h2>
                                                        </div>
                                                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                            <div class="card-body">
                                                                <div class="row justify-content-center">
                                                                    <div class="col-md-6">
                                                                        <label>Monto: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                                        <div class="form-group">
                                                                            <input id="montotarjeta" type="number" class="form-control form-control-sm">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row justify-content-center">
                                                                    <div class="col-md-6">
                                                                        <label>Número de la operación: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                                        <div class="form-group">
                                                                            <input id="numerotarjeta" type="text" class="form-control form-control-sm">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="pills-profile" role="tabpanel">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>Monto</th>
                                                                    <th>Fecha</th>
                                                                    <th>Monto Inicial</th>
                                                                    <th>Quitar</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="tvPlazos">

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <button class="btn btn-link" id="btnPlazos" type="button">Agregar cuota +</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" id="btnGuardarModal">
                                    <i class="fa fa-save"></i> Guardar</button>
                                <button type="button" class="btn btn-danger" id="btnCancelModal">
                                    <i class="fa fa-remove"></i> Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tile">
                <div class="row">
                    <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group text-left">
                                    <button class="btn btn-success" type="button" id="btnPlan"><i class="fa fa-file"></i>
                                        Planes</button>
                                    <button class="btn btn-success" type="button" id="btnProducto"><i class="fa fa-plus"></i>
                                        Productos</button>
                                </div>
                                <div class="form-group d-flex">
                                    <input type="search" class="form-control" placeholder="Cliente..." aria-controls="sampleTable" id="txtCliente" disabled>
                                    <button class="btn btn-info" type="button" id="btnBuscar"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                            <tr role="row">
                                                <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1">Nombre</th>
                                                <th class="sorting_asc" aria-controls="sampleTable" rowspan="1" colspan="1">Cantidad</th>
                                                <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1">Precio</th>
                                                <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1">Descuento</th>
                                                <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1">Total</th>
                                                <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbLista">
                                            <!-- tbLista -->
                                            <tr role="row" class="odd">
                                                <td class="sorting_1">Airi Satou</td>
                                                <td>10</td>
                                                <td>S/ 20.00</td>
                                                <td>0</td>
                                                <td>S/ 200.00</td>
                                                <td>
                                                    <button class="btn btn-danger btn-sm"> <i class="fa fa-trash"></i> Quitar</button>
                                                </td>
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
                                                <h5 id="lblSumaTotal">0.00</h5>
                                            </div>
                                        </div>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="subTotal">Comprobante:</label>
                                <div class="form-group">
                                    <select id="comprobante" class="form-control">
                                        <option value="0">- Seleccione -</option>
                                        <option value="0">Tiket</option>
                                        <option value="1">Boleta</option>
                                        <option value="2">Factura</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </main>
        <!-- Essential javascripts for application to work-->
        <?php include "./layout/footer.php"; ?>
        <script>
            let tools = new Tools();

            let listaVenta = [];

            $(document).ready(function() {

                $("#btnCobrar").click(function() {
                    if(listaVenta.length == 0){
                        tools.AlertWarning("Ventas: ","No hay ítems en la lista para continuar.");
                    }else{
                        $("#modalCobro").modal("show");
                    }                    
                })

                $("#btnCancelModal").click(function() {
                    //closeClearModal()
                    $("#modalCobro").modal("hide")
                });

                $("#btnCloseModal").click(function() {
                    //closeClearModal()
                    $("#modalCobro").modal("hide")
                });

                $("#btnPlazos").click(function() {
                    let currentDate = Date.now();
                    $("#tvPlazos").append('<tr id="'+currentDate+'">' +
                        '<td><input class="form-control" type="number" /></td>' +
                        '<td><input class="form-control" type="date" /></td>' +
                        '<td><div class="text-center"><input type="checkbox" /></div></td>' +
                        '<td><button class="btn btn-danger" onclick="removePlazos(\'' +currentDate + '\')"><i class="fa fa-trash"></i></button></td>' +
                        '</tr>');

                    $("#tvPlazos tr").each(function(row, tr) {        
                        console.log(row)                
                        //$(tr).find("td:eq(2)").find("input").val();                            
                        //console.log($(tr).find("td:eq(2)").find('input[type="checkbox"]').is(':checked'));
                        // console.log($(tr).find("td:eq(2)").find("input").val());
                    });
                });

                $("#btnGuardarModal").click(function(){
                    registrarVenta();
                });

            });

            function registrarVenta(){             
                if($("#pills-home-tab").hasClass("active")){
                   if(!tools.isNumeric($("#monto").val())){
                    tools.AlertWarning("Venta: ","Ingrese el monto por favor.");
                    $("#monto").focus();
                   }
                }else{

                }
            }

            function removePlazos(idPlazos){
                $("#" + idPlazos).remove();
            }
        </script>
    </body>

    </html>

<?php
}
