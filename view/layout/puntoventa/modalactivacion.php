 <!-- modal ajuste de membresia -->
 <div class="row">
     <div class="modal fade" id="modalActivacion" data-backdrop="static">
         <div class="modal-dialog">
             <div class="modal-content">

                 <div class="modal-header">
                     <h4 class="modal-title"><i class="fa fa-external-link-square"></i> Activación
                     </h4>
                     <button type="button" class="close" id="btnCloseModalActivacion">
                         <i class="fa fa-close"></i>
                     </button>
                 </div>

                 <div class="modal-body">
                     <div class="tile p-0">

                         <div class="overlay d-none" id="divOverlayActivacion">
                             <div class="m-loader mr-4">
                                 <svg class="m-circular" viewBox="25 25 50 50">
                                     <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle>
                                 </svg>
                             </div>
                             <h4 class="l-text" id="lblTextOverlayActivacion">Cargando información...</h4>
                         </div>

                         <div class="tile-body">
                             <div class="row">
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label for="txtFechaInicioActivacion">Fecha Inicio: </label>
                                         <input id="txtFechaInicioActivacion" type="date" class="form-control">
                                     </div>
                                 </div>
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label for="txtFechaFinActivacion">Fecha Final: </label>
                                         <input id="txtFechaFinActivacion" type="date" class="form-control">
                                     </div>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label for="cbPlanesActivacion">Plan Activación: </label>
                                         <select class="form-control" id="cbPlanesActivacion">
                                             <option value="">- Selecciona -</option>
                                         </select>
                                     </div>
                                 </div>

                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label for="txtPrecioActivacion">Precio: </label>
                                         <input id="txtPrecioActivacion" type="text" class="form-control" placeholder="Ingrese el precio">
                                     </div>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col-md-12">
                                     <div class="form-group">
                                         <div class="form-check">
                                             <label class="form-check-label">
                                                 <input id="cbPlanNormal" class="form-check-input" type="checkbox">Agregar Plan
                                             </label>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label for="cbPlanNormalActivacion">Plan Normal: </label>
                                         <select id="cbPlanNormalActivacion" class="form-control" disabled>
                                             <option value="">- Selecciona -</option>
                                         </select>
                                     </div>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label class="h6" id="lblNombrePlanNormal">Nombre:</label>
                                     </div>
                                     <div class="form-group">
                                         <label class="h6" id="lblPrecioPlanNormal">Precio:</label>
                                     </div>
                                 </div>
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label class="h6" id="lblTiempoPlanNormal">Tiempo: </label>
                                     </div>
                                     <div class="form-group">
                                         <label class="h6" id="lblDisciplinasPlanNormal">Disciplinas: </label>
                                     </div>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label for="txtCantidadPlanNormal">Cantidad: </label>
                                         <input id="txtCantidadPlanNormal" type="text" value="1" class="form-control" placeholder="Ingrese la cantidad" disabled>
                                     </div>
                                 </div>
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label for="txtDescuentoPlanNormal">Descuento: </label>
                                         <input id="txtDescuentoPlanNormal" type="text" class="form-control" placeholder="Ingrese el descuento" disabled>
                                     </div>
                                 </div>
                             </div>
                         </div>

                     </div>
                 </div>

                 <div class="modal-footer">
                     <div class="col-md-6">
                         <p class="text-left text-danger"> Todos los campos marcados con <i class="fa fa-asterisk"></i> son obligatorios</p>
                     </div>
                     <div class="col-md-6 text-right">
                         <button type="button" class="btn btn-success" id="btnAceptarModalActivacion">
                             <i class="fa fa-save"></i> Aceptar</button>
                         <button type="button" class="btn btn-danger" id="btnCancelModalActivacion">
                             <i class="fa fa-remove"></i> Cancelar</button>
                     </div>
                 </div>

             </div>
         </div>
     </div>
 </div>
 <!--  -->