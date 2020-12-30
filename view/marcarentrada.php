<div class="row">
    <div class="modal fade show" id="modalMarcarEntrada" data-backdrop="static">
        <div class="modal-dialog modal-md">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">
                        <i class="fa fa-hand-pointer-o fa-lg"></i> Marcar Entrada
                    </h4>
                    <button type="button" class="close" id="btnCloseMarcarEntrada">
                        <i class="fa fa-close"></i>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="container-fluid">

                        <div class="tile">
                            <div class="overlay d-none" id="divOverlay">
                                <div class="m-loader mr-4">
                                    <svg class="m-circular" viewBox="25 25 50 50">
                                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle>
                                    </svg>
                                </div>
                                <h4 class="l-text">Cargando información...</h4>
                            </div>
                            <div class="tile-body">

                                <div class="row text-center">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" id="rbCliente" type="radio" name="tipopersona" checked="">Cliente
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" id="rbTrabajador" type="radio" name="tipopersona">Trabajador
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="search" class="form-control" placeholder="Ingrese su código o n° dni" id="txtCliente" />
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="button" id="btnBuscarAsistencia"><i class="fa fa-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row text-center">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <p class="h5 text-info border-bottom" id="lblFecha"><i class="fa fa-calendar"></i> 00/00/0000</p>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <p class="h5 text-info border-bottom" id="lblHora"><i class="fa fa-clock-o"></i> 00:00:00 am/pm</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                                        <div class="form-group">
                                            <label class="h5" id="lblDatosCompletos">Bienvenido --</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12">
                                        <p class="h6">Codigo:</p>
                                    </div>
                                    <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-12">
                                        <p class="h6" id="lblCodigo">--</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12">
                                        <p class="h6">Dni:</p>
                                    </div>
                                    <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-12">
                                        <p class="h6" id="lblDni">--</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12">
                                        <p class="h6">Email:</p>
                                    </div>
                                    <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-12">
                                        <p class="h6" id="lblEmail">--</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12">
                                        <p class="h6">Celular:</p>
                                    </div>
                                    <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-12">
                                        <p class="h6" id="lblCelular">--</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12">
                                        <p class="h6">Fecha de Nacimiento:</p>
                                    </div>
                                    <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-12">
                                        <p class="h6" id="lblFechaNacimiento">--</p>
                                    </div>
                                </div>
                                <!--  -->
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="bs-component">
                                            <div class="card mb-3 border-primary">
                                                <div class="card-body">
                                                    <blockquote class="card-blockquote text-center">
                                                        <p id="lblAsistencia">--</p>
                                                    </blockquote>
                                                </div>
                                                <button type="button" class="btn btn-info btn-sm" id="btnMarcarEntrada">
                                                    <i class="fa fa-save"></i> Marcar Entrada</button>
                                                <button type="button" class="btn btn-warning btn-sm" id="btnCerrarEntrada">
                                                    <i class="fa fa-arrow-left"></i> Cerrar Entrada</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--  -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-danger" id="btnCancelarMarcarEntrada">
                        <i class="fa fa-close"></i> Cancelar</button>
                </div>

            </div>
        </div>
    </div>
</div>