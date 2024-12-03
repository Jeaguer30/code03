


function open_mdl_notaria(){          
    $('#mdl_insertar_notaria').modal('show');                  
    $('#mdl_buscador_notarias').modal('hide');                  
}

function insertar_notaria(){      
    var ruc          = $('#txt_ruc').val();
    var r_social     = $('#txt_razon_social').val();
    var dir          = $('#txt_direccion').val();
    var dep          = $('#slc_departamento').val();
    var pro          = $('#slc_provincia').val();
    var dis          = $('#slc_distrito').val();
    var lat          = $('#txt_latitud').val();
    var log          = $('#txt_longitud').val();
    var cel          = $('#txt_celular').val();
    var cel2          = $('#txt_celular2').val();
    var tel          = $('#txt_telefono').val();
    var estado       = $('#txt_estado_not').val();
    var hor          = $('#txt_horario').val();
    $.ajax({
        type: "POST",
        url: 'https://geochasqui.com/sistema_geo/Controller_notaria/insertar_notaria',
        data: {
            'ruc':ruc,               
            'r_social':r_social,
            'dir':dir,   
            'dep':dep,    
            'pro':pro,    
            'dis':dis,   
            'lat':lat,   
            'hor':hor,  
            'log':log,  
            'cel':cel,  
            'cel2':cel2, 
            'tel':tel, 
            'estado':estado  
        }, 
        beforeSend:function(){
        },   
        success: function(data){              
            if (data=='1') {
                get_notarias();
                alertify.success('Notaria Registrada correctamente');
                tb_table_notaria.ajax.reload();
                $('#mdl_insertar_notaria').modal('hide');
                clear_form_data();
            } else {
                alertify.error('Se debe de completar los campos');  
            } 
        }
    });        

}

function aplicar_filtro_depa(){
    var dep = $('#slc_departamento').val();
    $.ajax({
        type: "POST",
        url: 'https://geochasqui.com/sistema_geo/Controller_notaria/aplicar_filtro_depa',
        data: {'dep':dep}, 
        beforeSend:function(){
        
        },   
        success: function(data){
        
            $('#slc_provincia').html(data);
        },
        error: function(){
        }
    }); 
}

function aplicar_filtro_prov(){
    var prov = $('#slc_provincia').val();
    $.ajax({
        type: "POST",
        url: 'https://geochasqui.com/sistema_geo/Controller_notaria/aplicar_filtro_prov',
        data: {'prov':prov}, 
        beforeSend:function(){
        
        },   
        success: function(data){
        
            $('#slc_distrito').html(data);
        },
        error: function(){
        }
    }); 
}



function activar_filtro_estado() {
    var dato = $('#slc_filter_estado').val();
    var controller = 'Controller_notarial_lindley';
    var url = 'https://geochasqui.com/sistema_geo/' + controller + '/activar_filtro_estado';

    $.ajax({
        type: "POST",
        url: url,
        data: {'dato': dato},
        beforeSend: function () {
            // Código antes de enviar la solicitud
        },
        success: function (data) {
            if (data == 1) {
                alertify.success('Filtro estado activado.');
            } else {
                alertify.error('Filtro desactivado.');
            }
            tb_table_consulta.ajax.reload();
        }
    });
}


function activar_filtro_departamento(){
    var dato = $('#slc_filter_departamento').val();
    $.ajax({
        type: "POST",
        url: 'https://geochasqui.com/sistema_geo/Controller_notarial_lindley/activar_filtro_departamento',
        data: {'dato':dato}, 
        beforeSend:function(){
        },   
        success: function(data){   
            if(data==1){
                alertify.success('Filtro estado activado.');
            }else{                  
                alertify.error('Filtro desactivado.');
            }             
            tb_table_notaria.ajax.reload();
        }
    });   
}
