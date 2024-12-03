
    /********************************************************************************************************* */
    function alerta_icono_ok(id){
        $('#'+id).css('border','1px solid green');
        $('#'+id+'_msj').html('<img width="16px" style="margin-left:4px;" src="public/img/iconos/check_button.png">');
    }

    function alerta_icono_error(id){
        $('#'+id).css('border','1px solid red');
        $('#'+id+'_msj').html('<img width="16px" style="margin-left:4px;" src="public/img/iconos/error_button.png">');
    }

    function validador_inputs(id,tipo){
        if($('#'+id).val()!=''){
            switch (tipo) {
                case 'texto':
                    alerta_icono_ok(id);
                    break;
                case 'date':
                    if(validador_fecha){
                        alerta_icono_ok(id);
                    } else{
                        alerta_icono_error(id);
                    }
                    break;
            
                default:
                    break;
            }

        }else{
            alerta_icono_error(id);
        }
    }

    function validador_fecha(){
        //mi validacion de fecha
    }
    /********************************************************************************************************* */

    





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
    }

/* fin */