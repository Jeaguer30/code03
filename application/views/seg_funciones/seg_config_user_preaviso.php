




<!-- *******************MODAL ADD - BLOQUE COTIZACION ************************** -->

    <div class="modal fade" id="mdl_config_user_preaviso" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <img src="<?php echo base_url();?>public/img/iconos/moneda.png" alt="Descripción de la imagen" style="max-width: 34px; max-height: 34px; margin-right: 10px;">
                    <h5 class="modal-title" id="staticBackdropLabel">Nueva Cotización</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">                  
                    <div class="row">
                        <div class="col-lg-12" >
                            <div class="mb-3" style="display:none">
                                <label>Codigo</label>
                                <input class="form-control form-control-sm" id="txt_codigo" disabled>
                            </div>
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label>Tipo de cotización</label>
                                    <select class="form-control form-control-sm" id="slc_tipo_cotizacion">
                                        <option value="">Seleccione</option>                             
                                        <?php                                                      
                                            foreach ($slc_tipos_cotizacion as $key) {
                                                echo '
                                                    <option value="'.$key->id.'">'.$key->descripcion.'</option>
                                                '; 
                                            }
                                        ?>                                                                                          
                                    </select>                               
                                </div>  
                                <div class="col-6 mb-3">
                                    <label>Descripción</label>
                                    <input class="form-control form-control-sm" id="txt_descripcion" placeholder="Ingrese descripción">
                                </div>   
                            </div>
                           
                            
                            
                            <div class="row">
                                <div class="col-8 mb-3">
                                    <label>Departamento</label>
                                    <select class="form-control form-control-sm" id="slc_departamento_bloque">
                                        <option value="">Seleccione</option>                             
                                        <?php                                                      
                                            foreach ($lst_departament as $key) {
                                                echo '
                                                    <option value="'.$key->id.'">'.$key->departamento.'</option>
                                                '; 
                                            }
                                        ?>                                                                                          
                                    </select>                               
                                </div>  
                            </div>
                           

                            <div class="row">
                                <div class="col-8 mb-3">
                                    <label>Tipo de Cobranza</label>
                                    <select class="form-control form-control-sm" id="slc_tipo_cobranza" onclick="activador_panel_respuesta('slc_tipo_cobranza');">
                                        <option value="">Seleccione</option>                             
                                        <?php                                                      
                                            foreach ($slc_tipo_cobranza_cotizacion as $key) {
                                                echo '
                                                    <option value="'.$key->id.'">'.$key->descripcion.'</option>
                                                '; 
                                            }
                                        ?>                                                                                          
                                    </select>                               
                                </div>  
                                <div class="col-4 mb-3"  id="panel_monto_servico" style="display:none">
                                    <label>Monto según Cobranza</label>
                                    <input class="form-control form-control-sm" type="number" id="txt_monto_cotizacion" placeholder="S/ 000.00" onchange="disparar();">
                                </div>  
                            </div>
                            
                            <div class="row">
                                <div class="col-5 mb-3" id="panel_fecha_inicio_servico" style="display:none">
                                    <label class="form-label">Fecha inicio de Servicio</label>
                                    <input class="form-control form-control-sm" type="datetime-local" value="" id="txt_fecha_inicio_servicio" onchange="disparar();">
                                </div>

                                <div  class="col-5 mb-3" id="panel_fecha_fin_servico" style="display:none">
                                    <label class="form-label">Fecha fin de Servicio</label>
                                    <input class="form-control form-control-sm" type="datetime-local" value="" id="txt_fecha_fin_servicio" onchange="disparar();">
                                </div>

                                <div class="col-2 mb-3"  id="panel_monto_calculado_servico" style="display:none">
                                    <label>Totalidad</label>
                                    <input class="form-control form-control-sm" type="number" id="txt_monto_total_cotizacion" placeholder="S/ 000.00" >
                                </div> 

                            </div>   
                            
                            
                        
                        </div>   
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <!-- <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button> -->
                    <button type="button" class="btn btn-danger" onclick="insertar_bloque_notarial();">Guardar </button>
                </div>
                
            </div>
        </div>
    </div>

<!-- *************************************************************************** -->
