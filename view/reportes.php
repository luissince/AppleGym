<?php
session_start();
if (!isset($_SESSION["IdEmpleado"])) {
    echo '<script>location.href = "./login.php";</script>';
} else {
    if ($_SESSION["Roles"][13]["ver"] == 1) {
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
            <!-- modal de ingresos por fechas -->
            <div class="row">
                <div class="modal fade show" id="modalIngresos" data-backdrop="static" aria-modal="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="titulo-modal">
                                    <i class="fa fa-calendar"></i> Resumen de Ingresos - Ventas
                                </h4>
                                <button type="button" class="close" data-dismiss="modal">
                                    <i class="fa fa-close"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txtFechaInicioIngreso">Fecha de Inicio: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <input id="txtFechaInicioIngreso" type="date" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txtFechaFinalIngreso">Fecha Final: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <input id="txtFechaFinalIngreso" type="date" class="form-control">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" id="btnAceptarIngresos">
                                    <i class="fa fa-file-pdf-o"></i> Aceptar</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">
                                    <i class="fa fa-remove"></i> Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- modal de ingresos por fechas -->

            <!-- modal de asistencia - cliente por fechas -->
            <div class="row">
                <div class="modal fade show" id="modalAsistenciaClientes" data-backdrop="static" aria-modal="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="titulo-modal">
                                    <i class="fa fa-calendar"></i> Resumen de Asistencia - Clientes
                                </h4>
                                <button type="button" class="close" data-dismiss="modal">
                                    <i class="fa fa-close"></i>
                                </button>
                            </div>
                            <div class="modal-body">

                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label for="txtFechaInicioAsistenciaClientes">Fecha de Inicio: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <input id="txtFechaInicioAsistenciaClientes" type="date" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label for="txtFechaFinalAsistenciaClientes">Fecha Final: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <input id="txtFechaFinalAsistenciaClientes" type="date" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row border-bottom">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-right">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-success" id="btnAceptarAsistenciaClientes">
                                                <i class="fa fa-file-pdf-o"></i> Generar</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label for="cbMonthAsistenciaClientes">Mes: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <select id="cbMonthAsistenciaClientes" class="form-control">
                                                <option value="1">Enero</option>
                                                <option value="2">Febreo</option>
                                                <option value="3">Marzo</option>
                                                <option value="4">Abril</option>
                                                <option value="5">Mayo</option>
                                                <option value="6">Junio</option>
                                                <option value="7">Julio</option>
                                                <option value="8">Agosto</option>
                                                <option value="9">Setiembre</option>
                                                <option value="10">Octubre</option>
                                                <option value="11">Noviembre</option>
                                                <option value="12">Diciembre</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label for="cbYearAsistenciaClientes">Año: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <select id="cbYearAsistenciaClientes" class="form-control">
                                                <option value="2010">2010</option>
                                                <option value="2011">2011</option>
                                                <option value="2012">2012</option>
                                                <option value="2013">2013</option>
                                                <option value="2014">2014</option>
                                                <option value="2015">2015</option>
                                                <option value="2016">2016</option>
                                                <option value="2017">2017</option>
                                                <option value="2018">2018</option>
                                                <option value="2019">2019</option>
                                                <option value="2020">2020</option>
                                                <option value="2021">2021</option>
                                                <option value="2022">2022</option>
                                                <option value="2023">2023</option>
                                                <option value="2024">2024</option>
                                                <option value="2025">2025</option>
                                                <option value="2026">2026</option>
                                                <option value="2027">2027</option>
                                                <option value="2028">2028</option>
                                                <option value="2029">2029</option>
                                                <option value="2030">2030</option>
                                                <option value="2031">2031</option>
                                                <option value="2032">2032</option>
                                                <option value="2033">2033</option>
                                                <option value="2034">2034</option>
                                                <option value="2035">2035</option>
                                                <option value="2036">2036</option>
                                                <option value="2037">2037</option>
                                                <option value="2038">2038</option>
                                                <option value="2039">2039</option>
                                                <option value="2040">2040</option>
                                                <option value="2041">2041</option>
                                                <option value="2042">2042</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-right">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-success" id="btnAceptarAsistenciaPorMesClientes">
                                                <i class="fa fa-file-pdf-o"></i> Generar</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">

                                <button type="button" class="btn btn-danger" data-dismiss="modal">
                                    <i class="fa fa-remove"></i> Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- modal de asistencia - cliente por fechas -->

            <!-- modal de asistencia - empleados por fechas -->
            <div class="row">
                <div class="modal fade show" id="modalAsistenciaPersonal" data-backdrop="static" aria-modal="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="titulo-modal">
                                    <i class="fa fa-calendar"></i> Resumen de Asistencia - Personal
                                </h4>
                                <button type="button" class="close" data-dismiss="modal">
                                    <i class="fa fa-close"></i>
                                </button>
                            </div>
                            <div class="modal-body">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txtFechaInicioAsistenciaPersonal">Fecha de Inicio: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <input id="txtFechaInicioAsistenciaPersonal" type="date" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txtFechaFinalAsistenciaPersonal">Fecha Final: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <input id="txtFechaFinalAsistenciaPersonal" type="date" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row border-bottom">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-right">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-success" id="btnAceptarAsistenciaPersonal">
                                                <i class="fa fa-file-pdf-o"></i> Generar</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label for="cbMonthAsistenciaPersonal">Mes: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <select id="cbMonthAsistenciaPersonal" class="form-control">
                                                <option value="1">Enero</option>
                                                <option value="2">Febrero</option>
                                                <option value="3">Marzo</option>
                                                <option value="4">Abril</option>
                                                <option value="5">Mayo</option>
                                                <option value="6">Junio</option>
                                                <option value="7">Julio</option>
                                                <option value="8">Agosto</option>
                                                <option value="9">Setiembre</option>
                                                <option value="10">Octubre</option>
                                                <option value="11">Noviembre</option>
                                                <option value="12">Diciembre</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label for="cbYearAsistenciaPersonal">Año: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <select id="cbYearAsistenciaPersonal" class="form-control">
                                                <option value="2010">2010</option>
                                                <option value="2011">2011</option>
                                                <option value="2012">2012</option>
                                                <option value="2013">2013</option>
                                                <option value="2014">2014</option>
                                                <option value="2015">2015</option>
                                                <option value="2016">2016</option>
                                                <option value="2017">2017</option>
                                                <option value="2018">2018</option>
                                                <option value="2019">2019</option>
                                                <option value="2020">2020</option>
                                                <option value="2021">2021</option>
                                                <option value="2022">2022</option>
                                                <option value="2023">2023</option>
                                                <option value="2024">2024</option>
                                                <option value="2025">2025</option>
                                                <option value="2026">2026</option>
                                                <option value="2027">2027</option>
                                                <option value="2028">2028</option>
                                                <option value="2029">2029</option>
                                                <option value="2030">2030</option>
                                                <option value="2031">2031</option>
                                                <option value="2032">2032</option>
                                                <option value="2033">2033</option>
                                                <option value="2034">2034</option>
                                                <option value="2035">2035</option>
                                                <option value="2036">2036</option>
                                                <option value="2037">2037</option>
                                                <option value="2038">2038</option>
                                                <option value="2039">2039</option>
                                                <option value="2040">2040</option>
                                                <option value="2041">2041</option>
                                                <option value="2042">2042</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-right">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-success" id="btnAceptarAsistenciaPorMesPersonal">
                                                <i class="fa fa-file-pdf-o"></i> Generar</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">
                                    <i class="fa fa-remove"></i> Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- modal de asistencia - empleados por fechas -->

            <!-- modal de resumen de membresia -->
            <div class="row">
                <div class="modal fade show" id="modalAsistenciaModal" data-backdrop="static" aria-modal="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="titulo-modal">
                                    <i class="fa fa-calendar"></i> Resumen de Membresia - Mes
                                </h4>
                                <button type="button" class="close" data-dismiss="modal">
                                    <i class="fa fa-close"></i>
                                </button>
                            </div>
                            <div class="modal-body">

                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label for="cbMonthMembresia">Mes: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <select id="cbMonthMembresia" class="form-control">
                                                <option value="1">Enero</option>
                                                <option value="2">Febreo</option>
                                                <option value="3">Marzo</option>
                                                <option value="4">Abril</option>
                                                <option value="5">Mayo</option>
                                                <option value="6">Junio</option>
                                                <option value="7">Julio</option>
                                                <option value="8">Agosto</option>
                                                <option value="9">Setiembre</option>
                                                <option value="10">Octubre</option>
                                                <option value="11">Noviembre</option>
                                                <option value="12">Diciembre</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label for="cbYearMembresia">Año: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <select id="cbYearMembresia" class="form-control">
                                                <option value="2010">2010</option>
                                                <option value="2011">2011</option>
                                                <option value="2012">2012</option>
                                                <option value="2013">2013</option>
                                                <option value="2014">2014</option>
                                                <option value="2015">2015</option>
                                                <option value="2016">2016</option>
                                                <option value="2017">2017</option>
                                                <option value="2018">2018</option>
                                                <option value="2019">2019</option>
                                                <option value="2020">2020</option>
                                                <option value="2021">2021</option>
                                                <option value="2022">2022</option>
                                                <option value="2023">2023</option>
                                                <option value="2024">2024</option>
                                                <option value="2025">2025</option>
                                                <option value="2026">2026</option>
                                                <option value="2027">2027</option>
                                                <option value="2028">2028</option>
                                                <option value="2029">2029</option>
                                                <option value="2030">2030</option>
                                                <option value="2031">2031</option>
                                                <option value="2032">2032</option>
                                                <option value="2033">2033</option>
                                                <option value="2034">2034</option>
                                                <option value="2035">2035</option>
                                                <option value="2036">2036</option>
                                                <option value="2037">2037</option>
                                                <option value="2038">2038</option>
                                                <option value="2039">2039</option>
                                                <option value="2040">2040</option>
                                                <option value="2041">2041</option>
                                                <option value="2042">2042</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-right">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-success" id="btnAceptarMembreias">
                                                <i class="fa fa-file-pdf-o"></i> Generar</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">
                                    <i class="fa fa-remove"></i> Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- modal de resumen de membresia -->

            <!-- modal de servicios -->
            <div class="row">
                <div class="modal fade show" id="modalServicioModal" data-backdrop="static" aria-modal="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="titulo-modal">
                                    <i class="fa fa-calendar"></i> Resumen de Servicios/Inscripción
                                </h4>
                                <button type="button" class="close" data-dismiss="modal">
                                    <i class="fa fa-close"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label for="cbServicios">Servicio/Inscripción: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                            <select id="cbServicios" style="width: 100%;" class="form-control select2">
                                                <option value="">- Selecciona -</option>                                               
                                            </select>
                                        </div>
                                    </div>                                    
                                </div>

                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-right">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-success" id="btnAceptarServiciosInscripcion">
                                                <i class="fa fa-file-pdf-o"></i> Generar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">
                                    <i class="fa fa-remove"></i> Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- modal de resumen de membresia -->

            <main class="app-content">
                <!-- Sidebar menu-->
                <?php include "./marcarentrada.php"; ?>

                <div class="app-title">
                    <div>
                        <h1><i class="fa fa-bar-chart"></i> Reportes <spam id="loading"></spam>
                        </h1>
                    </div>
                </div>

                <div class="tile mb-4">

                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                            <button class="btn btn-default" id="btnReporteIngresos">
                                <div class="bs-component">
                                    <div class="card">
                                        <h5 class="card-header">Reporte de Ingresos - Ventas</h5>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                                                    <img width="140" src="./images/ingresos.png" alt="Card image">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </button>
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                            <button class="btn btn-default" id="btnReporteAsistenciaClientes">
                                <div class="bs-component">
                                    <div class="card">
                                        <h5 class="card-header">Reporte de Asistencias - Clientes</h5>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                                                    <img width="140" src="./images/asistencia.png" alt="Card image">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </button>
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                            <button class="btn btn-default" id="btnReporteAsistenciaPersonal">
                                <div class="bs-component">
                                    <div class="card">
                                        <h5 class="card-header">Reporte de Asistencias - Personal</h5>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                                                    <img width="140" src="./images/asistencia.png" alt="Card image">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </button>
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                            <button class="btn btn-default" id="btnReporteMembresia">
                                <div class="bs-component">
                                    <div class="card">
                                        <h5 class="card-header">Reporte de Membresias - Mes</h5>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                                                    <img width="140" src="./images/asistencia.png" alt="Card image">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </button>
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                            <button class="btn btn-default" id="btnReporteServicio">
                                <div class="bs-component">
                                    <div class="card">
                                        <h5 class="card-header">Reporte de Servicio/Inscripción</h5>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                                                    <img width="140" src="./images/asistencia.png" alt="Card image">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </button>
                        </div>
                    </div>

            </main>
            <!-- Essential javascripts for application to work-->
            <?php include "./layout/footer.php"; ?>
            <script>
                let tools = new Tools();

                let fechaInicioIngresos = $("#txtFechaInicioIngreso");
                let fechaFinalIngresos = $("#txtFechaFinalIngreso");

                let fechaInicioClientes = $("#txtFechaInicioAsistenciaClientes");
                let fechaFinalClientes = $("#txtFechaFinalAsistenciaClientes");

                let fechaInicioPersonal = $("#txtFechaInicioAsistenciaPersonal");
                let fechaFinalPersonal = $("#txtFechaFinalAsistenciaPersonal");

                let monthClientes = $("#cbMonthAsistenciaClientes");
                let yearClientes = $("#cbYearAsistenciaClientes");

                let monthPersonal = $("#cbMonthAsistenciaPersonal");
                let yearPersonal = $("#cbYearAsistenciaPersonal");

                let monthMembresia = $("#cbMonthMembresia");
                let yearMembresia = $("#cbYearMembresia");

                $(document).ready(function() {

                    fechaInicioIngresos.val(tools.getCurrentDate());
                    fechaFinalIngresos.val(tools.getCurrentDate());

                    fechaInicioClientes.val(tools.getCurrentDate());
                    fechaFinalClientes.val(tools.getCurrentDate());

                    fechaInicioPersonal.val(tools.getCurrentDate());
                    fechaFinalPersonal.val(tools.getCurrentDate());

                    monthClientes.val(tools.getCurrentMonth());
                    yearClientes.val(tools.getCurrentYear());

                    monthPersonal.val(tools.getCurrentMonth());
                    yearPersonal.val(tools.getCurrentYear());

                    monthMembresia.val(tools.getCurrentMonth());
                    yearMembresia.val(tools.getCurrentYear());

                    //-----------------------------------------------------------------------------------------------------

                    $("#btnAceptarIngresos").click(function() {
                        if (tools.validateDate(fechaInicioIngresos.val()) && tools.validateDate(fechaFinalIngresos.val())) {
                            window.open("../app/reportes/resumeningresos.php?fechaInicial=" + fechaInicioIngresos.val() + "&fechaFinal=" + fechaFinalIngresos.val(), "_blank");
                        }
                    });

                    $("#btnAceptarIngresos").keypress(function(event) {
                        if (event.keyCode === 13) {
                            if (tools.validateDate(fechaInicioIngresos.val()) && tools.validateDate(fechaFinalIngresos.val())) {
                                window.open("../app/reportes/resumeningresos.php?fechaInicial=" + fechaInicioIngresos.val() + "&fechaFinal=" + fechaFinalIngresos.val(), "_blank");
                            }
                        }
                        event.preventDefault();
                    });

                    $("#btnReporteIngresos").click(function() {
                        $("#modalIngresos").modal("show");
                    });

                    $("#btnReporteIngresos").keypress(function(event) {
                        if (event.keyCode === 13) {
                            $("#modalIngresos").modal("show");
                        }
                        event.preventDefault();
                    });

                    //-----------------------------------------------------------------------------------------------------

                    $("#btnAceptarAsistenciaClientes").click(function() {
                        if (tools.validateDate(fechaInicioClientes.val()) && tools.validateDate(fechaFinalClientes.val())) {
                            window.open("../app/reportes/resumenasistenciaclientes.php?fechaInicial=" + fechaInicioClientes.val() + "&fechaFinal=" + fechaFinalClientes.val(), "_blank");
                        }
                    });

                    $("#btnAceptarAsistenciaClientes").keypress(function(event) {
                        if (event.keyCode === 13) {
                            if (tools.validateDate(fechaInicioClientes.val()) && tools.validateDate(fechaFinalClientes.val())) {
                                window.open("../app/reportes/resumenasistenciaclientes.php?fechaInicial=" + fechaInicioClientes.val() + "&fechaFinal=" + fechaFinalClientes.val(), "_blank");
                            }
                        }
                        event.preventDefault();
                    });

                    $("#btnAceptarAsistenciaPorMesClientes").click(function() {
                        window.open("../app/reportes/resumenasistenciamesclientes.php?month=" + monthClientes.val() + "&year=" + yearClientes.val(), "_blank");
                    });

                    $("#btnAceptarAsistenciaPorMesClientes").keypress(function(event) {
                        if (event.keyCode === 13) {
                            window.open("../app/reportes/resumenasistenciamesclientes.php?month=" + monthClientes.val() + "&year=" + yearClientes.val(), "_blank");

                        }
                        event.preventDefault();
                    });

                    $("#btnReporteAsistenciaClientes").click(function() {
                        $("#modalAsistenciaClientes").modal("show");
                    });

                    $("#btnReporteAsistenciaClientes").keypress(function(event) {
                        if (event.keyCode === 13) {
                            $("#modalAsistenciaClientes").modal("show");
                        }
                        event.preventDefault();
                    });

                    //-----------------------------------------------------------------------------------------------------

                    $("#btnAceptarAsistenciaPersonal").click(function() {
                        if (tools.validateDate(fechaInicioPersonal.val()) && tools.validateDate(fechaFinalPersonal.val())) {
                            window.open("../app/reportes/resumenasistenciaempleado.php?fechaInicial=" + fechaInicioPersonal.val() + "&fechaFinal=" + fechaFinalPersonal.val(), "_blank");
                        }
                    });

                    $("#btnAceptarAsistenciaPersonal").keypress(function(event) {
                        if (event.keyCode === 13) {
                            if (tools.validateDate(fechaInicioPersonal.val()) && tools.validateDate(fechaFinalPersonal.val())) {
                                window.open("../app/reportes/resumenasistenciaempleado.php?fechaInicial=" + fechaInicioPersonal.val() + "&fechaFinal=" + fechaFinalPersonal.val(), "_blank");
                            }
                        }
                        event.preventDefault();
                    });

                    $("#btnAceptarAsistenciaPorMesPersonal").click(function() {
                        window.open("../app/reportes/resumenasistenciamesempleados.php?month=" + monthPersonal.val() + "&year=" + yearPersonal.val(), "_blank");
                    });

                    $("#btnAceptarAsistenciaPorMesPersonal").keypress(function(event) {
                        if (event.keyCode === 13) {
                            window.open("../app/reportes/resumenasistenciamesempleados.php?month=" + monthPersonal.val() + "&year=" + yearPersonal.val(), "_blank");
                        }
                        event.preventDefault();
                    });

                    $("#btnReporteAsistenciaPersonal").click(function() {
                        $("#modalAsistenciaPersonal").modal("show");
                    });

                    $("#btnReporteAsistenciaPersonal").keypress(function(event) {
                        if (event.keyCode === 13) {
                            $("#modalAsistenciaPersonal").modal("show");
                        }
                        event.preventDefault();
                    });

                    //-----------------------------------------------------------------------------------------------------

                    //resumenmembresias

                    $("#btnAceptarMembreias").click(function() {
                        window.open("../app/reportes/resumenmembresias.php?month=" + monthMembresia.val() + "&year=" + yearMembresia.val(), "_blank");

                    });

                    $("#btnAceptarMembreias").keypress(function(event) {
                        if (event.keyCode === 13) {
                            window.open("../app/reportes/resumenmembresias.php?month=" + monthMembresia.val() + "&year=" + yearMembresia.val(), "_blank");
                        }
                        event.preventDefault();
                    });

                    $("#btnReporteMembresia").click(function() {
                        $("#modalAsistenciaModal").modal("show");
                    });

                    $("#btnReporteMembresia").keypress(function(event) {
                        if (event.keyCode === 13) {
                            $("#modalAsistenciaModal").modal("show");
                        }
                        event.preventDefault();
                    });

                    //-----------------------------------------------------------------------------------------------------
                    //inscripción
                    $("#btnReporteServicio").click(function() {
                        $("#modalServicioModal").modal("show");
                        $("#cbServicios").select2();
                    });

                    $("#btnReporteServicio").keypress(function(event) {
                        if (event.keyCode == 13) {
                            $("#modalServicioModal").modal("show");
                            $("#cbServicios").select2();
                        }
                        event.preventDefault();
                    });

                    $("#cbServicios").change(function(){
                            console.log("Dd")
                    });

                    $("#btnAceptarServiciosInscripcion").click(function(){

                    });

                    $("#btnAceptarServiciosInscripcion").keypress(function(event){
                        if(event.keyCode == 13){

                        }
                        event.preventDefault();
                    });

                });
            </script>
        </body>

        </html>

<?php
    } else {
        echo '<script>location.href = "./bienvenido.php";</script>';
    }
}
