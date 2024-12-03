/* funciones para añadir transportista */

    function ver_mdl(tipo){
        switch (tipo) {
            case 'mdl_add_paleta_equipo':
                $('#mdl_add_paleta_equipo').modal('show');
                
                break;
            case 'mdl_add_paleta_visita':
                $('#mdl_add_paleta_visita').modal('show');
                
                break;
        
            default:
                break;
        }

    }

    function add_new_paleta_visita(){
        var tipo_gestion = $('#txt_tipo_gestion_vis').val(); 
        var descripcion = $('#txt_descripcion_vis').val(); 
        var conclusion = $('#txt_conclusion_vis').val(); 
        var resultado = $('#txt_resultado_vis').val(); 

        // Obtener el estado de las casillas de verificación
        var hab_edfs = $('#Hab_edfs_vis').is(':checked') ? 1 : 0;
        var req_imagen = $('#Req_imagen_vis').is(':checked') ? 1 : 0;
        var base_validacion = $('#Base_validacion_vis').is(':checked') ? 1 : 0;
        var otras_bases = $('#Otras_bases_vis').is(':checked') ? 1 : 0;
        var base_censo = $('#Base_censo_vis').is(':checked') ? 1 : 0;
        var base_filtros = $('#Base_filtros_vis').is(':checked') ? 1 : 0;

        if (!descripcion) {alertify.error('Completa el campo Descripción');return;}
        if (!resultado) {alertify.error('Selecione el Resultado');return;}

        $.ajax({
            type: "POST",
            url: 'https://geochasqui.com/sistema_geo/Controller_paletas_lindley/add_new_paleta_visita',
            data: {                
                'tipo_gestion':tipo_gestion,
                'descripcion':descripcion,
                'conclusion':conclusion,
                'resultado':resultado,     
                
                'hab_edfs': hab_edfs,
                'req_imagen': req_imagen,
                'base_validacion': base_validacion,
                'otras_bases': otras_bases,
                'base_censo': base_censo,
                'base_filtros': base_filtros
            }, 
            beforeSend:function(){
            },   
            success: function(data){   
            
                if (data=='1') {
                    alertify.success('Nueva paleta de Visita Registrada');
                    //tb_table_campania.ajax.reload();
                    $('#mdl_add_paleta_visita').modal('hide');
                    tb_table_paleta_equipo.ajax.reload();
                } else {
                    alertify.error('Se debe agregar el tipo de base');  
                } 
            }
        });
    }


    function add_new_paleta_equipo() {
       
        var tipo_gestion = $('#txt_tipo_gestion').val();
        var descripcion = $('#txt_descripcion').val();
        var conclusion = $('#txt_conclusion').val();
        var resultado = $('#txt_resultado').val();

        // Obtener el estado de las casillas de verificación
        var hab_pro = $('#Hab_pro').is(':checked') ? 1 : 0;
        var req_imagen = $('#Req_imagen').is(':checked') ? 1 : 0;
        var base_validacion = $('#Base_validacion').is(':checked') ? 1 : 0;
        var otras_bases = $('#Otras_bases').is(':checked') ? 1 : 0;
        var base_censo = $('#Base_censo').is(':checked') ? 1 : 0;
        var base_filtros = $('#Base_filtros').is(':checked') ? 1 : 0;

        if (!descripcion) {alertify.error('Completa el campo Descripción');return;}
        if (!resultado) {alertify.error('Selecione el Resultado');return;}

        $.ajax({
            type: "POST",
            url: 'https://geochasqui.com/sistema_geo/Controller_paletas_lindley/add_new_paleta_equipo',
            data: {
                'tipo_gestion': tipo_gestion,
                'descripcion': descripcion,
                'conclusion': conclusion,
                'resultado': resultado,

                'hab_pro': hab_pro,
                'req_imagen': req_imagen,
                'base_validacion': base_validacion,
                'otras_bases': otras_bases,
                'base_censo': base_censo,
                'base_filtros': base_filtros
            },
            beforeSend: function () {
                // Código de beforeSend
            },
            success: function (data) {
                if (data == '1') {
                    alertify.success('Nueva paleta de Equipo Registrada');
                    //tb_table_campania.ajax.reload();
                    $('#mdl_add_paleta_equipo').modal('hide');
                    tb_table_paleta_equipo.ajax.reload();
                    limpiar_formulario();
                } else {
                    alertify.error('Se debe agregar el tipo de base');
                }
            }
        });
    }

/* fin */


/* funciones para actualizar */
 
    function edit_equipo(id) {
        limpiar_formulario();
        $.ajax({
            type: "POST",
            //dataType: 'json',
            url: 'https://geochasqui.com/sistema_geo/Controller_paletas_lindley/edit_equipo',
            data: {
                'id':id
            }, 
            beforeSend:function(){
            },   
            success: function(e){ 
                // id_upd=coduser;
                var res = jQuery.parseJSON(e);
                if(res.mensaje!='error'){
                    $('#txt_id').val(res.id); 
                    $('#txt_tipo_gestion_edit').val(res.tipo_gestion);                      
                    $('#txt_descripcion_edit').val(res.descripcion);
                    $('#txt_conclusion_edit').val(res.conclusion);
                    $('#txt_resultado_edit').val(res.resultado);                           
                    // Marcamos el checkbox solo si res.hab_pro es igual a 1
                    $('#Hab_pro_edit').prop('checked', res.hab_pro == 1);
                    $('#Req_imagen_edit').prop('checked', res.req_img == 1);
                    $('#Base_validacion_edit').prop('checked', res.base_validacion == 1);
                    $('#Otras_bases_edit').prop('checked', res.otras_bases == 1);
                    $('#Base_censo_edit').prop('checked', res.base_censo == 1);
                    $('#Base_filtros_edit').prop('checked', res.base_filtros == 1);
                
                    $('#mdl_edit_paleta_equipo').modal('show');

                }else{
                }
            }
        });    
    
    }

    function edit_visita(id) {
        limpiar_formulario();
        $.ajax({
            type: "POST",
            //dataType: 'json',
            url: 'https://geochasqui.com/sistema_geo/Controller_paletas_lindley/edit_visita',
            data: {
                'id':id
            }, 
            beforeSend:function(){
            },   
            success: function(e){ 
                // id_upd=coduser;
                var res = jQuery.parseJSON(e);
                if(res.mensaje!='error'){
                    $('#txt_vis_id').val(res.id); 
                    $('#txt_tipo_gestion_vis_edit').val(res.tipo_gestion);                      
                    $('#txt_descripcion_vis_edit').val(res.descripcion);
                    $('#txt_conclusion_vis_edit').val(res.conclusion);
                    $('#txt_resultado_vis_edit').val(res.resultado);                           
                    // Marcamos el checkbox solo si res.hab_pro es igual a 1
                    $('#Hab_edfs_vis_edit').prop('checked', res.hab_edfs == 1);
                    $('#Req_imagen_vis_edit').prop('checked', res.req_img == 1);
                    $('#Base_validacion_vis_edit').prop('checked', res.base_validacion == 1);
                    $('#Otras_bases_vis_edit').prop('checked', res.otras_bases == 1);
                    $('#Base_censo_vis_edit').prop('checked', res.base_censo == 1);
                    $('#Base_filtros_vis_edit').prop('checked', res.base_filtros == 1);
                
                    $('#mdl_edit_paleta_visita').modal('show');

                }else{
                }
            }
        });    
    
    }

    function upd_paleta_equipo() {
        var txt_id = $('#txt_id').val();
        var tipo_gestion = $('#txt_tipo_gestion_edit').val();
        var descripcion = $('#txt_descripcion_edit').val();
        var conclusion = $('#txt_conclusion_edit').val();
        var resultado = $('#txt_resultado_edit').val();

        // Obtener el estado de las casillas de verificación
        var hab_pro = $('#Hab_pro_edit').is(':checked') ? 1 : 0;
        var req_imagen = $('#Req_imagen_edit').is(':checked') ? 1 : 0;
        var base_validacion = $('#Base_validacion_edit').is(':checked') ? 1 : 0;
        var otras_bases = $('#Otras_bases_edit').is(':checked') ? 1 : 0;
        var base_censo = $('#Base_censo_edit').is(':checked') ? 1 : 0;
        var base_filtros = $('#Base_filtros_edit').is(':checked') ? 1 : 0;

        $.ajax({
            type: "POST",
            url: 'https://geochasqui.com/sistema_geo/Controller_paletas_lindley/upd_paleta_equipo',
            data: {
                'txt_id': txt_id,
                'tipo_gestion': tipo_gestion,
                'tipo_gestion': tipo_gestion,
                'descripcion': descripcion,
                'conclusion': conclusion,
                'resultado': resultado,

                'hab_pro': hab_pro,
                'req_imagen': req_imagen,
                'base_validacion': base_validacion,
                'otras_bases': otras_bases,
                'base_censo': base_censo,
                'base_filtros': base_filtros
            },
            beforeSend: function () {
                // Código de beforeSend
            },
            success: function (data) {
                if (data == '1') {
                    alertify.success('Actualizado paleta de Equipo');
                    //tb_table_campania.ajax.reload();
                    $('#mdl_edit_paleta_equipo').modal('hide');
                    tb_table_paleta_equipo.ajax.reload();
                } else {
                    //alertify.error('Se debe agregar el tipo de base');
                }
            }
        });
    }

    function upd_paleta_visita() {
        var txt_id = $('#txt_vis_id').val();
        var tipo_gestion = $('#txt_tipo_gestion_vis_edit').val();
        var descripcion = $('#txt_descripcion_vis_edit').val();
        var conclusion = $('#txt_conclusion_vis_edit').val();
        var resultado = $('#txt_resultado_vis_edit').val();

        // Obtener el estado de las casillas de verificación
        var hab_edfs = $('#Hab_edfs_vis_edit').is(':checked') ? 1 : 0;
        var req_imagen = $('#Req_imagen_vis_edit').is(':checked') ? 1 : 0;
        var base_validacion = $('#Base_validacion_vis_edit').is(':checked') ? 1 : 0;
        var otras_bases = $('#Otras_bases_vis_edit').is(':checked') ? 1 : 0;
        var base_censo = $('#Base_censo_vis_edit').is(':checked') ? 1 : 0;
        var base_filtros = $('#Base_filtros_vis_edit').is(':checked') ? 1 : 0;

        $.ajax({
            type: "POST",
            url: 'https://geochasqui.com/sistema_geo/Controller_paletas_lindley/upd_paleta_visita',
            data: {
                'txt_id': txt_id,
                'tipo_gestion': tipo_gestion,
                'tipo_gestion': tipo_gestion,
                'descripcion': descripcion,
                'conclusion': conclusion,
                'resultado': resultado,

                'hab_edfs': hab_edfs,
                'req_imagen': req_imagen,
                'base_validacion': base_validacion,
                'otras_bases': otras_bases,
                'base_censo': base_censo,
                'base_filtros': base_filtros
            },
            beforeSend: function () {
                // Código de beforeSend
            },
            success: function (data) {
                if (data == '1') {
                    alertify.success('Actualizado paleta de Visita');
                    //tb_table_campania.ajax.reload();
                    $('#mdl_edit_paleta_visita').modal('hide');
                    tb_table_paleta_visita.ajax.reload();
                } else {
                    //alertify.error('Se debe agregar el tipo de base');
                }
            }
        });
    }

/* fin */


/* limpiar formulario */

    function limpiar_formulario(){  
        var d = new Date(); 
        var format =  d.getDate() + "-" + (d.getMonth()+1) + "-" +  d.getFullYear();
        //insert equipo
        $("#txt_tipo_gestion").val('');
        $("#txt_descripcion").val('');
        $("#txt_conclusion").val('');
        $("#txt_resultado").val('');
        $("#Hab_pro").val('');
        $("#Req_imagen").val('');
        $("#Base_validacion").val('');
        $("#Otras_bases").val('');       
        $("#Base_censo").val('');  
        $("#Base_filtros").val('');  
        //edit equipo
        $("#txt_tipo_gestion_edit").val('');
        $("#txt_descripcion_edit").val('');
        $("#txt_conclusion_edit").val('');
        $("#txt_resultado_edit").val('');
        $("#Hab_pro_edit").val('');
        $("#Req_imagen_edit").val('');
        $("#Base_validacion_edit").val('');
        $("#Otras_bases_edit").val('');       
        $("#Base_censo_edit").val('');  
        $("#Base_filtros_edit").val('');
        
        //edit visit
        $("#txt_tipo_gestion_vis_edit").val('');
        $("#txt_descripcion_vis_edit").val('');
        $("#txt_conclusion_vis_edit").val('');
        $("#txt_resultado_vis_edit").val('');
        $("#Hab_edfs_vis_edit").val('');
        $("#Req_imagen_vis_edit").val('');
        $("#Base_validacion_vis_edit").val('');
        $("#Otras_bases_vis_edit").val('');       
        $("#Base_censo_vis_edit").val('');  
        $("#Base_filtros_vis_edit").val('');  


    }

/* fin */