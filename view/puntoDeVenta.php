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

            <!-- Sidebar menu-->
            <?php include "./marcarentrada.php"; ?>

            <!-- modal pagar  -->
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
                                        <p class="h5">TOTAL A PAGAR: <b class="h5 text-info" id="lblTotalPagar">S/ 0.00</b></p>
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
                                                                <button id="btnEfectivo" class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
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
                                                                            <input id="monto" type="text" class="form-control form-control-sm">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row justify-content-center">
                                                                    <div class="col-md-6">
                                                                        <label id="lblPorCobrar">Por cobrar:</label>
                                                                        <div class="form-group">
                                                                            <input id="vuelto" type="text" class="form-control form-control-sm" disabled>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card">
                                                        <div class="card-header" id="headingTwo">
                                                            <h2 class="mb-0">
                                                                <button id="btnTarjeta" class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
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
                                                                            <input id="montotarjeta" type="text" class="form-control form-control-sm">
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
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12">
                                                        <label>Crédito:</label>
                                                        <div class="form-group">
                                                            <button class="btn btn-outline-primary btn-sm" id="btnPlazos" type="button">Agregar cuota +</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-12">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label>Forma de Pago:</label>
                                                                <div class="form-group">
                                                                    <select id="formapagocredito" class="form-control form-control-sm">
                                                                        <option value="">- Selecciona -</option>
                                                                        <option value="1">EFECTIVO</option>
                                                                        <option value="2">TARJETA</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <label>N° Operación: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                                        <div class="form-group">
                                                                            <input id="numerocreditotarjeta" type="text" class="form-control form-control-sm">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
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

            <!-- modal lista cliente -->
            <div class="row">
                <div class="modal fade" id="modalLista" data-backdrop="static">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">
                                    <i class="fa fa-users"></i> Lista de Clientes
                                </h4>
                                <button type="button" class="close" id="btnCloseModalClientes">
                                    <i class="fa fa-close"></i>
                                </button>
                            </div>
                            <div class="modal-body">

                                <div class="row">
                                    <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                                        <div class="form-group d-flex">
                                            <div class="input-group">
                                                <input type="search" class="form-control" placeholder="Buscar por apellidos, nombres o dni" aria-controls="sampleTable" id="txtSearchLista">
                                                <div class="input-group-append">
                                                    <button class="btn btn-info" type="button" id="btnReloadCliente"><i class="fa fa-refresh"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                                        <div class="form-group">
                                            <div class="text-right">
                                                <button class="btn btn-primary" id="btnAnterior">
                                                    <i class="fa fa-arrow-circle-left"></i>
                                                </button>
                                                <span class="m-2" id="lblPaginaActual">0
                                                </span>
                                                <span class="m-2">
                                                    de
                                                </span>
                                                <span class="m-2" id="lblPaginaSiguiente">0
                                                </span>
                                                <button class="btn btn-primary" id="btnSiguiente">
                                                    <i class="fa fa-arrow-circle-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <div class="tile-body">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1" style="width: 59px;">#</th>
                                                            <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1" style="width: 250px;">
                                                                Cliente</th>
                                                            <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1" style="width: 72px;">Celular
                                                            </th>
                                                            <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1" style="width: 59px;">Estado
                                                            </th>
                                                            <th class="sorting" aria-controls="sampleTable" rowspan="1" colspan="1" style="width: 69px;">Membresia
                                                            </th>
                                                            <th class="sorting_asc" aria-controls="sampleTable" rowspan="1" colspan="1" style="width: 107px;">Descripción
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbListaCliente">
                                                        <!-- tbLista -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 ">
                                        <label class="text-danger">Para seleccione un cliente hacer doble click en la lista.</label>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- modal nuevo cliente -->
            <div class="row">
                <div class="modal fade" id="modalCliente" data-backdrop="static">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="titulo-modal">
                                </h4>
                                <button type="button" class="close" id="btnCloseModalNewCliente">
                                    <i class="fa fa-close"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="dni">DNI: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <input id="dni" type="number" name="dni" class="form-control" placeholder="Ingrese el número DNI" required="" minlength="8">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="apellidos">Apellidos: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <input id="apellidos" type="text" name="apellidos" class="form-control" placeholder="Ingrese los Apellidos" required="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nombres">Nombres: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <input id="nombres" type="text" name="nombres" class="form-control" placeholder="Ingrese los Nombres" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="genero">Genero: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <select id="genero" class="form-control">
                                                <option value="1">Maculino</option>
                                                <option value="0">Femenino</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nacimiento">Nacimiento: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <input id="nacimiento" type="date" name="nacimiento" class="form-control" required="">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="codigo">Codigo: </label>
                                            <input id="codigo" type="text" name="codigo" class="form-control" placeholder="Ingrese el Codigo" required="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email: </label>
                                            <input id="email" type="email" name="email" class="form-control" placeholder="Ingrese el correo" required="">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="celular">Celular: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <input id="celular" type="number" name="celular" class="form-control" placeholder="Ingrese el número de celular" required="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="direccion">Dirección: </label>
                                            <input id="direccion" type="text" name="direccion" class="form-control" placeholder="Ingrese la dirección" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="descripcion">Descripción: </label>
                                            <input id="descripcion" type="text" name="descripcion" class="form-control" placeholder="Ingrese una descripción" required="">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <p class="text-left text-danger">Todos los campos marcados con <i class="fa fa-fw fa-asterisk text-danger"></i> son obligatorios</p>
                                <button type="button" class="btn btn-success" id="btnGuardarModalNewCliente">
                                    <i class="fa fa-save"></i> Guardar</button>
                                <button type="button" class="btn btn-danger" id="btnCancelModalNewCliente">
                                    <i class="fa fa-remove"></i> Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- modal lista planes -->
            <div class="row">
                <div class="modal fade" id="modalPlan" data-backdrop="static">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="titulo-modal">
                                    <i class="fa fa-bandcamp"></i> Planes
                                </h4>
                                <button type="button" class="close" id="btnCloseModalPlanes">
                                    <i class="fa fa-close"></i>
                                </button>
                            </div>
                            <div class="modal-body">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Seleccione el Plan: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <select id="plan" class="form-control">
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="text-danger" id="errorPlan"></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="h6" id="lblNombrePlan">Nombre: </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="h6" id="lblPrecioPlan">Precio: </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="h6" id="lblTiempoPlan">Tiempo: </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="h6" id="lblDisciplinasPlan">Disciplinas: </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="h6" id="lblDescripcionPlan">Descripcion: </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" id="inicio" type="checkbox">Fecha de Inicio:
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input id="fechainicio" type="date" class="form-control" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="descuento">Descuento: </label>
                                            <input id="descuento" type="text" value="0" class="form-control" placeholder="Ingrese el descuento">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="Membresia">Tipo de Membresia: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <select id="Membresia" class="form-control">
                                                <option value="">- Selecciona -</option>
                                                <option value="1">Nuevo</option>
                                                <option value="2">Recuperación</option>
                                                <option value="3">Renovación</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cantidad">Cantidad: </label>
                                            <input id="cantidad" type="number" value="1" class="form-control" placeholder="Ingrese la cantidad">
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <p class="text-left text-danger">
                                    Todos los campos marcados con <i class="fa fa-fw fa-asterisk text-danger"></i> son obligatorios
                                </p>
                                <button type="button" class="btn btn-success" id="btnGuardarModalPlanes">
                                    <i class="fa fa-check"></i> Aceptar</button>
                                <button type="button" class="btn btn-danger" id="btnCancelarModalPlanes">
                                    <i class="fa fa-close"></i> Cancelar</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- modal lista Productos -->
            <div class="row">
                <div class="modal fade" id="modalProductos" data-backdrop="static">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="titulo-modal">
                                    <i class="fa fa fa-shopping-bag"></i> Lista de Productos
                                </h4>
                                <button type="button" class="close" id="btnCloseModalProductos">
                                    <i class="fa fa-close"></i>
                                </button>
                            </div>
                            <div class="modal-body">

                                <div class="row">
                                    <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                                        <div class="form-group">
                                            <input type="search" class="form-control" placeholder="Buscar por nombre o codigo de producto" aria-controls="sampleTable" id="txtSearProducto">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                                        <div class="form-group">
                                            <div class="text-right">
                                                <button class="btn btn-primary" id="btnAnterior">
                                                    <i class="fa fa-arrow-circle-left"></i>
                                                </button>
                                                <span class="m-2" id="lblPaginaActual">0
                                                </span>
                                                <span class="m-2">
                                                    de
                                                </span>
                                                <span class="m-2" id="lblPaginaSiguiente">0
                                                </span>
                                                <button class="btn btn-primary" id="btnSiguiente">
                                                    <i class="fa fa-arrow-circle-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 ">

                                        <div class="tile-body">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th class="sorting" width="5%">#</th>
                                                            <th class="sorting_asc" width="50%">Codigo / Nombre</th>
                                                            <th class="sorting" width="15%">Categoria</th>
                                                            <th class="sorting" width="15%">Cantidad </th>
                                                            <th class="sorting" width="15%">Precio</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbListaProductos">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>

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
                                    <!-- <button class="btn btn-success" type="button" id="btnProductos"><i class="fa fa-plus"></i>
                                        Productos</button> -->
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

        </main>
        <!-- Essential javascripts for application to work-->
        <?php include "./layout/footer.php"; ?>
        <script>
            let tools = new Tools();

            let listaVenta = [];

            let tbListaCliente = $("#tbListaCliente");

            let tbListaProductos = $("#tbListaProductos");

            let listarPlanes = [];
            let idPlan = "";
            let nombrePlan = "";
            let precioPlan = 0;
            let mesesPlan = 0;
            let diasPlan = 0;
            let freezePlan = 0;

            let idCliente = "";

            let total = 0;
            let montoCambio = 0;

            let idEmpleado = "<?php echo $_SESSION["IdEmpleado"] ?>";

            $(document).ready(function() {

                $("#monto").keypress(function() {
                    var key = window.Event ? event.which : event.keyCode;
                    var c = String.fromCharCode(key);
                    if ((c < '0' || c > '9') && (c != '\b') && (c != '.')) {
                        event.preventDefault();
                    }
                    if (c == '.' && $("#monto").val().includes(".")) {
                        event.preventDefault();
                    }
                });

                $("#montocreditotarjeta").keypress(function() {
                    var key = window.Event ? event.which : event.keyCode;
                    var c = String.fromCharCode(key);
                    if ((c < '0' || c > '9') && (c != '\b') && (c != '.')) {
                        event.preventDefault();
                    }
                    if (c == '.' && $("#montocreditotarjeta").val().includes(".")) {
                        event.preventDefault();
                    }
                });

                $("#txtNumeracion").keypress(function() {
                    var key = window.Event ? event.which : event.keyCode;
                    var c = String.fromCharCode(key);
                    if ((c < '0' || c > '9') && (c != '\b')) {
                        event.preventDefault();
                    }
                });

                $("#descuento").keypress(function() {
                    var key = window.Event ? event.which : event.keyCode;
                    var c = String.fromCharCode(key);
                    if ((c < '0' || c > '9') && (c != '\b') && (c != '.')) {
                        event.preventDefault();
                    }
                    if (c == '.' && $("#descuento").val().includes(".")) {
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

                $("#modalLista").on('shown.bs.modal', function() {
                    listaClientes($("#txtSearchLista").val());
                });

                $("#btnListaCliente").click(function() {
                    $("#modalLista").modal("show");
                });

                $("#txtSearchLista").keypress(function() {
                    if ($("#txtSearchLista").val().trim() != '') {
                        listaClientes($("#txtSearchLista").val());
                    }
                });

                $("#btnReloadCliente").click(function() {
                    listaClientes("");
                });

                $("#btnCloseModalClientes").click(function() {
                    $("#modalLista").modal("hide");
                    tbListaCliente.empty();
                });

                $("#btnOpenModalCliente").click(function() {
                    $("#modalCliente").modal("show");
                    $("#titulo-modal").append('<i class="fa fa-user-plus"></i> Registrar Cliente')
                });

                $("#btnCloseModalNewCliente").click(function() {
                    $("#modalCliente").modal("hide");
                    $("#titulo-modal").empty();
                    closeClearModal();
                });

                $("#btnCancelModalNewCliente").click(function() {
                    $("#modalCliente").modal("hide");
                    $("#titulo-modal").empty();
                    closeClearModal();
                });

                $("#btnGuardarModalNewCliente").click(function() {
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
                        tools.ModalDialog('Cliente', '¿Desea guardar los datos?', 'question', function(result) {
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
                //-----------------------------------

                $("#inicio").change(function() {
                    $("#fechainicio").prop('disabled', !$("#inicio").is(':checked'));
                });

                $("#btnPlan").click(function() {
                    $("#modalPlan").modal("show");
                    listaPlanes();
                });

                $("#btnCloseModalPlanes").click(function() {
                    $("#modalPlan").modal("hide");
                    clearPlanes();
                });

                $("#btnCancelarModalPlanes").click(function() {
                    $("#modalPlan").modal("hide");
                    clearPlanes();
                });


                $("#plan").change(function() {
                    for (let i = 0; i < listarPlanes.length; i++) {
                        if (listarPlanes[i].idPlan == $(this).val()) {
                            idPlan = listarPlanes[i].idPlan;
                            nombrePlan = listarPlanes[i].nombre;
                            precioPlan = listarPlanes[i].precio;
                            mesesPlan = listarPlanes[i].meses;
                            diasPlan = listarPlanes[i].dias;
                            freezePlan = listarPlanes[i].freeze;

                            $("#lblNombrePlan").html("Nombre: " + nombrePlan);
                            $("#lblPrecioPlan").html("Precio: S/ " + tools.formatMoney(precioPlan));
                            $("#lblDescripcionPlan").html("Descripcion: " + listarPlanes[i].descripcion);
                            $("#lblTiempoPlan").html("Tiempo: " + (mesesPlan == 1 ? mesesPlan + " Mes y " + (diasPlan == 1 ? diasPlan + " día" : diasPlan + " días") : mesesPlan + " Meses y " + (diasPlan == 1 ? diasPlan + " día" : diasPlan + " días")) + " Libre: " + freezePlan + " día(s)");
                            $("#lblDisciplinasPlan").html("Disciplinas: Ilimitadas");
                            break;
                        }
                    }
                });

                $("#btnGuardarModalPlanes").click(function() {
                    if (idPlan == '') {
                        tools.AlertWarning("Ventas: ", "Seleccione un plan.")
                        $("#plan").focus();
                    } else if ($("#Membresia").val() == '') {
                        tools.AlertWarning("Ventas: ", "Seleccione una membresia.")
                        $("#Membresia").focus();
                    } else if ($("#inicio").is(':checked') && !tools.validateDate($("#fechainicio").val())) {
                        tools.AlertWarning("Ventas: ", "Ingre la fecha de inicio.")
                        $("#fechainicio").focus()
                    } else if (!tools.isNumeric($("#cantidad").val())) {
                        tools.AlertWarning("Ventas: ", "Ingrese una cantidad.")
                        $("#cantidad").focus();
                    } else if (parseInt($("#cantidad").val()) <= 0) {
                        tools.AlertWarning("Ventas: ", "Ingrese una cantidad mayor a 0.")
                        $("#cantidad").focus();
                    } else {
                        if (!validateDatelleVenta($("#plan").val())) {

                            let cantidad = parseInt($("#cantidad").val());
                            let descuento = !tools.isNumeric($("#descuento").val()) ? 0 : parseFloat($("#descuento").val());

                            let fechaInicio = $("#inicio").is(':checked') ? $("#fechainicio").val() : tools.getCurrentDate();
                            let fechaFin = fechaInicio;
                            let fecha = new Date(fechaFin);
                            let dias = (parseInt(mesesPlan * cantidad) * 30) + parseInt(diasPlan) + parseInt(freezePlan);
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
                            $("#modalPlan").modal("hide");
                            clearPlanes();
                        } else {
                            tools.AlertWarning("Ventas: ", "Ya existe una plan con las mismas caracteristicas.")
                        }
                    }
                });

                //-----------------------------------
                $("#modalProductos").on('shown.bs.modal', function() {
                    listaProductos($("#txtSearProducto").val())
                });

                $("#txtSearProducto").keyup(function() {
                    if ($("#txtSearProducto").val().trim() != '') {
                        listaProductos($("#txtSearProducto").val().trim());
                    }
                });

                $("#btnProductos").click(function() {
                    $("#modalProductos").modal("show")
                })

                $("#btnCloseModalProductos").click(function() {
                    $("#modalProductos").modal("hide")
                });

                //-----------------------------------
                $("#btnCobrar").click(function() {
                    if (listaVenta.length == 0) {
                        tools.AlertWarning("Ventas: ", "No hay ítems en la lista para continuar.");
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

                $("#btnCancelModal").click(function() {
                    $("#modalCobro").modal("hide")
                });

                $("#btnCloseModal").click(function() {
                    $("#modalCobro").modal("hide")
                });

                $("#btnPlazos").click(function() {
                    let currentDate = Date.now();
                    $("#tvPlazos").append('<tr id="' + currentDate + '">' +
                        '<td><input class="form-control form-control-sm" type="number" /></td>' +
                        '<td><input class="form-control form-control-sm" type="date" /></td>' +
                        '<td><div class="text-center"><input type="checkbox" /></div></td>' +
                        '<td><button class="btn btn-danger" onclick="removePlazos(\'' + currentDate + '\')"><i class="fa fa-trash"></i></button></td>' +
                        '</tr>');

                });

                $("#btnGuardarModal").click(function() {
                    registrarVenta();
                });

                $("#monto").keyup(function(event) {
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

                listaComprobantes();

            });

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
                            tools.ModalDialog('Venta', '¿Está seguro de continuar?', 'question', function(value) {
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
                                        beforeSend: function() {
                                            $("#modalCobro").modal("hide");
                                            clearComponents();
                                            clearPlanes();
                                            tools.ModalAlertInfo('Venta', 'Procesando petición...');
                                        },
                                        success: function(result) {
                                            if (result.estado == 1) {
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
                    } else if ($("#btnTarjeta").attr('aria-expanded') == 'true') {
                        if (!tools.isNumeric($("#montotarjeta").val())) {
                            tools.AlertWarning("Venta: ", "Ingrese el monto por favor.");
                            $("#montotarjeta").focus();
                        } else if ($("#numerotarjeta").val() == '') {
                            tools.AlertWarning("Venta: ", "Ingrese número de la operación.");
                            $("#numerotarjeta").focus();
                        } else {
                            tools.ModalDialog('Venta', '¿Está seguro de continuar?', 'question', function(value) {
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
                                        beforeSend: function() {
                                            $("#modalCobro").modal("hide");
                                            clearComponents();
                                            clearPlanes();
                                            tools.ModalAlertInfo('Venta', 'Procesando petición...');
                                        },
                                        success: function(result) {
                                            if (result.estado == 1) {
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
                        $("#tvPlazos tr").each(function(row, tr) {
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
                            tools.ModalDialog('Venta', '¿Está seguro de continuar?', 'question', function(value) {
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
                                        beforeSend: function() {
                                            $("#modalCobro").modal("hide");
                                            clearComponents();
                                            clearPlanes();
                                            tools.ModalAlertInfo('Venta', 'Procesando petición...');
                                        },
                                        success: function(result) {
                                            if (result.estado == 1) {
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
                    }
                }
            }

            function removePlazos(idPlazos) {
                $("#" + idPlazos).remove();
            }

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

            function listaClientes(text) {
                $.ajax({
                    url: "../app/cliente/Obtener_Clientes.php",
                    method: "GET",
                    data: {
                        opcion: 1,
                        page: 1,
                        datos: text
                    },
                    beforeSend: function() {
                        // state = true;
                        tbListaCliente.empty();
                        tbListaCliente.append(
                            '<tr role="row" class="odd"><td class="sorting_1" colspan="6" style="text-align:center"><img src="./images/loading.gif" width="100"/><p>cargando información...</p></td></tr>'
                        );
                    },
                    success: function(result) {
                        let data = JSON.parse(result);
                        console.log(data)
                        if (data.estado == 1) {
                            tbListaCliente.empty();
                            for (let cliente of data.clientes) {
                                tbListaCliente.append('<tr ondblclick="onSelectCliente(\'' + cliente.idCliente + '\',\'' + cliente.apellidos + '\',\'' + cliente.nombres + '\')" role="row" >' +
                                    '<td class="sorting_1">' + cliente.id + '</td>' +
                                    // '<td>' + cliente.dni + '</td>' +
                                    '<td>' + cliente.dni + '<br>' + cliente.apellidos + " " + cliente.nombres + '</td>' +
                                    '<td>' + cliente.celular + '</td>' +
                                    '<td><span class="badge badge-pill badge-success">Activo</span></td>' +
                                    '<td>' + (cliente.membresia >= 1 ? cliente.membresia + " MEMBRESIA(S)" :
                                        "NINGUNA") + "<br>" + (cliente.venta == 1 ? cliente.venta +
                                        " deuda(s)" : "0 deudas") + '</td>' +
                                    '<td>' + cliente.descripcion + '</td>' +
                                    '</tr>');
                            }
                            // totalPaginacion = parseInt(Math.ceil((parseFloat(data.total) / parseInt(
                            //     10))));
                            // $("#lblPaginaActual").html(paginacion);
                            // $("#lblPaginaSiguiente").html(totalPaginacion);
                            // state = false;
                        } else {
                            tbListaCliente.empty();
                            tbListaCliente.append(
                                '<tr role="row" class="odd"><td class="sorting_1" colspan="6" style="text-align:center"><p>' +
                                data.mensaje + '</p></td></tr>');
                            // $("#lblPaginaActual").html(0);
                            // $("#lblPaginaSiguiente").html(0);
                            // state = false;
                        }
                    },
                    error: function(error) {
                        tbListaCliente.empty();
                        tbListaCliente.append(
                            '<tr role="row" class="odd"><td class="sorting_1" colspan="6" style="text-align:center"><p>' +
                            error.responseText + '</p></td></tr>');
                        // $("#lblPaginaActual").html(0);
                        // $("#lblPaginaSiguiente").html(0);
                        // state = false;
                    }
                });
            }

            function onSelectCliente(id, apellidos, nombres) {
                idCliente = id;
                $("#clienteDatos").val(apellidos + " " + nombres)
                $("#modalLista").modal("hide")
            }

            function listaPlanes() {
                $.ajax({
                    url: "../app/plan/Obtener_Datos_Para_Select.php",
                    method: "GET",
                    data: {},
                    beforeSend: function() {
                        listarPlanes = [];
                        $("#plan").empty();
                    },
                    success: function(result) {
                        if (result.estado == 1) {
                            listarPlanes = result.planes;
                            $("#plan").append('<option value="">- Selecciona -</option>');
                            for (let plan of listarPlanes) {
                                $("#plan").append('<option id="' + plan.precio + '" value="' + plan.idPlan + '">' + plan.nombre + (' S/ ' + tools.formatMoney(plan.precio)) + '</option>');
                            }
                        } else {
                            $("#errorPlan").html(result.mensaje);
                        }
                    },
                    error: function(error) {
                        $("#errorPlan").html("Ha ocurrido un problema en cargar los planes.");
                    }
                });
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
                        } else {
                            $("#errorComprobante").html(result.mensaje);
                        }
                    },
                    error: function(error) {
                        $("#errorComprobante").html("Ha ocurrido un problema en cargar los comprobantes.");
                    }
                });
            }

            function listaProductos(text) {
                $.ajax({
                    url: "../app/productos/ProductoController.php",
                    method: "GET",
                    data: {
                        "type": "lista",
                        "page": 1,
                        "datos": text
                    },
                    beforeSend: function() {
                        // state = true;
                        tbListaProductos.empty();
                        tbListaProductos.append(
                            '<tr role="row" class="odd"><td class="sorting_1" colspan="5" style="text-align:center"><img src="./images/loading.gif" width="100"/>p>Cargando información...</p></td></tr>'
                        );
                    },
                    success: function(result) {
                        tbListaProductos.empty();
                        let data = result;
                        if (data.estado == 1) {

                            if (data.productos.length == 0) {
                                tbListaProductos.append(
                                    '<tr role="row" class="odd"><td class="sorting_1" colspan="5" style="text-align:center">No datos para mostrar.<p></p></td></tr>'
                                );
                            } else {
                                for (let producto of data.productos) {
                                    tbListaProductos.append('<tr role="row" class="odd">' +
                                        '<td class="text-center">' + producto.id + '</td>' +
                                        '<td>' + producto.clave + '<br>' + producto.nombre + '</td>' +
                                        '<td>' + producto.categoria + '</td>' +
                                        '<td class="text-right">' + tools.formatMoney(producto.cantidad) + '</td>' +
                                        '<td class="text-right">' + tools.formatMoney(producto.precio) + '</td>' +
                                        '</tr>');
                                }
                                // totalPaginacion = parseInt(Math.ceil((parseFloat(data.total) / parseInt(
                                //     10))));
                                // $("#lblPaginaActual").html(paginacion);
                                // $("#lblPaginaSiguiente").html(totalPaginacion);
                                // state = false;
                            }

                        } else {
                            tbListaProductos.append(
                                '<tr role="row" class="odd"><td class="sorting_1" colspan="5" style="text-align:center"><p>' +
                                data.mensaje + '</p></td></tr>');
                            // $("#lblPaginaActual").html(0);
                            // $("#lblPaginaSiguiente").html(0);
                            // state = false;
                        }
                    },
                    error: function(error) {
                        tbListaProductos.empty();
                        tbListaProductos.append(
                            '<tr role="row" class="odd"><td class="sorting_1" colspan="5" style="text-align:center"><p>' +
                            error.responseText + '</p></td></tr>');
                        // $("#lblPaginaActual").html(0);
                        // $("#lblPaginaSiguiente").html(0);
                        // state = false;
                    }
                });
            }

            function registrarCliente(dni, apellidos, nombres, genero, nacimiento, codigo, email, celular, direccion, descripcion) {
                $.ajax({
                    url: "../app/cliente/Crud_Clientes.php",
                    method: "POST",
                    accepts: "application/json",
                    contentType: "application/json",
                    data: JSON.stringify({
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
                    beforeSend: function() {
                        closeClearModal();
                        tools.ModalAlertInfo('Cliente', 'Procesando petición...');
                    },
                    success: function(result) {
                        if (result.estado == 1) {
                            tools.ModalAlertSuccess('Cliente', result.mensaje);
                        } else {
                            tools.ModalAlertWarning('Cliente', result.mensaje);
                        }
                    },
                    error: function(error) {
                        tools.ModalAlertError("Cliente", error.responseText);
                    }
                });
            }

            function closeClearModal() {
                $("#modalCliente").modal("hide")
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


            function clearComponents() {
                idCliente = "";
                $("#clienteDatos").val("");
                listaVenta = [];
                listarPlanes = [];
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
                $("#plan").val("");
                $("#Membresia").val("");
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
}
