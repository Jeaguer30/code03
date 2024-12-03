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

    
</style>


<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">           
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <div class="">
                                    <h4 class="card-title">MODULO DE PERMISOS</h4>
                                    <p class="card-title-desc">Detalle de accesos.</p>
                                </div>
                                
                            </div>                               
                        </div>                    

                        <div class="card-body">
                            <div class="row">                           
                                
                                <div class="col-lg-2 col-sm-2  col-md-2 ">
                                    <div class="card p-3 " style="border-radius:15px;" >
                                        <div class="row">
                                            <div class="col-lg-12 "  > 
                                                <label> Filtro tipo de usuario </label>                                                                                                          
                                                <select class="form-select form-select-sm" id="slc_tipo_user" onchange="aplicar_filter_tipo_user();">
                                                    <option value="">Seleccione</option>                                                                                                                                         
                                                </select>  
                                            </div>                                               
                                        </div>                                                                            
                                    </div>
                                </div>

                                <div class="col-lg-2 col-sm-2  col-md-2 ">
                                    <div class="card p-3 " style="border-radius:15px;">
                                        <div class="row">
                                            <div class="col-lg-12 " > 
                                                <label> Filtro Menu </label>                                                                                                          
                                                <select class="form-select form-select-sm" id="slc_menu" onchange="aplicar_filter_menu();">
                                                    <option value="">Seleccione</option>                                                                                                                                         
                                                </select>  
                                            </div>                                               
                                        </div>                                                                            
                                    </div>
                                </div>

                                <div class="col-lg-2 col-sm-2  col-md-2 ">
                                    <div class="card p-3" style="border-radius:15px;">
                                        <div class="row">
                                            <div class="col-lg-12 " > 
                                                <label> Filtro Sub - Menu </label>                                                                                                          
                                                <select class="form-select form-select-sm" id="slc_sub_menu" onchange="aplicar_filter_sub_menu();">
                                                    <option value="">Seleccione</option>                                                                                                                                         
                                                </select>  
                                            </div>                                               
                                        </div>                                                                            
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-3  col-md-3 ">
                                    <div class="card p-3" style="border-radius:15px;">
                                        <div class="row">
                                            <div class="col-lg-12 " > 
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label" for="check_activo">Activo</label>
                                                <input  class="form-check-input" type="radio" name="inlineRadioOptions" id="check_activo" value="1" onchange="filter_check(this)">
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="check_inactivo" value="0" onchange="filter_check(this)">
                                                <label class="form-check-label" for="check_inactivo">Inactivo</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input checked class="form-check-input" type="radio" name="inlineRadioOptions" id="check_ambos" value="" onchange="filter_check(this)">
                                                <label  class="form-check-label" for="check_ambos">Ambos</label>
                                            </div>
                                            </div>                                               
                                        </div>                                                                            
                                    </div>
                                </div>
                                
                                <div class="col-lg-3 col-sm-3  col-md-3 ">
                                    <div class="card p-3" style="border-radius:15px;">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div>
                                                    <label> Agregar </label> 
                                                </div>                                                                                                                                                 
                                                <button class="btn btn-sm btn-secondary waves-effect waves-light " id="btn_agregar"  onclick="ver_mdl();"> <i class="mdi mdi-plus"></i>Agregar</button>    
                                            </div>  
                                            
                                            <div class="col-lg-6 " > 
                                                <form action="<?php echo base_url(); ?>Controller_config_sub_menu/exportar_log_permisos" method="post" target="_blank">
                                                <label >Exportar</label>
                                                    <div>                                                
                                                        <button  class="btn btn-sm btn-outline-light waves-effect waves-light">
                                                            <img src="<?php echo base_url();?>public/img/iconos/excel.png" alt="Botón Imagen" style="width:23px;"> .XLSX
                                                        </button>
                                                    </div> 
                                                </form>
                                            </div>
                                        </div>                                                                            
                                    </div>
                                    
                                </div>  

                            </div>
                            <div class="card" style="max-height: 600px; overflow-y: auto;">   
                                <div class="card-header">
                                    <div class="row">                                            
                                        <div class ="col-lg-6">
                                            <label class="card-title"> configuracion para usuarios tipo: </label>
                                            <label id="lbl_tipo_user">N/A</label>
                                        </div>
                                    </div>
                                </div>                                
                                <div class="card-body p-1">
                                    <table class="table table-responsive table-bordered  dt-responsive nowrap w-100" style="font-size:11px;">
                                        <thead>                                          
                                            <tr class="bg-primary text-center text-white">    
                                                <th>#</th>    
                                                <th>Menu</th> 
                                                <th>Sub Menu</th>                                                                                                                                                          
                                                <th>Permiso</th>                                                                                 
                                            </tr>
                                        </thead>
                                        <tbody id="tb_sub_menu">
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


<div class="modal fade" id="mdl_add_menu" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <img src="<?php echo base_url();?>public/img/iconos/agregar-contacto.png" alt="Descripción de la imagen" style="max-width: 34px; max-height: 34px; margin-right: 10px;">
                <h5 class="modal-title" id="staticBackdropLabel">Agregar/Asignar Menu Submenu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">        
                <div class="row">                        
                    <div class="col-lg-12 mb-3" > 
                        <label> Filtro Menu </label>                                                                                                          
                        <select class="form-select form-select-sm" id="slc_menu_add" onchange="add_otros();">
                            <option value="">Seleccione</option>  
                                                                                                                                                                    
                        </select>  
                    </div>
                </div> 
                <div id="pnl_add_menu" style="display:none;">
                    <div class="row">                                  
                        <div class="col-lg-6 mb-3" > 
                            <label>  Menu </label>                                                                                                                                       
                            <input type="text" class="form-control form-control-sm" id="txt_menu_add" placeholder="Nombre Menu">                        
                        </div>
                        <div class="col-lg-6 mb-3" > 
                            <label>  Icono </label>                                                                                                                                                          
                            <input type="text" class="form-control form-control-sm" id="txt_icono_add" placeholder="Ejemplo: bx bx-trash ">                          
                        </div>
                    </div> 
                </div>
                <div class="row">                        
                    <div class="col-lg-6 " > 
                        <label> Sub Menu</label>                                                                                                          
                        <div class="col-lg-12 mb-3">                            
                            <input type="text" class="form-control form-control-sm" id="txt_sub_menu_add" placeholder="Nombre Sub Menu">
                        </div> 
                    </div>
                    <div class="col-lg-6 " > 
                        <label> Ruta Sub Menu </label>                                                                                                          
                        <div class="col-lg-12 mb-3">                            
                            <input type="text" class="form-control form-control-sm" id="txt_ruta_sub_menu_add" placeholder="Ejemplo: seg_permisos_menu">
                        </div> 
                    </div>
                </div> 
            </div>
            <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="agregar_add_menu();">Guardar</button>
            </div>
            
        </div>
    </div>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script>
    var sessionInterval;
    $(document).ready(function() {
        
        load_tipo_user();
        load_menu();
        load_sub_menu(0);
        sessionInterval = setInterval(() => {
            validar_session();
        }, 2000);
    });

/**************************************************************************************/
/*********************************** VALIDAR SESSION **********************************/
/**************************************************************************************/

    function validar_session(){
        $.ajax({
            type: "POST",
            url: '<?php echo base_url();?>Controller_validar_session/validar_session',
            data: {}, 
            beforeSend:function(){
                
            },   
            success: function(data){             
                var json = JSON.parse(data);
                if (json.mensaje=='error') {                   
                    $('#modal_session').modal('show');
                    $('.modal-backdrop').addClass('custom-backdrop');
                    console.log('SESSION INACTIVA');                   
                    clearInterval(sessionInterval);
                } else {                    
                    
                    console.log('SESSION ACTIVA');
                }
            },
            error: function(){
            }
        });
    } 

/**************************************************************************************/
/***************************** FUNCIONES GET TABLA ************************************/
/**************************************************************************************/ 

    function get_tbl_config_sub_menu(){
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>Controller_config_sub_menu/get_tbl_config_sub_menu',
            data: {}, 
            beforeSend:function(){
            },   
            success: function(data){ 
                var json  = JSON.parse(data);
                if(json.mensaje=='ok'){
                    $('#tb_sub_menu').html(json.resultado);
       
                }else{

                }
            }
        });
    } 

/**************************************************************************************/
/***************************** FUNCIONES AGREGAR MENU *********************************/
/**************************************************************************************/

    function ver_mdl(){
        $('#mdl_add_menu').modal('show');
        load_menu(1)
    }

    function add_otros(){
        var slc_menu_add = $('#slc_menu_add').val();
        if (slc_menu_add == 99) {
            $('#pnl_add_menu').css('display','block');
        }else{
            $('#pnl_add_menu').css('display','none');
        }   
    }

    function agregar_add_menu(){

        var txt_sub_menu_add = $('#txt_sub_menu_add').val();
        var txt_ruta_sub_menu_add = $('#txt_ruta_sub_menu_add').val();
        var slc_menu_add = $('#slc_menu_add').val();
        var txt_menu_add = $('#txt_menu_add').val();
        var txt_icono_add = $('#txt_icono_add').val();

        if (slc_menu_add == 99) {
           if (txt_menu_add=='') {
                alertify.error('Ingrese el nombre del menú');return;
           }
           if (txt_icono_add=='') {
                alertify.error('Ingrese icono para el menú');return;
           }
        }
       
        if (txt_sub_menu_add=='') {
            alertify.error('Ingrese el Sub menu');return;
        }
        if (txt_ruta_sub_menu_add=='') {
            alertify.error('Ingrese la ruta');return;
        }

        $.ajax({
           type: "POST",
           url: '<?php echo base_url();?>Controller_config_sub_menu/agregar_add_menu',
           data: {  'txt_sub_menu_add':txt_sub_menu_add,
                    'txt_ruta_sub_menu_add':txt_ruta_sub_menu_add,
                    'slc_menu_add':slc_menu_add,
                    'txt_menu_add':txt_menu_add,
                    'txt_icono_add':txt_icono_add
        
            }, 
           beforeSend:function(){            
           },   

           success: function(data){             
                var json = JSON.parse(data);

                if (json.mensaje=='1'){
                    alertify.success('Sub Menu agregado correctamente');
                }

                if (json.mensaje=='2'){
                    alertify.success('Menú y Sub Menú agregado correctamente');
                }
                $('#mdl_add_menu').modal('hide');
                get_tbl_config_sub_menu();
           },
           error: function(){
           }
       }); 

    }

/**************************************************************************************/
/***************************** FUNCIONES CARGA SELECT *********************************/
/**************************************************************************************/ 
    
    function load_tipo_user(){       
       $.ajax({
           type: "POST",
           url: '<?php echo base_url();?>Controller_config_sub_menu/load_tipo_user',
           data: {}, 
           beforeSend:function(){            
           },   

           success: function(data){             
               $('#slc_tipo_user').html(data);
           },
           error: function(){
           }
       }); 
    }

    function load_menu(id){       
       $.ajax({
           type: "POST",
           url: '<?php echo base_url();?>Controller_config_sub_menu/load_menu',
           data: {'id':id}, 
           beforeSend:function(){            
           },   

           success: function(data){             
               $('#slc_menu').html(data);
               $('#slc_menu_add').html(data);      
              
           },
           error: function(){
           }
       }); 
    }

    function load_sub_menu(){       
       $.ajax({
           type: "POST",
           url: '<?php echo base_url();?>Controller_config_sub_menu/load_sub_menu',
           data: {}, 
           beforeSend:function(){            
           },   
           success: function(data){             
               $('#slc_sub_menu').html(data);
           },
           error: function(){
           }
       }); 
    }

/**************************************************************************************/
/****************************** APLICAR FILTRO SELECT *********************************/
/**************************************************************************************/ 
    function filter_check(radio) {
        var filtro_tipo_user = $('#slc_tipo_user').val();
        if (filtro_tipo_user == ''){
            alertify.error('Seleccione el tipo de usuario');return;
           
        }
        var value;
        if (radio.checked) {
            var value = radio.value;      
        }
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>Controller_config_sub_menu/filter_check',
            data: {'value':value},
            beforeSend: function() {},
            success: function(data) {                
                get_tbl_config_sub_menu();              
            }
        });
    }

    function aplicar_filter_menu(){ 
        var filtro_tipo_user = $('#slc_tipo_user').val();
        if (filtro_tipo_user == ''){
            alertify.error('Seleccione el tipo de usuario');return;
        }
        var filtro_menu = $('#slc_menu').val();
        $.ajax({
            type: "POST",
            url: '<?php echo base_url();?>Controller_config_sub_menu/aplicar_filter_menu',
            data: {'filtro_menu':filtro_menu}, 
            beforeSend:function(){
               
            },   
            success: function(data){               
                load_sub_menu();
                get_tbl_config_sub_menu();         
            },
            error: function(){
            }
        }); 
    }

    function aplicar_filter_sub_menu(){ 
        var filtro_tipo_user = $('#slc_tipo_user').val();
        if (filtro_tipo_user == ''){
            alertify.error('Seleccione el tipo de usuario');return;
        }        
        var filtro_sub_menu = $('#slc_sub_menu').val();
        $.ajax({
            type: "POST",
            url: '<?php echo base_url();?>Controller_config_sub_menu/aplicar_filter_sub_menu',
            data: {'filtro_sub_menu':filtro_sub_menu}, 
            beforeSend:function(){
               
            },   
            success: function(data){
                
                
                get_tbl_config_sub_menu();         
            },
            error: function(){
            }
        }); 
    }

    function aplicar_filter_tipo_user(){ 
       

        
        var filtro_user = $('#slc_tipo_user').val();
        $.ajax({
            type: "POST",
            url: '<?php echo base_url();?>Controller_config_sub_menu/aplicar_filter_tipo_user',
            data: {'filtro_user':filtro_user}, 
            beforeSend:function(){
               
            },   
            success: function(data){
                var json = JSON.parse(data);
                $('#lbl_tipo_user').html(json.descripcion);
                get_tbl_config_sub_menu();  
                $('#check_activo').prop('checked',false);
                $('#check_inactivo').prop('checked',false);
               
            },
            error: function(){
            }
        }); 
    }

/**************************************************************************************/
/****************************** AGREGAR/QUITAR PERMISOS *******************************/
/**************************************************************************************/

    function add_permisos_sub_menu(id,user,contador){
        if (user == '0'){
            alertify.error('Seleccione el tipo de usuario');return;
        }
        var check_permiso = $('#check_permiso_'+contador).is(':checked') ? 1 : 0;

        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>Controller_config_sub_menu/add_permisos_sub_menu',
            data: {'check_permiso':check_permiso,'id':id,'user':user}, 
            beforeSend:function(){
            },   
            success: function(data){ 
               var json = JSON.parse(data);

               if (json.mensaje=='ok') {
                alertify.success('Permisos aplicados correctamente');
               }

               if (json.mensaje_1=='ok') {
                alertify.success('Permisos elimados');
               } 
               get_tbl_config_sub_menu(); 
            }
        });
    }



</script>