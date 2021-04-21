 <!-- modal ajuste de membresia -->
 <div class="row">
     <div class="modal fade" id="modalRenovar" data-backdrop="static">
         <div class="modal-dialog">
             <div class="modal-content">

                 <div class="modal-header">
                     <h4 class="modal-title"><i class="fa fa-pencil-square-o"></i> Renovación
                     </h4>
                     <button type="button" class="close" id="btnCloseModalRenovar">
                         <i class="fa fa-close"></i>
                     </button>
                 </div>

                 <div class="modal-body">
                     <div class="tile p-0">

                         <div class="overlay d-none" id="divOverlayRenovacion">
                             <div class="m-loader mr-4">
                                 <svg class="m-circular" viewBox="25 25 50 50">
                                     <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"></circle>
                                 </svg>
                             </div>
                             <h4 class="l-text" id="lblTextOverlayRenovacion">Cargando información...</h4>
                         </div>

                         <div class="tile-body">
                             <div class="row">
                                 <div class="col-md-12">
                                     <div class="form-group">
                                         <label for="cbPlanRenovar">Plan a Renovar: </label>
                                         <select id="cbPlanRenovar" class="form-control">
                                             <option value="">- Selecciona -</option>
                                         </select>
                                     </div>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label class="h6" id="lblNombrePlanRenovar">Nombre:</label>
                                     </div>
                                     <div class="form-group">
                                         <label class="h6" id="lblPrecioPlanRenovar">Precio:</label>
                                     </div>
                                 </div>
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label class="h6" id="lblTiempoPlanRenovar">Tiempo: </label>
                                     </div>
                                     <div class="form-group">
                                         <label class="h6" id="lblDisciplinasPlanRenovar">Disciplinas: </label>
                                     </div>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label for="txtFechaInicioRenovar">Fecha Inicio: </label>
                                         <input id="txtFechaInicioRenovar" type="date" class="form-control" disabled>
                                     </div>
                                 </div>
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label for="txtFechaTerminoRenovar">Fecha Término: </label>
                                         <input id="txtFechaTerminoRenovar" type="date" class="form-control" disabled>
                                     </div>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col-md-12">
                                     <div class="form-group">
                                         <label class="h6">Estado: </label>
                                         <label class="h6 badge badge-pill badge-default" id="lblEstadoRenovar">--</label>
                                     </div>
                                 </div>
                             </div>                           
                             <div class="row">
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label for="txtCantidadPlanRenovar">Cantidad: </label>
                                         <input id="txtCantidadPlanRenovar" type="text" value="1" class="form-control" placeholder="Ingrese la cantidad">
                                     </div>
                                 </div>
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label for="txtDescuentoPlanRenovar">Descuento: </label>
                                         <input id="txtDescuentoPlanRenovar" type="text" class="form-control" placeholder="Ingrese el descuento">
                                     </div>
                                 </div>
                             </div>
                         </div>

                     </div>
                 </div>

                 <div class="modal-footer">
                     <div class="col-md-6">
                         <p class="text-left text-info"><i class="fa fa-info text-danger"></i> La Renovación va utilizar la fecha de término de la membresía para sumar días en caso este vencido va utilizar fecha actual del sistema.</p>
                     </div>
                     <div class="col-md-6 text-right">
                         <button type="button" class="btn btn-success" id="btnAceptarModalRenovacion">
                             <i class="fa fa-save"></i> Aceptar</button>
                         <button type="button" class="btn btn-danger" id="btnCancelModalRenovacion">
                             <i class="fa fa-remove"></i> Cancelar</button>
                     </div>
                 </div>

             </div>
         </div>
     </div>
 </div>
 <!--  -->