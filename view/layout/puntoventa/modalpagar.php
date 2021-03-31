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