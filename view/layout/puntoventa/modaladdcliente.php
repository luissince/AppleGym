<div class="row">
    <div class="modal fade" id="modalCliente" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="titulo-modal-cliente">
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