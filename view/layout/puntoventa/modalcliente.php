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
                                    <button class="btn btn-primary" id="btnAnteriorCliente">
                                        <i class="fa fa-arrow-circle-left"></i>
                                    </button>
                                    <span class="m-2" id="lblPaginaActualCliente">0
                                    </span>
                                    <span class="m-2">
                                        de
                                    </span>
                                    <span class="m-2" id="lblPaginaSiguienteCliente">0
                                    </span>
                                    <button class="btn btn-primary" id="btnSiguienteCliente">
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
                                                <th class="sorting" style="width: 5%;">#</th>
                                                <th class="sorting" style="width: 35%;">Cliente</th>
                                                <th class="sorting" style="width: 15%;">Celular</th>
                                                <th class="sorting" style="width: 15%;">Membresia</th>
                                                <th class="sorting" style="width: 15%;">Deuda</th>
                                                <th class="sorting_asc" style="width: 20%;">Descripción</th>
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