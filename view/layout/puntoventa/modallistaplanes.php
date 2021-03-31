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