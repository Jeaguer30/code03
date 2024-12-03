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
                                        <h4 class="card-title">CONTROL DE USUARIOS</h4>
                                        <p class="card-title-desc">Detalle de control.</p>
                                    </div>
                                    
                                </div>                               
                            </div>                    

                            <div class="card-body">
                                <div class="row mb-3">                                   
                                    
                                    <div class="col-lg-2 col-sm-2  col-md-2 ">
                                        <div class="card p-3" >
                                            <div class="row">
                                                <div class="col-lg-12 " > 
                                                    <label> Filtro por Mes </label>                                                                                                          
                                                    <select class="form-control form-control-sm" id="slc_mes_control" onchange="aplicar_filter_mes();">
                                                        <option value="">Seleccione</option>                                                                                                                                         
                                                    </select>  
                                                </div>                                               
                                            </div>                                                                            
                                        </div>
                                    </div>

                                    <div class=" col-lg-5 col-sm-5  col-md-5  ">
                                        <div class="card p-3" >
                                            <div class="row">
                                                <div class="col-lg-5 " >                                                                                                                                                                                             
                                                    <label >Fecha Inicio</label>
                                                    <input type="date" class="form-control form-control-sm" id="fil_fecha_inicio"  />                                                                                    
                                                </div> 
                                                
                                                <div class="col-lg-5 " >                                                                                                                                                                                             
                                                    <label >Fecha Fin</label>
                                                    <input type="date" class="form-control form-control-sm" id="fil_fecha_fin" />                                                                                                                                      
                                                </div>
                                                <div class="col-lg-1 " > 
                                                    <label >-</label>
                                                    <button type="button" class="btn btn-sm btn-outline-success" onclick="filter_rango_fechas();"><i class='bx bx-search-alt'></i></button>
                                                </div>
                                            </div>                                                                            
                                        </div> 
                                    </div>
                                   
                                    <div class="col-lg-2 col-sm-2  col-md-2  ">
                                        <div class="card p-3" >
                                            <div class="row">                                               
                                                <div class="col-lg-12  " >  
                                                    <label> Filtro por Usuario </label>                                                                                                         
                                                    <select class="form-control form-control-sm" id="slc_filter_usuario" onchange="aplicar_filter_usuario();">
                                                        <option value="">Seleccione</option>                                                                                                                                         
                                                    </select>  
                                                </div> 
                                            </div>
                                        </div>                                    
                                    </div> 

                                    <div class="col-lg-3 col-sm-3  col-md-3  ">
                                        <div class="card p-3" >
                                            <div class="row">
                                                <div class="col-lg-6  " > 
                                                    <label >Nuevo control</label>
                                                    <div>
                                                        <button class="btn btn-sm btn-outline-primary waves-effect waves-light " id="btn_agregar"  onclick="view_mdl();"> <i class="mdi mdi-plus"></i> </button>                                     
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 " > 
                                                    <form action="<?php echo base_url(); ?>Controller_control_asistencia/exportar_bloque" method="post" target="_blank">
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
                                <div class="card" style="max-height: 480px; overflow-y: auto;">
                                   
                                    <div class="card-body p-1">
                                    <table class="table table-responsive table-striped  " style="font-size:11px;">
                                    <thead>
                                        <tr class="bg-primary text-center text-white">    
                                            <th colspan="3">Información General</th> 
                                         
                                            <th colspan="2">Entrada</th> 
                                            <th colspan="2">Salida</th>  
                                            <th colspan="2">opciones</th>                                                                                                               
                                                                                
                                        </tr>
                                        <tr class="bg-primary text-center text-white">    
                                            <th>#</th>    
                                            <th>Gestor</th> 
                                            <th>Fecha registro</th>                                                                                                                 
                                            <th>hora ingreso</th>    
                                            <th>Resultado</th>                                                
                                            <th>Hora de salida</th>
                                            <th>Resultado Salida</th>                                            
                                            <th>Guardar</th>  
                                            <th>Eliminar</th>                               
                                        </tr>
                                    </thead>
                                    <tbody id="tb_asistencia">
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

    <!-- Modal add control usuario  -->

    <div class="modal fade" id="mdl_add_control_fecha" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-secondary">
                <div class="modal-header bg-primary ">
                    <h5 class="modal-title text-white" id="staticBackdropLabel">Crear control</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">   
                    
                    <div class="col-lg-12 col-md-12">                        
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <label for="slc_fecha_control_add">Fecha de control</label>
                            <input type="date" class="form form-control form-control-sm" id="slc_fecha_control_add">
                            </div>
                        
                            <div class="col-lg-12 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="cb_agregar_x_usuario" onchange="on_agregar_usuario();">
                                    <label class="form-check-label" for="cb_agregar_x_usuario">
                                        Agregar x usuario
                                    </label>
                                </div>
                            </div> 

                            <div class="col-lg-12" style="display:none" id="pnl_add_user">
                                <label >Usuario</label>
                                <select class="form form-control form-control-sm" id="slc_usuario_control"></select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" onclick="add_user_control();">Grabar</button>
                </div>
            </div>
        </div>
    </div> <!-- fin modal --> 

  


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>


<script>

    //tb_table_registros.ajax.reload();
    var sessionInterval;
    $(document).ready(function() {
       
        
        load_select_fecha();
        load_usuario_add();
        load_select_mes_control();
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

    function get_tbl_control_asistencia(){
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>Controller_control_asistencia/get_tbl_control_asistencia',
            data: {}, 
            beforeSend:function(){
            },   
            success: function(data){ 
                var json         = eval("(" + data + ")");
                if(json.mensaje=='ok'){
                    $('#tb_asistencia').html(json.resultado);
                    $('#slc_filter_usuario').val('');
                    
                    
                }else{
                }
            }
        });
    } 

/**************************************************************************************/
/***************************** FUNCIONES TABLA ASISTENCIA *****************************/
/**************************************************************************************/

    function view_mdl() {
        $('#mdl_add_control_fecha').modal('show');  
        load_usuario_add();      
    }

    function add_user_control(){   
        var cb_agregar_x_usuario = $('#cb_agregar_x_usuario').is(':checked') ? 1 : 0; 
        var slc_fecha_control_add = $('#slc_fecha_control_add').val();
        var slc_usuario_control = $('#slc_usuario_control').val();

        if (cb_agregar_x_usuario == 1) {
            if (slc_fecha_control_add=='') {
                alertify.error('Seleccione la fecha donde se agregara el usuario');return;
            } 
 
            if (slc_usuario_control == '') {
                alertify.error('Seleccione el usuario');return;
            } 
        }   

        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>Controller_control_asistencia/add_user_control',
            data: {
                'cb_agregar_x_usuario':cb_agregar_x_usuario,
                'slc_fecha_control_add':slc_fecha_control_add,
                'slc_usuario_control':slc_usuario_control
            
            },
            beforeSend: function () { 
            },
            success: function (data) {
                var json = JSON.parse(data);
                if (json.mensaje_2== '1') {
                    alertify.success('Gestor agregado correctamente');
                } else {
                    if (json.mensaje_1 == 'ok') {

                        if (json.mensaje == 'ok') {
                            alertify.success('control Generado correctamente');
                        } else {
                            alertify.error('Ocurrio un error intentelo nuevamente');
                        }

                    } else {
                        alertify.error('Ya cuenta con un bloque generado el dia de hoy, Por favor filtre por fecha')
                    
                    }                    
                }
                $('#mdl_add_control_fecha').modal('hide'); 
                load_select_fecha();
                get_tbl_control_asistencia();
            },          
        });
    }
    
    function load_select_fecha(){
       
       $.ajax({
           type: "POST",
           url: '<?php echo base_url();?>Controller_control_asistencia/load_select_fecha',
           data: {}, 
           beforeSend:function(){
              
           },   
           success: function(data){
             
               $('#slc_fechas_control').html(data);
           },
           error: function(){
           }
       }); 
    }

    function load_select_mes_control(){
       
       $.ajax({
           type: "POST",
           url: '<?php echo base_url();?>Controller_control_asistencia/load_select_mes_control',
           data: {}, 
           beforeSend:function(){
              
           },   
           success: function(data){
             
               $('#slc_mes_control').html(data);
           },
           error: function(){
           }
       }); 
    }

    function load_usuario_add(){       
       $.ajax({
           type: "POST",
           url: '<?php echo base_url();?>Controller_control_asistencia/load_usuario_add',
           data: {}, 
           beforeSend:function(){
              
           },   
           success: function(data){
             
               $('#slc_usuario_control').html(data);
               $('#slc_filter_usuario').html(data);
               
           },
           error: function(){
           }
       }); 
    }

    function aplicar_filter_fecha(){ 
        
        var filtro_fecha = $('#slc_fechas_control').val();
        $.ajax({
            type: "POST",
            url: '<?php echo base_url();?>Controller_control_asistencia/aplicar_filter_fecha',
            data: {'filtro_fecha':filtro_fecha}, 
            beforeSend:function(){
               
            },   
            success: function(data){
                get_tbl_control_asistencia();
            },
            error: function(){
            }
        }); 
    }

    function aplicar_filter_mes(){ 
        
        var filtro_mes = $('#slc_mes_control').val();
        $.ajax({
            type: "POST",
            url: '<?php echo base_url();?>Controller_control_asistencia/aplicar_filter_mes',
            data: {'filtro_mes':filtro_mes}, 
            beforeSend:function(){
               
            },   
            success: function(data){
                get_tbl_control_asistencia();
                $('#fil_fecha_inicio').val('')
                $('#fil_fecha_fin').val('')
            },
            error: function(){
            }
        }); 
    }

    function filter_rango_fechas(){ 

        
        var fecha_inicio = $('#fil_fecha_inicio').val();
        if (fecha_inicio=='') {
            alertify.error('Ingrese la Fecha de Inicio');return;
        } 
        var fecha_fin = $('#fil_fecha_fin').val();
        if (fecha_fin=='') {
            alertify.error('Ingrese la Fecha Fin');return;
        } 

        $.ajax({
            type: "POST",
            url: '<?php echo base_url();?>Controller_control_asistencia/filter_rango_fechas',
            data: {'fecha_inicio':fecha_inicio,'fecha_fin':fecha_fin}, 
            beforeSend:function(){
               
            },   
            success: function(data){
                get_tbl_control_asistencia();
            },
            error: function(){
            }
        }); 
    }
    
    function aplicar_filter_usuario(){
        var filtro_fecha = $('#slc_fechas_control').val();
        if (filtro_fecha=='') {
          alertify.error('seleccione la fecha');return;  
         
        }
        
        var filtro_usuario = $('#slc_filter_usuario').val();
        $.ajax({
            type: "POST",
            url: '<?php echo base_url();?>Controller_control_asistencia/aplicar_filter_usuario',
            data: {'filtro_usuario':filtro_usuario}, 
            beforeSend:function(){
               
            },   
            success: function(data){
                get_tbl_control_asistencia();
            },
            error: function(){
            }
        }); 
    }

    function on_agregar_usuario(){
        var cb_agregar_x_usuario = $('#cb_agregar_x_usuario').is(':checked') ? 1 : 0; 
        
        if (cb_agregar_x_usuario == 1) {
            $('#pnl_add_user').css('display','block');
        } else {
            $('#pnl_add_user').css('display','none');
        }
        
        

    }

/**************************************************************************************/
/********************** FUNCIONES OPCIONES TABLA ASISTENCIA ***************************/
/**************************************************************************************/

    function delete_usuario_ctrl(id){

        msg_delete()
            .then((val) => {
                if (val === 'true') {                                                   
                    $.ajax({
                        type: "POST",
                        url: '<?php echo base_url(); ?>Controller_control_asistencia/delete_usuario_ctrl',
                        data: {'id':id},
                        beforeSend: function () {   

                        },
                        success: function (data) { 
                                                                     
                            get_tbl_control_asistencia();
                        },
                    });                   
                }else{
                    alertify.error('Operacion cancelada');
                }
            })
            .catch((error) => {
            
        });
    }   

    
    function save_control(contador,id){

        var txt_hora_entrada_ctrl        = $('#txt_hora_entrada_ctrl_'+contador).val();               
        var slc_resultado_entrada_ctrl   = $('#slc_resultado_entrada_ctrl_'+contador).val(); 
        var txt_obs_entrada_ctrl         = $('#txt_obs_entrada_ctrl_'+contador).val();   
        var txt_hora_salida_ctrl         = $('#txt_hora_salida_ctrl_'+contador).val();
        var slc_resultado_salida_ctrl    = $('#slc_resultado_salida_ctrl_'+contador).val();
        var txt_obs_salida_ctrl          = $('#txt_obs_salida_ctrl_'+contador).val();

        $.ajax({
            type: "POST",
            
            url: '<?php echo base_url();?>Controller_control_asistencia/grabar_progamacion',
            data: {
                'id':id,
                'txt_hora_entrada_ctrl':txt_hora_entrada_ctrl,
                'slc_resultado_entrada_ctrl':slc_resultado_entrada_ctrl,
                'txt_obs_entrada_ctrl':txt_obs_entrada_ctrl,                
                'txt_hora_salida_ctrl':txt_hora_salida_ctrl,
                'slc_resultado_salida_ctrl':slc_resultado_salida_ctrl,
                'txt_obs_salida_ctrl':txt_obs_salida_ctrl
                    
            }, 
            beforeSend:function(){
            },   
            success: function(data){  
            var json = JSON.parse(data);  
            if (json.mensaje=='ok') {
                $('#txt_fecha_update_ctrl_'+contador).html(json.fecha_upd)
            } else {
                
            }            
                alertify.success('Control realizado correctamente');                    
            //  get_tbl_control_asistencia();
            }
        });    
    }


/**************************************************************************************/
/************************************* OTRAS FUNCIONES ********************************/
/**************************************************************************************/

    function msg_delete() {
        return new Promise((resolve, reject) => {
            const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-danger m-3 ',
                cancelButton: 'btn btn-success '
            },
            buttonsStyling: false
            });
            swalWithBootstrapButtons.fire({
            title: '¿Esta seguro que desea eliminar el usuario?',
            html: "<p></p>",                                 
            icon: 'warning',
            showCloseButton: true,
            showCancelButton: true,           
            confirmButtonText: 'Si, eliminar',
            cancelButtonText: 'No, Cancelar',
            reverseButtons: true
            }).then((result) => {
            if (result.isConfirmed) {
                resolve('true');
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                resolve('false');
            } else {
                reject('unknown'); // En caso de otro resultado
            }
            });
        });
    }


</script>