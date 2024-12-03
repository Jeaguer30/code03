/* funciones para exportar pdf de ruteo */

   
    function generar_consulta_equipo(){
            
        //cod=id_cliente1;
        var cod = $('#id_cliente1').val();


        if(cod!=''){
        var url = 'https://geochasqui.com/sistema_geo/Controller_exportar_geo/generar_pdf_consulta_edf/'+cod; 
            window.open(url, '_blank');
        }else{
            alerta_error('error','Ingrese el código del cliente.','Resultado');
        }
    }

    function generar_consulta_equipo_unico(id){
            
        //cod=id_cliente1;
        var cod = $('#id_cliente1').val();
        var id= id;


        if(cod!=''){
        var url = 'https://geochasqui.com/sistema_geo/Controller_exportar_geo/generar_pdf_consulta_edf_unico/' + cod+ '/' + id;; 
        window.open(url, '_blank');
        }else{
        alerta_error('error','Ingrese el código del cliente.','Resultado');
        }
    }


    function generar_preaviso(cod){
        
        if(cod!=''){
        var url = 'https://geochasqui.com/sistema_geo/Controller_exportar_geo/generar_pdf_x_codcliente/'+cod; 
        window.open(url, '_blank');
        }else{
        alerta_error('error','Ingrese el código del cliente.','Resultado');
        }
    }

    function generar_notarial(cod){

        if(cod!=''){
        var url = 'https://geochasqui.com/sistema_geo/Controller_exportar_geo/generar_pdf_x_cliente_cn/'+cod; 
        window.open(url, '_blank');
        }else{
        alerta_error('error','Ingrese el código del cliente.','Resultado');
        }
    }

/* fin */