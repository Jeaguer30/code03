<style>
    .status_success {
        background: #2ab57d !important;
        border-radius: 10px;
        color: white;
    }

    .status_warning {
        background: #ffbf53 !important;
        border-radius: 10px;
        color: white;
    }

    /* The switch - the box around the slider */
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    /* Hide default HTML checkbox */
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    /* The slider */
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #2196F3;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">   <!-- content start        -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-dm-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-lg-11 col-sm-10 col-9 mb-2 ">
                                    <h4 class="card-title">REGISTRAR CLIENTES LIBRES</h4>
                                    <p class="card-title-desc">Detalle de registros.</p>
                                </div>

                                <div class="col-lg-1 col-sm-2 col-3 mb-2"  >
                                    <button class="btn btn-sm btn-primary waves-effect waves-light mb-1" id="btn_agregar_chat"  onclick="ver_mdl('mdl_add_registro');"> <i class="mdi mdi-plus"></i>NUEVO CLIENTE</button>                                     
                                </div> 
                            </div>     
                        </div>  
                                            

                        <div class="card-body">                        
                            <div class="col-lg-12 col-dm-12 col-sm-12 col-12 my-3"> 
                                <div class="row"> 




                                    <div class="col-lg-2 col-dm-5 col-sm-5 col-5">
                                        <div class="card border border-light p-3 " style="border-radius:15px;" >
                                            <div class="row">
                                                <div class="col-lg-12 "  > 
                                                    <label >Filtro de Cliente</label>                                                                                                  
                                                    <select class="form form-select form-select-sm text-black" style="background-color :#FFE880;" id="select_filtro_cliente" onchange="aplicar_filtro_cliente();">
                                                        <option value="">Seleccione</option>
                                                        <option value="1">Cliente Regular</option>
                                                        <option value="2">Cliente Libre</option>                                   
                                                        <option value="3">Cliente No recooce</option>
                                                    </select>  
                                                </div>                                               
                                            </div>                                                                            
                                        </div>
                                    </div>


                                    <div class="col-lg-2 col-dm-5 col-sm-7 col-7">
                                        <div class="card border border-light p-3 " style="border-radius:15px;" >                                                                                              
                                             <div class="row">
                                                <div class="col-lg-12 col-md-12  col-sm-12 col-12"  > 
                                                    <label>Filtro de Estado</label>                                                                    
                                                    <select class="form form-select form-select-sm text-black" style="background-color :#FFE880;" id="select_filtro_estado" onchange="aplicar_filtro_estado();"></select>  
                                                </div>          
                                            </div>                                              
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-dm-5 col-sm-5 col-5">
                                        <div class="card border border-light p-3 " style="border-radius:15px;" >
                                            <div class="row">
                                                <div class="col-lg-12 "  > 
                                                    <label >Filtro de Distribuidor</label>                                                                                                  
                                                    <select class="form form-select form-select-sm text-black" style="background-color :#FFE880;" id="select_filtro_distribuidor" onchange="aplicar_filtro_distribuidor();">
                                                        <option value="">Seleccione</option>
                                                        <option value="SI">SI</option>
                                                        <option value="NO">NO</option>
                                                    </select> 
                                                </div>                                               
                                            </div>                                                                            
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-lg-2 col-dm-5 col-sm-5 col-5">
                                        <div class="card border border-light p-3 " style="border-radius:15px;" >
                                            <div class="row">
                                                <div class="col-lg-12 "  > 
                                                    <label >Filtro de Departamento</label>                                                                                                  
                                                    <select class="form form-select form-select-sm text-black" style="background-color :#FFE880;" id="select_filtro_departamento" onchange="aplicar_filtro_departamento();">
                                                        
                                                    </select> 
                                                </div>                                               
                                            </div>                                                                            
                                        </div>
                                    </div>  


                                </div> 
                              
                            </div>

                           
                           

                            <table id="tb_table_registros" class="table table-bordered dt-responsive nowrap w-100" style="font-size:11px;">
                                <thead>
                                    <tr class="bg-primary text-center text-white">
                                        <th>N°</th>
                                        <th>Opciones</th> 
                                        <th>Razon Social</th>  
                                        <th>Estado</th>  
                                        <th>Ruc</th>                                                                      
                                        <th>Codigo iscom</th>                                      
                                        
                                        <!--<th>Cuenta SD</th>
                                        <th>Mes Deuda</th>
                                        <th>N° dias pago</th>   
                                        <th>Osinergmin</th>--> 
                                        
                                        <th>Distribuidor Local</th>    
                                        <th>N° suministro Distrito</th>    
                                        <th>Alimentador</th>      
                                        <th>Dirección suministro</th> 
                                        <th>Distrito</th>  
                                        <th>Provincia </th>    
                                        <th>Departamento </th>                                                                                                           
                                        <th>Fecha Registro</th>                                       
                                    </tr>
                                </thead>
                            </table> 

                        </div>        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>







    <!--
        ***********************
        ***********************
        ADD NEW USER
        ***********************
        ***********************
    -->

    <div class="modal fade bs-example-modal-center" id="mdl_add_registro" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="txt_titulo">Agregar Cliente Libre</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>                                                    
                        <div class="row">                        

                            <div class="col-lg-8 p-2">
                                <label>Razon Social</label>
                                <input class="form-control form-control-sm" id="cvc_razon_social" type="text" placeholder="Razon Social">
                            </div>

                            <div class="col-lg-4 p-2">
                                <label>RUC</label>
                                <input class="form-control form-control-sm" id="cvc_ruc" type="number" placeholder="RUC">
                            </div>

                            <div class="col-lg-7 p-2">
                                <label>Código ISCOM</label>
                                <input class="form-control form-control-sm" id="cvc_codigo_iscom" type="text" placeholder="Código ISCOM">
                            </div>
                            <div class="col-lg-1 p-2">
                                
                            </div>

                            <div class="col-lg-4 p-2">
                                <label>Estado</label>
                                <select class="form-select form-select-sm" id="cvc_estado">                               
                                </select>
                            </div>

                            <!--<div class="col-lg-3 p-2">
                                <label>Cuenta (S/D) </label>
                                <input class="form-control form-control-sm" id="cvc_cuenta_sd" type="text" placeholder="S y D">
                            </div>

                            <div class="col-lg-2 p-2">
                                <label>Mes Deuda   </label>
                                <input class="form-control form-control-sm" id="cvc_mes_deuda" type="text" placeholder="1">
                            </div>

                            <div class="col-lg-2 p-2">
                                <label># días pago
                                </label>
                                <input class="form-control form-control-sm" id="cvc_dias_pago" type="text" placeholder="10">
                            </div>

                            <div class="col-lg-1 p-2">
                                
                            </div>

                            <div class="col-lg-4 p-2">
                                <label>Osinergmin
                                </label>
                                <select class="form-select form-select-sm" id="cvc_osinergmin">
                                    <option value="" selected>Seleccione</option>
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
                               
                                </select>
                            </div>-->
                           
                   
                            <div class="col-lg-4 p-2">
                                <label>Distribuidor Local</label>
                                <select class="form-select form-select-sm" id="cvc_distribuidora">                                                             
                                </select>

                                
                            </div>

                            <div class="col-lg-4 p-2">
                                <label># de Suministro Distribuidora</label>
                                <input class="form-control form-control-sm" id="cvc_suministro_dis" type="text" placeholder="40006063">
                            </div>

                            <div class="col-lg-4 p-2">
                                <label>Alimentador</label>
                                <input class="form-control form-control-sm" id="cvc_alimentador" type="text" placeholder="AMT: A2064 - LAV103">
                            </div>

                            <div class="col-lg-4 p-2">
                                <label>PMI   </label>
                                <input class="form-control form-control-sm" id="cvc_pmi" type="text" placeholder="">
                            </div>

                            <div class="col-lg-8 p-2">
                                <label>Dirección de Suministro</label>
                                <input class="form-control form-control-sm" id="cvc_direccion_dis" type="text" placeholder="Ca. Tumbes 1211 Pblo. Tambogrande, Piura - Piura CIENEGUILLO - CIENEGUILLO">
                            </div>

                            <br>
                            
                            <div class="col-lg-4  p-2">
                                <label>Distrito</label>
                                <input class="form-control form-control-sm" id="cvc_distrito" type="text" placeholder="Distrito">
                            </div>  
                            <div class="col-lg-4  p-2">
                                <label>Provincia</label>
                                <input class="form-control form-control-sm" id="cvc_provincia" type="text" placeholder="Provincia">
                            </div>  

                            <div class="col-lg-4  p-2">
                                <label>Departamento</label>
                                
                                <select class="form-select form-select-sm" id="cvc_departamento">                                                             
                                </select>
                            </div>                                         
                        </div>                
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="btn_modal" onclick="registrar()">Registrar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>


    <!--
        ***********************
        ***********************
        EDIT USER mdl_edit_registro
        ***********************
        ***********************
    -->
    <div class="modal fade bs-example-modal-center" id="mdl_edit_registro" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="txt_titulo">Agregar Cliente Libre</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>                                                    
                        <div class="row">                        
                            <div class="col-lg-12 p-2" style="display:none;">
                                <label>ID</label>
                                <input class="form-control form-control-sm" id="cvco_id" type="text" placeholder="Razon Social">
                            </div>

                            <div class="col-lg-8 p-2">
                                <label>Razon Social</label>
                                <input class="form-control form-control-sm" id="cvco_razon_social" type="text" placeholder="Razon Social">
                            </div>

                            <div class="col-lg-4 p-2">
                                <label>RUC</label>
                                <input class="form-control form-control-sm" id="cvco_ruc" type="number" placeholder="RUC">
                            </div>

                            <div class="col-lg-7 p-2">
                                <label>Código ISCOM</label>
                                <input class="form-control form-control-sm" id="cvco_codigo_iscom" type="text" placeholder="Código ISCOM">
                            </div>
                            <div class="col-lg-1 p-2">
                                
                            </div>

                            <div class="col-lg-4 p-2">
                                <label>Estado</label>
                                <select class="form-select form-select-sm" id="cvco_estado">                               
                                </select>
                            </div>

                            <!--<div class="col-lg-3 p-2">
                                <label>Cuenta (S/D) </label>
                                <input class="form-control form-control-sm" id="cvco_cuenta_sd" type="text" placeholder="S y D">
                            </div>

                            <div class="col-lg-2 p-2">
                                <label>Mes Deuda   </label>
                                <input class="form-control form-control-sm" id="cvco_mes_deuda" type="text" placeholder="1">
                            </div>

                            <div class="col-lg-2 p-2">
                                <label># días pago
                                </label>
                                <input class="form-control form-control-sm" id="cvco_dias_pago" type="text" placeholder="10">
                            </div>

                            <div class="col-lg-1 p-2">
                                
                            </div>

                            <div class="col-lg-4 p-2">
                                <label>Osinergmin
                                </label>
                                <select class="form-select form-select-sm" id="cvco_osinergmin">
                                    <option value="" selected>Seleccione</option>
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
                               
                                </select>
                            </div>-->
                           
                   
                            <div class="col-lg-4 p-2">
                                <label>Distribuidor Local</label>
                                <select class="form-select form-select-sm" id="cvco_distribuidora">                                                             
                                </select>

                            </div>

                            <div class="col-lg-4 p-2">
                                <label># de Suministro Distribuidora</label>
                                <input class="form-control form-control-sm" id="cvco_suministro_dis" type="text" placeholder="40006063">
                            </div>

                            <div class="col-lg-4 p-2">
                                <label>Alimentador</label>
                                <input class="form-control form-control-sm" id="cvco_alimentador" type="text" placeholder="AMT: A2064 - LAV103">
                            </div>

                            <div class="col-lg-4 p-2">
                                <label>PMI   </label>
                                <input class="form-control form-control-sm" id="cvco_pmi" type="text" placeholder="">
                            </div>

                            <div class="col-lg-8 p-2">
                                <label>Dirección de Suministro</label>
                                <input class="form-control form-control-sm" id="cvco_direccion_dis" type="text" placeholder="Ca. Tumbes 1211 Pblo. Tambogrande, Piura - Piura CIENEGUILLO - CIENEGUILLO">
                            </div>

                            <br>
                            
                            <div class="col-lg-4  p-2">
                                <label>Distrito</label>
                                <input class="form-control form-control-sm" id="cvco_distrito" type="text" placeholder="Distrito">
                            </div>  
                            <div class="col-lg-4  p-2">
                                <label>Provincia</label>
                                <input class="form-control form-control-sm" id="cvco_provincia" type="text" placeholder="Provincia">
                            </div>  

                            <div class="col-lg-4  p-2">
                                <label>Departamento</label>
                                <select class="form-select form-select-sm" id="cvco_departamento">                                                             
                                </select>
                            </div>                                         
                        </div>                
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="btn_modal" onclick="actualizar()">Actualizar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
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









<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<!-- 
<script  src="<?php echo base_url();?>public/js/seg_usuarios/seg_usuarios.js"></script> -->


<script>
    let id_upd          = 0 ;
    var tb_table_registros;

    //tb_table_registros.ajax.reload();
    $(document).ready(function() {
       
        forDataTables('#tb_table_registros', 'Controller_cliente_libre/listar_registros'); 
        
        /* funciones config user preaviso */
        retirar_filtros();  

        load_filtro_estado();
        load_filtro_distribuidor();
        load_filtro_departamento();
    });


    function retirar_filtros(){
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>C_config_user_preaviso/retirar_filtros',
            data: {},
            beforeSend: function() {},
            success: function(data) {                
                           
            }
        });

    }

/* funciones para los filtros */
    function load_filtro_estado(){       
        $.ajax({
            type: "POST",
            url: '<?php echo base_url();?>Controller_cliente_libre/load_filtro_estado',
            data: {}, 
            beforeSend:function(){               
            },   
            success: function(data){
                $('#cvco_estado').html(data);
                $('#cvc_estado').html(data);
                $('#select_filtro_estado').html(data);
            },
            error: function(){
            }
        }); 
    }

    function load_filtro_distribuidor(){       
        $.ajax({
            type: "POST",
            url: '<?php echo base_url();?>Controller_cliente_libre/load_filtro_distribuidor',
            data: {}, 
            beforeSend:function(){               
            },   
            success: function(data){
                $('#select_filtro_distribuidor').html(data);
                $('#cvc_distribuidora').html(data);
                $('#cvco_distribuidora').html(data);
                 
            },
            error: function(){
            }
        }); 
    }

    function load_filtro_departamento(){       
        $.ajax({
            type: "POST",
            url: '<?php echo base_url();?>Controller_cliente_libre/load_filtro_departamento',
            data: {}, 
            beforeSend:function(){               
            },   
            success: function(data){
                $('#select_filtro_departamento').html(data);
                $('#cvc_departamento').html(data);
                $('#cvco_departamento').html(data);
                 
            },
            error: function(){
            }
        }); 
    }

    function aplicar_filtro_estado(){
        var dato = $('#select_filtro_estado').val();

        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>Controller_cliente_libre/aplicar_filtro_estado',
            data: {'dato':dato},
            beforeSend: function() {},
            success: function(data) {                
                tb_table_registros.ajax.reload();     
            }
        });
    }


    function aplicar_filtro_cliente(){
        var dato = $('#select_filtro_cliente').val();

        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>Controller_cliente_libre/aplicar_filtro_cliente',
            data: {'dato':dato},
            beforeSend: function() {},
            success: function(data) {                
                tb_table_registros.ajax.reload();     
            }
        });
    }

    function aplicar_filtro_distribuidor(){
        var dato = $('#select_filtro_distribuidor').val();

        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>Controller_cliente_libre/aplicar_filtro_distribuidor',
            data: {'dato':dato},
            beforeSend: function() {},
            success: function(data) {                
                tb_table_registros.ajax.reload();     
            }
        });
    }

    function aplicar_filtro_departamento(){
        var dato = $('#select_filtro_departamento').val();

        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>Controller_cliente_libre/aplicar_filtro_departamento',
            data: {'dato':dato},
            beforeSend: function() {},
            success: function(data) {                
                tb_table_registros.ajax.reload();     
            }
        });
    }

/* fin */


/* funciones para eliminar */  

    function eliminar(id) {
        alertify.confirm("¿Está seguro de eliminar el registro?",
            function () {
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url();?>Controller_cliente_libre/eliminar',
                    data: {
                        'id': id
                    },
                    beforeSend: function () {
                        // You can add some code to execute before sending the request if needed
                    },
                    success: function (response) {                                            
                            tb_table_registros.ajax.reload();
                            alertify.error('Registro eliminado correctamente.');
                        
                    },
                   
                });
            },
            function () {
                alertify.error('No se pudo completar la acción de eliminar sobre el registro seleccionado.');
        });
    }

/* fin */



/* funcion carga datatable */

    function forDataTables( id, ruta) {
        tb_table_registros = $(id).DataTable({
            "scrollX": false,
            "processing":true,
            "serverSide":true,
            "order":[],
            "ajax":{
                url:"<?php echo base_url(); ?>" + ruta,
                type:"POST"
            },          
            "order": [[ 0, "DESC" ]],
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Del _START_ al _END_",
                "sInfoEmpty": "Del 0 al 0 ",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
            
        });
    } 

/* fin */


/* funciones para añadir transportista */

    function ver_mdl(tipo){
        $('#mdl_add_registro').modal('show');
    }

    function registrar(){      
        var r_social = $('#cvc_razon_social').val();
        var ruc = $('#cvc_ruc').val();
        var cod_iscom = $('#cvc_codigo_iscom').val();
        var estado = $('#txt_tipo_user').val();

        //var cuenta_sd = $('#cvc_cuenta_sd').val();
        //var mes_deuda = $('#cvc_mes_deuda').val();     
        //var dias_pago = $('#cvc_dias_pago').val();    
        //var osig = $('#cvc_osinergmin').val();

        var distrib = $('#cvc_distribuidora').val();
        var sumin_dis = $('#cvc_suministro_dis').val();
        var alimen = $('#cvc_alimentador').val();      
        var pmi = $('#cvc_pmi').val();
        var dir_dis = $('#cvc_direccion_dis').val();
        var dis = $('#cvc_distrito').val();
        var pro = $('#cvc_provincia').val();
        var dep = $('#cvc_departamento').val();

        if (!r_social) {alertify.error('Ingresa la Razon Social');return;}
        if (!dep) {alertify.error('Seleccione el Departamento');return;}
        if (!distrib) {alertify.error('Seleccione el Distribuidor');return;}
        if (!estado) {alertify.error('Seleccione el Estado');return;}
        if (!osig) {alertify.error('Selecciona el Estado de Osinergmin"');return;}

        // Validación del RUC
        if (!ruc || ruc.length !== 11) {
            alertify.error('El RUC debe tener 11 dígitos');
            return;
        }

       
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>Controller_cliente_libre/agregar',
            data: {                               
                'r_social':r_social,
                'ruc':ruc,
                'cod_iscom':cod_iscom,
                'estado':estado,

                //'cuenta_sd':cuenta_sd,                         
                //'mes_deuda':mes_deuda,  
                //'dias_pago':dias_pago,
                //'osig':osig,   

                'distrib':distrib,                
                'sumin_dis':sumin_dis,  
                'alimen':alimen, 
                'pmi':pmi, 
                'dir_dis':dir_dis,
                'dis':dis, 
                'pro':pro,
                'dep':dep                    
            }, 
            beforeSend:function(){
            },   
            success: function(data){ 
                nuevo_registro=1;
                cont_nuevos=0; 
                $('#mdl_add_registro').modal('hide');
                $("#btn_agregar_chat").removeAttr('disabled');
               
                   // get_registros();
                tb_table_registros.ajax.reload();
                var json         = eval("(" + data + ")");
                
                if (json.mensaje=='') {
                    notificacion('Usuario registrado', 'No se pudo asignar la impresión del preaviso debido a que se ha superado el límite', 'info');
                }else{
                    notificacion('Registro realizado','Se regitró correctamente.','success');
                }

            }
        });

        //agregar('solicitud',0,id_tipo_registro,cuspp);
    }

/* fin */



/* funciones para actualizar */

    function get_datos(id){
        limpiar_formulario();
        $.ajax({
            type: "POST",
            //dataType: 'json',
            url: '<?php echo base_url(); ?>Controller_cliente_libre/get_datos',
            data: {
                'id':id
            }, 
            beforeSend:function(){
            },   

            success: function(e){ 
                id_upd=id;
                var res = jQuery.parseJSON(e);
                if(res.mensaje!='error'){
                    
                    $('#cvco_id').val(res.id); 
                    $('#cvco_razon_social').val(res.razon_social);                      
                    $('#cvco_ruc').val(res.ruc);
                    $('#cvco_codigo_iscom').val(res.codigo_iscom);
                    $('#cvco_estado').val(res.status);
                    
                    //$('#cvco_cuenta_sd').val(res.cuenta_sd);
                    //$('#cvco_mes_deuda').val(res.mes_deuda);               
                    //$('#cvco_dias_pago').val(res.nro_dias_pago);
                    //$('#cvco_osinergmin').val(res.osinergmin);                 
                    
                    $('#cvco_distribuidora').val(res.distribuidor_local);                  
                    $('#cvco_suministro_dis').val(res.nro_suministro_distri);                   
                    $('#cvco_alimentador').val(res.alimentador);  

                    $('#cvco_pmi').val(res.pmi);                 
                    $('#cvco_direccion_dis').val(res.direccion_suministro);                  
                    $('#cvco_distrito').val(res.distrito);                   
                    $('#cvco_provincia').val(res.provincia);  
                    $('#cvco_departamento').val(res.departamento);  

                    $('#mdl_edit_registro').modal('show');




                }else{
                }
            }
        });
    }

    function actualizar(){      
        var id = $('#cvco_id').val();
        var r_social = $('#cvco_razon_social').val();
        var ruc = $('#cvco_ruc').val();
        var cod_iscom = $('#cvco_codigo_iscom').val();
        var estado = $('#cvco_estado').val();
        var cuenta_sd = $('#cvco_cuenta_sd').val();
        var mes_deuda = $('#cvco_mes_deuda').val();     
        var dias_pago = $('#cvco_dias_pago').val();    
        var osig = $('#cvco_osinergmin').val();
        var distrib = $('#cvco_distribuidora').val();
        var sumin_dis = $('#cvco_suministro_dis').val();
        var alimen = $('#cvco_alimentador').val();      
        var pmi = $('#cvco_pmi').val();
        var dir_dis = $('#cvco_direccion_dis').val();
        var dis = $('#cvco_distrito').val();
        var pro = $('#cvco_provincia').val();
        var dep = $('#cvco_departamento').val();

        if (!r_social) {alertify.error('Ingresa la Razon Social');return;}
        if (!dep) {alertify.error('Seleccione el Departamento');return;}
        if (!distrib) {alertify.error('Seleccione el Distribuidor');return;}
        if (!estado) {alertify.error('Seleccione el Estado');return;}
        if (!osig) {alertify.error('Selecciona el Estado de Osinergmin"');return;}

         // Validación del RUC
        if (!ruc || ruc.length !== 11) {
            alertify.error('El RUC debe tener 11 dígitos');
            return;
        }
    
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>Controller_cliente_libre/actualizar',
            data: {    
                'id':id,    
                'r_social':r_social,
                'ruc':ruc,
                'cod_iscom':cod_iscom,
                'estado':estado,

                //'cuenta_sd':cuenta_sd,                         
                //'mes_deuda':mes_deuda,  
                //'dias_pago':dias_pago,
                //'osig':osig,   

                'distrib':distrib,                
                'sumin_dis':sumin_dis,  
                'alimen':alimen, 
                'pmi':pmi, 
                'dir_dis':dir_dis,
                'dis':dis, 
                'pro':pro,
                'dep':dep                     
            }, 
            beforeSend:function(){
            },   
            success: function(data){ 
                nuevo_registro=1;
                cont_nuevos=0; 
                $('#mdl_edit_registro').modal('hide');
                $("#btn_agregar_chat").removeAttr('disabled');

                var json         = eval("(" + data + ")");
                if (json.mensaje=='') {

                    notificacion('Actualización realizada', 'No se pudo actualizar la impresión del preaviso debido a que se ha superado el límite', 'info');

                }else{
                    notificacion('Actualización realizada','Se actualizo correctamente.','success');

                    tb_table_registros.ajax.reload();
                }
                
                  
                  
            }
        });

        //agregar('solicitud',0,id_tipo_registro,cuspp);
    }
/* fin */



/* limpiar formulario */

    function limpiar_formulario(){  
        var d = new Date(); 
        var format =  d.getDate() + "-" + (d.getMonth()+1) + "-" +  d.getFullYear();
    
        $("#txt_nombres").val('');
        $("#txt_apellidos").val('');
        $("#txt_dni").val('');
        $("#txt_tipo_user").val('');
        $("#txt_clave").val('');
        $("#txt_estado").val('');
        $("#txt_email").val('');
        $("#txt_movil").val('');       
        $("#txt_f_nac").val('');  
        $("#txt_direccion").val('');  
        $("#txt_observacion").val('');
    }

/* fin */

</script>