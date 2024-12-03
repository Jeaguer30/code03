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
                                    <h4 class="card-title">REGISTROS DE USUARIOS</h4>
                                    <p class="card-title-desc">Detalle de registros.</p>
                                </div>

                                <div class="col-lg-1 col-sm-2 col-3 mb-2"  >
                                    <button class="btn btn-sm btn-primary waves-effect waves-light mb-1" id="btn_agregar_chat"  onclick="ver_mdl('mdl_add_registro');"> <i class="mdi mdi-plus"></i>NUEVO USUARIO</button>                                     
                                </div> 

                                <!-- <div class="col-lg-2 col-7" >
                                    <button class="btn btn-sm btn-primary waves-effect waves-light mb-1" id="btn_agregar_chat"  onclick="ver_mdl_config_user_preaviso();"> <i class="mdi mdi-plus"></i>Conf. Usuario Preaviso</button>                                     
                                </div>                              -->
                            </div>     
                        </div>  
                                            

                        <div class="card-body">                        
                            <div class="col-lg-12 col-dm-12 col-sm-12 col-12 my-3"> 
                                <div class="row"> 
                                    <div class="col-lg-3  col-dm-5 col-sm-7 col-7">
                                        <div class="card p-3 " style="border-radius:15px;" >
                                            <div class="row">
                                                <div class="col-lg-10 col-md-10  col-sm-10 col-9"  > 
                                                    <label >Tipo de Usuario</label>                                                                    
                                                    <select class="form form-select form-select-sm" id="slc_tipo_user" onchange="aplicar_filter_tipo_user();"></select>  
                                                </div>      
                                                <div class="col-lg-2 col-md-2 col-sm-2 col-3 mt-1"  > 
                                                  
                                                    <button type="button" class="btn btn-sm btn-outline-success mt-4" onclick="mdl_tipo_usuarios();"><i class='bx bxs-pencil'></i></button>  
                                                </div>   
                                               
                                            </div>                                                                            
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-dm-5 col-sm-5 col-5">
                                        <div class="card p-3 " style="border-radius:15px;" >
                                            <div class="row">
                                                <div class="col-lg-12 "  > 
                                                    <label >Estado</label>                                                                                                  
                                                    <select class="form form-select form-select-sm" id="slc_estado" onchange="aplicar_estado();">
                                                        <option value="">Seleccione</option>
                                                        <option value="1">Activo</option>
                                                        <option value="0">Inactivo</option>
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
                                        <th>id</th>
                                        <th>Opciones</th> 
                                        <th>Tipo de Usuario</th>  
                                        <th>Nombres</th>  
                                        <th>Apellidos</th>                                                                      
                                        <th>Usuario</th>                                      
                                        <th>DNI</th>
                                        <th>Celular</th>
                                        <th>F.Nacimiento</th>   
                                        <th>Estado</th>                                            
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



<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<!-- 
<script  src="<?php echo base_url();?>public/js/seg_usuarios/seg_usuarios.js"></script> -->


<script>
    let cont_nuevos     = 0 ;
    let nuevo_registro  = 0 ;
    let actualizar      = 0 ;
    let id_upd          = 0 ;
    var tb_table_registros;

    /* config user preaviso */
    let timer = 0;
    const delayValue = 100; 

    //tb_table_registros.ajax.reload();
    var sessionInterval;
    $(document).ready(function() {
       
        setInterval(() => {
            if(nuevo_registro===1 && cont_nuevos<=10){
                cont_nuevos++;
                if(cont_nuevos%2===0){
                    $('.card-new').css('border','1px solid #2ab57d');
                    console.log(cont_nuevos);
                }else{
                    $('.card-new').css('border','1px solid yellow');
                }
            }else{
                $('.card-new').css('border','1px solid #e9e9ef');
                $(".card-body").removeClass("card-new");
            }
        }, 1000);

        forDataTables('#tb_table_registros', 'Controller_usuario/listar_registros'); 
        
        /* funciones config user preaviso */
        get_tbl_user_preaviso();
        get_tbl_tipo_user();
        retirar_filtros();      
        load_select_tipo_user();
    });

/**************************************************************************************/
/*************************** FUNCIONES CONFIG USER PREAVISO ***************************/
/**************************************************************************************/

    function ver_mdl_config_user_preaviso(){
        
        $('#mdl_config_user_preaviso').modal('show');  

    }

    function mdl_tipo_usuarios(){
        
        $('#mdl_nuevo_tipo_usuario').modal('show');  

    }

    function get_tbl_user_preaviso() {

        $("#txt_buscar_user").on("keyup", function() {
            clearTimeout(timer);
            timer = setTimeout(() => {
            var value = $(this).val().toLowerCase();
            filter_tbl_preaviso(value);
        }, delayValue);
        });       

        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>C_config_user_preaviso/get_tbl_user_preaviso',
            data: {},
            beforeSend: function() {},
            success: function(data) {
                var json = JSON.parse(data);
                if (json.mensaje == 'ok') {
                    $('#tb_detalle_envio_mdl').html(json.resultado);
                } else {
                   
                }
            }
        });
    }


    function get_tbl_tipo_user() {

        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>Controller_usuario/get_tbl_tipo_user',
            data: {},
            beforeSend: function() {},
            success: function(data) {
                var json = JSON.parse(data);
                if (json.mensaje == 'ok') {
                    $('#tb_detalle_tipo_user').html(json.resultado);
                } else {
                
                }
            }
        });
    }


    function filter_tbl_preaviso(value){
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>C_config_user_preaviso/filter_tbl_preaviso',
            data: {'value':value},
            beforeSend: function() {},
            success: function(data) {                
                get_tbl_user_preaviso();   
                value='';           
            }
        });

    }

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

    function upd_user_preaviso(id,contador){
        
        var check_preaviso = $('#check_preaviso_'+contador).is(':checked') ? 1 : 0;

      
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>C_config_user_preaviso/upd_user_preaviso',
            data: {'check_preaviso':check_preaviso,'id':id}, 
            beforeSend:function(){
            },   
            success: function(data){ 
                var json         =JSON.parse(data);

                if (json.mensaje_1!='') {
                    alertify.error(json.mensaje_1);
                     $('#check_preaviso_'+contador).prop('checked',false);
                } else {
                    alertify.success(json.mensaje_2); 
                }
                
            }
        });

    }   

    function filter_check(radio) {
        var value;
        if (radio.checked) {
            var value = radio.value;
           
        }
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>C_config_user_preaviso/filter_check',
            data: {'value':value},
            beforeSend: function() {},
            success: function(data) {                
                get_tbl_user_preaviso();              
            }
        });
    }

/**************************************************************************************/
/************************ FIN FUNCIONES CONFIG USER PREAVISO **************************/
/**************************************************************************************/

/* funciones para los filtros */
    function load_select_tipo_user(){       
        $.ajax({
            type: "POST",
            url: '<?php echo base_url();?>Controller_usuario/load_select_tipo_user',
            data: {}, 
            beforeSend:function(){               
            },   
            success: function(data){
                $('#slc_tipo_user').html(data);
                $('#txt_tipo_user').html(data);
                $('#txto_tipo_user').html(data);
                 
            },
            error: function(){
            }
        }); 
    }

   

    function aplicar_filter_tipo_user(){
        var tipo_user = $('#slc_tipo_user').val();

        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>Controller_usuario/aplicar_filter_tipo_user',
            data: {'tipo_user':tipo_user},
            beforeSend: function() {},
            success: function(data) {                
                tb_table_registros.ajax.reload();     
            }
        });
    }


    function aplicar_estado(){
        var tipo_user = $('#slc_estado').val();

        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>Controller_usuario/aplicar_filter_estado',
            data: {'tipo_user':tipo_user},
            beforeSend: function() {},
            success: function(data) {                
                tb_table_registros.ajax.reload();     
            }
        });
    }

/* fin */


/* funciones para eliminar */  

    function eliminar(coduser) {
        alertify.confirm("¿Está seguro de eliminar el registro?",
            function () {
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url();?>Controller_usuario/eliminar',
                    data: {
                        'coduser': coduser
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



/* otras funciones */

/* fin */
   


/* funciones para añadir transportista */

    function ver_mdl(tipo){
        switch (tipo) {
            case 'mdl_add_registro':
                $('#mdl_add_registro').modal('show');
                
                break;
            case 'mdl_insertar_tipo_base':
                $('#mdl_insertar_tipo_base').modal('show');
                
                break;
        
            default:
                break;
        }
    
    }

    function registrar_usuario(){      
        var txt_nombres = $('#txt_nombres').val();
        var txt_apellidos = $('#txt_apellidos').val();
        var txt_dni = $('#txt_dni').val();
        var txt_email = $('#txt_email').val();
        var txt_movil = $('#txt_movil').val();        
        var txt_f_nac = $('#txt_f_nac').val();
        var txt_clave = $('#txt_clave').val();
        var txt_tipo_user = $('#txt_tipo_user').val();
        var txt_estado = $('#txt_estado').val();
        var txt_direccion = $('#txt_direccion').val();      
        var txt_observacion = $('#txt_observacion').val();
        var txt_usuario_a = $('#txt_usuario_a').val();

        if (!txt_nombres) {alertify.error('Completa el campo Nombres completos');return;}
        if (!txt_apellidos) {alertify.error('Completa el campo Apellidos Completos');return;}
        if (!txt_dni) {alertify.error('Ingresa el DNI"');return;}
        if (!txt_clave) {alertify.error('Ingresa una Contraseña"');return;}
        if (!txt_tipo_user) {alertify.error('Selecciona el tipo de usuario"');return;}

        
        var id_check_preaviso = 0;

        if($('#check_preaviso').prop("checked") == true){
            id_check_preaviso=1;
        }
       
        $.ajax({
            type: "POST",
            
            url: '<?php echo base_url(); ?>Controller_usuario/agregar_usuario',
            data: {                               
                'txt_nombres':txt_nombres,
                'txt_apellidos':txt_apellidos,
                'txt_dni':txt_dni,
                'txt_email':txt_email,
                'txt_movil':txt_movil,               
                'txt_estado':txt_estado,  
                'txt_f_nac':txt_f_nac,   
                'txt_clave':txt_clave,                
                'txt_tipo_user':txt_tipo_user,  
                'txt_direccion':txt_direccion,               
                'txt_observacion':txt_observacion, 
                'txt_usuario_a':txt_usuario_a,
                'id_check_preaviso':id_check_preaviso                    
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
                if (json.mensaje!='') {

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

    function get_datos(coduser){
        limpiar_formulario();
        $.ajax({
            type: "POST",
            //dataType: 'json',
            url: '<?php echo base_url(); ?>Controller_usuario/get_datos',
            data: {
                'coduser':coduser
            }, 
            beforeSend:function(){
            },   
            success: function(e){ 
                id_upd=coduser;
                var res = jQuery.parseJSON(e);
                if(res.mensaje!='error'){
                    if(res.user_carta==='1'){
                        $('#check_preaviso_editar').prop('checked',true);
                    }else{
                        $('#check_preaviso_editar').prop('checked',false);
                    }
                    $('#txto_coduser').val(res.coduser);                      
                    $('#txto_nombres').val(res.nombres);
                    $('#txto_apellidos').val(res.apellidos);
                    $('#txto_dni').val(res.dni);
                    $('#txto_email').val(res.email);
                    $('#txto_estado').val(res.estado);
                    //$('#txto_clave').val(res.clave);
                    $('#txto_tipo_user').val(res.tipo_user);
                    $('#txto_movil').val(res.telefono);                 
                    $('#txto_f_nac').val(res.f_nacimiento);                  
                    $('#txto_direccion').val(res.direccion);                   
                    $('#txto_observacion').val(res.observacion);    
                    $('#txt_usuario_e').val(res.usuario);       
                    $('#mdl_edit_registro').modal('show');

                }else{
                }
            }
        });
    }


    function get_data_tipouser(id){
        //limpiar_formulario();
        $.ajax({
            type: "POST",
            //dataType: 'json',
            url: '<?php echo base_url(); ?>Controller_usuario/get_data_tipouser',
            data: {
                'id':id
            }, 
            beforeSend:function(){
            },   
            success: function(e){ 
               
                var res = jQuery.parseJSON(e);
                if(res.mensaje!='error'){
                    
                    $('#txtip_id').val(res.id);                      
                    $('#txtip_descripcion').val(res.descripcion);
                    $('#txtip_area').val(res.area);
                        
                    //$('#mdl_edit_registro').modal('show');

                }else{
                }
            }
        });
    }


    function actualizar_usuario(){      
        var txt_coduser = $('#txto_coduser').val();
        var txt_nombres = $('#txto_nombres').val();
        var txt_apellidos = $('#txto_apellidos').val();
        var txt_dni = $('#txto_dni').val();
        var txt_email = $('#txto_email').val();
        var txt_movil = $('#txto_movil').val();        
        var txt_f_nac = $('#txto_f_nac').val();
        var txt_estado = $('#txto_estado').val();
        var txt_clave = $('#txto_clave').val();
        var txt_tipo_user = $('#txto_tipo_user').val();
        var txt_direccion = $('#txto_direccion').val();      
        var txt_observacion = $('#txto_observacion').val();
        var txt_usuario_e = $('#txt_usuario_e').val();
   
        if (!txt_nombres) {alertify.error('Completa el campo Nombres completos');return;}
        if (!txt_apellidos) {alertify.error('Completa el campo Apellidos Completos');return;}
        if (!txt_dni) {alertify.error('Ingresa el DNI"');return;}
        //if (!txt_clave) {alertify.error('Ingresa una Contraseña"');return;}
        if (!txt_tipo_user) {alertify.error('Selecciona el tipo de usuario"');return;}

        var status =$('#check_preaviso_editar').is(':checked') ? 1 : 0;

        $.ajax({
            type: "POST",
           
            url: '<?php echo base_url(); ?>Controller_usuario/actualizar_usuario',
            data: {        
                'txt_coduser':txt_coduser,                      
                'txt_nombres':txt_nombres,
                'txt_apellidos':txt_apellidos,
                'txt_dni':txt_dni,
                'txt_email':txt_email,
                'txt_estado':txt_estado, 
                'txt_movil':txt_movil,               
                'txt_f_nac':txt_f_nac,   
                'txt_clave':txt_clave,                
                'txt_tipo_user':txt_tipo_user,  
                'txt_direccion':txt_direccion,               
                'txt_observacion':txt_observacion,
                'txt_usuario_e':txt_usuario_e,
                'status':status                 
            }, 
            beforeSend:function(){
            },   
            success: function(data){ 
                nuevo_registro=1;
                cont_nuevos=0; 
                $('#mdl_edit_registro').modal('hide');
                $("#btn_agregar_chat").removeAttr('disabled');
                var json         = eval("(" + data + ")");
                if (json.mensaje!='') {

                    notificacion('Actualización realizada', 'No se pudo actualizar la impresión del preaviso debido a que se ha superado el límite', 'info');

                }else{
                    notificacion('Actualización realizada','Se actualizo correctamente.','success');

                    tb_table_registros.ajax.reload();
                }
                
                  
                  
            }
        });

        //agregar('solicitud',0,id_tipo_registro,cuspp);
    }

    function actualizar_tipo_usuario(){      
        var id = $('#txtip_id').val();
        var des = $('#txtip_descripcion').val();
        var area = $('#txtip_area').val();
        
        if (!des) {alertify.error('ingrese la descripción');return;}
        if (!area) {alertify.error('Ingresa el área"');return;}
       
    
        $.ajax({
            type: "POST",
           
            url: '<?php echo base_url(); ?>Controller_usuario/actualizar_tipo_usuario',
            data: {        
                'id':id,                      
                'des':des,
                'area':area
               
            }, 
            beforeSend:function(){
            },   
            success: function(data){ 
             
            
                var json         = eval("(" + data + ")");
                /*if (json.mensaje!='') {

                    notificacion('Actualización realizada', 'No se pudo actualizar la impresión del preaviso debido a que se ha superado el límite', 'info');
                    get_tbl_tipo_user();
                }else{*/
                    notificacion('Actualización realizada','Se actualizo correctamente.','success');
                    get_tbl_tipo_user();
                    
                //}
                
                  
                  
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