/* funciones para exportar pdf de ruteo */

    function generar_preaviso_1(cod){
        
        if(cod!=''){
        var url = 'https://geochasqui.com/sistema_geo/Controller_exportar_geo/generar_pdf_x_codcliente/'+cod; 
        window.open(url, '_blank');
        }else{
        alerta_error('error','Ingrese el código del cliente.','Resultado');
        }
    }

    function generar_notarial_1(cod){
        if(cod!=''){
        var url = 'https://geochasqui.com/sistema_geo/Controller_exportar_geo/generar_pdf_x_cliente_cn_asig_avance/'+cod; 
        window.open(url, '_blank');
        }else{
        alerta_error('error','Ingrese el código del cliente.','Resultado');
        }
    }

/* fin */