<!-- <div class="main-content">
    <div class="page-content">
        <div class="container-fluid"> -->
        <div class="row">
                <div class="card p-1">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">

                                            <div class="col-sm-1" style="display:block;">
                                                <input type="text" class="form-control form-control" id="txt_id" disabled placeholder="12">
                                            </div>
                                            

                                            <div class="col-sm-2" style="display:block;">
                                                <input type="text" class="form-control form-control " id="txt_uniqueid" disabled placeholder="452685.888">
                                            </div>
                                            
                                            <div class="col-sm-4 text-center">
                                            
                                                <div>
                                                    <button class="btn btn-danger w-md"  onclick="open_contactos_area_cvc();">Contactos CVC</button>
                                                    <button class="btn btn-secondary w-md"  onclick="open_distribuidores();">Distribuidores</button>
                                                </div>
                                
                                            </div>

                                            <div class="col-sm-5">
                                                <div class="buscador_cliente">
                                                    <div class="container my-2">
                                                        <div class="row justify-content-center">
                                                            <div class="col-12">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control form-control rounded-start" id="search_dato" placeholder="Ingrese Razón Social, Ruc, Codigo Iscom o Nro de Suministro">
                                                                    <button class="btn btn-primary rounded-end p-2" onclick="buscar_registro();"><i class="fas fa-search"></i></button>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>                                        
                                            </div>                                           
                                        </div>                                          
                                    </div>
                                </div>
                            </div>


                            <!-- El elemento donde se mostrará el mensaje -->
                            <div  class="mb-3 font-size-16 "id="mensaje" style="display: none;"></div>

                            <div class="col-lg-5">                                                     
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mt-4 mt-lg-0">

                                            <!--05/11/2024--->
                                            <div class="row mb-2">
                                                <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">UniqueId</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control form-control font-size-14 " id="unique_id_link" disabled placeholder="" value="<?php echo $unique_id_obtenido;?>">
                                                </div>
                                            </div>
                                            <!--FIN 05/11/2024--->
                                            
                                            <div class="row mb-2">
                                                <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Teléfono</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control form-control font-size-14 " id="txt_celular" disabled placeholder="">
                                                </div>
                                            </div>
                                

                                            <div class="row mb-2">
                                                <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Tipo de llamada</label>
                                                <div class="col-sm-9">
                                                    <select class="form-select form-select" id="txt_tipo_llamada"  onchange="action_form_paneles('txt_tipo_llamada');" >
                                                        <option selected value="">Tipo de llamada</option>
                                                        <option value="1">Entrante</option>
                                                        <option value="2">Saliente</option>
                                                    </select>                                           
                                                </div>
                                            </div>                                   

                                            <div id="contenido1" style="display:none">
                                                <!-- Contenido de Código Iscom -->
                                                <div class="row mb-2">
                                                    <label class="col-sm-3 col-form-label">Código Iscom</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control" id="txt_codigo" placeholder="30702">  
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <button class="btn btn-secondary" title="Cliente no encontrado en ISCOM y Clientes libres" onclick ="generar_cod_fic();"> codigo </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="contenido2" style="display:none">
                                                <!-- Contenido de Contacto Saliente -->
                                                <div class="row mb-2">
                                                    <label class="col-sm-3 col-form-label">Contacto Saliente</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-select" id="txt_contacto_saliente"  onchange="action_form_paneles('txt_contacto_saliente');">
                                                            <option selected value="">Seleccione</option>
                                                            <option value="1">Clientes</option>
                                                            <option value="2">Distribuidor</option>
                                                            <option value="3">Supervisor / Jefe Zonal </option>
                                                            <option value="4">Caso Especial </option>
                                                            <option value="5">No Encontrado </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div> 

                                            <div id="contenido3" style="display:none">
                                                <div class="row mb-2">
                                                    <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Nombre del Cliente</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control form-control" id="txt_nombres_cliente" placeholder="Nombres y Apellidos">
                                                    </div>
                                                </div>

                                                <div class="row mb-2">
                                                    <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Parentesco</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-select form-select" id="txt_parentesco">
                                                            <option selected value="">Parentesco</option>
                                                            <option  value="Titular">Titular</option>
                                                            <option  value="Familiar">Familiar</option>
                                                            <option  value="Inquilino">Inquilino</option>
                                                            <option  value="Osinergmin">Osinergmin</option>
                                                        </select> 
                                                    </div>                                             
                                                </div>

                                                <div class="row mb-2">
                                                    <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Tipo de Cliente</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-select form-select" id="txt_tipo_cliente" onchange="action_form_paneles('txt_tipo_cliente');">
                                                            <option selected value="">Tipo de Cliente</option>
                                                            <option  value="1">Regulado</option>
                                                            <option  value="2">Libre</option>
                                                            <option  value="3">No encontrado</option>
                                                        </select>                                          
                                                    </div>
                                                </div>  

                                            <div id="contenido5" style="display:none"> 
                                                <div class="row mb-2">
                                                    <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Localidad</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-select form-select" id="txt_localidad">
                                                            <option selected value="">localidad</option>                                                      
                                                        </select>                                          
                                                    </div>
                                                </div>  
                                            </div>  
                                           
                                           
                                                <div class="row mb-2">
                                                    <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Motivo de llamada</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-select form-select" id="txt_motivo_llamada">                                                   
                                                        </select>  
                                                    </div>
                                                </div>
                                            
                                            </div>

                                            
                                            <div id="contenido4" style="display:none">          
                                                <div class="row justify-content-end my-3">
                                                    <div class="col-sm-9">                                                                   
                                                        <div>
                                                            <button class="btn btn-primary w-md"  onclick="action_uniqueid_call();">Guardar</button>
                                                        </div>
                                                    </div>
                                                </div>  
                                            </div> 
                                              
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-7">  

                                <div class="card-header" id="activar_panel_busq" style ="display:none;">
                                    <div class="card-body">
                                        <div class="row" id="panel_buscador">
                                         
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card">
                                    <div class="card-body bg-soft-secondary text-white">                                     
                                        <div class="list-group list-group-flush" id="listado_clientes">                                                                                   
                                        </div>
                                    </div>                                  
                                </div>



                                <div class="card "> 

                                <div class="card-header d-flex justify-content-between">
                                    <div class="text-start">
                                        Solicitudes Generadas:
                                    </div>
                                    <div class="text-end">    
                                    <button type="button" class="btn btn-sm btn-warning waves-effect waves-light" title="Cómo usar el formulario ?" onclick="abrir_modal_alerta();"><i class="bx bx-error font-size-16 align-middle"></i></button>                                  
                                       
                                    </div>
                                </div>


                                    <div class="card-body">
                                        <div>                                        
                                            
                                        </div>    
                                    </div>                      

                                    <div class="card-body ">
                                        <div class="px-3" data-simplebar="init"><div class="simplebar-wrapper" style="margin: 0px -16px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: -17px; bottom: 0px;"><div class="simplebar-content-wrapper" style="height: auto; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 0px 16px;">
                                            <ul class="list-unstyled activity-wid mb-0"  id="listado_solicitudes_cliente"> 
                                                                                       
                                            </ul>
                                        </div>
                                        </div></div></div><div class="simplebar-placeholder" style="width: auto; height: 490px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 282px; transform: translate3d(0px, 0px, 0px); display: block;"></div></div></div>    
                                    </div>                                 
                                </div>    
                                


                               
                                <div class="row">
                                    <div class="col-7">
                                        <div class="card">
                                            <div class="card-body">                                     
                                                <div class="list-group list-group-flush" id="listado_distribuidores2">                                                                                   
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                    
                                    <div class="col-5">
                                        <div class="card">
                                            <div class="card-body">                                     
                                                <div class="list-group list-group-flush" id="listado_distribuidores3">                                                                                    
                                                </div>
                                            </div>  
                                        </div>
                                    </div> 
                                </div>                                                           
                                
                            </div>
                        </div>
                    </div>
                </div>
                          
                <div class="card p-2 m-1" >
                    <div class="card-body">  
                        <div id="panel_registros_call">
                        </div>                                                                                                                                                                       
                    </div>
                </div>    

            </div>


            <!-- aqui va  -->             
        <!--</div>
    </div>
</div>-->

    <div class="modal fade bs-example-modal-center" id="mdl_distribuidores" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="txt_titulo">Distribuidores</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-header ">
                    <div class="row mb-2">
                        
                        <select class="form-select form-select" id="txt_distribuidor_cvc" onchange="activar_filtro_distribuidores_cvc();">   
                                                                    
                        </select>  
                        
                    </div>
                </div>
                
                <div class="modal-body">

                <div class="row">
                    <div class="col-7">
                    <div class="card">                                 
                        <div class="card-body">
                            <div class="table">
                                <table class="table mb-0">
                                    <thead class="table-light">
                                        <tr>                                      
                                            <th>Distribuidora</th>
                                            <th>Area</th>
                                            <th>Teléfono</th>                                          
                                        </tr>
                                    </thead>
                                    <tbody id=listado_distribuidores>
                                        
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>                   
                    </div>
                    </div>

                    <div class="col-5">
                    <div class="card">                                 
                        <div class="card-body">
                            <div class="table">
                                <table class="table mb-0">
                                    <thead class="table-light">
                                        <tr>                                      
                                            <th>Distribuidora</th>
                                            <th>Correo</th>
                                                                                 
                                        </tr>
                                    </thead>
                                    <tbody id=listado_correos_distribuidores>
                                        
                                        
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




    <div class="modal fade bs-example-modal-center" id="mdl_contactos_area_cvc" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="txt_titulo">Contactos del área de operaciones de CVC Energía</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-header ">
                    <div class="row mb-2">
                        
                        <select class="form-select form-select" id="txt_emergencia_region" onchange="activar_filtro_contactos_area_cvc();">   
                                                                    
                        </select>  
                        
                    </div>
                </div>

                <div class="modal-body">
                    <div class="card">                                 
                        <div class="card-body">
                            <div class="table">
                                <table class="table mb-0">
                                    <thead class="table-light">
                                        <tr>                                           
                                            <th>Emergencia</th>
                                            <th>Persona</th>
                                            <th>Correo Electrónico</th>
                                            <th>Teléfono</th>
                                            <th>Turno</th>
                                        </tr>
                                    </thead>
                                    <tbody id=listado_contacto_area_cvc>
                                        
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>                   
                    </div>
                </div>           
            </div>
        </div>
    </div>



    <div class="modal fade bs-example-modal-lg" tabindex="-1" id="alerta_modal" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">¿Cómo usar el formulario?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <p><mark><strong>Caso Osinergmin:</strong></mark> Registrar en el formulario. <br></p>
                    <div class="m-2">
                        <img src="https://geochasqui.com/sistema_cvc/public/img/cvc/osinergmin.png" style="width:80%;" alt="">
                    </div>
                    <br><br>


                    <p><mark><strong>Caso Nuevo cliente:</strong></mark> No lo tenemos como cliente Libre y en el ISCOM , Para ello generamos un codigo con el boton y seleccionamos el tipo de cliente a NO ENCONTRADO. <br></p>
                    <div class="m-2">
                        <img src="https://geochasqui.com/sistema_cvc/public/img/cvc/nuevo_cliente.png" style="width:80%;" alt="">
                    </div>
                    <br><br>


                    <p><mark><strong>Caso Especial:</strong></mark> Son los clientes compartidos por José que no tendra una LLamada de Entrada, para ello hacemos la llamada SALIENTE y el contacto saliente seleccionamos como CASO ESPECIAL para habilitar los campos a llenar<br></p>
                    <div class="m-2">
                        <img src="https://geochasqui.com/sistema_cvc/public/img/cvc/caso_especial.png" style="width:80%;" alt="">
                    </div>
                    


                    <!-- <p><mark><strong>Casos en Seguimiento:</strong></mark> Realiza el siguimiento hasta finalizar la solicitud. <br></p>
                    <p> <mark><strong>Casos Finalizados:</strong></mark>  Registrar nueva solicitud. <br></p>
                    <p class="mb-0">     <mark><strong>Casos No requiere Seguimiento:</strong></mark> Registrar nueva solicitud.</p>
                     -->
                </div>
            </div>
        </div>
    </div>


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script>
$(document).ready(function() {

    get_validador_unique_id();
    

    load_motivo_call(); // marcador
    get_registros();
    //get_registros_call();
    get_select_filtros(); 
    get_indicadores();
    get_datos_call(); // marcador   
    get_distribuidores();
    get_correos_distribuidores();
    load_distribuidores_cvc();
    get_contactos_area_cvc();
    load_emergencia();
   
});

/*05/11/2024*/
function get_validador_unique_id(){
    var dato      = get_data('unique_id_link');
    $.ajax({
        type: "POST",
        url: '<?php echo base_url();?>Controller_formulario/valida_uniqueid',
        data: {
            'dato':dato
        }, 
        beforeSend:function(){
        },   
        success: function(e){ 
            if(e=='ok'){

            }else{
                //redirigir a link nuevo
                location.href =e;
            }
        }
    });
}
/*fin 05/11/2024*/




function generar_cod_fic() {
    // Obtener la fecha y hora actuales
    const now = new Date();
    
    // Formatear como AAAAmmddHHMM
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const day = String(now.getDate()).padStart(2, '0');
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    
    // Concatenar el formato
    const formattedDateTime = `${year}${month}${day}${hours}${minutes}`;
    
    // Asignar el valor al input
    document.getElementById('txt_codigo').value = formattedDateTime;
}

function set_data(id){
    return $('#'+id).val('');
}

function get_data(id){
    return $('#'+id).val();
}

function pintar_input(id,tipo,mensaje,id_input){
    switch (tipo) {
        case 'error':
            $('#'+id).css('color','red');
            $('#'+id).text(mensaje);
            $('#'+id_input).css('border','1px solid red');
            break;
        case 'success':
            $('#'+id).css('color','green');
            $('#'+id).text(mensaje);
            $('#'+id_input).css('border','1px solid green');
            break;                    
        default:
            $('#'+id).css('color','white');
            $('#'+id).text('');
            $('#'+id_input).css('border','1px solid #ced4da');                                        
            break;
    }
}

function alerta_input(tipo,id_input,id_lbl,msj){
    switch (tipo) {
        case 'success':
            $('#'+id_input).css('border','1px solid green');
            /*if(id_lbl!=''){
                $('#'+id_lbl).css('color','green');
                $('#'+id_lbl).text(msj);
            }*/
        break;

        case 'error':
            $('#'+id_input).css('border','1px solid red');
            /*if(id_lbl!=''){
                $('#'+id_lbl).css('color','red');
                $('#'+id_lbl).text(msj);
            }*/
        break; 

        default:
            $('#'+id_input).css('border','1px solid #ced4da');
            /*if(id_lbl!=''){
                $('#'+id_lbl).css('color','white');
                $('#'+id_lbl).text('');                  
            }*/
        break;
    }
}

/*
Buscador
*/

$('#search_dato').keypress(function(e) {
    var keycode = (e.keyCode ? e.keyCode : e.which);
    if (keycode == '13') {
        buscar_registro();
        e.preventDefault();
        return false;
    }
});


function abrir_modal_alerta() {
    var myModal = new bootstrap.Modal(document.getElementById('alerta_modal'), {});
    myModal.show();
}


function buscar_registro(){
    $('#panel_buscador').html('Buscando..');
    var dato      = get_data('search_dato');
    if(dato!=''){
        /*var rz      = get_data('search_razon_social');
        var ruc     = get_data('search_ruc');
        var iscom   = get_data('search_cod_iscom');
        var nsumin  = get_data('search_nro_suministro');*/

        $.ajax({
            type: "POST",
            url: '<?php echo base_url();?>Controller_formulario/buscar_registro',
            data: {
                'dato':dato
            }, 
            beforeSend:function(){
            },   
            success: function(e){ 
                $('#panel_buscador').html(e);

                $('#activar_panel_busq').show();
            }
        });
    }
}

/*
- Filtros de busqueda
*/

function activar_filtro(tipo,id){
    let dato = '';
    switch (tipo) {
        case 'paginacion':
            dato = id;
            break;
        default:
            dato = $('#'+id).val();
            break;
    }
    $.ajax({
        type: "POST",
        url: '<?php echo base_url();?>Controller_formulario/activar_filtro',
        data: {
            'tipo':tipo,
            'dato':dato
        }, 
        beforeSend:function(){
        },   
        success: function(e){ 
            get_registros();          
        }
    });
}

/*
-- JAVASCRIPT SOLICITUDES
*/

function ver_contactos(id){
    $('#btn_regresar_'+id).css('display','block');
    $('#btn_actualizar_'+id).css('display','none');
    $('#panel_detalle_'+id).css('display','block');

    $('#panel_respon_'+id).css('display','block');
    $('#panel_reque_'+id).css('display','none');

    get_registros_adicional('contacto',id);
}

function ver_seguimientos(id){
    $('#btn_regresar_'+id).css('display','block');
    $('#btn_actualizar_'+id).css('display','none');
    $('#panel_detalle_'+id).css('display','block');

    $('#panel_respon_'+id).css('display','none');
    $('#panel_reque_'+id).css('display','block');

    get_registros_adicional('seguimiento',id);

}

function regresar(id){
    $('#btn_regresar_'+id).css('display','none');
    $('#btn_actualizar_'+id).css('display','block');
    $('#panel_detalle_'+id).css('display','block');

    $('#panel_respon_'+id).css('display','none');
    $('#panel_reque_'+id).css('display','none');
}

/*
-- Actualizar Solicitud
*/


function actualizar(id_sol){
    //Validador
    let contador = 0 ; 
    //Obtención de datos

    let txt_estado_sol = $('#txt_estado_sol_'+id_sol).val();
    let text_resumen_sol = $('#text_resumen_sol_'+id_sol).val();

    if (txt_estado_sol==2) {
       
        Swal.fire({
            title: "Estado En Proceso",
            text: "Por favor actualice el estado de la solicitud correctamente.",
            icon: "error"
        });
        return;
    }




    //Validación de casos
    let cade9 ='txt_estado_sol_'+id_sol; 
    if(txt_estado_sol==''){alerta_input('error',cade9,'','');contador++;}else{alerta_input('success',cade9,'','');}
    let cade7 ='text_resumen_sol_'+id_sol; 
    if(text_resumen_sol==''){alerta_input('error',cade7,'','');contador++;}else{alerta_input('success',cade7,'','');}

    if(contador<=0){
        //notificacion('¡ Actualización completa !','Se actualizó correctamente la información de la solicitud.','success');
        //enviamos el ajax
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: '<?php echo base_url();?>Controller_formulario/actualizar',
            data: {
                'text_resumen_sol':text_resumen_sol,
                'txt_estado_sol':txt_estado_sol,
                'id':id_sol
            }, 
            beforeSend:function(){
            },   
            success: function(e){ 
                /*Limpiamos*/
                alerta_input('',cade7,'','');
                alerta_input('',cade9,'','');
                notificacion('Actualización completa','Se actualizó el registro de la solicitud seleccionada..','success');
                //get_registros();
                get_registros_call();
                //get_indicadores();
            }
        });
    }else{
        notificacion('¡ Ocurrió algo !','Toda la información solicitada es importante para el reclutamiento del personal.','error');
    }

}

/*
AGREGAR RESPONSABILIDADES
*/



function agregar(tipo,id){
    let des      = '';
    let cade     = '';
    switch (tipo) {
        case 'solicitud':

           


            $.ajax({
                type: "POST",
                dataType: 'json',
                url: '<?php echo base_url();?>Controller_formulario/insert',
                data: {
                    'id':id
                }, 
                beforeSend:function(){
                },   
                success: function(e){ 
                    notificacion('Solicitud En Espera','Se registró correctamente una solicitud, complete los detalles solicitados.','success');
                    get_registros();
                    get_indicadores();
                }
            });
            break;            
        case 'contacto':
            des = get_data('txt_sol_contacto_'+id);
            cel = get_data('txt_sol_celular_'+id);
            cade = 'txt_sol_contacto_'+id;

            if(des==''){
                alerta_input('error',cade,'','');
                notificacion('¡ Ocurrió un error !','Ingrese una descripción correcta.','error');
            }else{
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: '<?php echo base_url();?>Controller_formulario/insert_registros',
                    data: {
                        'id':id,
                        'des':des,
                        'cel':cel,
                        'tipo':tipo
                    }, 
                    beforeSend:function(){
                    },   
                    success: function(e){ 
                        alerta_input('success',cade,'','');
                        notificacion('¡ Contacto agregado !','Se registró correctamente el contacto para la solicitud seleccionada.','success');
                        get_registros_adicional(tipo,id);
                        setTimeout(() => {
                            set_data('txt_sol_contacto_'+id);
                            set_data('txt_sol_celular_'+id);
                            alerta_input('',cade,'','');
                        }, 2000);
                    }
                });
            }
            break;
        case 'seguimiento':
            //mot = get_data('txto_motivo_llamada_'+id);
            //per = get_data('txto_persona_llamada_'+id);
            des = get_data('txt_des_reque_'+id);
            cade = 'txt_des_reque_'+id;
            if(des==''){
                alerta_input('error',cade,'','');
                notificacion('¡ Ocurrió un error !','Ingrese una descripción del seguimiento solicitado.','error');
            }else{
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: '<?php echo base_url();?>Controller_formulario/insert_registros',
                    data: {
                        'id':id,
                        'des':des,
                       // 'mot':mot,
                       // 'per':per,
                        'tipo':tipo
                    }, 
                    beforeSend:function(){
                    },   
                    success: function(e){ 
                        alerta_input('success',cade,'','');
                        notificacion('¡ Seguimiento agregado !','Se registró correctamente el seguimiento para la solicitud seleccionada.','success');
                        get_registros_adicional(tipo,id);
                        setTimeout(() => {
                            //set_data('txt_des_reque_'+id);
                            alerta_input('',cade,'','');
                        }, 2000);
                    }
                });
            }
            break;                
        default:
            break;
    }
}

function get_registros(){
    $.ajax({
        type: "POST",
        url: '<?php echo base_url();?>Controller_formulario/get_registros',
        data: {
        }, 
        beforeSend:function(){
        },   
        success: function(e){ 
            var res = jQuery.parseJSON(e);
            $('#panel_paginacion').html(res.paginacion);
            $('#panel_registros').html(res.registros);
            $('#panel_viendo').html(res.viendo);
        }
    });
}

function get_registros_adicional(tipo,id_sol){
    $.ajax({
        type: "POST",
        url: '<?php echo base_url();?>Controller_formulario/get_registros_adicional',
        data: {
            'tipo':tipo,
            'id_sol':id_sol
        }, 
        beforeSend:function(){
        },   
        success: function(e){ 
            switch (tipo) {
                case 'seguimiento':
                    $('#lista_reque_'+id_sol).html(e);
                    break;
                case 'contacto':
                    $('#lista_respon_'+id_sol).html(e); 
                    break;
                case 'cargos':
                    $('#txt_cargo_sol_'+id_sol).html(e); 
                    break;                                                
                default:
                    break;
            }
        }
    });
}



/*Obtenemos datos del select por id registrado*/
function get_datos_select_x_id(tipo,id_sol,input){
    let id_seleccion = $('#'+input+id_sol).val(); 
    $.ajax({
        type: "POST",
        url: '<?php echo base_url();?>Controller_formulario/get_datos_select_x_id',
        data: {
            'tipo':tipo,
            'id_sol':id_sol,
            'id_seleccion':id_seleccion
        }, 
        beforeSend:function(){
        },   
        success: function(e){ 
            switch (tipo) {
                case 'seguimiento':
                    $('#lista_reque_'+id_sol).html(e);
                    break;
                case 'contacto':
                    $('#lista_respon_'+id_sol).html(e); 
                    break;
                case 'cargos':
                    $('#txt_cargo_sol_'+id_sol).html(e); 
                    break;                                                
                default:
                    break;
            }
        }
    });
}

function eliminar(tipo,id_sol,id_reg){
    alertify.confirm("¿Està seguro de eliminar el registro?.",
    function(){
    $.ajax({
        type: "POST",
        url: '<?php echo base_url();?>Controller_formulario/eliminar',
        data: {
            'tipo':tipo,
            'id_sol':id_sol,
            'id_reg':id_reg
        }, 
        beforeSend:function(){
        },   
        success: function(e){ 
            switch (tipo) {
                case 'seguimiento':
                    get_registros_adicional(tipo,id_sol);
                    alertify.success('Registro eliminado correctamente.');
                    break;
                case 'contacto':
                    get_registros_adicional(tipo,id_sol);
                    alertify.success('Registro eliminado correctamente.');
                    break;  
                case 'solicitud':
                    get_registros();
                    alertify.success('Registro eliminado correctamente.');
                    break;                                                    
                default:
                    break;
            }
            get_indicadores();
        }
    });
},

function(){
    alertify.error('No se pudo completar la acción de eliminar sobre el registro seleccionado.');
}); 
}


/*
//Funciones de filtro
*/
function get_select_filtros(){
    $.ajax({
        type: "POST",
        //dataType: 'json',
        url: '<?php echo base_url();?>Controller_formulario/get_select_filtros',
        data: {
        }, 
        beforeSend:function(){
        },   
        success: function(e){ 
            var res = jQuery.parseJSON(e);

            $('#s_estado_solicitud').html(res.estado_solicitud);
            //$('#s_tipo_contrato').html(res.tipo_contrato);
            //$('#s_frecuencia').html(res.tipo_frecuencia);
            $('#s_mes').html(res.mes_solicitud);

        }
    });
}


/*
Funciones obtener indicadores
*/
function get_indicadores(){
    $.ajax({
        type: "POST",
        //dataType: 'json',
        url: '<?php echo base_url();?>Controller_formulario/get_indicadores',
        data: {
        }, 
        beforeSend:function(){
        },   
        success: function(e){ 
            var res = jQuery.parseJSON(e);

            //$('#btn_activo').html('Activo '+ res.activo);
            $('#btn_en_espera').html('En Espera '+ res.en_espera);
            $('#btn_completado').html('En Seguimiento '+ res.completado);
            $('#btn_cancelado').html('Finalizado '+res.cancelado);

        }
    });
}


function subir_foto(){
    /*Con evento carga*/
    var inputfile = document.getElementById('file');
    var file      = inputfile.files[0];
    var xhr = new XMLHttpRequest();
    (xhr.upload || xhr).addEventListener('progress', function(e) {
        var done = e.position || e.loaded;
        var total = e.totalSize || e.total;
        var carg = Math.round(done/total*100);
        $("#progressBar_img").val(carg);
        $('#loaded_n_total_img').text(carg + ' % ');
    });
    xhr.addEventListener('load', function(e) {
            var json         = eval("(" + this.responseText + ")");
            if($.trim(json.valida)=='si'){            
                //$('#foto_visita').val('');
                var  caden  = '<?php echo base_url();?>public/images/tag/'+json.imagen;
                $('#img_foto').attr('src',caden);
                $('#img_foto_2').attr('src',caden);
                alertify.success('success','Foto de perfil actualizada.');
            }else{
                alertify.error('error','Hubo un error al actualizar su foto de perfil');
            }
    });
    xhr.addEventListener('error', function(e) {
        alertify.error('error','Ocurrio un error, vuelva a intentarlo','Error');
    });  
    
    xhr.addEventListener('abort', function(e) {
        alertify.error('error','Ocurrio un error, vuelva a intentarlo','Error');
    });     
    xhr.open('post', '<?php echo base_url();?>Controller_formulario/subir_foto', true);
    
    var data = new FormData;
    data.append('file', file);
    xhr.send(data);          
}

/*CARGA DE UBIGEO*/
function load_ubigeos(tipo,id){
    let cadena=''; 
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: '<?php echo base_url();?>C_ubigeo/get_data_ubigeo',
        data: {
            'tipo':tipo,
            'id':id
        }, 
        beforeSend:function(){
        },   
        success: function(e){ 
            for(var i=0; i < e.length; i++)
            {
                cadena +='<option value="'+e[i]['id']+'">'+e[i]['descripcion']+'</option>'
            }

            switch (tipo) {
                case 'departamento':
                    $('#text_departamento').html(cadena);
                    $('#text_departamento').val(id);
                    break;
                case 'provincia':
                    $('#text_provincia').html(cadena);
                    $('#text_provincia').val(id_provincia);
                    break;          
                case 'distrito':
                    $('#text_distrito').html(cadena);
                    $('#text_distrito').val(id_distrito);
                break;                                                              
                default:
                    break;
            }

        }
    });
}

function grabar(){
    let nombres     = $('#text_nombres').val();
    let apellidos   = $('#text_apellidos').val();
    let dni         = $('#text_dni').val();
    let fecha       = $('#text_fecha_nac').val();
    let correo      = $('#text_correo').val();
    let celular     = $('#text_celular').val();
    let direccion   = $('#text_direccion').val();

    let id_departamento   = $('#text_departamento').val();
    let id_provincia      = $('#text_provincia').val();
    let id_distrito       = $('#text_distrito').val();

    let contador = 0; 
    /* VALIDACIONES */
    if(nombres==''){alerta_input('error','text_nombres','text_nombres_msj',' * Obligatorio');contador++;}else{alerta_input('success','text_nombres','text_nombres_msj','');}
    if(apellidos==''){alerta_input('error','text_apellidos','text_apellidos_msj',' * Obligatorio');contador++;}else{alerta_input('success','text_apellidos','text_apellidos_msj','');}
    if(dni==''){alerta_input('error','text_dni','text_dni_msj',' * Obligatorio');contador++;}else{alerta_input('success','text_dni','text_dni_msj','');}
    if(fecha==''){alerta_input('error','text_fecha_nac','text_fecha_nac_msj',' * Obligatorio');contador++;}else{alerta_input('success','text_fecha_nac','text_fecha_nac_msj','');}
    if(correo==''){alerta_input('error','text_correo','text_correo_msj',' * Obligatorio');contador++;}else{alerta_input('success','text_correo','text_correo_msj','');}
    if(celular==''){alerta_input('error','text_celular','text_celular_msj',' * Obligatorio');contador++;}else{alerta_input('success','text_celular','text_celular_msj','');}
    if(direccion==''){alerta_input('error','text_direccion','text_direccion_msj',' * Obligatorio');contador++;}else{alerta_input('success','text_direccion','text_direccion_msj','');}

    //Ubigeos
    if(id_departamento==''){alerta_input('error','text_departamento','text_departamento_msj',' * Obligatorio');contador++;}else{alerta_input('success','text_departamento','text_departamento_msj','');}
    if(id_provincia==''){alerta_input('error','text_provincia','text_provincia_msj',' * Obligatorio');contador++;}else{alerta_input('success','text_provincia','text_provincia_msj','');}
    if(id_distrito==''){alerta_input('error','text_distrito','text_distrito_msj',' * Obligatorio');contador++;}else{alerta_input('success','text_distrito','text_distrito_msj','');}


    if(contador<=0){

        $.ajax({
            type: "POST",
            url: '<?php echo base_url();?>Controller_formulario/grabar',
            data: {
            'nombres':nombres,
                'apellidos':apellidos,
                'dni':dni,
                'fecha':fecha,
                'correo':correo,
                'celular':celular,
                'distrito':id_distrito,
                'direccion':direccion
            }, 
            beforeSend:function(){
            },   
            success: function(data){ 
                if(data=='duplicado'){
                    notificacion('¡ Ocurrió algo !','La información de su perfíl no se actualizó, vuelva a intentarlo.','error');
                }else{
                    notificacion('Datos actualizados','La información de su perfíl se actualizó correctamente','success');
                }
            }
        });
    }else{
        notificacion('Ocurrió algo','Uno o más datos no se encuentran correctos.','error');
    }

}
                                                                 
function forDataTables( id, ruta) {
    table = $(id).DataTable({
        "scrollX": true,
        "processing":true,
        "serverSide":true,
        "order":[],
        "dom": 'Bfrtip',
        "buttons": ['copy', 'excel', 'pdf', 'colvis'],
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




/*Marcador*/



function load_motivo_call(id){       
    $.ajax({
        type: "POST",
        url: '<?php echo base_url();?>Controller_formulario/load_motivo_call',
        data: {'id':id}, 
        beforeSend:function(){               
        },   
        success: function(data){          
            $('#txt_motivo_llamada').html(data);           
        },
        error: function(){
        }
    }); 
}


function load_localidad_call(id){       
    $.ajax({
        type: "POST",
        url: '<?php echo base_url();?>Controller_formulario/load_localidad_call',
        data: {'id':id}, 
        beforeSend:function(){               
        },   
        success: function(data){          
            $('#txt_localidad').html(data);           
        },
        error: function(){
        }
    }); 
}


function load_emergencia(){       
    $.ajax({
        type: "POST",
        url: '<?php echo base_url();?>Controller_formulario/load_emergencia',
        data: {
            
            //'id':id
        }, 
        beforeSend:function(){               
        },   
        success: function(data){          
            $('#txt_emergencia_region').html(data);           
        },
        error: function(){
        }
    }); 
}



function load_distribuidores_cvc(){       
    $.ajax({
        type: "POST",
        url: '<?php echo base_url();?>Controller_formulario/load_distribuidores_cvc',
        data: {
            
            //'id':id
        }, 
        beforeSend:function(){               
        },   
        success: function(data){          
            $('#txt_distribuidor_cvc').html(data);           
        },
        error: function(){
        }
    }); 
}

function get_datos_call(){   
    $.ajax({
        type: "POST",
        //dataType: 'json',
        url: '<?php echo base_url(); ?>Controller_formulario/get_datos_call',
        data: {
            //'id':id
        }, 
        beforeSend:function(){
        },   

        success: function(e){ 
            //id_upd=id;
            
            var res = jQuery.parseJSON(e);
            if(res.mensaje!='error'){   
                $('#txt_id').val(res.id);          
                $('#txt_uniqueid').val(res.uniqueid);
                $('#txt_celular').val(res.celular); 
                //$('#txt_tipo_llamada').val(res.id_tipo_llamada);
                //$('#txt_codigo').val(res.codigo_cliente);
                //$('#txt_nombres_cliente').val(res.nombres_cliente);  
                //$('#txt_contacto_saliente').val(res.contacto_saliente);    
                // $('#txt_parentesco').val(res.parentesco);
                //$('#txt_motivo_llamada').val(res.id_motivo);
                //$('#txt_localidad').val(res.id_localidad);
                //$('#txt_tipo_cliente').val(res.id_tipo_cliente);


                if (res.id_tipo_llamada !== null && res.id_tipo_llamada !== '') {
                    $('#txt_tipo_llamada').val(res.id_tipo_llamada).css('background-color', '#ADFF2F');
                    // Mostrar el texto cuando el campo está lleno
                    $('#mensaje').text('El formulario está completo. Por favor, abre un nuevo formulario vacío.').css('background-color', '#ADFF2F' ).show();
                } else {
                    $('#txt_tipo_llamada').val('').css('background-color', '');
                    // Ocultar el texto cuando el campo está vacío
                    $('#mensaje').text('').hide();
                }

                if (res.codigo_cliente !== null && res.codigo_cliente !== '') {
                    $('#txt_codigo').val(res.codigo_cliente).css('background-color', '#ADFF2F');
                } else {
                    $('#txt_codigo').val('').css('background-color', '');
                }

                if (res.nombres_cliente !== null && res.nombres_cliente !== '') {
                    $('#txt_nombres_cliente').val(res.nombres_cliente).css('background-color', '#ADFF2F');
                } else {
                    $('#txt_nombres_cliente').val('').css('background-color', '');
                }

                if (res.contacto_saliente !== null && res.contacto_saliente !== '') {
                    $('#txt_contacto_saliente').val(res.contacto_saliente).css('background-color', '#ADFF2F');
                } else {
                    $('#txt_contacto_saliente').val('').css('background-color', '');
                }

                if (res.parentesco !== null && res.parentesco !== '') {
                    $('#txt_parentesco').val(res.parentesco).css('background-color', '#ADFF2F');
                } else {
                    $('#txt_parentesco').val('').css('background-color', '');
                }

                if (res.id_motivo !== null && res.id_motivo !== '') {
                    $('#txt_motivo_llamada').val(res.id_motivo).css('background-color', '#ADFF2F');
                } else {
                    $('#txt_motivo_llamada').val('').css('background-color', '');
                }


                if (res.id_localidad !== null && res.id_localidad !== '') {
                    $('#txt_localidad').val(res.id_localidad).css('background-color', '#ADFF2F');
                } else {
                    $('#txt_localidad').val('').css('background-color', '');
                }


                if (res.id_tipo_cliente !== null && res.id_tipo_cliente !== '') {
                    $('#txt_tipo_cliente').val(res.id_tipo_cliente).css('background-color', '#ADFF2F');
                } else {
                    $('#txt_tipo_cliente').val('').css('background-color', '');
                }       
               
                load_motivo_call(res.id_motivo);  
                load_localidad_call(res.id_localidad);  
                
               

                
                var dato = res.id_tipo_llamada;
                switch(dato) {
                    case '1': 
                        $('#contenido1').show();
                        $('#contenido2').hide();
                        $('#contenido3').show();
                        $('#contenido4').show();
                        break;

                    case '2': 
                        $('#contenido1').show();
                        $('#contenido2').show();
                        $('#contenido3').hide();
                        $('#contenido4').show();
                        break;

                    default: // Valor vacío o no reconocido
                        ocultar_panel();
                        break;
                }
                     
            }else{
            }
        }
    });
}


function validar_solicitud_seguimiento(id) {
    $.ajax({
        type: "POST",
        url: '<?php echo base_url();?>Controller_formulario/validar_solicitud_seguimiento',
        data: {
            id: id
        }, 
        success: function(response) {
            var res = jQuery.parseJSON(response);

            // Si hay casos en seguimiento, mostramos la alerta con la cantidad
            if (res > 0) {
                Swal.fire({
                    title: "Solicitudes Pendientes?",
                    text: "Tienes " + res + " solicitudes en Pendientes. ¿Qué acción deseas realizar?",
                    icon: "warning",
                    //showCancelButton: true,
                    showDenyButton: true,
                    confirmButtonText: '<i class="fa fa-check"></i> Registrar Solicitud',
                    denyButtonText: '<i class="fa fa-tasks"></i> Realizar Seguimiento',
                //  cancelButtonText: '<i class="fa fa-times"></i> Cancelar',
                    confirmButtonColor: "#3085d6",
                    denyButtonColor: "#f8bb86",
                    //cancelButtonColor: "#d33",
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Acción para ingresar solicitud
                        Swal.fire({
                            title: "Solicitud registrada",
                            text: "La solicitud ha sido ingresada correctamente.",
                            icon: "success"
                        });

                        add_solicitud();

                    } else if (result.isDenied) {
                        // Acción para ingresar seguimiento                
                        Swal.fire({
                            title: "Solictudes en Seguimiento Encontrados",
                            text: "Registra el seguimiento, porfavor .",
                            icon: "success"
                        });

                        let dato = [3, 5];
                        $.ajax({
                            type: "POST",
                            url: '<?php echo base_url();?>Controller_formulario/activar_filtro_seguimiento',
                            data: {                        
                                'dato':dato
                            }, 
                            beforeSend:function(){
                            },   
                            success: function(e){ 
                                get_registros_call();
                            }
                        });

                    } else {
                        // Acción para cancelar
                        Swal.fire({
                            title: "Acción cancelada",
                            text: "No se ha realizado ninguna acción.",
                            icon: "info"
                        });
                    }
                });

            }else{
                Swal.fire({
                    title: "Solicitud registrada",
                    text: "La solicitud ha sido ingresada correctamente.",
                    icon: "success"
                });

                add_solicitud();

                

            }
        }
    });
}


function validar_solicitud_seguimiento2(id) {
    $.ajax({
        type: "POST",
        url: '<?php echo base_url();?>Controller_formulario/validar_solicitud_seguimiento',
        data: {
            'id': id
        }, 
        success: function(response) {
            var res = jQuery.parseJSON(response);

            // Si hay casos en seguimiento, mostramos la alerta con la cantidad
        
            /*Swal.fire({
                title: "Solicitud registrada",
                text: "La solicitud ha sido ingresada correctamente.",
                icon: "success"
            });*/

            get_registros_call();

                

            
        }
    });
}

/*
function diseño_alerta(id) {
    Swal.fire({
        title: "Solicitudes en Seguimiento?",
        text: "Tienes 4 solicitudes en Seguimiento. ¿Qué acción deseas realizar?",
        icon: "warning",
        //showCancelButton: true,
        showDenyButton: true,
        confirmButtonText: '<i class="fa fa-check"></i> Registrar Solicitud',
        denyButtonText: '<i class="fa fa-tasks"></i> Registrar Seguimiento',
      //  cancelButtonText: '<i class="fa fa-times"></i> Cancelar',
        confirmButtonColor: "#3085d6",
        denyButtonColor: "#f8bb86",
        //cancelButtonColor: "#d33",
    }).then((result) => {
        if (result.isConfirmed) {
            // Acción para ingresar solicitud
            Swal.fire({
                title: "Solicitud registrada",
                text: "La solicitud ha sido ingresada correctamente.",
                icon: "success"
            });
        } else if (result.isDenied) {
            // Acción para ingresar seguimiento
            Swal.fire({
                title: "Seguimiento registrado",
                text: "El seguimiento ha sido ingresado correctamente.",
                icon: "success"
            });
        } else {
            // Acción para cancelar
            Swal.fire({
                title: "Acción cancelada",
                text: "No se ha realizado ninguna acción.",
                icon: "info"
            });
        }
    });
}
*/

function action_uniqueid_call(){
    
    let unid     = $('#txt_uniqueid').val();
    let nom      = $('#txt_nombres_cliente').val();
    let sal      = $('#txt_contacto_saliente').val();
    let pare     = $('#txt_parentesco').val();
    let motivo   = $('#txt_motivo_llamada').val();
    let loc      = $('#txt_localidad').val();
    let cod      = $('#txt_codigo').val();
    let tipo     = $('#txt_tipo_cliente').val();
    let llam     = $('#txt_tipo_llamada').val();


    if (!llam) {alertify.error('Seleccione el tipo de llamada.');return;}


    
    if(pare == "Osinergmin"){ // llamada osinergmin
        if (!llam) {alertify.error('Seleccione el tipo de llamada.');return;}
        if (!pare) {alertify.error('Seleccione el parentesto con el cliente.');return;}
        if (!motivo) {alertify.error('Seleccione el motivo de llamada.');return;}
        alerta_osinergmin();

    }else{
            
        if(llam == 1){ //entrante
        
        if (!cod) {alertify.error('Ingrese el Código del cliente.');return;}
        if (!nom) {alertify.error('ingrese los nombres completos del cliente.');return;}
       // if (!pare) {alertify.error('Seleccione el parentesto con el cliente.');return;}
        if (!motivo) {alertify.error('Seleccione el motivo de llamada.');return;}
        if (!tipo) {alertify.error('Seleccione el tipo de cliente.');return;}
       

        /*if(tipo != 13 ){ 
            if (!pare) {alertify.error('Seleccione el parentesto con el cliente.');return;}        
        }*/



        if (tipo == 1) { // El tipo de cliente es regular

            if (!pare) { alertify.error('Seleccione el parentesco con el cliente.');   return;   }
            if (!loc) { alertify.error('Seleccione la localidad del cliente Regular.');  return;  }

        } else if (tipo == 2) { //libre

            if (!pare) {  alertify.error('Seleccione el parentesco con el cliente.');    return;   }

        } else {

            // Puedes agregar cualquier otro caso aquí si es necesario
        }



    
        }else{ //saliente
            if (!cod) {alertify.error('Ingrese el Código del cliente.');return;}
            if (!sal) {alertify.error('Seleccione el contacto Saliente.');return;}      
        }
        validar_solicitud_seguimiento(cod);
    }

    $.ajax({
        type: "POST",
        url: '<?php echo base_url();?>Controller_formulario/action_uniqueid_call',
        data: {
            'unid':unid,
            'nom':nom,
            'pare':pare,
            'sal':sal,
            'loc':loc,
            'motivo':motivo,
            'cod':cod,
            'llam':llam,
            'tipo':tipo
        }, 
        beforeSend:function(){
        },   
        success: function(data){           
            //notificacion('Datos actualizados','La información de su perfíl se actualizó correctamente','success');  
            //limpiar_form_call();     
        }
    });
}


function get_registros_call(){
   // let id     = $('#txt_codigo').val();
    $.ajax({
        type: "POST",
        url: '<?php echo base_url();?>Controller_formulario/get_registros_call',
        data: {
           // 'id':id
        }, 
        beforeSend:function(){
        },   
        success: function(e){ 
            var res = jQuery.parseJSON(e);
            //$('#panel_paginacion').html(res.paginacion);
            $('#panel_registros_call').html(res.registros);
            //$('#panel_viendo').html(res.viendo);
        }
    });
}


function activar_filtro_call(tipo,id){
    let dato = '';
    switch (tipo) {
        case 'paginacion':
            dato = id;
            break;
        default:
            dato = $('#'+id).val();
            break;
    }
    $.ajax({
        type: "POST",
        url: '<?php echo base_url();?>Controller_formulario/activar_filtro',
        data: {
            'tipo':tipo,
            'dato':dato
        }, 
        beforeSend:function(){
        },   
        success: function(e){ 
            get_registros_call();          
        }
    });
}


function action(tipo, id) {
    let des = $('#text_resumen_seg_'+id).val();

    switch (tipo) {
        case 'upd_seguimiento':
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: '<?php echo base_url(); ?>Controller_formulario/upd_registros',
                data: {
                    'id': id,
                    'des': des,
                    'tipo': tipo
                },
                beforeSend: function() {
                    // Puedes agregar aquí cualquier código que quieras ejecutar antes de enviar la solicitud
                },
                success: function(response) {
                    notificacion('¡ Seguimiento agregado !', 
                                 'Se registró correctamente el seguimiento para la solicitud seleccionada.', 
                                 'success');
                },
                error: function(xhr, status, error) {
                    // Manejo de errores
                    console.log("Error:", error);
                }
            });
            break;
        default:
            console.log("Tipo de acción no reconocido:", tipo);
            break;
    }
}


function add_solicitud(){
    let id     = $('#txt_codigo').val();  
    let nom     = $('#txt_nombres_cliente').val();
    let tip     = $('#txt_tipo_cliente').val(); //123
    $.ajax({
        type: "POST",
        url: '<?php echo base_url();?>Controller_formulario/add_solicitud',
        data: {   
            'id':id,  
            'nom':nom, 
            'tip':tip                                            
        }, 
        beforeSend:function(){
        },   
        success: function(data){           
            //notificacion('Datos actualizados 2','La información de su perfíl se actualizó correctamente','success');   
            //get_registros_call();
            validar_solicitud_seguimiento2(id);   
    
        }
    });
}

function limpiar_form_call(){
    $('#txt_id').val('');
    $('#txt_uniqueid').val(''); 
    $('#txt_nombres_cliente').val(''); 
    $('#txt_contacto_saliente').val('');
    $('#txt_parentesco').val(''); 
    $('#txt_codigo').val(''); 
    $('#txt_motivo_llamada').val(''); 
    $('#txt_tipo_cliente').val(''); 
    $('#txt_tipo_llamada').val(''); 
}





function activar_filtro_contactos_area_cvc(){
    let dato = $('#txt_emergencia_region').val(); 
    //let dato = 3;
    $.ajax({
        type: "POST",
        url: '<?php echo base_url();?>Controller_formulario/activar_filtro_contactos_area_cvc',
        data: {                        
            'dato':dato
        }, 
        beforeSend:function(){
        },   
        success: function(e){ 
            get_contactos_area_cvc();
        }
    });
}


function activar_filtro_distribuidores_cvc(){
    let dato = $('#txt_distribuidor_cvc').val(); 
    //let dato = 3;
    $.ajax({
        type: "POST",
        url: '<?php echo base_url();?>Controller_formulario/activar_filtro_distribuidores_cvc',
        data: {                        
            'dato':dato
        }, 
        beforeSend:function(){
        },   
        success: function(e){ 
            get_distribuidores();
            get_correos_distribuidores();
        }
    });
}









$(document).ready(function() {
    $('#txt_codigo').on('input', function() {
        let codigoCliente = $(this).val().trim();

        // Verificar si el campo no está vacío
        if (codigoCliente !== '') {


            // Hacer la solicitud AJAX para obtener los clientes
            $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>Controller_formulario/get_clientes',
                data: {
                    'codigo_cliente': codigoCliente
                },
                success: function(response) {       
                    $('#listado_clientes').html(response);                     
                }
            });


            // Hacer la solicitud AJAX para obtener las solicitudes
            $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>Controller_formulario/get_solicitudes',
                data: {
                    'codigo_cliente': codigoCliente
                },
                success: function(response) {
                    // Mostrar los resultados en el contenedor de la lista
                    $('#listado_solicitudes_cliente').html(response);
                }
            });


            // Hacer la solicitud AJAX para obtener los telefonos - distribuidor         
            $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>Controller_formulario/get_distribuidores_telefonos',
                data: {
                    'codigo_cliente': codigoCliente
                },
                success: function(response) {       
                    $('#listado_distribuidores2').html(response);                     
                }
            });


            // Hacer la solicitud AJAX para obtener los correos - distribuidor
            $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>Controller_formulario/get_distribuidores_correos',
                data: {
                    'codigo_cliente': codigoCliente
                },
                success: function(response) {       
                    $('#listado_distribuidores3').html(response);                     
                }
            });


        } else {
            // Limpiar la lista si el campo está vacío
            $('#listado_solicitudes_cliente').html('');
            $('#listado_clientes').html('');
            $('#listado_distribuidores2').html('');
            $('#listado_distribuidores3').html('');
        }
    });
});




function open_distribuidores(){
    $('#mdl_distribuidores').modal('show');
}


function open_contactos_area_cvc(){
    $('#mdl_contactos_area_cvc').modal('show');
}





function get_distribuidores(){
    //let id_seleccion = $('#'+input+id_sol).val(); 
    $.ajax({
        type: "POST",
        url: '<?php echo base_url();?>Controller_formulario/get_distribuidores_cvc',
        data: {
            /*'tipo':tipo,
            'id':id_sol,
            'id_seleccion':id_seleccion*/
        }, 
        beforeSend:function(){
        },   
        success: function(e){       
            $('#listado_distribuidores').html(e);                     
        }
    });
}



function get_correos_distribuidores(){
    //let id_seleccion = $('#'+input+id_sol).val(); 
    $.ajax({
        type: "POST",
        url: '<?php echo base_url();?>Controller_formulario/get_correos_distribuidores_cvc',
        data: {
          
        }, 
        beforeSend:function(){
        },   
        success: function(e){       
            $('#listado_correos_distribuidores').html(e);                     
        }
    });
}


function get_contactos_area_cvc(){
    //let id_seleccion = $('#'+input+id_sol).val(); 
    $.ajax({
        type: "POST",
        url: '<?php echo base_url();?>Controller_formulario/get_contactos_area_cvc',
        data: {
            /*'tipo':tipo,
            'id':id_sol,
            'id_seleccion':id_seleccion*/
        }, 
        beforeSend:function(){
        },   
        success: function(e){       
            $('#listado_contacto_area_cvc').html(e);                     
        }
    });
}




function upd_motivo_llamada(id,id_mot) {
    let id_motivo = $('#txt_motivo_' + id_mot).val();

    $.ajax({
        type: "POST",
        dataType: 'json',
        url: '<?php echo base_url(); ?>Controller_formulario/upd_motivo_llamada',
        data: {
            'id': id,             
            'id_motivo': id_motivo
        },
        beforeSend: function() {
            
        },
        success: function(response) {
            notificacion('¡ Motivo de llamada actualizado !', 
                            'Se actualizó correctamente la opción seleccionada.', 
                            'success');
            get_registros_adicional('seguimiento',id);
            //get_datos_select_x_id('seguimiento',id);
        },
        error: function(xhr, status, error) {
            // Manejo de errores
            console.log("Error:", error);
        }
    });
         
}


function upd_motivo_llamada_call(id,id_mot) {
    //let id = 25;
    
    let id_motivo = $('#txt_motivo2_' + id_mot).val();

    $.ajax({
        type: "POST",
        dataType: 'json',
        url: '<?php echo base_url(); ?>Controller_formulario/upd_motivo_llamada_call',
        data: {
            'id': id,             
            'id_motivo': id_motivo
        },
        beforeSend: function() {
            
        },
        success: function(response) {
            notificacion('¡ Motivo de llamada actualizado !', 
                            'Se actualizó correctamente la opción seleccionada.', 
                            'success');
            get_registros_adicional('seguimiento',id);
            //get_datos_select_x_id('seguimiento',id);
        },
        error: function(xhr, status, error) {
            // Manejo de errores
            console.log("Error:", error);
        }
    });
         
}


// Función para mostrar u ocultar paneles según el tipo de llamada
function action_form_paneles(tipo) {

    if(tipo === 'txt_tipo_llamada') {
        var dato = $('#txt_tipo_llamada').val();

        // Oculta todos los paneles al inicio
        ocultar_panel();

        // Muestra paneles según el valor seleccionado
        switch(dato) {
            case '1': // Caso "Entrante"
                $('#contenido1').show(); //30758 | 30764
                $('#contenido2').hide();
                $('#contenido3').show();
                $('#contenido4').show();
                break;

            case '2': // Caso "Saliente"
                $('#contenido1').show();
                $('#contenido2').show();
                $('#contenido4').show();
                $('#contenido3').hide();
                


                break;

            default: // Valor vacío o no reconocido
                ocultar_panel();
                break;
        }
    }

    if (tipo === 'txt_contacto_saliente') {
        var dato2 = $('#txt_contacto_saliente').val();
        if (dato2 === '4') { // Caso Especial
            $('#contenido3').show();
        } else {
            $('#contenido3').hide();
        }
    }

    if (tipo === 'txt_tipo_cliente') {
        var dato3 = $('#txt_tipo_cliente').val();
        if (dato3 === '1') { // Caso Especial
            $('#contenido5').show();
        } else {
            $('#contenido5').hide();
        }
    }


}

// Función para ocultar todos los paneles
function ocultar_panel() {
    $('#contenido1').hide();
    $('#contenido2').hide();
    $('#contenido3').hide();
    $('#contenido4').hide();
}

  


function limpiar_buscador(){
    //limpiamos el campo
    $('#search_dato').val(''); 
    buscar_registro();
    $('#activar_panel_busq').hide();
}


function alerta_osinergmin(){
    Swal.fire({
        title: "Caso de Osinergmin registrado",
        text: "El contacto ha sido ingresada correctamente.",
        icon: "success"
    });
}



$(document).ready(function() {
    // Lista de IDs de los inputs que quieres monitorear
    const inputs = [
        '#txt_uniqueid',
        '#txt_nombres_cliente',
        '#txt_contacto_saliente',
        '#txt_parentesco',
        '#txt_motivo_llamada',
        '#txt_codigo',
        '#txt_tipo_cliente',
        '#txt_tipo_llamada'
    ];

    // Itera sobre cada input y aplica el evento 'input'
    inputs.forEach(function(selector) {
        $(selector).on('input', function() {
            if ($(this).val().trim() !== '') {
                // Si el input no está vacío, cambia el fondo
                $(this).css('background-color', '#DFF2BF'); // Color de fondo verde claro, por ejemplo
            } else {
                // Si está vacío, restaura el fondo original
                $(this).css('background-color', '');
            }
        });
    });
});
      
</script>