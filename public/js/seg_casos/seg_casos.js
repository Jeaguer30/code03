/* funciones para añadir transportista */

    function ver_mdl(tipo){
        switch (tipo) {
            case 'mdl_insertar_almacenes':
                $('#mdl_insertar_almacenes').modal('show');
                
                break;
            case 'mdl_insertar_tipo_base':
                $('#mdl_insertar_tipo_base').modal('show');
                
                break;
        
            default:
                break;
        }
    
    }

    function insertar_almacen(){
        var dep            = $('#select_dep_direccion').val();
        var dir            = $('#txt_alm_direccion').val();
        var tipo           = $('#select_tipo').val();
        var provincia      = $('#txt_provincia').val();
        var latitud        = $('#txt_latitud').val();
        var longitud        = $('#txt_longitud').val();
        var contacto       = $('#txt_contacto').val();
        var cargo          = $('#txt_cargo').val();
        var telefono       = $('#txt_celular').val();
      
        $.ajax({
            type: "POST",
            url: 'https://geochasqui.com/sistema_geo/Controller_almacenes/insertar_almacen',
            data: {
                'dep':dep,
                'dir':dir,
                'tipo':tipo,
                'provincia':provincia,
                'latitud':latitud,
                'longitud':longitud,
                'contacto':contacto,
                'cargo':cargo,
                'telefono':telefono     
            
            }, 
            beforeSend:function(){
            },   
            success: function(data){   
               
                if (data=='1') {
                    alertify.success('Almacen Registrado correctamente');
                    tb_table.ajax.reload();
                    $('#mdl_insertar_almacenes').modal('hide');
                    clear_form();
                   

                } else {
                    alertify.error('Se debe agregar ambos campos');  
                } 
            }
        });        
       

    }

/* fin */



/* funciones para el modal fullsccream de DETALLE DE SEGUIMIENTO */

    function abrir_modal(id,n_modal){
        $.ajax({
            type: "POST",
            url: 'https://geochasqui.com/sistema_geo/Controller_consulta_lindley/obtener_datos',
            data: {
                'id':id
            }, 
            beforeSend:function(){
            },   
            success: function(data){ 
                var json         = eval("(" + data + ")");
                if(json.mensaje=='ok'){
                    //Datos del cliente
                    $('#id_edf').val($.trim(json.id));
                    $('#txt_codigo_cliente').val($.trim(json.txt_codigo_cliente));
                    $('#txt_nombre_cliente').val($.trim(json.txt_nombre_cliente));
                    $('#txt_departamento').val($.trim(json.txt_departamento));
                    $('#txt_distrito').val($.trim(json.txt_distrito));
                    $('#txt_direccion').val($.trim(json.txt_direccion));
                    $('#txt_ruta').val($.trim(json.txt_ruta));
                    $('#txt_coordenadas').val($.trim(json.txt_coordenadas));
                           
                    //Observación Comercial
                    $('#txt_comentario_sup').val($.trim(json.txt_comentario_sup));
                    $('#txt_akm_gestion').val($.trim(json.txt_akm_gestion));
                    $('#txt_akm_descripcion').val($.trim(json.txt_akm_descripcion));

                    //equipos
                    $('#detalle_edfs').html($.trim(json.detalle_edfs));
                   
                    //vissitas
                    $('#lista_cabecera_cierres').html($.trim(json.detalle_botones_campania));
                    $('#lista_visitas').html($.trim(json.detalle_visitas_edfs));


                    $('#txt_supervisor').val($.trim(json.txt_supervisor));
                    $('#txt_telefono_supervisor').val($.trim(json.txt_telefono_supervisor));
                    $('#txt_vendedor').val($.trim(json.txt_vendedor));
                    $('#txt_telefono_vendedor').val($.trim(json.txt_telefono_vendedor));


                   

                    $('#list_fotos').html('');
                    
                    $('#'+n_modal).modal('show');
                }else{
                }
            }
        });
    }


    //menu de seguimiento:

    //comercial:

    function actualizar_supervisor(){
        let id_edf = $('#id_edf').val();
        let txt_telefono_supervisor = $('#txt_telefono_supervisor').val();
        let txt_supervisor = $('#txt_supervisor').val();

        $.ajax({
            type: "POST",
            url: 'https://geochasqui.com/sistema_geo/Controller_consulta_lindley/actualizar_supervisor',
            data: {
                'id_edf':id_edf,
                'txt_telefono_supervisor':txt_telefono_supervisor,
                'txt_supervisor':txt_supervisor
            }, 
            beforeSend:function(){
            },   
            success: function(data){ 
                //var json         = eval("(" + data + ")");
                //if(json.mensaje=='1'){
                if(data=='1'){
                    alertify.success('Actualizado correctamente..');
                    //$('#'+n_modal).modal('show');
                }else{
                }
            }
        });
    }

    function actualizar_vendedor(){
        let id_edf = $('#id_edf').val();
        let txt_vendedor = $('#txt_vendedor').val();
        let txt_telefono_vendedor = $('#txt_telefono_vendedor').val();

        $.ajax({
            type: "POST",
            url: 'https://geochasqui.com/sistema_geo/Controller_consulta_lindley/actualizar_vendedor',
            data: {
                'id_edf':id_edf,
                'txt_telefono_vendedor':txt_telefono_vendedor,
                'txt_vendedor':txt_vendedor
            }, 
            beforeSend:function(){
            },   
            success: function(data){ 
                if(data=='1'){
                    alertify.success('Actualizado correctamente..');
                }else{
                }
            }
        });
    }


    //cierres
    
    function get_cierres_cliente(){
        var id_cliente = $('#txt_codigo_cliente').val();
        $.ajax({
            type: "POST",
            url: 'https://geochasqui.com/sistema_geo/Controller_cierres_lindley/get_cierres_cliente',
            data: {
                'id_cliente':id_cliente
            }, 
            beforeSend:function(){
            },   
            success: function(data){ 
                $('#detalle_cierres').html(data);
            }
        });
    }

    
    //visitas

    function get_cierres_cliente(){
        var id_cliente = $('#txt_codigo_cliente').val();
        $.ajax({
            type: "POST",
            url: 'https://geochasqui.com/sistema_geo/Controller_cierres_lindley/get_cierres_cliente',
            data: {
                'id_cliente':id_cliente
            }, 
            beforeSend:function(){
            },   
            success: function(data){ 
                $('#detalle_cierres').html(data);
            }
        });
    }

    // ,ostrar los datos ocultos de los seleccionado en visistas
    function filtrar_resultado_visitas(campania,contador){
        $('.panel_visitas').css('display','none');
        $('.'+campania).css('display','block');
    }

   
    
  

/* fin */




/* OTRAS FUNCIONES */

    function abrir_galeria(){
        var id = $('#txt_codigo_cliente').val();
        window.open('https://geochasqui.com/sistema_geo/seg_galeria?id=' + id, '_blank');      
    }

    function ver_fotos(id){
        $.ajax({
            type: "POST",
            url: 'https://geochasqui.com/sistema_geo/Controller_consulta_lindley/ver_fotos',
            data: {
                'id':id
            }, 
            beforeSend:function(){
            },   
            success: function(data){ 
                var json         = eval("(" + data + ")");
                if(json.mensaje=='ok'){
                    $('#list_fotos').html($.trim(json.list_fotos));
                }else{
                }
            }
        });
    }

/* fin */