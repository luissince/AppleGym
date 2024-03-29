<div class="row">
    <div class="modal fade" id="modalTraspaso" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        <i class="fa  fa-sign-in"></i> Clientes Hábidos Para Traspaso
                    </h4>
                    <button type="button" class="close" id="btnCloseModalTraspaso">
                        <i class="fa fa-close"></i>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="tile p-0">
                        <div class="overlay d-none" id="divOverlayTraspaso">
                            <div class="m-loader mr-4">
                                <svg class="m-circular" viewBox="25 25 50 50">
                                    <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle>
                                </svg>
                            </div>
                            <h4 class="l-text" id="lblTextOverlayTraspaso">Cargando información...</h4>
                        </div>

                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label>Seleccionar Cliente</label>
                                    <select class="form-control select2" style="width: 100%;" id="cbClienteTraspaso">
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="form-group">
                                    <label>Membresías a traspasar</label>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <div class="tile-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th class="sorting" style="width: 20px;">#</th>
                                                        <th class="sorting"> Plan</th>
                                                        <th class="sorting">Fecha Inicio</th>
                                                        <th class="sorting">Fecha Fin</th>
                                                        <th class="sorting">Dias activo</th>
                                                        <th class="sorting" style="width: 20px;">Precio/Traspaso</th>
                                                        <th class="sorting">Opciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbMembresiaTraspaso">
                                                    <!-- tbLista -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>                           
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" id="cbUsarMembresia" type="checkbox" checked>Agregar a una membresía el traspaso
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <select class="form-control select2" style="width: 100%;" id="cbListaMembresiaCliente">
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
</div>