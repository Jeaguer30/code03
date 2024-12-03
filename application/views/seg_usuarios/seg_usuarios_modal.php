
    <!--
        ***********************
        ***********************
        ADD NEW USER
        ***********************
        ***********************
    -->

    <div class="modal fade bs-example-modal-center" id="mdl_add_registro" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="txt_titulo">Agregar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>                                                    
                        <div class="row">                        

                            <div class="col-lg-4 p-2">
                                <label>DNI</label>
                                <input class="form-control form-control-sm" id="txt_dni" type="text" placeholder="DNI">
                            </div>

                            <div class="col-lg-4 p-2">
                                <label>Celular</label>
                                <input class="form-control form-control-sm" id="txt_movil" type="text" placeholder="Celular">
                            </div>

                            <div class="col-lg-4 p-2">
                                <label>Tipo Usuario</label>
                                <select class="form-control form-control-sm" id="txt_tipo_user">
                                 
                                </select>
                            </div>

                            <div class="col-lg-12 p-2">
                                <label>Nombres Completos</label>
                                <input class="form-control form-control-sm" id="txt_nombres" type="text" placeholder="Nombres Completos">
                            </div>
                   
                            <div class="col-lg-12 p-2">
                                <label>Apellidos Completos</label>
                                <input class="form-control form-control-sm" id="txt_apellidos" type="text" placeholder="Apellidos Completos">
                            </div>

                            <div class="col-lg-8 p-2">
                                <label>E-mail</label>
                                <input class="form-control form-control-sm" id="txt_email" type="text" placeholder="E-mail">
                            </div>

                            <div class="col-lg-4 p-2">
                                <label>Estado</label>
                                <select class="form-control form-control-sm" id="txt_estado">
                                    <option value="" selected>Seleccione</option>
                                    <option value="1">ACTIVO</option>
                                    <option value="0">DESACTIVADO</option>
                                    <!-- Agrega más opciones según sea necesario -->
                                </select>
                            </div>
                        
                            <div class="col-lg-8  p-2">
                                <label>Dirección Completa</label>
                                <input class="form-control form-control-sm" id="txt_direccion" type="text" placeholder="Dirección Completa">
                            </div>  

                            <div class="col-lg-4 p-2">
                                <label>F. nacimiento</label>
                                <input class="form-control form-control-sm" id="txt_f_nac" type="date" placeholder="Fecha Nacimiento">
                            </div>  
                            <div class="col-lg-4 p-2">
                                <label>Usuario</label>
                                <input class="form-control form-control-sm" id="txt_usuario_a" type="text" placeholder="Usuario">
                            </div>   

                            <div class="col-lg-8 p-2">
                                <label>Contraseña</label>
                                <input class="form-control form-control-sm" id="txt_clave" type="password" placeholder="Contraseña">
                            </div>
                            
                        </div>
                        <hr>
                        
                        <div class="row" style="display:none">
                            <div class="col-lg-12">                                
                                <div >
                                    <div>
                                        <input type="checkbox" id="check_preaviso"> Nombre Impresión preaviso
                                    </div>                               
                                </div>
                            </div>
                        </div>
                       
                        <div class="row">
                            <div class="col-lg-12">
                                <label>Información adicional</label>
                                <textarea class="form-control form-control-sm" id="txt_observacion" placeholder="Información adicional"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="btn_modal" onclick="registrar_usuario()">Registrar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>


    <!--
        ***********************
        ***********************
        EDIT USER
        ***********************
        ***********************
    -->
    <div class="modal fade bs-example-modal-center" id="mdl_edit_registro" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Actualizar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>                                                    
                        <div class="row">

                            <div class="col-lg-12 mb-1" style="display:none;">
                                <label>id</label>
                                <input class="form-control form-control-sm" id="txto_coduser" type="text" placeholder="Nombres Completos">
                            </div>

                            <div class="col-lg-4 p-2">
                                <label>DNI</label>
                                <input class="form-control form-control-sm" id="txto_dni" type="text" placeholder="DNI">
                            </div>

                            <div class="col-lg-4 p-2">
                                <label>Celular</label>
                                <input class="form-control form-control-sm" id="txto_movil" type="text" placeholder="Celular">
                            </div>
                            <div class="col-lg-4 p-2">
                                <label>Tipo Usuario</label>
                                <select class="form-control form-control-sm" id="txto_tipo_user">
                                
                                </select>
                            </div>
                            <div class="col-lg-12 p-2">
                                <label>Nombres Completos</label>
                                <input class="form-control form-control-sm" id="txto_nombres" type="text" placeholder="Nombres Completos">
                            </div>

                            <div class="col-lg-12 p-2">
                                <label>Apellidos Completos</label>
                                <input class="form-control form-control-sm" id="txto_apellidos" type="text" placeholder="Apellidos Completos">
                            </div>

                            <div class="col-lg-8 p-2">
                                <label>E-mail</label>
                                <input class="form-control form-control-sm" id="txto_email" type="text" placeholder="E-mail">
                            </div>

                            <div class="col-lg-4 p-2">
                                <label>Estado</label>
                                <select class="form-control form-control-sm" id="txto_estado">
                                    <option value="" selected>Seleccione</option>
                                    <option value="1">ACTIVO</option>
                                    <option value="0">DESACTIVADO</option>
                                    <!-- Agrega más opciones según sea necesario -->
                                </select>
                            </div>
                        
                            <div class="col-lg-8  p-2">
                                <label>Dirección Completa</label>
                                <input class="form-control form-control-sm" id="txto_direccion" type="text" placeholder="Dirección Completa">
                            </div>  

                            <div class="col-lg-4 p-2">
                                <label>F. nacimiento</label>
                                <input class="form-control form-control-sm" id="txto_f_nac" type="date" placeholder="Fecha Nacimiento">
                            </div>     
                            <div class="col-lg-4 p-2">
                                <label>Usuario</label>
                                <input class="form-control form-control-sm" id="txt_usuario_e" type="text" placeholder="Usuario">
                            </div>
                            <div class="col-lg-8 p-2">
                                <label>Contraseña</label>
                                <input class="form-control form-control-sm" id="txto_clave" type="password" placeholder="Contraseña" value="sistemas123">
                            </div>
                            
                        </div>
                        <hr>
                        <div class="row" style="display:none">
                            <div class="col-lg-12">                                
                                <div >
                                    <div>
                                        <input type="checkbox" id="check_preaviso_editar"> Nombre Impresión preaviso
                                    </div>                               
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            
                            <div class="col-lg-12">
                                <label>Información adicional</label>
                                <textarea class="form-control form-control-sm" id="txto_observacion" placeholder="Información adicional"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="btn_modal" onclick="actualizar_usuario()">Actualizar</button>
                </div>
            </div>
        </div>
    </div>




    <div class="modal fade" id="mdl_config_user_preaviso" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <img src="<?php echo base_url();?>public/img/iconos/impresion_preaviso.png" alt="Descripción de la imagen" style="max-width: 34px; max-height: 34px; margin-right: 10px;">
                    <h5 class="modal-title" id="staticBackdropLabel">Configuración de usuarios para la impresión de preavisos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">        
                    <div class="row">
                        <div class="col-lg-6 mb-3">                            
                            <input type="text" class="form-control form-control-sm" id="txt_buscar_user" placeholder="Buscar por nombre">
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label" for="check_activo">Activo</label>
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="check_activo" value="1" onchange="filter_check(this)">
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="check_inactivo" value="0" onchange="filter_check(this)">
                                <label class="form-check-label" for="check_inactivo">Inactivo</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="check_ambos" value="" onchange="filter_check(this)">
                                <label class="form-check-label" for="check_ambos">Ambos</label>
                            </div>
                        </div>
                    </div> 

                    <div class="row"  id="slc_tbl_impresión_preaviso">
                        <div class="card" style="max-height: 400px; overflow-y: auto;">
                            <div class="card-header">
                                <h4 class="card-title"><i class='bx bxs-user-detail'></i> Lista de usuarios</h4>
                            </div>

                            <div class="card-body p-3">
                                <table class="table table-bordered  border-primary dt-responsive nowrap w-100" style="font-size:11px;">
                                    <thead>
                                        <tr class="bg-primary text-center text-white">
                                            <th>N°</th>
                                            <th>Usuario</th>
                                            <th>Impresión Preaviso</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tb_detalle_envio_mdl">
                                        <!-- Contenido de la tabla -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                                                                                       
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <!-- <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>  -->
                    <button type="button" class="btn btn-primary"  data-bs-dismiss="modal">Aceptar </button>
                </div>
                
            </div>
        </div>
    </div>



    <div class="modal fade" id="mdl_nuevo_tipo_usuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <img src="<?php echo base_url();?>public/img/iconos/impresion_preaviso.png" alt="Descripción de la imagen" style="max-width: 34px; max-height: 34px; margin-right: 10px;">
                    <h5 class="modal-title" id="staticBackdropLabel">Configuración de tipo de usuarios</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">        
                    <div class="row">
                        <div class="col-lg-3 mb-3">  
                            <div class="card" style="border-radius:15px;" >
                                <!-- <div class="card-header">
                                    <h4 class="card-title"><i class='bx bxs-user-detail'></i> Registrar Tipo</h4>
                                </div> -->

                                <div class="card-body p-3">   

                                    <h5 class="font-size-14 mb-2"><i class="mdi mdi-arrow-right text-primary "></i> Codigo</h5>
                                        <input type="text" class="form-control form-control-sm mb-1" id="txtip_id" placeholder="...">
                                    <br>

                                    <h5 class="font-size-14 mt-2"><i class="mdi mdi-arrow-right text-primary "></i> Descripcion</h5>
                                        <input type="text" class="form-control form-control-sm mb-1" id="txtip_descripcion" placeholder="....">
                                    <br>

                                    <h5 class="font-size-14 mt-2"><i class="mdi mdi-arrow-right text-primary "></i> Area</h5>
                                        <input type="text" class="form-control form-control-sm" id="txtip_area" placeholder=".....">
                                    <br>

                                    <div class="modal-footer justify-content-center">                            
                                        <button type="button" class="btn btn-sm btn-primary" onclick="actualizar_tipo_usuario()">Guardar  </button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-9 mb-3">
                            <div class="row"  id="slc_tbl_impresión_preaviso">
                                <div class="card" style="max-height: 400px; overflow-y: auto; border-radius:15px;">
                                    <!-- <div class="card-header">
                                        <h4 class="card-title"><i class='bx bxs-user-detail'></i> Lista de Tipos</h4>
                                    </div> -->

                                    <div class="card-body p-3">
                                        <table class="table table-bordered  border-primary dt-responsive nowrap w-100" style="font-size:11px;">
                                            <thead>
                                                <tr class="bg-primary text-center text-white">
                                                    <th>N°</th>
                                                    <th>Descripción</th>
                                                    <th>Area</th>
                                                    <th class="bg-danger">Opcion</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tb_detalle_tipo_user">
                                                <!-- Contenido de la tabla -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                                                                            
                            </div>
                        </div>

                    </div> 

                    



                </div>
               
                
            </div>
        </div>
    </div>
