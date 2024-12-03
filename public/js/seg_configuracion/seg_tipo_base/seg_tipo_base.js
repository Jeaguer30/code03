function insertar_tipo_base(){
    var t_base = $('#txt_tipo_base').val();       
    $.ajax({
        type: "POST",
        url: 'https://geochasqui.com/sistema_geo/Controller_tipo_base_geo/insertar_tipo_base',
        data: {'t_base':t_base}, 
        beforeSend:function(){
        },   
        success: function(data){               
            if (data=='1') {
                alertify.success('Tipo de base Registrada');
                //tb_table_campania.ajax.reload();
                $('#mdl_insertar_tipo_base').modal('hide');
                tb_table_tipo_base.ajax.reload();
            } else {
                alertify.error('Se debe agregar el tipo de ssssss');  
            } 
        }
    });
}

function ver_mdl(tipo){
    switch (tipo) {
        case 'mdl_insertar_campania':
            $('#mdl_insertar_campania').modal('show');                
            break;
        case 'mdl_insertar_tipo_base':
            $('#mdl_insertar_tipo_base').modal('show');                
            break;        
        default:
            break;
    }       
}