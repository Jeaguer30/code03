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
        var ref            = $('#txt_alm_referencia').val();
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
                'ref':ref,
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

/* funciones para actualizar */


    function get_datos(id){
        clear_form();
        $.ajax({
            type: "POST",
            //dataType: 'json',
            url: 'https://geochasqui.com/sistema_geo/Controller_almacenes/get_datos',
            data: {
                'id':id
            }, 
            beforeSend:function(){
            },   
            success: function(e){ 
                id_upd=id;
                var res = jQuery.parseJSON(e);
                if(res.mensaje!='error'){
                    $('#id_edit').val(res.id);  
                    $('#select_tipo_edit').val(res.tipo);                      
                    $('#select_dep_direccion_edit').val(res.id_departamento);
                    $('#txt_provincia_edit').val(res.provincia);
                    $('#txt_alm_direccion_edit').val(res.direccion);
                    $('#txt_alm_referencia_edit').val(res.referencia);
                    $('#txt_latitud_edit').val(res.latitud);
                    $('#txt_longitud_edit').val(res.longitud);
                    $('#txt_contacto_edit').val(res.contacto);                   
                    $('#txt_cargo_edit').val(res.cargo);
                    $('#txt_celular_edit').val(res.telefono);   

                    $('#mdl_editar_almacen').modal('show');
                    

                }else{
                }
            }
        });
    }

    function actualizar_almacen(){
        var id_edit        = $('#id_edit').val();
        var dep            = $('#select_dep_direccion_edit').val();
        var dir            = $('#txt_alm_direccion_edit').val();
        var ref            = $('#txt_alm_referencia_edit').val();
        var tipo           = $('#select_tipo_edit').val();
        var provincia      = $('#txt_provincia_edit').val();
        var latitud        = $('#txt_latitud_edit').val();
        var longitud       = $('#txt_longitud_edit').val();
        var contacto       = $('#txt_contacto_edit').val();
        var cargo          = $('#txt_cargo_edit').val();
        var telefono       = $('#txt_celular_edit').val();
      
        $.ajax({
            type: "POST",
            url: 'https://geochasqui.com/sistema_geo/Controller_almacenes/actualizar_almacen',
            data: {
                'id_edit':id_edit,
                'dep':dep,
                'dir':dir,
                'ref':ref,
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
                    alertify.success('Almacen Actualizado correctamente');
                    tb_table.ajax.reload();
                    $('#mdl_editar_almacen').modal('hide');
                    clear_form();
                   

                } else {
                    alertify.error('Se debe agregar ambos campos');  
                } 
            }
        });        
       

    }


/* fin */

/* limpiar formulario */

    function clear_form(){
        $("#select_tipo").val('');
        $("#select_dep_direccion").val('');
        $("#txt_provincia").val('');
        $("#txt_alm_direccion").val('');
        $("#txt_coordenadas").val('');
        $("#txt_contacto").val('');
        $("#txt_cargo").val('');
        $("#txt_celular").val(''); 
        $("#txt_alm_referencia_edit").val(''); 
    }

/* fin */