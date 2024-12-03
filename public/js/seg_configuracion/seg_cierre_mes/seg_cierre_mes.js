/* funciones para añadir transportista */

    function ver_mdl(tipo){
        switch (tipo) {
            case 'mdl_new_year':
                $('#mdl_new_year').modal('show');
                
                break;
            case 'mdl_new_week':
                $('#mdl_new_week').modal('show');
                
                break;
        
            default:
                break;
        }

    }

    function add_new_year() {
            
        var anio_cierre = $('#txt_year').val();
        var mes_cierre = $('#txt_month').val();       
        var status = $('#txt_estado').is(':checked') ? 1 : 0;
       
        $.ajax({
            type: "POST",
            url: 'https://geochasqui.com/sistema_geo/Controller_cierres_mes_lindley/add_new_year',
            data: {
                'anio_cierre': anio_cierre,
                'mes_cierre': mes_cierre,
                'status': status         
            },
            beforeSend: function () {
                // Código de beforeSend
            },
            success: function (data) {
                if (data == '1') {
                    alertify.success('Registrado el nuevo mes de cierre');
                    //tb_table_anio_mes_campania.ajax.reload();
                    $('#mdl_new_year').modal('hide');
                    tb_table_anio_mes.ajax.reload();
                } else {
                    //alertify.error('Se debe agregar el tipo de base');
                }
            }
        });
    }

    function add_new_week() {
        
        var anio_semana_cierre = $('#txt_year_week').val();
        var semana_cierre = $('#txt_week').val();       
        var status_week = $('#txt_estado_week').is(':checked') ? 1 : 0;
       
        $.ajax({
            type: "POST",
            url: 'https://geochasqui.com/sistema_geo/Controller_cierres_mes_lindley/add_new_week',
            data: {
                'anio_semana_cierre': anio_semana_cierre,
                'semana_cierre': semana_cierre,
                'status_week': status_week         
            },
            beforeSend: function () {
                // Código de beforeSend
            },
            success: function (data) {
                if (data == '1') {
                    alertify.error('Semana Existente');
                    
                } else {
                   
                    //tb_table_anio_mes_campania.ajax.reload();
                    $('#mdl_new_week').modal('hide');
                    tb_table_semanal.ajax.reload();
                }
            }
        });
    }


  

/* fin */


/* funciones para actualizar */
 
function edit_week(id) {
    //limpiar_formulario();
    $.ajax({
        type: "POST",
        //dataType: 'json',
        url: 'https://geochasqui.com/sistema_geo/Controller_cierres_mes_lindley/edit_week',
        data: {
            'id':id
        }, 
        beforeSend:function(){
        },   
        success: function(e){ 
            // id_upd=coduser;
            var res = jQuery.parseJSON(e);  
            if(res.mensaje!='error'){
    
                $('#id_week').val(res.id);  
                $('#txt_year_week_edit').val(res.id_cierre_mes);   
                select_year_week_edit();

                $('#txt_week_edit').val(res.descripcion);   
                $('#txt_estado_week_edit').prop('checked', res.deshab == 1);  
                $('#mdl_edit_week').modal('show');

            }else{
            }

            
        }
    });    

}

function update_week() {
    var id_week = $('#id_week').val();
    var year_week_edit = $('#txt_year_week_edit').val();
    var week_edit = $('#txt_week_edit').val();       
    var estado_week_edit = $('#txt_estado_week_edit').is(':checked') ? 1 : 0;
   
    $.ajax({
        type: "POST",
        url: 'https://geochasqui.com/sistema_geo/Controller_cierres_mes_lindley/update_week',
        data: {
            'id_week': id_week,
            'year_week_edit': year_week_edit,
            'week_edit': week_edit,
            'estado_week_edit': estado_week_edit         
        },
        beforeSend: function () {
            // Código de beforeSend
        },
        success: function (data) {
            if (data == '1') {
                alertify.success('Registro actualizado correctamente');  

                $('#mdl_edit_week').modal('hide');
                tb_table_semanal.ajax.reload();
            } else {
                //alertify.error('Se debe agregar el tipo de base');
            }
        }
    });

}
/* fin */


/* limpiar formulario */

   

/* fin */