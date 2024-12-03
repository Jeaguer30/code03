function ver_mdl(tipo){
    switch (tipo) {
        case 'mdl_insertar_campania':
            $('#mdl_insertar_campania').modal('show');      
            break;       
        default:
            break;
    }
   
}

function insertar_campania(){
    var campania = $('#txt_campania').val();
    var tipo_base = $('#slc_tipo_base_cam').val();
    $.ajax({
        type: "POST",
        url: 'https://geochasqui.com/sistema_geo/Controller_campania_geo/insertar_campania',
        data: {'campania':campania, 'tipo_base':tipo_base }, 
        beforeSend:function(){
        },   
        success: function(data){   
           
            if (data=='1') {
                alertify.success('Campaña Registrada');
                tb_table_campania.ajax.reload();
                $('#mdl_insertar_campania').modal('hide');
            } else {
                alertify.error('Se debe agregar ambos campos');  
            } 
        }
    });        
   

}