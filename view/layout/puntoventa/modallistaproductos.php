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
                            <div class="form-group d-flex">
                                <div class="input-group">
                                    <input type="search" class="form-control" placeholder="Buscar por nombre o codigo de producto" aria-controls="sampleTable" id="txtSearProducto">
                                    <div class="input-group-append">
                                        <button class="btn btn-info" type="button" id="btnReloadProductos"><i class="fa fa-refresh"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <div class="text-right">
                                    <button class="btn btn-primary" id="btnAnteriorProductos">
                                        <i class="fa fa-arrow-circle-left"></i>
                                    </button>
                                    <span class="m-2" id="lblPaginaActualProductos">0
                                    </span>
                                    <span class="m-2">
                                        de
                                    </span>
                                    <span class="m-2" id="lblPaginaSiguienteProductos">0
                                    </span>
                                    <button class="btn btn-primary" id="btnSiguienteProductos">
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
                        <div class="col-md-12 ">
                            <label class="text-danger">Para seleccione un producto/servicio hacer doble click en la lista.</label>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>