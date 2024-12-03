    function eliminar_visita() {
        Swal.fire({
            title: "¿Estás seguro de Eliminar?",
            text: "No podrás revertir esto",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí, eliminarlo"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: 'https://geochasqui.com/sistema_geo/Controller_visita/eliminar_visita',
                    data: {
                        'id_visita': id_visita
                    },
                    beforeSend: function () {
                        // Código de antes de enviar la solicitud
                    },
                    success: function (data) {
                        Swal.fire({
                                title: "¡Eliminado!",
                                text: "El registro ha sido eliminado.",
                                icon: "success"
                        });  

                        search_cliente();
                    }
                });
            }
        });
    }


    function siguiente_id_cliente(){

        $.ajax({                
            type: "POST",
            //dataType: 'json',
            url: 'https://geochasqui.com/sistema_geo/Controller_visita/siguiente_id_cliente',
            data: {   
                'id_cliente':id_cliente           
            }, 
            beforeSend:function(){
            },   
            success: function(e){                
                var res = jQuery.parseJSON(e);
                if(res.mensaje!='error'){

                    //$('#txt_id_visita').val(res.id);                  
                    //$('#title_campania').text(res.campania);               
                    var id_cliente = res.id_cliente;
                    var id_visita = res.id_visita;
                    abrir_detalle_visita(id_cliente,id_visita);
                                                                                                    
                }else{
                    
                }
            }
        });      
    }

// FUNCIONES PRINCIPALES 
// ----------------------

    //buscar con la tabla 99%
    function abrir_detalle_visita(id_cliente,id_visita) {

        //general
        get_data_cliente(id_cliente);  
        get_data_equipos(id_cliente);
        get_data_comercial(id_cliente);           
        visitas_realizadas(id_cliente,id_visita);  
        get_data_visita(id_visita); 
        get_data_detalle_visitas_idcliente(id_cliente);
        get_data_detalle_campania(id_cliente);
        //eventos
        get_list_events(id_cliente);  
        get_indicadores_eventos(id_cliente);
       
        get_data_historial_asignacion1(id_cliente);
        $('#mdl_detalle_visita').modal('show'); //open
    }

    //buscar con buscador(id_cliente) 99%
    function search_cliente() {   

        var dato = $('#text_buscar_id').val();
        id_cliente = dato; // asignar id
        $.ajax({
            type: "POST",
            url: 'https://geochasqui.com/sistema_geo/Controller_visita/search_cliente',
            data: {'dato':dato}, 
            beforeSend:function(){
            },   
            success: function(e){   

                var res = jQuery.parseJSON(e);
                if(res.mensaje!='error'){
                    //$('#search_busqueda').val(res.id_visita);
                    get_data_cliente(id_cliente);  
                    get_data_equipos(id_cliente);
                    get_data_comercial(id_cliente);                    
                    visitas_realizadas(id_cliente); 
                    get_cierre_mes(res.id_cliente);
                    get_data_visita(res.id_visita); 
                    get_data_detalle_visitas_idcliente(id_cliente);   
                    get_list_events(id_cliente);  
                    get_indicadores_eventos(id_cliente);    
                   
                    get_data_detalle_campania(id_cliente);    
                    get_data_historial_asignacion1(id_cliente);
                }else{
                }
                                
                      
            
            }   
        }); 
    }

    //obtener las visitas 93%
    function visitas_realizadas(id,id_visita) {
        $.ajax({
            type: "POST",
            url: 'https://geochasqui.com/sistema_geo/Controller_visita/visitas_realizadas',
            data: { 
                    'id': id,
                    'id_visita': id_visita
                  },
            beforeSend: function() {                   
            },
            success: function(data) {
                var json = JSON.parse(data);
                if (json.mensaje == 'ok') {
                    $('#lista_visitas').html($.trim(json.listar_visitas));
                    $('#lista_visitas1').html($.trim(json.listar_visitas));                                      
                }                     
            }
        });             
    }

    //cargar funciones (id_visita) 98%
    function get_data_visita(id) {
    
        id_visita = id;
        get_data_gestion_x_visita(id_visita);
        get_data_control_visita(id_visita);
        get_data_gestion_x_equipo1(id_visita);    
        get_data_historial_cambios(id_visita);

    }

//----------------------





// FUNCIONES SECUNDARIAS
//------------------------    
    // -------------------- GET SHOW ----------------------

        function abrir_agregar_nueva_visita(){                  
            $('#mdl_agregar_visita_new').modal('show'); 
        }

        function coordenadas_copiar(){                  
            $('#miModal').modal('show'); 
        }
    
        function abrir_segmento_data_cliente(id){                  
            $('#mdl_detalle_cliente').modal('show'); 
        }

        function procesar_imagenes(){                  
            $('#modal_procesar_fotos').modal('show'); 
            get_data_proceso_fotos(id_visita);
        }

        function abrir_segmento_data_equipo(id){ 

            $.ajax({
                type: "POST",
                dataType: 'json',
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/get_segmento_data_equipo',
                data: {
                    'id': id
                },
                beforeSend: function () {                      
                },
                success: function (res) {
                    if (res.mensaje !== 'error') {
                    
                        $('#upd_edf_id').val(res.id);
                        $('#upd_edf_serie').val(res.serie);
                        $('#upd_edf_modelo').val(res.modelo);
                        $('#upd_edf_censo').val(res.censo);
                        $('#upd_edf_marca').val(res.marca);                   
                        $('#upd_edf_equipo').val(res.equipo);
                        $('#upd_edf_tipo').val(res.tipo);
                        $('#upd_edf_finstalacion').val(res.finstalacion);            
                        $('#upd_edf_estado').val(res.estado);
                        $('#mdl_detalle_equipo').modal('show');//open                            
                    } 
                }                 
            });                            
        }

        function abrir_detalle_asignacion_rapida(){
            $('#mdl_upd_asignacion_rapida').modal('show');           
        }

        function open_coordenada_visita() {
            var pnl = $('#pnl_actualizar_coordenada_visita');
            if (pnl.is(':visible')) {
                pnl.hide();
            } else {
                pnl.show();
            }
        }

        function abrir_mdl_edit_gestionxequipo(id){         
            $.ajax({
                
                type: "POST",
                //dataType: 'json',
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/get_data_gestionxequipo_and_prog',
                data: {
                    'id':id
                }, 
                beforeSend:function(){
                },   
                success: function(e){                
                    var res = jQuery.parseJSON(e);
                    if(res.mensaje!='error'){
                        
                        $('#txt_eq_id_cliente').val(res.id_cliente);                                                                                           
                        $('#txt_span_serie').text(res.serie);
                        $('#txt_span_censo').text(res.censo);                     
                        $('#txt_span_modelo').text(res.modelo);

                        //gestion
                        $('#txt_eq_id_gestionxeq').val(res.id_gestionxeq); //id
                        $('#txt_eq_gestion_equipo').val(res.gestion);
                        $('#txt_gxeq_comentario').val(res.comentario);         
                        $('#txt_eq_id_prog').val(res.id_prog); 
                        //programacion  
                        if (res.gestion == 1) {
                            $('#programacion_gestion_x_equipo').css('display', 'block'); // Muestra el panel
                        
                            $('#txt_eq_persona_contacto').val(res.persona_contacto);
                            $('#txt_eq_telefono').val(res.telefono);
                            $('#txt_eq_cierre_fecha_recojo').val(res.fecha_recojo);
                            $('#txt_eq_hora_rango').val(res.hora_rango);
                            $('#txt_eq_hora_fin').val(res.hora_fin);
                            $('#txt_eq_comentario_prog').val(res.comentario_prog);

                        } else {

                            $('#programacion_gestion_x_equipo').css('display', 'none'); // Oculta el panel
                        // $('#txt_eq_id_prog').val(''); 
                            $('#txt_eq_persona_contacto').val('');
                            $('#txt_eq_telefono').val('');
                            $('#txt_eq_cierre_fecha_recojo').val('');
                            $('#txt_eq_hora_rango').val('');
                            $('#txt_eq_hora_fin').val('');
                            $('#txt_eq_comentario_prog').val('');
                        }

                        //eqxcampania
                        $('#txt_id_eqxcampania').val(res.id_eqxcamp);
                        $('#slc_inf_foto_serie').val(res.inf_foto_serie);
                        $('#slc_inf_foto_guia').val(res.inf_foto_guia);
                        $('#slc_inf_apoyo_comercial').val(res.inf_apoyo_comercial);
                        $('#slc_inf_edf_otra_direccion').val(res.inf_edf_otra_direccion);
                        $('#slc_inf_ubicacion_errada').val(res.inf_ubicacion_errada);
                        $('#slc_inf_falso_flete').val(res.inf_falso_flete);
                        $('#txt_eq_cierre_mes').val(res.id_cierre_mes);
                        $('#txt_eq_cierre_semanal').val(res.id_cierre_semanal);

                        $('#txt_eq_cierre_resultado').val(res.id_cierre_resultado);

                        if (res.id_cierre_resultado == 32 || res.id_cierre_resultado == 33 || res.id_cierre_resultado == 67 || res.id_cierre_resultado == 65 ) {
                            $('#pnl_seguimiento_cierre').css('display', 'block');
                            $('#fecha_seguimiento').val(res.fecha_seguimiento);
                            $('#hora_seguimiento').val(res.hora_seguimiento);
                            $('#obs_seguimiento').val(res.obs_seguimiento);
                        }
                        else{
                            $('#pnl_seguimiento_cierre').css('display', 'none');
                            $('#fecha_seguimiento').val('');
                            $('#hora_seguimiento').val('');
                            $('#obs_seguimiento').val('');
                        }
                      
                       
             
                        get_cierre_mes(res.id_cierre_mes);
                        get_cierres_semanal(res.id_cierre_mes,res.id_cierre_semanal);
                        $('#mdl_edit_gestionxequipo').modal('show');
                        //$('#pnl_editar_gestion').css('display', 'none');
      
                    }else{
                    }
                }
            });
        }


        function form_select_cierre() {
            var id_cierre_res  = $('#txt_eq_cierre_resultado').val();

            if(id_cierre_res == 67 || id_cierre_res == 65 || id_cierre_res == 32 ||id_cierre_res == 33){
            $('#pnl_seguimiento_cierre').css('display', 'block');    
            //limpiar campo
            $('#fecha_seguimiento').val('');
            $('#hora_seguimiento').val('');
            $('#obs_seguimiento').val('');

            }else{
            $('#pnl_seguimiento_cierre').css('display', 'none'); 
            //limpiar campo
            $('#fecha_seguimiento').val('');
            $('#hora_seguimiento').val('');
            $('#obs_seguimiento').val('');
                                
            }
            //console.log(id_cierre_mes);
        }


        function abrir_detalle_programacion(id){

            $.ajax({
                type: "POST",
                dataType: 'json',
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/get_id_detalle_programacion',
                data: {
                    'id': id
                },
                beforeSend: function () {
                
                },
                success: function (res) {
                    if (res.mensaje !== 'error') {
                    
                        $('#prog_id').text(res.id);
                        $('#prog_departamento').text(res.departamento);
                        $('#prog_persona').text(res.persona);
                        $('#prog_telefono').text(res.telefono);
                        $('#prog_estado').text(res.estado);
                        $('#prog_h_inicio').text(res.hora_inicio);
                        $('#prog_h_fin').text(res.hora_fin);
                        $('#prog_fecha').text(res.fecha);
                        $('#prog_comentario').text(res.comentario);
                        $('#prog_id_cliente').val(res.id_cliente);
                        $('#prog_id_visita').val(res.id_visita);

                        $('#mdl_detalle_programacion').modal('show');
                        
                    } 
                }
                
            });  

           // $('#mdl_detalle_programacion').modal('show'); 

        }
   
        function abrir_detalle_cdas(id){

            $.ajax({
                type: "POST",
                dataType: 'json',
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/get_id_detalle_cda',
                data: {
                    'id': id
                },
                beforeSend: function () {
                   
                },
                success: function (res) {
                    if (res.mensaje !== 'error') {
                    
                        $('#cda_id').text(res.id);
                        $('#cda_nombre').text(res.contacto);
                        $('#cda_ubicacion').text(res.ubicacion);
                        $('#cda_celular').text(res.telefono);
                        $('#cda_direccion').text(res.direccion);                   
                        $('#cda_tipo').text(res.tipo);
                        $('#cda_departamento').text(res.departamento);
                        $('#cda_provincia').text(res.provincia);            
                        $('#cda_fecha').text(res.fecha);

                        $('#mdl_detalle_cdas').modal('show'); 
                         
                    } 
                }
                
            });

            //$('#mdl_detalle_cdas').modal('show'); 

           
        }

        function abrir_detalle_asignacion(id){

            $.ajax({
                type: "POST",
                dataType: 'json',
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/abrir_detalle_asignacion',
                data: {
                    'id': id
                },
                beforeSend: function () {
                
                },
                success: function (res) {
                    if (res.mensaje !== 'error') {
                    
                        $('#txt_id_asig').val(res.id);
                        $('#txt_id_cliente_asig').val(res.id_cliente);
                        $('#txt_usuario_asig').val(res.usuario);
                        $('#txt_estado_asig').val(res.estado);
                        $('#txt_fecha_asig').val(res.fecha);

                        $('#mdl_edit_asignacion').modal('show');
                        
                    } 
                }
                
            });        
        }

        function abrir_detalle_contactos(id){

            $.ajax({
                type: "POST",
                dataType: 'json',
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/get_id_detalle_contacto',
                data: {
                    'id': id
                },
                beforeSend: function () {
                   
                },
                success: function (res) {
                    if (res.mensaje !== 'error') {
                    
                        $('#contact_cda').text(res.cda);
                        $('#contact_nombre').text(res.nombre);
                        $('#contact_cargo').text(res.cargo);
                        $('#contact_celular').text(res.telefono);
                        $('#contact_ruta').text(res.ruta);

                        $('#mdl_detalle_cda_contactos').modal('show'); 
                         
                    } 
                }
                
            });

        }

        function abrir_detalle_campania(id){

            $.ajax({
                type: "POST",
                dataType: 'json',
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/get_id_detalle_campania',
                data: {
                    'id': id
                },
                beforeSend: function () {
                
                },
                success: function (res) {
                    if (res.mensaje !== 'error') {
                    
                        $('#txteq_id').val(res.id);
                        $('#txteq_id_cliente').val(res.id_cliente);
                        $('#txteq_id_equipo').val(res.id_equipo);
                        $('#txteq_id_campania').val(res.id_campania);
                        $('#txteq_id_campania_ant').val(res.id_campania);

                        $('#txteq_codigo_incidencia').val(res.codigo_incidencia);
                        $('#txteq_base_region').val(res.base_region);                    
                        $('#txteq_base_sub_region').val(res.base_sub_region);
                        $('#txteq_base_cda').val(res.base_cda);

                        $('#txteq_cierre').val(res.id_cierre);
                        $('#txteq_estado').val(res.estado);

                        $('#txteq_data_conclusion').val(res.data_conclusion);
                        $('#txteq_data_telf_chatbot').val(res.data_telf_chatbot);
                        $('#txteq_data_fecha_instalacion').val(res.data_fecha_instalacion);
                        $('#txteq_data_fecha_compra').val(res.data_fecha_compra);
                        $('#txteq_data_fecha_recepcion').val(res.data_fecha_recepcion);
                      
                        
                        $('#mdl_edit_campania').modal('show'); 
                        get_data_lista_idvisita_campania(res.id_equipo, res.desc_campania);
                     
                    } 
                }
                
            });

            

        }

        function abrir_detalle_transporte(id){               
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/get_id_detalle_transporte',
                data: {
                    'id': id
                },
                beforeSend: function () {
                   
                },
                success: function (res) {
                    if (res.mensaje !== 'error') {
                    
                        $('#transporte_id').text(res.id);
                        $('#transporte_nombre').text(res.nombre);
                        $('#transporte_dni').text(res.dni);
                        $('#transporte_telefono1').text(res.telefono1);
                        $('#transporte_telefono2').text(res.telefono2);
                        $('#transporte_tipo').text(res.tipo);
                        $('#transporte_departamento').text(res.departamento);
                        $('#transporte_provincia').text(res.provincia);
                        $('#transporte_comprobante').text(res.comprobante);
                        $('#transporte_fecha').text(res.fecha);

                        $('#mdl_detalle_transporte').modal('show'); 

                         
                    } 
                }
                
            });

            //$('#mdl_detalle_transporte').modal('show'); 

        }

    //--------------------- GET----------------------------

        function get_data_gestion_x_visita(id){         
            $.ajax({
                
                type: "POST",
                //dataType: 'json',
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/get_data_gestion_x_visita',
                data: {
                    'id':id
                }, 
                beforeSend:function(){
                },   
                success: function(e){                
                    var res = jQuery.parseJSON(e);
                    if(res.mensaje!='error'){
                        $('#txt_id_visita').val(res.id); 
                        $('#title_id_visita').text(res.id); 
                        $('#title_respuesta_visita').text(res.respuesta_visita); 
                        $('#title_campania').text(res.campania);  
                        $('#title_fecha').text(res.fecha_visita);  
                        $('#slc_v_respuesta_visita').val(res.gestion); 
                        $('#slc_v_tipo_visita').val(res.tipo_visita); 
                        $('#txt_v_comentario').val(res.comentario);   
                        $('#txt_v_fecha_visita').val(res.fecha_visita);      
                        $('#txt_id_campania_evento').val(res.campania); 


                        //$('#slc_v_respuesta_visita').val(res.gestion).prop('disabled', true);
                        //$('#slc_v_tipo_visita').val(res.tipo_visita).prop('disabled', true);
                        //$('#txt_v_comentario').val(res.comentario).prop('disabled', true);  
                        //$('#txt_v_fecha_visita').val(res.fecha_visita).prop('disabled', true);

                        $('#textoACopiar').text(res.coordenadas);
                        $('#txt_coordenada_visita_blq').val(res.coordenadas);

                        //concatenar 
                        var link_maps = 'https://www.google.com/maps/place/' + res.coordenadas;
                        $('#textoACopiar2').text(link_maps);

                                                                                      
                        latitud = res.latitud;
                        longitud = res.longitud;
                    }else{
                    }
                }
            });
        }

        function get_data_gestion_x_equipo1(id){
            $.ajax({
                type: "POST",
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/get_data_gestion_x_equipo1',
                data: {
                    'id':id
                
                }, 
                beforeSend:function(){
                },   
                success: function(data){ 
                    var json         = eval("(" + data + ")");
                    if(json.mensaje=='ok'){
                        $('#listar_equipos').html($.trim(json.listar_equipos));     
                        
                       
                    }else{
                    }           
                }  
            });      
        }

        function get_data_detalle_visitas_idcliente(id){
            $.ajax({
                type: "POST",
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/get_data_detalle_visitas_idcliente',
                data: {
                    'id':id
                
                }, 
                beforeSend:function(){
                },   
                success: function(data){ 
                    var json         = eval("(" + data + ")");
                    if(json.mensaje=='ok'){
                        $('#listar_detalle_visita').html($.trim(json.listar_detalle_visita));                     
                    }else{
                    }           
                }  
            });      
        }

        function get_data_cliente(id){
            $.ajax({
                type: "POST",
                //dataType: 'json',
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/get_data_cliente',
                data: {
                    'id':id
                }, 
                beforeSend:function(){
                },   
                success: function(e){                
                    var res = jQuery.parseJSON(e);
                    if(res.mensaje!='error'){
                        //id_cliente=res.id;
                        
                        $('#txt_cliente_mdl').val(res.id); 
                        $('#txt_campania').text(res.campania); 
                        $('#txt_identificador').text(res.identificador); 
                        $('#title_idcliente').text(res.id); 
                        $('#txt_id').text(res.id);   
                        $('#txt_id_cliente_evento').val(res.id);                                                        
                        $('#txt_nombres').text(res.nombres);
                        $('#txt_direccion').text(res.direccion);                                  
                        $('#txt_departamento').text(res.departamento);
                        $('#txt_provincia').text(res.distrito); 
                        $('#txt_distrito').text(res.distrito); 
                        $('#txto_dni').text(res.dni);   
                        $('#txt_region').text(res.region); 
                        $('#txt_zona').text(res.zona); 

                        //data para el modal para editar

                        $('#upd_cliente_ruc').val(res.ruc); 
                        $('#upd_cliente_ruta').val(res.ruta); 
                        $('#upd_cliente_dni').val(res.dni); 
                        $('#upd_cliente_nombres').val(res.nombres);
                        $('#upd_cliente_departamento').val(res.id_departamento);                         
                        $('#upd_cliente_distrito').val(res.distrito);                         
                        $('#upd_cliente_base').val(res.id_tipobase);                    
                        $('#upd_cliente_direccion').val(res.direccion);
                        $('#upd_cliente_referencia').val(res.referencia);
                        $('#upd_cliente_fecha_alta').val(res.fecha_alta);
                        $('#udp_cliente_estado').val(res.estado);
                        //select
                        $('#upd_cliente_zona').html(res.lst_zonas);                     
                        latitud_cliente = res.latitud;
                        longitud_cliente = res.longitud; 


                        var coordenadas2 = res.latitud + ',' + res.longitud; 
                        $('#textoACopiarb').text(coordenadas2);                         
                        var link_maps2 = 'https://www.google.com/maps/place/' + coordenadas2;
                        $('#textoACopiarb2').text(link_maps2);


                        var coor_visita = latitud + ',' + longitud;
                        var coor_cliente = coordenadas2;
                        var link_maps3 = 'https://www.google.com/maps/dir/'+ coor_visita + "/" + coor_cliente;
                        $('#textoACopiarc3').text(link_maps3);
    

                    }else{
                    }
                }
            });
        }     

        function get_data_equipos(id){
            
            $.ajax({
                type: "POST",
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/get_data_equipos',
                data: {
                    'id':id
                }, 
                beforeSend:function(){
                },   
                success: function(data){ 
                    var json         = eval("(" + data + ")");
                    var contenido =''; 
                    var contador = 0; 

                    if(json!='error'){
                        //alertify.success('Se actualizó el resumen de carga de la base.');  
                        for (let index = 0; index < json.length; index++) {
                            contador += 1; 
                            contenido +='<tr  style="color:#74788D;" >';
                                contenido +='<td>'+ contador +'</td>';                              
                                contenido +='<td>'+json[index]['serie']+'</td>';
                                contenido +='<td>'+json[index]['modelo']+'</td>';
                                contenido +='<td>'+json[index]['censo']+'</td>';
                                contenido += '<td><button class="btn btn-sm btn-primary p-1" onclick="abrir_segmento_data_equipo(' + json[index]['id'] + ')"><i class="mdi mdi-pencil"></i></button></td>';
                                
                            contenido +='</tr>';                     
                        }               
                    }else{
                        contenido +='<tr>';
                            contenido +='<td>SIN RESULTADOS...</td>';
                        contenido +='</tr>';
                    }
                    $('#data_equipos').html(contenido);
                }
            });
        }

        function get_data_historial_asignacion1(id){
            $.ajax({
                type: "POST",
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/get_data_historial_asignacion1',
                data: {
                    'id':id
                }, 
                beforeSend:function(){
                },   
                success: function(data){ 
                    var json         = eval("(" + data + ")");
                    var contenido =''; 
                    var contador = 0; 

                    if(json!='error'){
                        //alertify.success('Se actualizó el resumen de carga de la base.');  
                        for (let index = 0; index < json.length; index++) {
                            contador += 1; 
                            contenido +='<tr  style="color:#74788D;" >';
                                contenido +='<td>'+ contador +'</td>';
                                contenido +='<td>'+json[index]['usuario']+'</td>';
                                contenido +='<td>'+json[index]['fecha_asignado']+'</td>';
                                
                                let estado = (json[index]['estado'] == 1) ? 'Activo' : 'No Activo';
                                contenido += '<td>' + estado + '</td>';
                            

                                let estado_visita = (json[index]['estado_visita'] == 1) ? 'Realizado' : 'No Realizada';
                                contenido += '<td>' + estado_visita + '</td>';

                                let total_visita = json[index].total_visita + ' visitas';                       
                                contenido += '<td>' + total_visita + '</td>';


                                contenido += '<td>' +
                                '<button class="btn btn-sm btn-secondary p-1 ms-1" onclick="abrir_detalle_asignacion(' + json[index].id + ')"><i class="bx bx-pencil"></i></button>' +                                                       
                                '<button class="btn btn-sm btn-danger p-1" onclick="eliminar_asignacion(' + json[index].id + ')"><i class="bx bx-trash"></i> </button>' +                               
                                '</td>';


                            contenido +='</tr>';                     
                        }               
                    }else{
                        contenido +='<tr>';
                            contenido +='<td>SIN RESULTADOS...</td>';
                        contenido +='</tr>';
                    }

                    $('#tb_historial_asignacion').html(contenido);
                }
            });
        }
    
        function get_data_comercial(id) {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/get_data_comercial',
                data: {
                    'id': id
                },
                beforeSend: function () {
                    // Puedes agregar alguna acción antes de enviar la solicitud, si es necesario.
                },
                success: function (res) {
                    if (res.mensaje !== 'error') {
                    
                        $('#txt_id_comercial').val(res.id);
                        $('#txt_nombre_supervisor').val(res.nombre_supervisor);
                        $('#txt_telf_supervisor').val(res.telefono_supervisor);
                        $('#txt_nombre_vendedor').val(res.nombre_vendedor);
                        $('#txt_telf_vendedor').val(res.telefono_vendedor);
                            //_cliente
                        $('#txt_id_cliente').val(res.id);
                        $('#txt_telf_cliente').val(res.telefono_cliente);
                            // corrdenadas
                        $('#txt_coordenadas_pdv').val(res.pdv);
                        $('#txt_coordenadas_acmovil').val(res.acmovil);
                        $('#txt_coordenadas_wellington').val(res.wellington);
                    } 
                }
                
            });
        }

        function get_data_control_visita(id) {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/get_data_control_visita',
                data: {
                    'id': id
                },
                beforeSend: function () {},
                success: function (res) {
                    if (res.mensaje !== 'error') {
                    
                        $('input[name="control_visita"]').prop('checked', false); // Desmarcar todos los radio buttons primero
                        $('input[name="control_visita"][value="' + res.control + '"]').prop('checked', true); // Marcar el radio button correspondiente 

                        if(res.control == 3){
                            $('#panel_verificacion').css('display', 'block');
                        }else{
                            $('#panel_verificacion').css('display', 'none');
                        }    
                        $('#c_redaccion').val(res.c_redaccion);
                        $('#c_consulta').val(res.c_consultas);
                        $('#c_comentario').val(res.c_inf_comercial);
                        $('#c_foto').val(res.c_foto);
                        $('#c_coordenadas').val(res.c_coordenadas);

                        $('#title_control_visita').html($.trim(res.title_control));

                    } 
                }
            });
        }


    //--------------------- UDP ---------------------------


        function action_data_gestionxequipo_and_prog(){
                    
            var serie         =$('#txt_span_serie').text();
            var id_gxeq         =$('#txt_eq_id_gestionxeq').val();
            var id_eqxcam       =$('#txt_id_eqxcampania').val();
            var ges             =$('#txt_eq_gestion_equipo').val();
            var obs             =$('#txt_gxeq_comentario').val();

            var id_prog        =$('#txt_eq_id_prog').val();
            var contacto        =$('#txt_eq_persona_contacto').val(); 
            var tel             =$('#txt_eq_telefono').val();      
            var f_recojo        =$('#txt_eq_cierre_fecha_recojo').val();
            var h_recojo        =$('#txt_eq_hora_rango').val();  
            var h_recojo2       =$('#txt_eq_hora_fin').val();        
            var obs_prog        =$('#txt_eq_comentario_prog').val();


            var id_cliente     =$('#txt_eq_id_cliente').val();
            var inf_serie      =$('#slc_inf_foto_serie').val();
            var inf_guia       =$('#slc_inf_foto_guia').val();
            var inf_apoyo      =$('#slc_inf_apoyo_comercial').val();
            var inf_dir        =$('#slc_inf_edf_otra_direccion').val();
            var inf_ubi        =$('#slc_inf_ubicacion_errada').val();
            var inf_flete      =$('#slc_inf_falso_flete').val();
            var c_mes          =$('#txt_eq_cierre_mes').val();
            var c_semanal      =$('#txt_eq_cierre_semanal').val();

            var cierre_resultado      =$('#txt_eq_cierre_resultado').val();
            var fecha_seguimiento      =$('#fecha_seguimiento').val();
            var hora_seguimiento      =$('#hora_seguimiento').val();
            var obs_seguimiento      =$('#obs_seguimiento').val();

            

            $.ajax({
                type: "POST",
                dataType: 'json',
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/action_data_gestionxequipo_and_prog',
                data: {
                    'serie':serie,
                    'id_gxeq':id_gxeq,
                    'id_eqxcam':id_eqxcam,
                    'id_visita':id_visita,
                    'ges':ges,
                    'obs':obs,                  
                    'id_prog':id_prog,
                    'f_recojo':f_recojo,
                    'h_recojo':h_recojo, 
                    'h_recojo2':h_recojo2, 
                    'contacto':contacto,
                    'tel':tel,
                    'obs_prog':obs_prog, 

                    'id_cliente':id_cliente,
                    'inf_serie':inf_serie,
                    'inf_guia':inf_guia,
                    'inf_apoyo':inf_apoyo,  
                    'inf_dir':inf_dir, 
                    'inf_ubi':inf_ubi, 
                    'inf_flete':inf_flete, 

                    'cierre_resultado':cierre_resultado, 
                    'fecha_seguimiento':fecha_seguimiento, 
                    'hora_seguimiento':hora_seguimiento, 
                    'obs_seguimiento':obs_seguimiento, 

                    'c_mes':c_mes, 
                    'c_semanal':c_semanal
                }, 
                beforeSend:function(){
                },   
                success: function(data){ 
                    alertify.success('Gestión de Equipo ha sido actualizado.');
                    //get_data_comercial();
                    $('#mdl_edit_gestionxequipo').modal('hide'); 
                    //$('#pnl_editar_gestion').css('display', 'block');
                  
      
                    get_data_gestion_x_equipo1(id_visita);
                    get_data_historial_cambios(id_visita);
                }
            });

        }

        function upd_detalle_campania(){

            var id =$('#txteq_id').val();
            var id_cliente =$('#txteq_id_cliente').val();
            var id_equipo =$('#txteq_id_equipo').val();
            var id_campania =$('#txteq_id_campania').val();
            var id_campania_ant =$('#txteq_id_campania_ant').val();

            var codigo_incidencia =$('#txteq_codigo_incidencia').val();
            var base_region =$('#txteq_base_region').val();
            var base_sub_region =$('#txteq_base_sub_region').val();
            var base_cda =$('#txteq_base_cda').val();

            var cierre =$('#txteq_cierre').val();
            var estado =$('#txteq_estado').val();

            var conclusion =$('#txteq_data_conclusion').val();
            var tel_bot =$('#txteq_data_telf_chatbot').val();
            var fecha_instalacion =$('#txteq_data_fecha_instalacion').val();
            var fecha_compra =$('#txteq_data_fecha_compra').val(); 
            var fecha_recepcion =$('#txteq_data_fecha_recepcion').val();
        
            $.ajax({
                type: "POST",
                //dataType: 'json',
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/upd_detalle_campania',
                data: {
                    'id':id,
                    'id_cliente':id_cliente,
                    'id_equipo':id_equipo,
                    'id_campania':id_campania,
                    'id_campania_ant':id_campania_ant, 
                    'codigo_incidencia':codigo_incidencia,
                    'cierre':cierre,
                    'estado':estado,
                    'base_region':base_region,
                    'base_sub_region':base_sub_region,
                    'base_cda':base_cda,
                    'conclusion':conclusion,
                    'tel_bot':tel_bot,
                    'fecha_instalacion':fecha_instalacion,
                    'fecha_compra':fecha_compra,
                    'fecha_recepcion':fecha_recepcion
                



                }, 
                beforeSend:function(){
                },   
                success: function(data){ 
                    alertify.success('La Campaña ha sido actualizado.');
                    //get_data_comercial();
                    get_data_detalle_campania(id_cliente);
                    $('#mdl_edit_campania').modal('hide');
                }
            });
        }

        function upd_detalle_asignacion(){

            var id =$('#txt_id_asig').val();
            var id_cliente =$('#txt_id_cliente_asig').val();
            var user =$('#txt_usuario_asig').val();
            var estado  =$('#txt_estado_asig').val();
            var fecha =$('#txt_fecha_asig').val();

            $.ajax({
                type: "POST",
                //dataType: 'json',
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/upd_detalle_asignacion',
                data: {
                    'id':id,
                    'id_cliente':id_cliente,
                    'user':user,
                    'estado':estado,                
                    'fecha':fecha
                }, 
                beforeSend:function(){
                },   
                success: function(data){ 
                    alertify.success('Detalle de Asignación ha sido actualizado.');
                    
                }
            });
        }

        function upd_data_gestion_x_visita(){

            var id              =$('#txt_id_visita').val();
            var tipo_visita     =$('#slc_v_tipo_visita').val();
            var gestion         =$('#slc_v_respuesta_visita').val();
            var comentario      =$('#txt_v_comentario').val();
            var fecha_visita    =$('#txt_v_fecha_visita').val();

            $.ajax({
                type: "POST",
                dataType: 'json',
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/upd_data_gestion_x_visita',
                data: {
                    'id':id,
                    'tipo_visita':tipo_visita,
                    'gestion':gestion,
                    'comentario':comentario,                
                    'fecha_visita':fecha_visita
                }, 
                beforeSend:function(){
                },   
                success: function(data){ 
                    alertify.success('Gestión de Visita ha sido actualizado.');
                    get_data_historial_cambios(id_visita);
                }
            });

        }

        function upd_telefono(){
            var id =$('#txt_id_cliente').val();      
            var telf_cliente =$('#txt_telf_cliente').val();

            $.ajax({
                type: "POST",
                //dataType: 'json',
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/upd_data_telefono',
                data: {
                    'id':id,
                    'id_visita':id_visita,
                    'telf_cliente':telf_cliente              
                }, 
                beforeSend:function(){
                },   
                success: function(data){ 
                    alertify.success('Telefono ha sido actualizado.');    
                    get_data_historial_cambios(id_visita);         
                }
            });

        }

        function upd_coordenada_visita_blq(){
            //var id =$('#text_id_visita_coordenada').val();      
            var coordenada =$('#txt_coordenada_visita_blq').val();

            $.ajax({
                type: "POST",
                //dataType: 'json',
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/upd_coordenada_visita_blq',
                data: {
                    'id_visita':id_visita,
                    'coordenada':coordenada                            
                }, 
                beforeSend:function(){
                },   
                success: function(data){ 
                    alertify.success('La coordenada ha sido actualizado.');    
                    //get_data_historial_cambios(id_visita);         
                }
            });

        }

        function upd_comercial(){
            var id =$('#txt_id_comercial').val();
            var name_supervisor =$('#txt_nombre_supervisor').val();
            var telf_supervisor =$('#txt_telf_supervisor').val();
            var name_vendedor  =$('#txt_nombre_vendedor').val();
            var telf_vendedor =$('#txt_telf_vendedor').val();

            $.ajax({
                type: "POST",
                //dataType: 'json',
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/upd_data_comercial',
                data: {
                    'id':id,
                    'id_visita':id_visita,
                    'name_supervisor':name_supervisor,
                    'telf_supervisor':telf_supervisor,
                    'name_vendedor':name_vendedor,                
                    'telf_vendedor':telf_vendedor
                }, 
                beforeSend:function(){
                },   
                success: function(data){ 
                    alertify.success('Detalle comercial ha sido actualizado.');
                    get_data_historial_cambios(id_visita);
                }
            });      
        }

        function upd_coordenadas(){

            //var id =$('#txt_id_comercial').val();         
            var co_pdv =$('#txt_coordenadas_pdv').val();
            var co_acm  =$('#txt_coordenadas_acmovil').val();
            var co_well =$('#txt_coordenadas_wellington').val();

            $.ajax({
                type: "POST",
                //dataType: 'json',
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/upd_data_coordenadas',
                data: {
                    'id_cliente':id_cliente,
                    'id_visita':id_visita,
                    'co_pdv':co_pdv,              
                    'co_acm':co_acm,                
                    'co_well':co_well
                }, 
                beforeSend:function(){
                },   
                success: function(data){ 
                    alertify.success('Las coordenadas han sido actualizado.');
                    get_data_historial_cambios(id_visita);
                }
            });
        }

        function upd_coordenada_ruteo(){         
            var co_pdv2 =$('#txt_coordenadas_pdv').val();        
            $.ajax({
                type: "POST",
                //dataType: 'json',
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/upd_data_coordenada_ruteo',
                data: {
                    'id_cliente':id_cliente,
                    'co_pdv2':co_pdv2             
                    
                }, 
                beforeSend:function(){
                },   
                success: function(data){ 
                    //alertify.success('Las coordenada de Ruteo han sido actualizado.');
                    //get_data_comercial();
                    if(data==1){
                        alertify.success('Las coordenada de Ruteo han sido actualizado.');
                    }else{                  
                        alertify.error('Cliente no se encuentra en la tabla de ruteo.');
                    }  
                }
            });
        }

        function upd_coordenada_ruteo2(){         
            var co_pdv2 =$('#txt_coordenadas_acmovil').val();        
            $.ajax({
                type: "POST",
                //dataType: 'json',
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/upd_data_coordenada_ruteo2',
                data: {
                    'id_cliente':id_cliente,
                    'co_pdv2':co_pdv2             
                    
                }, 
                beforeSend:function(){
                },   
                success: function(data){ 
                    //alertify.success('Las coordenada de Ruteo han sido actualizado.');
                    //get_data_comercial();
                    if(data==1){
                        alertify.success('Las coordenada de Ruteo han sido actualizado.');
                    }else{                  
                        alertify.error('Cliente no se encuentra en la tabla de ruteo.');
                    }  
                }
            });
        }

        function upd_coordenada_ruteo3(){         
            var co_pdv2 =$('#txt_coordenadas_wellington').val();        
            $.ajax({
                type: "POST",
                //dataType: 'json',
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/upd_data_coordenada_ruteo3',
                data: {
                    'id_cliente':id_cliente,
                    'co_pdv2':co_pdv2             
                    
                }, 
                beforeSend:function(){
                },   
                success: function(data){ 
                    //alertify.success('Las coordenada de Ruteo han sido actualizado.');
                    //get_data_comercial();
                    if(data==1){
                        alertify.success('Las coordenada de Ruteo han sido actualizado.');
                    }else{                  
                        alertify.error('Cliente no se encuentra en la tabla de ruteo.');
                    }  
                }
            });
        }

        function upd_control_visita(){             
            var id = id_visita;
            var c_redaccion         = $('#c_redaccion').val();
            var c_consulta          = $('#c_consulta').val();
            var c_comentario        = $('#c_comentario').val();
            var c_foto              = $('#c_foto').val();
            var c_coordenadas       = $('#c_coordenadas').val();           
            var c_visita_value      = $('input[name="control_visita"]:checked').val();
        
            $.ajax({
                type: "POST",
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/upd_control_visita',
                data: {

                    'id':id,  
                    'c_redaccion':c_redaccion,
                    'c_consulta':c_consulta,
                    'c_comentario':c_comentario,
                    'c_foto':c_foto,
                    'c_coordenadas':c_coordenadas,
                    'c_visita_value':c_visita_value
                    
                }, 
                beforeSend:function(){},   
                success: function(data){   
                    alertify.success('Control de visita Actualizado correctamente'); 
                    get_data_historial_cambios(id_visita);    
                
                }
            });        
        }

        function upd_data_segmento_cliente(){
            var id =$('#txt_id_cliente').val();      
            var ruc =$('#upd_cliente_ruc').val();
            var ruta =$('#upd_cliente_ruta').val();
            var dni =$('#upd_cliente_dni').val();
            var nombres =$('#upd_cliente_nombres').val();
            var dep =$('#upd_cliente_departamento').val();
            var dis =$('#upd_cliente_distrito').val();
            var base =$('#upd_cliente_base').val();
            var dir =$('#upd_cliente_direccion').val();
            var ref =$('#upd_cliente_referencia').val();
            var fecha =$('#upd_cliente_fecha_alta').val();
            var estado =$('#udp_cliente_estado').val();
            var zona =$('#upd_cliente_zona').val();

            $.ajax({
                type: "POST",
                //dataType: 'json',
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/upd_data_segmento_cliente',
                data: {
                    'id':id,
                    'ruc':ruc,
                    'ruta':ruta,
                    'dni':dni,
                    'nombres':nombres,
                    'dep':dep,
                    'dis':dis,
                    'base':base,
                    'dir':dir,
                    'ref':ref,
                    'fecha':fecha,
                    'estado':estado,
                    'zona':zona
                        
                }, 
                beforeSend:function(){
                },   
                success: function(data){ 
                    alertify.success('Los datos del cliente han sido actualizado.');  
                    $('#mdl_detalle_cliente').modal('hide');   
                    //et_data_historial_cambios(id_visita);         
                }
            });

        }

        function upd_data_segmento_equipo(){

            var id =$('#upd_edf_id').val();      
            var serie =$('#upd_edf_serie').val();
            var modelo =$('#upd_edf_modelo').val();
            var censo =$('#upd_edf_censo').val();
            var marca =$('#upd_edf_marca').val();
            var equipo =$('#upd_edf_equipo').val();
            var tipo =$('#upd_edf_tipo').val();
            var fins =$('#upd_edf_finstalacion').val();
            var estado =$('#upd_edf_estado').val();

            $.ajax({
                type: "POST",
                //dataType: 'json',
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/upd_data_segmento_equipo',
                data: {
                    'id':id,
                    'serie':serie,
                    'modelo':modelo,
                    'censo':censo,
                    'marca':marca,
                    'equipo':equipo,
                    'tipo':tipo,                   
                    'fins':fins,
                    'estado':estado                                          
                }, 
                beforeSend:function(){
                },   
                success: function(data){ 
                    alertify.success('Los datos del Equipo han sido actualizado.');  
                    $('#mdl_detalle_equipo').modal('hide');   
                    //get_data_historial_cambios(id_visita);         
                }
            });

        }

    //--------------------- LOAD ---------------------------

        function load_zonas_upd(){
            var datos = $('#upd_cliente_departamento').val();
            if(datos!=''){
                var data =  new  FormData();
                data.append('datos',datos);
                $.ajax({
                type:'post',
                    contentType:false,
                    url:'<?php echo base_url()?>Controller_visita/load_zonas',
                    data: data,
                    processData:false,
                    beforeSend:function(){
                    },
                    success: function(response){
                    $('#upd_cliente_zona').html(response);
                    alerta_error('success','','Se descargó correctamente las zona del departamento seleccionado.','Error');
                    }
                });   
            }else{
                alerta_error('error','','Seleccione el departamento del cliente.','Error');
            }
        } 

        function load_select_usuario_asignacion_rapida(){
            $.ajax({
                type: "POST",
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/load_select_usuario_asignacion_rapida',
                data: {}, 
                beforeSend:function(){
                },   
                success: function(data){
                    //cargar_respuestas_subseguimiento();
                    $('#slc_usuario_mdl').html(data);
                    $('#slc_usuario_mdl2').html(data);
                },
                error: function(){
                }
            }); 
        }


    //--------------------- FILTER ------------------------

        function activar_filtro_departamento_transp(){
            var dato = $('#slc_filter_departamento').val();
            $.ajax({
                type: "POST",
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/activar_filtro_departamento_transp',
                data: {'dato':dato}, 
                beforeSend:function(){
                },   
                success: function(data){   
                    if(data==1){
                        alertify.success('Filtro departamento activado.');
                    }else{                  
                        alertify.error('Filtro desactivado.');
                    }             
                    get_data_transportistas();
                }   
            });   
        }

        function activar_filtro_departamento_cda(){
            var dato = $('#slc_filter_departamento_cda').val();
            $.ajax({
                type: "POST",
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/activar_filtro_departamento_cda',
                data: {'dato':dato}, 
                beforeSend:function(){
                },   
                success: function(data){   
                    if(data==1){
                        alertify.success('Filtro departamento activado.');
                    }else{                  
                        alertify.error('Filtro desactivado.');
                    }             
                    get_data_almacenes();
                }   
            });   
        }

        /*function activar_filtro_departamento_programacion(){ //pendiente
            var dato = $('#slc_filter_departamento_programacion').val();
            $.ajax({
                type: "POST",
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/activar_filtro_departamento_programacion',
                data: {'dato':dato}, 
                beforeSend:function(){
                },   
                success: function(data){   
                    if(data==1){
                        alertify.success('Filtro departamento activado.');
                    }else{                  
                        alertify.error('Filtro desactivado.');
                    }             
                    get_data_programacion();
                }   
            });   
        }*/

        function activar_filtro_fecha_programacion(){
            var dato = $('#filter_fecha_programacion').val();
            var dato2 = $('#slc_filter_departamento_programacion').val();
            $.ajax({
                type: "POST",
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/activar_filtro_fecha_programacion',
                data: {'dato':dato, 'dato2':dato2}, 
                beforeSend:function(){
                },   
                success: function(data){   
                    if(data==1){
                        alertify.success('Filtro activado.');
                    }else{                  
                        alertify.error('Filtro desactivado.');
                    }             
                    get_data_programacion();
                }   
            });   
        }

        function activar_filtro_cda_contactos(dato){
            //var dato = $('#slc_filter_cda_contactos').val();
            $.ajax({
                type: "POST",
                url: 'https://geochasqui.com/sistema_geo/Controller_visita_arm/activar_filtro_cda_contactos',
                data: {'dato':dato}, 
                beforeSend:function(){
                },   
                success: function(data){   
                    console.log('Entrada:'+dato);            
                    get_data_contactos_comercial();
                }   
            });   
        }


    //--------------------- GET TABLE ---------------------

        function get_data_programacion(){
            $.ajax({
                type: "POST",
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/get_data_programacion',
                data: {
                //'id':id
                }, 
                beforeSend:function(){
                
                },   
                success: function(data){ 
                    var json = JSON.parse(data); 
                    var contenido = ''; 
                    var contador = 0; 

                    if(json != 'error'){
                        for (let index = 0; index < json.length; index++) {
                            contador += 1; 
                            contenido += '<tr style="color:#74788D;">';
                            // contenido += '<td>' + contador + '</td>';
                            contenido += '<td>' + json[index]['id'] + '</td>';
                            contenido += '<td>' + json[index]['departamento'] + '</td>';
                            contenido += '<td>' + json[index]['fecha_recojo'] + '</td>';
                            //contenido += '<td>' + json[index]['hora_rango'] + ' - ' + json[index]['hora_fin'] + '</td>';                    
                            contenido += '<td><button class="btn btn-sm btn-secondary p-1" onclick="abrir_detalle_programacion(' + json[index]['id'] + ')"><i class="mdi mdi-eye"></i></button></td>';
                            contenido += '</tr>';                     
                        }               
                    } else {
                        contenido += '<tr>';
                        contenido += '<td>SIN RESULTADOS...</td>';
                        contenido += '</tr>';
                    }

                    $('#data_programacion').html(contenido);
                }
            });
        }

        function get_data_almacenes(){
            $.ajax({
                type: "POST",
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/get_data_almacenes',
                data: {
                //'id':id
                }, 
                beforeSend:function(){
                
                },   
                success: function(data){ 
                    var json = JSON.parse(data); 
                    var contenido = ''; 
                    var contador = 0; 

                    if(json != 'error'){
                        for (let index = 0; index < json.length; index++) {
                            contador += 1; 
                            contenido += '<tr style="color:#74788D;">';
                            // contenido += '<td>' + contador + '</td>';
                            contenido += '<td>' + json[index]['direccion'] + '</td>';
                            contenido += '<td>' + json[index]['provincia'] + '</td>';
                            contenido += '<td>' + json[index]['contacto'] + '</td>';
                        
                            contenido += '<td><button class="btn btn-sm btn-secondary p-1" onclick="abrir_detalle_cdas(' + json[index]['id'] + ')"><i class="mdi mdi-eye"></i></button></td>';
                            contenido += '</tr>';                     
                        }               
                    } else {
                        contenido += '<tr>';
                        contenido += '<td>SIN RESULTADOS...</td>';
                        contenido += '</tr>';
                    }

                    $('#data_almacenes').html(contenido);
                }
            });
        }

        function get_data_transportistas(){
            $.ajax({
                type: "POST",
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/get_data_transportistas',
                data: {
                //'id':id
                }, 
                beforeSend:function(){
                
                },   
                success: function(data){ 
                    var json = JSON.parse(data); 
                    var contenido = ''; 
                    var contador = 0; 

                    if(json != 'error'){
                        for (let index = 0; index < json.length; index++) {
                            contador += 1; 
                            contenido += '<tr style="color:#74788D;">';
                            // contenido += '<td>' + contador + '</td>';
                            contenido += '<td>' + json[index]['nombre'] + '</td>';
                            contenido += '<td>' + json[index]['provincia'] + '</td>';
                            contenido += '<td>' + json[index]['telefono1'] + '</td>';
                        
                            contenido += '<td><button class="btn btn-sm btn-secondary p-1" onclick="abrir_detalle_transporte(' + json[index]['id'] + ')"><i class="mdi mdi-eye"></i></button></td>';
                            contenido += '</tr>';                     
                        }               
                    } else {
                        contenido += '<tr>';
                        contenido += '<td>SIN RESULTADOS...</td>';
                        contenido += '</tr>';
                    }

                    $('#data_transportistas').html(contenido);
                }
            });
        }

        function get_data_contactos_comercial(){
            $.ajax({
                type: "POST",
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/get_data_contactos_comercial',
                data: {
                //'id':id
                }, 
                beforeSend:function(){
                
                },   
                success: function(data){ 
                    var json = JSON.parse(data); 
                    var contenido = ''; 
                    var contador = 0; 

                    if(json != 'error'){
                        for (let index = 0; index < json.length; index++) {
                            contador += 1; 
                            contenido += '<tr style="color:#74788D;">';
                            // contenido += '<td>' + contador + '</td>';
                            contenido += '<td>' + json[index]['cda'] + '</td>';
                            contenido += '<td>' + json[index]['nombre'] + '</td>';
                            contenido += '<td>' + json[index]['tipo_contacto'] + '</td>';                           
                            contenido += '<td><button class="btn btn-sm btn-secondary p-1" onclick="abrir_detalle_contactos(' + json[index]['id'] + ')"><i class="mdi mdi-eye"></i></button></td>';
                            contenido += '</tr>';                     
                        }               
                    } else {
                        contenido += '<tr>';
                        contenido += '<td>SIN RESULTADOS...</td>';
                        contenido += '</tr>';
                    }

                    $('#data_contactos_comercial').html(contenido);
                }
            });
        }
        
        function get_data_historial_cambios(id){
            $.ajax({
                type: "POST",
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/get_data_historial_cambios',
                data: {
                'id':id
                }, 
                beforeSend:function(){
                
                },   
                success: function(data){ 
                    var json = JSON.parse(data); 
                    var contenido = ''; 
                    var contador = 0; 

                    if(json != 'error'){
                        for (let index = 0; index < json.length; index++) {
                            contador += 1; 
                            contenido += '<tr style="color:#74788D;">';
                            contenido += '<td>' + contador + '</td>';
                            // contenido += '<td>' + json[index]['id_visita'] + '</td>';
                            contenido += '<td>' + json[index]['tipo_change'] + '</td>';
                            contenido += '<td style="width:60px;">' + json[index]['gestion'] + '</td>';
                        
                            contenido += '<td style="width:80px;">';
                                if (json[index]['comentario'] === null || json[index]['comentario'] === '') {
                                    contenido += '';
                                } else {
                                    contenido += json[index]['comentario'];
                                }
                                
                            contenido += '</td>';

                            contenido += '<td style="width:60px;">' + json[index]['detalle_adicional'] + '</td>';      
                            contenido += '<td>' + json[index]['usuario_change'] + '</td>';
                            contenido += '<td>' + json[index]['fecha_change'] + '</td>';                              
                            contenido += '</tr>';                     
                        }               
                    } else {
                        contenido += '<tr>';
                        contenido += '<td>SIN RESULTADOS...</td>';
                        contenido += '</tr>';
                    }

                    $('#tb_historial_cambios').html(contenido);
                }
            });
        }
    
        function get_data_detalle_campania(id){
            $.ajax({
                type: "POST",
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/get_data_detalle_campania',
                data: {
                'id':id
                }, 
                beforeSend:function(){
                
                },   
                success: function(data){ 
                    var json = JSON.parse(data); 
                    var contenido = ''; 
                    var contador = 0; 

                    if(json != 'error'){
                        for (let index = 0; index < json.length; index++) {
                            contador += 1; 
                            contenido += '<tr style="color:#74788D;">';
                            contenido += '<td>' + contador + '</td>';
                            // contenido += '<td>' + json[index]['id_cliente'] + '</td>';
                            contenido += '<td>' + json[index]['serie'] + '</td>';
                            contenido += '<td>' + json[index]['modelo'] + '</td>';
                            contenido += '<td>' + json[index]['campania'] + '</td>';
                            contenido += '<td>' + json[index]['fecha_alta'] + '</td>';                       
                            contenido += '<td><button class="btn btn-sm btn-secondary p-1" onclick="abrir_detalle_campania(' + json[index]['id'] + ')"><i class="mdi mdi-eye"></i></button></td>';                                             
                            contenido += '</tr>';                     
                        }               
                    } else {
                        contenido += '<tr>';
                        contenido += '<td>SIN RESULTADOS...</td>';
                        contenido += '</tr>';
                    }

                    $('#tb_detalle_campania').html(contenido);
                }
            });
        }

        function get_data_lista_idvisita_campania(id,campania){        
            $.ajax({
                type: "POST",
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/get_data_lista_idvisita_campania',
                data: {
                'id':id,
                'campania':campania
                }, 
                beforeSend:function(){
                
                },   
                success: function(data){ 
                    var json = JSON.parse(data); 
                    var contenido = ''; 
                    var contador = 0; 

                    if(json != 'error'){
                        for (let index = 0; index < json.length; index++) {
                            contador += 1; 
                            contenido += '<tr style="color:#74788D;">';
                            // contenido += '<td>' + contador + '</td>';
                            // contenido += '<td style="font-size:12px; text-align: center;">' + json[index]['id_visita'] + '</td>';
                            contenido += '<td style="font-size:12px; text-align: center;">' + json[index]['campania'] + '</td>';   
                            contenido += '<td style="font-size:12px; text-align: center;">' + json[index]['fecha_visita'] + '</td>';
                            contenido += '<td style="font-size:12px; text-align: center;">' + json[index]['gestion'] + '</td>';
                            
                            
                            //contenido += '<td style="font-size:12px; text-align: center;">' + json[index]['del'] + '</td>';   

                            if (json[index]['del'] == 1) {
                                // Si 'del' es igual a 1, muestra un icono de eliminación rojo
                                contenido += '<td style="font-size:12px; text-align: center;"><i class="bx bx-trash" style="color: red; font-size:18px;"></i></td>';
                            } else {
                                // Si 'del' no es igual a 1, muestra un checkbox verde
                                contenido += '<td style="font-size:12px; text-align: center;"><i class="bx bxs-check-circle" style="color: green; font-size:18px;"></i></td>';
                            }
                            
                            
                            contenido += '</tr>';                     
                        }               
                    } else {
                        contenido += '<tr>';
                        contenido += '<td>SIN RESULTADOS...</td>';
                        contenido += '</tr>';
                    }
                    $('#listado_visitaxcampania').html(contenido);
                }
            });
        }


        function get_data_proceso_fotos(id_visita){  
            //var id_visita1 = 37123;
            $.ajax({
                type: "POST",
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/get_data_proceso_fotos',
                data: {
                'id_visita':id_visita
               
                }, 
                beforeSend:function(){
                
                },   
                success: function(data){ 
                    var json = JSON.parse(data); 
                    var contenido = ''; 
                    var contador = 0; 

                    if(json != 'error'){
                        for (let index = 0; index < json.length; index++) {
                            contador += 1; 
                            contenido += '<tr style="color:#74788D;">';

                            contenido += '<td>' + contador + '</td>';                          
                            // contenido += '<td style="font-size:12px; text-align: center;">' + json[index]['id'] + '</td>';   
                            // contenido += '<td style="font-size:12px; text-align: center;">' + json[index]['id_visita'] + '</td>';  
                            contenido += '<td style="font-size:12px; text-align: center;">' + json[index]['foto'] + '</td>';
                            contenido += '<td style="font-size:12px; text-align: center;">' + json[index]['tipo_imagen'] + '</td>';
                            //OBTENER EL PESO DE LA IMG
                            
                            
                            contenido += '<td style="font-size:12px; text-align: center;">' + json[index]['tipo_imagen'] + '</td>'; 
                            contenido += '<td><button class="btn btn-sm btn-secondary p-1" onclick="procesar_img(' + json[index]['id'] + ')"><i class="mdi mdi-eye"></i> Procesar</button></td>';                                                        
                           
                            
                            contenido += '</tr>';                     
                        }               
                    } else {
                        contenido += '<tr>';
                        contenido += '<td>SIN RESULTADOS...</td>';
                        contenido += '</tr>';
                    }
                    $('#listado_procesar_fotos').html(contenido);
                }
            });
        }

    //--------------------- OTHER -------------------------

        function coordenadas_visita_base() {
        
            var coor_visita = latitud + ',' + longitud;
            var coor_cliente = latitud_cliente + ',' + longitud_cliente;

            window.open("https://www.google.com/maps/dir/" + coor_visita + "/" + coor_cliente, '_blank');

        }

        function activador_panel(tipo) {
            switch (tipo) {
                case 'control_visita':
                    var dato = $('input[name="control_visita"]:checked').val();
                    switch (dato) {
                        case '1': // Verificar
                            $('#panel_verificacion').css('display', 'none');
                            break;
                        case '2': // Verificar
                            $('#panel_verificacion').css('display', 'none');
                            break;
                        case '3': // Verificar
                            $('#panel_verificacion').css('display', 'block');
                            break;
                        default:
                            $('#panel_verificacion').css('display', 'none');
                            break;
                    }
                break;

                case 'txt_eq_gestion_equipo':
                    var dato = $('#txt_eq_gestion_equipo').val();
                    switch (dato) {
                        case '1': // Verificar              
                            $('#programacion_gestion_x_equipo').css('display', 'block');
                            //$('#txt_eq_id_prog').val();
                            break;
                        default:
                            // Si dato no es igual a '1', hacer algo aquí
                            if (dato !== '1') {
                                // Realizar alguna acción cuando dato sea diferente de '1'
                                $('#programacion_gestion_x_equipo').css('display', 'none');
                                //$('#txt_eq_id_prog').val(''); 
                                $('#txt_eq_persona_contacto').val('');
                                $('#txt_eq_telefono').val('');
                                $('#txt_eq_cierre_fecha_recojo').val('');
                                $('#txt_eq_hora_rango').val('');
                                $('#txt_eq_hora_fin').val('');
                                $('#txt_eq_comentario_prog').val('');
                            }
                            break;
                    }
                break;

                default:
                    break;
            }
        }

        function eliminar_asignacion(id) {
            Swal.fire({
                title: "¿Estás seguro de Eliminar?",
                text: "No podrás revertir esto",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, eliminarlo"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: '<?php echo base_url(); ?>Controller_visita/eliminar_asignacion',
                        data: {
                            'id': id
                        },
                        beforeSend: function () {
                            // Código de antes de enviar la solicitud
                        },
                        success: function (data) {
                            if (data == 2) {
                                Swal.fire({
                                    title: "¡Eliminado!",
                                    text: "El registro ha sido eliminado.",
                                    icon: "success"
                                });
                            } else if (data == 1) {
                                Swal.fire({
                                    title: "No se puede eliminar",
                                    text: "El registro tiene visitas asociadas.",
                                    icon: "warning"
                                });
                            } else {
                                Swal.fire({
                                    title: "Error",
                                    text: "Se produjo un error al intentar eliminar el registro.",
                                    icon: "error"
                                });
                            }

                            get_data_historial_asignacion1(id_cliente);
                        
                        
                        }
                    });
                }
            });
        }


        function insertar_asignacion(){
            
            var txt_cliente_mdl = $('#txt_cliente_mdl').val();
            var slc_usuario_mdl = $('#slc_usuario_mdl').val();
            var slc_asignacion_mdl = $('#slc_asignacion_mdl').val();

            if(slc_usuario_mdl==''){
                alertify.error('Seleccione el usuario');
                registro_vacio('slc_usuario_mdl');
                return; 
            }
            if(txt_cliente_mdl==''){
                alertify.error('Seleccione el cliente');
                registro_vacio('txt_cliente_mdl');
                return; 
            }
            if(slc_asignacion_mdl==''){
                alertify.error('Seleccione el tipo de marcador');
                registro_vacio('slc_asignacion_mdl');
                return; 
            }  
            $.ajax({
                type: "POST",
                url: 'https://geochasqui.com/sistema_geo/Controller_visita/insertar_asignacion',
                data: {
                    'txt_cliente_mdl':txt_cliente_mdl,
                    'slc_usuario_mdl':slc_usuario_mdl,
                    'slc_asignacion_mdl':slc_asignacion_mdl
                }, 
                beforeSend:function(){
                },   
                success: function(data){                         
                    alertify.success(data);
                    //tb_table_campania.ajax.reload();
                    $('#mdl_upd_asignacion_rapida').modal('hide');
                    limpiar_formulario3();              
                }
            });       

        }

        function limpiar_formulario3(){
            $('#txt_cliente_mdl').val('');
            $('#slc_usuario_mdl').val('');
            $('#slc_asignacion_mdl').val('');
        }

        //1
        function agregar_visita_nuevo(){
           
           var id_clientexuser = 0;
           var tmp         = 0;            
           var idclie      = 1690;
           var usuario     = $('#add_asig_usuario').val();
        
           $.ajax({
               type:'post',              
               url:'https://geochasqui.com/sistema_geo/Controller_visita/agregar_visita_nuevo',
               data: {                       
                   'idcliente':idclie,                
                   'usuario':usuario,
                   'id_clientexuser':id_clientexuser
               },                  
               beforeSend:function(){                  
               },
               success: function(response){
                    if (response == 1) {
                        alertify.success('La visita es registrada correctamente');
                    } else if (response == 2) {
                        alertify.error('No tiene equipos activos (gestión para casos con resultado En Seguimiento)');
                    } else {
                        alertify.error('Ocurrió un error durante el proceso');
                    }
                    $('#mdl_agregar_visita_new').modal('hide');
                    abrir_detalle_visita(idclie);
                },
               
           });
       }


         // CIERRE DE MES Y SEMANA
        // ----------------------

            function get_cierre_mes(id) {
                var id_mes = id; // Debes definir la función obtenerIdCliente para obtener el ID del cliente
                $.ajax({
                    type: "POST",
                    url: 'https://geochasqui.com/sistema_geo/Controller_visita/get_cierre_mes',
                    data: { 'id_mes': id_mes },
                    beforeSend: function() {              
                    },
                    success: function(data) {
                        var json = JSON.parse(data);
                        if (json.mensaje == 'ok') {
                            $('#txt_eq_cierre_mes').html($.trim(json.pn_cierre_mes));                  
                        }
                    }
                });
            }

            function get_cierres_semanal(id_mes,id) {
                var id_semana = id; 
                var id_mes = id_mes;           
                $.ajax({
                    type: "POST",
                    url: 'https://geochasqui.com/sistema_geo/Controller_visita/get_cierres_semanal',
                    data: { 
                        'id_semana': id_semana ,
                        'id_mes': id_mes
                        },
                    beforeSend: function() {              
                    },
                    success: function(data) {
                        var json = JSON.parse(data);
                        if (json.mensaje == 'ok') {
                            $('#txt_eq_cierre_semanal').html($.trim(json.pn_cierre_semanal));
                        }
                    }
                });
            

            }

            function action_cierre_mes_semanal() {
            
                var id       =$('#txt_eq_cierre_mes').val();

                $.ajax({
                    type: "POST",
                    url: 'https://geochasqui.com/sistema_geo/Controller_visita/action_cierre_mes_semanal',
                    data: { 'id': id
                        },
                    beforeSend: function() {              
                    },
                    success: function(data) {
                        var json = JSON.parse(data);
                        if (json.mensaje == 'ok') {
                            $('#txt_eq_cierre_semanal').html($.trim(json.pn_cierre_semanal));
                        }
                    }
                });
            

            }

        // ----------------------

    //--------------------- PDF -------------------------

        function generar_preaviso(){

            cod= id_cliente;

            if(cod!=''){
            var url = 'https://geochasqui.com/sistema_geo/Controller_exportar_geo/generar_pdf_x_codcliente/'+cod; 
            window.open(url, '_blank');
            }else{
            alerta_error('error','Ingrese el código del cliente.','Resultado');
            }
        }

        function generar_notarial(){
            cod= id_cliente;

            if(cod!=''){
            var url = 'https://geochasqui.com/sistema_geo/Controller_exportar_geo/generar_pdf_x_cliente_cn/'+cod; 
            window.open(url, '_blank');
            }else{
            alerta_error('error','Ingrese el código del cliente.','Resultado');
            }
        }

    //--------------------- REDIRIGIR -------------------------

        function get_detalle_visita_programacion(){
            var id_cliente = $('#prog_id_cliente').val();
            var id_visita = $('#prog_id_visita').val();
            abrir_detalle_visita(id_cliente,id_visita);
            $('#mdl_detalle_programacion').modal('hide');//open   

        }   
        
    //--------------------- PORTAPAPALES -------------------------    

     /*    document.getElementById('botonCopiar').addEventListener('click', function() {
            var textoACopiar = document.getElementById('textoACopiar');
            var seleccion = window.getSelection();
            var rango = document.createRange();
            rango.selectNodeContents(textoACopiar);
            seleccion.removeAllRanges();
            seleccion.addRange(rango);
            document.execCommand('copy');
            seleccion.removeAllRanges();
            
            // Puedes mostrar un mensaje de éxito aquí si lo deseas
            alertify.success('El texto ha sido copiado al portapapeles.');    
            //alert('');
        });


        document.getElementById('botonCopiar2').addEventListener('click', function() {
            var textoACopiar = document.getElementById('textoACopiar2');
            var seleccion = window.getSelection();
            var rango = document.createRange();
            rango.selectNodeContents(textoACopiar);
            seleccion.removeAllRanges();
            seleccion.addRange(rango);
            document.execCommand('copy');
            seleccion.removeAllRanges();
            
            // Puedes mostrar un mensaje de éxito aquí si lo deseas
            alertify.success('El texto ha sido copiado al portapapeles.');    
            //alert('');
        });


        document.getElementById('botonCopiarb').addEventListener('click', function() {
            var textoACopiar = document.getElementById('textoACopiarb');
            var seleccion = window.getSelection();
            var rango = document.createRange();
            rango.selectNodeContents(textoACopiar);
            seleccion.removeAllRanges();
            seleccion.addRange(rango);
            document.execCommand('copy');
            seleccion.removeAllRanges();
            
            // Puedes mostrar un mensaje de éxito aquí si lo deseas
            alertify.success('El texto ha sido copiado al portapapeles.');    
            //alert('');
        });


        document.getElementById('botonCopiarb2').addEventListener('click', function() {
            var textoACopiar = document.getElementById('textoACopiarb2');
            var seleccion = window.getSelection();
            var rango = document.createRange();
            rango.selectNodeContents(textoACopiar);
            seleccion.removeAllRanges();
            seleccion.addRange(rango);
            document.execCommand('copy');
            seleccion.removeAllRanges();
            
            // Puedes mostrar un mensaje de éxito aquí si lo deseas
            alertify.success('El texto ha sido copiado al portapapeles.');    
            //alert('');
        });

        document.getElementById('botonCopiarc3').addEventListener('click', function() {
            var textoACopiar = document.getElementById('textoACopiarc3');
            var seleccion = window.getSelection();
            var rango = document.createRange();
            rango.selectNodeContents(textoACopiar);
            seleccion.removeAllRanges();
            seleccion.addRange(rango);
            document.execCommand('copy');
            seleccion.removeAllRanges();
            
            // Puedes mostrar un mensaje de éxito aquí si lo deseas
            alertify.success('El texto ha sido copiado al portapapeles.');    
            //alert('');
        }); */
        
//------------------------


  




// FUNCIONES DE EVENTOS 
// ------------------------------

    
    function get_list_events(id_cliente){               
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>C_mod_form_event/get_list_events1',
            data: {
                'id_cliente':id_cliente
            }, 
            beforeSend:function(){
            },   
            success: function(data){ 
                var json         = eval("(" + data + ")");
                if(json.mensaje=='ok'){
                    $('#tb_numeros_vicidial_list1').html(json.resultado);
                    
                    get_indicadores_eventos(id_cliente);
                }else{
                }
            }
        });
    }

    function get_indicadores_eventos(id_cliente) {
            var vendor_lead_code = id_cliente;
        $.ajax({
            
            type: "POST",
            url: '<?php echo base_url(); ?>C_mod_form_event/get_indicadores_eventos',
            data: {
                'vendor_lead_code':vendor_lead_code
            },
            beforeSend: function () {
                // Puedes realizar acciones antes de enviar la solicitud
            },
            success: function (data) {
                // Parsear la respuesta JSON
                var json = JSON.parse(data);
                // Actualizar los elementos HTML con los valores obtenidos
                $('#cant_whatsapp_evento').text(json.cant_whatsapp_evento);
                $('#cant_email_evento').text(json.cant_email_evento);
                $('#cant_evento').text(json.cant_evento);
                $('#cant_delete_evento').text(json.cant_delete_evento);
                $('#cant_control_calidad').text(json.cant_control_calidad);


            }
        });
    }

    function evaluar_resultado(id){
        var tipo = ''; 
        var dato = ''; 
        switch (id) {
            case 'txt_tipo_evento':
                tipo ='tipo_evento';
                dato= $('#txt_tipo_evento').val(); 
                $('#txt_respuesta_evento').html('<option value="">Seleccione</option>');
                break;


            /*case 'select_provincia':
                tipo ='provincia';
                dato= $('#select_provincia').val(); */
                
                break;       
            default:
                break;
        }        
        $.ajax({
            type: "POST",
            url: 'https://geochasqui.com/sistema_geo/C_mod_form_event/get_respuestas_evento',
            data: {
                'dato':dato,
                'tipo':tipo,
            }, 
            beforeSend:function(){
                
            },   
            success: function(e){    

                var res = jQuery.parseJSON(e);
                switch (tipo) {
                    case 'tipo_evento':
                        $('#txt_respuesta_evento').html(res.select_datos);
                        break;
                    /*case 'provincia':
                        $('#select_distrito').html(res.select_datos);
                        break; */                           
                    default:
                        break;
                }
            },
            error: function(){
            }
        });
    }

    function evaluar_resultado1(id){
        var tipo = ''; 
        var dato = ''; 
        switch (id) {
            case 'txto_tipo_evento':
                tipo ='tipo_evento';
                dato= $('#txto_tipo_evento').val(); 
                $('#txto_respuesta_evento').html('<option value="">Seleccione</option>');
                break;


            /*case 'select_provincia':
                tipo ='provincia';
                dato= $('#select_provincia').val(); */
                
                break;       
            default:
                break;
        }        
        $.ajax({
            type: "POST",
            url: 'https://geochasqui.com/sistema_geo/C_mod_form_event/get_respuestas_evento',
            data: {
                'dato':dato,
                'tipo':tipo,
            }, 
            beforeSend:function(){
                
            },   
            success: function(e){    

                var res = jQuery.parseJSON(e);
                switch (tipo) {
                    case 'tipo_evento':
                        $('#txto_respuesta_evento').html(res.select_datos);
                        break;
                    /*case 'provincia':
                        $('#select_distrito').html(res.select_datos);
                        break; */                           
                    default:
                        break;
                }
            },
            error: function(){
            }
        });
    }

    function edit_control_event(id) {
        $.ajax({
            type: "POST",
            dataType: 'json', // Descomenta esta línea para indicar que esperas una respuesta JSON
            url: '<?php echo base_url(); ?>C_mod_form_event/edit_control_event',
            data: {
                'id':id
            },
            beforeSend: function () {
                // Puedes agregar lógica adicional antes de la llamada AJAX si es necesario
            },
            success: function (res) {
                // Asegúrate de que las variables estén definidas antes de usarlas
                var id_upd = res.id_ct;
                // Actualiza los elementos en tu interfaz de usuario con los datos recibidos
                $('#txto_id1').val(res.id_ct);
                $('#txto_tipo_seguimiento1').val(res.tipo_seguimiento_ct);
                $('#txto_tipo_evento1').val(res.tipo_evento_ct);
                $('#txto_respuesta_evento1').val(res.id_paleta_gestion_ct);
                $('#txto_mensaje1').val(res.observacion_ct);
                
                $('#select_control_calidad').val(res.control_calidad_evento_ct);
                $('#observacion_control').val(res.control_calidad_observacion_ct);

                $('#mdl_control_calidad').modal('show');
                
            }
        });
    }
    
    function edit_event(id){          
        $.ajax({
            type: "POST",
            //dataType: 'json',
            url: '<?php echo base_url(); ?>C_mod_form_event/edit_event',
            data: {
                'id':id
            }, 
            beforeSend:function(){
            },   
            success: function(e){ 
                id_upd=id;
                var res = jQuery.parseJSON(e);                 
                $('#txto_id').val(res.id);
                $('#txto_tipo_seguimiento').val(res.tipo_seguimiento);
                $('#txto_tipo_evento').val(res.tipo_evento);
                $('#txto_respuesta_evento').val(res.id_paleta_gestion);
                $('#txto_mensaje').val(res.observacion);                                                   
                $('#mdl_update_event').modal('show');
            }
        });
    }

    function delete_event(id) {
        Swal.fire({
            title: "¿Estás seguro de Eliminar?",
            text: "No podrás revertir esto",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí, eliminarlo"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url(); ?>C_mod_form_event/delete_event',
                    data: {
                        'id': id
                    },
                    beforeSend: function () {
                        // Código de antes de enviar la solicitud
                    },
                    success: function (data) {
                        Swal.fire({
                            title: "¡Eliminado!",
                            text: "EL registro ha sido eliminado.",
                            icon: "success"
                        });
                        get_list_events(id_cliente);
                        get_indicadores_eventos(id_cliente);
                    }
                });
            }
        });
    }

    function get_select_respuesta_calidad_evento(){
        alert();
        $.ajax({
            type: "POST",
            url: 'https://geochasqui.com/sistema_geo/C_mod_form_event/get_select_respuesta_calidad_evento',
            data: {}, 
            beforeSend:function(){

            },   
            success: function(data){
                //cargar_respuestas_subseguimiento();
                $('#select_control_calidad').html(data);
            },
            error: function(){
            }
        }); 
    }

    function add_new_event(){
        clear_modal_add_event();     
        $('#mdl_add_event').modal('show');
    }

    function clear_modal_add_event(){
        $('#txt_tipo_seguimiento').val('');
        $('#txt_tipo_evento').val('');
        $('#txt_respuesta_evento').val('');
        $('#txt_comentario_evento').val('');
        $('#mdl_add_event').modal('hide');
    }

    function add_event(){

        var id_cliente              = $('#txt_id_cliente_evento').val();
        var id_campania             = $('#txt_id_campania_evento').val();
        var vendor_lead_code        = 75983305;
        var txt_tipo_seguimiento    = $('#txt_tipo_seguimiento').val();
        var txt_tipo_evento         = $('#txt_tipo_evento').val();
        var txt_respuesta_evento    = $('#txt_respuesta_evento').val();
        var txt_comentario_evento   = $('#txt_comentario_evento').val();

        // if(txt_tipo_seguimiento==''){alertify.error('Selecciona el tipo de Seguimiento.');return;}
        if(txt_tipo_evento==''){alertify.error('Selecciona el tipo de Evento.');return;}
        if(txt_respuesta_evento==''){alertify.error('Selecciona la Respuesta para el Evento.');return;}

        $.ajax({
            type: "POST",
            url: 'https://geochasqui.com/sistema_geo/C_mod_form_event/add_event',
            data: {
                'id_cliente':id_cliente,
                'id_visita':id_visita,
                'id_campania':id_campania,
                'vendor_lead_code':vendor_lead_code,
                'txt_tipo_seguimiento':txt_tipo_seguimiento,
                'txt_tipo_evento':txt_tipo_evento,
                'txt_respuesta_evento':txt_respuesta_evento,
                'txt_comentario_evento':txt_comentario_evento                                 
            }, 
            beforeSend:function(){
                $('.loading').fadeIn();
                //$('.loader_carga').fadeIn('slow');
            },   
            success: function(data){                                                        
                alertify.success('Registro agregado correctamente.');                 
                $('#mdl_add_event').modal('hide');  
                get_list_events(id_cliente); //llamar la lista 
                get_indicadores_eventos(id_cliente);   
                get_data_historial_cambios(id_visita);                        
            },
            error: function(){
            }
        });
    }

    function add_control_event(){    
        var txto_id1 = $('#txto_id1').val();
        var select_control_calidad = $('#select_control_calidad').val();
        var observacion_control = $('#observacion_control').val();
        if(select_control_calidad==''){alertify.error('Selecciona el tipo de Seguimiento.');return;}
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>C_mod_form_event/add_control_event',
            data: {
                'txto_id1':txto_id1,
                'select_control_calidad':select_control_calidad,
                'observacion_control':observacion_control   
            }, 
            beforeSend:function(){
            },   
            success: function(data){                                                        
                alertify.success('Registrado correctamente.');                 
                $('#mdl_control_calidad').modal('hide'); 
                get_list_events(id_cliente);                              
            },
            error: function(){
            }
        });
    }

    function update_event(){
        var txt_id = $('#txto_id').val();
        var txt_tipo_seguimiento = $('#txto_tipo_seguimiento').val();
        var txt_tipo_evento = $('#txto_tipo_evento').val();
        var txt_respuesta_evento = $('#txto_respuesta_evento').val();
        var txt_comentario_evento = $('#txto_mensaje').val();

        // if(txto_tipo_seguimiento==''){alertify.error('Selecciona el tipo de Seguimiento.');return;}
        if(txto_tipo_evento==''){alertify.error('Selecciona el tipo de Evento.');return;}
        if(txto_respuesta_evento==''){alertify.error('Selecciona la Respuesta para el Evento.');return;}
        
        $.ajax({
            type: "POST",
            url: 'https://geochasqui.com/sistema_geo/C_mod_form_event/update_event',
            data: {
                'txt_id':txt_id,
                'id_visita':id_visita,
                'txt_tipo_seguimiento':txt_tipo_seguimiento,
                'txt_tipo_evento':txt_tipo_evento,
                'txt_respuesta_evento':txt_respuesta_evento,
                'txt_comentario_evento':txt_comentario_evento                                 
            }, 
            beforeSend:function(){
            //  $('.loading').fadeIn();
                //$('.loader_carga').fadeIn('slow');
            },   
            success: function(data){                                                        
                alertify.success('Actualizado correctamente.');                 
                $('#mdl_update_event').modal('hide'); 
                
                get_list_events(id_cliente);   
                get_indicadores_eventos(id_cliente);    
                get_data_historial_cambios(id_visita);                        
            },
            error: function(){
            }
        });
    }

    function refresh_event() {
        let timerInterval;
        Swal.fire({
        title: "Actualizando la pagina!",
        html: "I will close in <b></b> milliseconds.",
        timer: 1100,
        timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
                const timer = Swal.getPopup().querySelector("b");
                timerInterval = setInterval(() => {
                timer.textContent = `${Swal.getTimerLeft()}`;
                }, 100);
            },
            willClose: () => {
                clearInterval(timerInterval);
            }
            }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                    console.log("I was closed by the timer");
                }
        });
        get_list_events1(id_cliente);
    }


// ------------------------------





// OTHER - INVESTIGACION
// -----------------
    //  dimensionar para celular
    window.addEventListener('resize', function(event){
        if(window.innerWidth <= 767){
            document.getElementById('panel_no_celular').style.display = 'none';
            document.getElementById('panel_celular').style.display = 'block';
        } else {
            document.getElementById('panel_no_celular').style.display = 'block';
            document.getElementById('panel_celular').style.display = 'none';
        }
    });


    function get_tbl_result_cda() {
        $("#txt_buscar_cda").on("keyup", function() {
            clearTimeout(timer);
            timer = setTimeout(() => {
                var value = $(this).val().toLowerCase();
                activar_filtro_cda_contactos(value);
            }, delayValue);
        });       
    }
// ----------------
