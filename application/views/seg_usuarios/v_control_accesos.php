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
                                        <h4 class="card-title">CONTROL DE ACCESOS </h4>
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
                                                    <label> Filtro Mes </label>                                                                                                          
                                                    <select class="form-select form-select-sm" id="slc_mes_control" onchange="aplicar_filter_mes();">
                                                        <option value="">Seleccione</option>   
                                                        <option value="1">Login </option>  
                                                        <option value="2">Acceso Modulo</option>       
                                                                                                                                                                                                   
                                                    </select>  
                                                </div>                                               
                                            </div>                                                                            
                                        </div>
                                    </div>

                                    <div class=" col-lg-4 col-sm-4  col-md-4  ">
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
                                    <div class="col-lg-2 col-sm-2  col-md-2 ">
                                        <div class="card p-3" >
                                            <div class="row">
                                                <div class="col-lg-12 " > 
                                                    <label> Tipo de acceso </label>                                                                                                          
                                                    <select class="form-select form-select-sm" id="slc_tipo_acceso" onchange="aplicar_filter_tipo_acceso();">
                                                        <option value="">Seleccione</option>   
                                                        <option value="1">Login </option>  
                                                        <option value="2">Acceso Modulo</option>       
                                                                                                                                                                                                   
                                                    </select>  
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

                                    <div class="col-lg-2 col-sm-2  col-md-2  ">
                                        <div class="card p-3" >
                                            <div class="row">                                              
                                                <div class="col-lg-12 " > 
                                                    <form action="<?php echo base_url(); ?>Controller_control_accessos/exportar_bloque" method="post" target="_blank">
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
                                                                  
                                    
                                        <table id="tb_control_log" class="table table-responsive table-bordered  dt-responsive nowrap w-100" style="font-size:11px;">
                                            <thead>                                            
                                                <tr class="bg-primary text-center text-white">    
                                                    <th>#</th>   
                                                    <th>Tipo acceso</th>  
                                                    <th>Usuario</th> 
                                                    <th>Fecha acceso</th>                                                                                                                                                                    
                                                    <th>Menu</th>    
                                                    <th>Sub Menu</th>                             
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

    //tb_control_log.ajax.reload();

    var tb_control_log;
    var sessionInterval;
    $(document).ready(function() {       
        
        forDataTables('#tb_control_log','Controller_control_accessos/listar_registros'); 
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


/**************************************************************************************/
/***************************** FUNCIONES TABLA ASISTENCIA *****************************/
/**************************************************************************************/
    
    function load_select_fecha(){
       
       $.ajax({
           type: "POST",
           url: '<?php echo base_url();?>Controller_control_accessos/load_select_fecha',
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
           url: '<?php echo base_url();?>Controller_control_accessos/load_select_mes_control',
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
           url: '<?php echo base_url();?>Controller_control_accessos/load_usuario_add',
           data: {}, 
           beforeSend:function(){
              
           },   
           success: function(data){
             
               
               $('#slc_filter_usuario').html(data);
               
           },
           error: function(){
           }
       }); 
    }

    function aplicar_filter_tipo_acceso(){ 
        
        var tipo_acceso = $('#slc_tipo_acceso').val();
        $.ajax({
            type: "POST",
            url: '<?php echo base_url();?>Controller_control_accessos/aplicar_filter_tipo_acceso',
            data: {'tipo_acceso':tipo_acceso}, 
            beforeSend:function(){
              
            },   
            success: function(data){
                tb_control_log.ajax.reload();
            },
            error: function(){
            }
        }); 
    }

    function aplicar_filter_mes(){ 
        
        var filtro_mes = $('#slc_mes_control').val();
        $.ajax({
            type: "POST",
            url: '<?php echo base_url();?>Controller_control_accessos/aplicar_filter_mes',
            data: {'filtro_mes':filtro_mes}, 
            beforeSend:function(){
               
            },   
            success: function(data){
                tb_control_log.ajax.reload();
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
            url: '<?php echo base_url();?>Controller_control_accessos/filter_rango_fechas',
            data: {'fecha_inicio':fecha_inicio,'fecha_fin':fecha_fin}, 
            beforeSend:function(){
               
            },   
            success: function(data){
                tb_control_log.ajax.reload(); 
            },
            error: function(){
            }
        }); 
    }
    
    function aplicar_filter_usuario(){
      /*   var filtro_fecha = $('#slc_fechas_control').val();
        if (filtro_fecha=='') {
          alertify.error('seleccione la fecha');return;  
         
        } */
        
        var filtro_usuario = $('#slc_filter_usuario').val();
        $.ajax({
            type: "POST",
            url: '<?php echo base_url();?>Controller_control_accessos/aplicar_filter_usuario',
            data: {'filtro_usuario':filtro_usuario}, 
            beforeSend:function(){
               
            },   
            success: function(data){
                tb_control_log.ajax.reload();  
            },
            error: function(){
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

/**************************************************************************************/
/************************************* DATATABLE  *************************************/
/**************************************************************************************/
    function forDataTables( id, ruta) {
        tb_control_log = $(id).DataTable({
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


</script>