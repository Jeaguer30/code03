<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Modelo_formulario extends CI_Model
{   


     /*CONEXIÓN A LA OTRA BD ASTERISK 05/11/2024*/
     public function obtener_uniqueid($user,$phone_number){
        $DB2 = $this->load->database('asterisk_db', TRUE);
        $DB2->select('*');
        $DB2->from('asterisk.vicidial_log');
        $DB2->where('user', $user);
        $DB2->where('phone_number', $phone_number);
        $DB2->order_by('call_date', 'DESC');

        $query = $DB2->get();

        if($query->num_rows() > 0){
            foreach ($query->result() as $row){
                return $row->uniqueid;
            }
        }else{
            return 'error';
        }
    }

    
    /*
        Para paginación
    */
    function get_total_registros_pag($table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->join('cvc_clientes_libres b','a.id_cliente=b.id','left');
        $this->db->join('cvc_call as c','a.id_call=c.id','left');
       // $cn = 0;

        if(isset($_SESSION['SESSION_SOL_ESTADO'])){
            $this->db->where('a.id_estado_solicitud',$_SESSION['SESSION_SOL_ESTADO']);
         //   $cn = 1;   
        }
        
        if(isset($_SESSION['SESSION_SOL_MES'])){
            $this->db->where('month(date(a.f_registro))',$_SESSION['SESSION_SOL_MES']);
         //   $cn = 1;   
        }   
/*
        if(isset($_SESSION['SESSION_DATO_BUSCAR'])){
            $this->db->where("(b.razon_social like '%".$_SESSION['SESSION_DATO_BUSCAR']."%' or b.ruc like '%".$_SESSION['SESSION_DATO_BUSCAR']."%' or b.codigo_iscom like '%".$_SESSION['SESSION_DATO_BUSCAR']."%' or b.nro_suministro_distri like '%".$_SESSION['SESSION_DATO_BUSCAR']."%')", NULL, FALSE);
           // $cn = 1;   
        } */


        // Condición por defecto si no hay filtros aplicados
        // if($cn == 0){
        //$this->db->where('a.del', 50);
            
       // }
        $this->db->where('c.uniqueid', $_SESSION['_SESSION_UNIQUE_ID']);
        //$this->db->where('a.del=0');
        $query = $this->db->get();
        return $query->num_rows(); 
    }

    /*
        Get Indicadores
    */
    function get_totales_indicador($table,$table2){
        $this->db->select('a.id_estado_solicitud,b.descripcion,count(a.id_estado_solicitud) as total');
        $this->db->from($table.' as a');
        $this->db->join($table2.' as b','a.id_estado_solicitud=b.id','left');
        $this->db->where('del=0');
        $this->db->group_by('a.id_estado_solicitud');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        } 
    }

    function eliminar($table,$id)
    {
        return $this->db->delete($table, array('id' => $id));
    }  

    /*
        detalle
    */
    function update($table,$array,$id,$campo){
        $this->db->where($campo,$id);
        return $this->db->update($table,$array);
    }
    
    function insert($table,$array){
        return $this->db->insert($table,$array);
    }


    function insert_call($table, $array) {
        $this->db->insert($table, $array);
        return $this->db->insert_id(); // Retorna el ID de la fila insertada
    }
    

    function get_select($table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('estado',0);
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        } 
    }

    function get_select_x_id($table,$id,$campo){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($campo,$id);
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        } 
    }

    function get_select_x_id_join($table,$id,$campo,$table2,$table3,$table4,$table5 ){
        $this->db->select('a.*,b.nombres,c.id_motivo, d.descripcion as motivo_llamada, c.nombres_cliente,c.id_tipo_llamada,c.celular,e.descripcion as des_saliente');
        $this->db->from($table);
        $this->db->join($table2,'a.id_usuario=b.coduser','left');
        $this->db->join($table3,'a.id_call=c.id','left');
        $this->db->join($table4,'c.id_motivo= d.id','left');
        $this->db->join($table5,'c.contacto_saliente= e.id','left');
        $this->db->where($campo,$id);
        $this->db->order_by('a.f_registro desc');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        } 
    }

    function get_registros_condicion($table,$dato){
        $this->db->select('*');
        $this->db->from($table); 
        $this->db->where("(razon_social like '%".$dato."%' or ruc like '%".$dato."%' or codigo_iscom like '%".$dato."%' or nro_suministro_distri like '%".$dato."%')", NULL, FALSE);
        //$this->db->where($campo,$id);
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        } 
    }

    
    /*
        OBTENER SOLICITUDES
    */
    function get_registros($table,$limite,$paginacion){
        $this->db->select('a.*,b.razon_social,b.status,b.ruc,b.codigo_iscom,
        b.cuenta_sd,b.mes_deuda,b.nro_dias_pago,b.osinergmin,
        b.distribuidor_local,b.nro_suministro_distri,b.alimentador,b.pmi,b.direccion_suministro,b.distrito,b.provincia,b.departamento,c.nombres');
        $this->db->from($table);
        $this->db->join('cvc_clientes_libres b','a.id_cliente=b.id','left');
        $this->db->join('tb_usuarios c','a.id_usuario=c.coduser','left');
        $this->db->join('cvc_call d','a.id_call=d.id','left');
        //$this->db->where('a.del',0);
      //  $cn = 0;

        if(isset($_SESSION['SESSION_SOL_ESTADO'])){
            $this->db->where('a.id_estado_solicitud',$_SESSION['SESSION_SOL_ESTADO']);
           // $cn = 1;
        }
      
        if(isset($_SESSION['SESSION_SOL_MES'])){
            $this->db->where('month(date(a.f_registro))',$_SESSION['SESSION_SOL_MES']);
            //$cn = 1;
        } 


        /*
        if(isset($_SESSION['SESSION_DATO_BUSCAR'])){
            $this->db->where("(razon_social like '%".$_SESSION['SESSION_DATO_BUSCAR']."%' or ruc like '%".$_SESSION['SESSION_DATO_BUSCAR']."%' or codigo_iscom like '%".$_SESSION['SESSION_DATO_BUSCAR']."%' or nro_suministro_distri like '%".$_SESSION['SESSION_DATO_BUSCAR']."%')", NULL, FALSE);
           // $cn = 1;
        } */

   

        //if($cn == 0){
        //    $this->db->where('a.del', 50);
            
        //}


        $this->db->where('d.uniqueid', $_SESSION['_SESSION_UNIQUE_ID']);
       // $this->db->order_by('a.f_registro','desc');
       // $this->db->limit($limite,$paginacion);
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        } 
    }

    function get_filtro_mes($table){
        $this->db->select('
            month(date(f_registro)) as mes
            ,CASE
                WHEN month(date(f_registro))= 1 THEN "ENERO"
                WHEN month(date(f_registro))= 2 THEN "FEBRERO"
                WHEN month(date(f_registro))= 3 THEN "MARZO"
                WHEN month(date(f_registro))= 4 THEN "ABRIL"
                WHEN month(date(f_registro))= 5 THEN "MAYO"
                WHEN month(date(f_registro))= 6 THEN "JUNIO"
                WHEN month(date(f_registro))= 7 THEN "JULIO"
                WHEN month(date(f_registro))= 8 THEN "AGOSTO"
                WHEN month(date(f_registro))= 9 THEN "SEPTIEMBRE"
                WHEN month(date(f_registro))= 10 THEN "OCTUBRE"
                WHEN month(date(f_registro))= 11 THEN "NOVIEMBRE"
                WHEN month(date(f_registro))= 12 THEN "DICIEMBRE"
                ELSE ""
            END AS descripcion
        ');
        $this->db->from($table);
        $this->db->where('del',0);
        $this->db->group_by('month(date(f_registro))');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        } 
    }













    /**/
    function make_datatables($table){
        $this->make_query($table);
        if($_POST["length"] != -1)
        {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    function make_query($table)
    {  
        $this->db->select('a.*,b.descripcion as tipo_servicio');
        $this->db->from($table.' as a');
        $this->db->join('tb_tipo_servicio as b','a.id_tipo_servicio=b.id','left');
        if(isset($_POST["search"]["value"]))
        {
            $busc = $_POST["search"]["value"];
            $this->db->where("(a.descripcion LIKE '%".$busc."%')", NULL, FALSE);
        }            
        $this->db->order_by('a.f_registro asc');
    }

    function get_all_data($table)
    {
        $this->db->select('a.*,b.descripcion as tipo_servicio');
        $this->db->from($table.' as a');
        $this->db->join('tb_tipo_servicio as b','a.id_tipo_servicio=b.id','left');
        return $this->db->count_all_results();
    }  
      
    function get_filtered_data($table){
        $this->make_query($table);
        $query = $this->db->get();
        return $query->num_rows();
    }      
    /**/

    function list($table,$table2=null){
        $this->db->select('a.*,b.descripcion as tipo_servicio');
        $this->db->from($table.' as a');
        $this->db->join($table2.' as b','a.id_tipo_servicio=b.id','left');
        $this->db->order_by('tipo_servicio desc');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'ok';
        } 
    }

    function validar($table,$dato,$id)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('id!=',$id);
        $this->db->where('descripcion',$dato);
        return $this->db->count_all_results();
    }  

    function validar_x_id($table,$dato)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('id',$dato);
        return $this->db->count_all_results();
    }  

    function get_data_x_id($table,$id){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('id',$id);
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        } 
    }

    function get_data_x_uniq($table,$id){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('uniqueid',$id);
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        } 
    }

    
    




    function get_datos($table,$id){
        $this->db->select('a.*,b.descripcion as puesto,b.descripcion as area');
        $this->db->from($table.' as a');
        $this->db->join('tb_tipouser as b','a.tipo_user=b.id','left');
        $this->db->where('a.coduser',$id);
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        } 
    }


    function get_data_load($table){
        $this->db->select('*');
        $this->db->from($table);      
        //$this->db->where('a',$id);

        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        } 
    }

    function validar_seguimiento($table,$dato)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('id_cliente',$dato);
        $this->db->where_in('id_estado_solicitud', array(2, 3, 5)); // en espera , enseguimiento , no requiere seguimiento
        $this->db->where('del',0);
    
        return $this->db->count_all_results();
    }  



    function get_registros_call($table,$limite,$paginacion){

        $this->db->select(' a.*,b.razon_social,b.status,b.ruc,b.codigo_iscom,
                            b.cuenta_sd,b.mes_deuda,b.nro_dias_pago,b.osinergmin,
                            b.distribuidor_local,b.nro_suministro_distri,b.alimentador,
                            b.pmi,b.direccion_suministro,b.distrito,b.provincia,
                            b.departamento,c.nombres,d.id_motivo,d.id as id_call, e.descripcion as motivo_llamada');
        $this->db->from($table);
        $this->db->join('cvc_clientes_libres b','a.id_cliente=b.id','left');
        $this->db->join('tb_usuarios c','a.id_usuario=c.coduser','left');
        $this->db->join('cvc_call d','a.id_call=d.id','left');
        $this->db->join('cvc_call_motivo e','d.id_motivo =e.id','left');
        $this->db->where('a.del',0);
        //$this->db->where('a.id_cliente',$id_cliente);

        $this->db->where('a.id_cliente', $_SESSION['_SESSION_CODIGO_CLIENTE']);


        //$this->db->where('a.id_cliente', 248);


        if(isset($_SESSION['SESSION_ESTADO_SEGUIMIENTO'])){
            
            $this->db->where_in('a.id_estado_solicitud', $_SESSION['SESSION_ESTADO_SEGUIMIENTO']);
        } 
        

        //$this->db->where('d.uniqueid', $_SESSION['_SESSION_UNIQUE_ID']);
        $this->db->order_by('a.f_registro','desc');
       // $this->db->limit($limite,$paginacion);
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        } 
    }


    function get_solicitudes(){

        $this->db->select(' a.*,b.razon_social,b.status,b.ruc,b.codigo_iscom,
                            b.cuenta_sd,b.mes_deuda,b.nro_dias_pago,b.osinergmin,
                            b.distribuidor_local,b.nro_suministro_distri,b.alimentador,
                            b.pmi,b.direccion_suministro,b.distrito,b.provincia,
                            b.departamento,c.nombres,d.nombres_cliente,d.celular,d.parentesco, e.descripcion as motivo_llamada,f.descripcion as estado_solicitud');
        $this->db->from('cvc_solicitudes a');
        $this->db->join('cvc_clientes_libres b','a.id_cliente=b.id','left');
        $this->db->join('tb_usuarios c','a.id_usuario=c.coduser','left');
        $this->db->join('cvc_call d','a.id_call=d.id','left');
        $this->db->join('cvc_call_motivo e','d.id_motivo =e.id','left');
        $this->db->join('cvc_estado_solicitud f','a.id_estado_solicitud =f.id','left');
        $this->db->where('a.del',0);
        $cn = 0;

        if(isset($_SESSION['_SESSION_CODIGO_CLIENTE1'])){
            $this->db->where('a.id_cliente',$_SESSION['_SESSION_CODIGO_CLIENTE1']);
            $cn = 1;
        } 
        //Condición por defecto si no hay filtros aplicados
        if($cn == 0){
            $this->db->where('a.del', 50);
        }

        //$this->db->where('a.id_cliente', $_SESSION['_SESSION_CODIGO_CLIENTE']);
    
        $this->db->order_by('a.f_registro','desc');   
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        } 
    }


    function get_clientes(){

        $this->db->select('a.*');
        $this->db->from('cvc_clientes_libres a');
        $cn = 0;

        if(isset($_SESSION['_SESSION_CODIGO_CLIENTE3'])){
            //$this->db->where('a.codigo_iscom',$_SESSION['_SESSION_CODIGO_CLIENTE3']);
            $this->db->like('a.codigo_iscom', $_SESSION['_SESSION_CODIGO_CLIENTE3']);
            $cn = 1;
        } 

        if($cn == 0){
            $this->db->where('a.del', 50);
        }

        $this->db->limit('3');   
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        } 
    }


    function get_distribuidores(){

        $this->db->select(' a.*');
        $this->db->from('cvc_contactos_distribuidores a');
        //$this->db->where('a.del',0);

        /*if(isset($_SESSION['_SESSION_DISTRIBUIDOR'])){
         //$this->db->where('a.codigo_iscom',$_SESSION['_SESSION_CODIGO_CLIENTE3']);
            $this->db->where('a.id',$_SESSION['_SESSION_DISTRIBUIDOR']);
        } */

        //$this->db->where('a.id_cliente', $_SESSION['_SESSION_CODIGO_CLIENTE']);
    
      //  $this->db->order_by('a.f_registro','desc');   
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        } 
    }


    function get_distribuidores_telefonos(){
        $this->db->select('a.codigo_iscom, b.descripcion, b.area, b.telefono');
        $this->db->from('cvc_clientes_libres a');
        $this->db->join('cvc_contactos_distribuidores b', 'a.distribuidor_local = b.descripcion');
        $this->db->where('a.codigo_iscom', $_SESSION['_SESSION_CODIGO_ISCOM_1']);
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        } 
    }

    function get_distribuidores_correos(){
        $this->db->select('a.codigo_iscom, b.descripcion, b.correo');
        $this->db->from('cvc_clientes_libres a');
        $this->db->join('cvc_correos_distribuidores b', 'a.distribuidor_local = b.descripcion');
        $this->db->where('a.codigo_iscom', $_SESSION['_SESSION_CODIGO_ISCOM_2']);
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        } 
    }





    function get_solicitudes_cvc(){

        $this->db->select(' a.*');
        $this->db->from('cvc_contactos_distribuidores a');

        if(isset($_SESSION['SESSION_CONTACTO_DISTRIBUIDOR_CVC'])){
            $this->db->where('a.descripcion',$_SESSION['SESSION_CONTACTO_DISTRIBUIDOR_CVC']);
        }
        $this->db->where('a.del',0);
        $this->db->order_by('a.descripcion','asc');  
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        } 
    }

    
    function grupos_contacto_solicitud(){

        $this->db->select('a.descripcion, count(a.id) as cantidad_contactos');
        $this->db->from('cvc_contactos_distribuidores a');

        if(isset($_SESSION['SESSION_CONTACTO_DISTRIBUIDOR_CVC'])){
            $this->db->where('a.descripcion',$_SESSION['SESSION_CONTACTO_DISTRIBUIDOR_CVC']);
        }
        $this->db->where('a.del',0);
        $this->db->group_by('a.descripcion');
        $this->db->order_by('a.descripcion','asc'); 
          
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        } 
    }








    function get_correos_distribuidor_cvc(){

        $this->db->select('a.*');
        $this->db->from('cvc_correos_distribuidores a');

        if(isset($_SESSION['SESSION_CONTACTO_DISTRIBUIDOR_CVC'])){
            $this->db->where('a.descripcion',$_SESSION['SESSION_CONTACTO_DISTRIBUIDOR_CVC']);
        }
        $this->db->where('a.del',0);
        $this->db->order_by('a.descripcion','asc');  
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        } 
    }

    
    function grupos_correos_distribuidor_cvc(){

        $this->db->select('a.descripcion, count(a.id) as cantidad_contactos');
        $this->db->from('cvc_correos_distribuidores a');

        if(isset($_SESSION['SESSION_CONTACTO_DISTRIBUIDOR_CVC'])){
            $this->db->where('a.descripcion',$_SESSION['SESSION_CONTACTO_DISTRIBUIDOR_CVC']);
        }
        $this->db->where('a.del',0);
        $this->db->group_by('a.descripcion');
        $this->db->order_by('a.descripcion','asc'); 
          
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        } 
    }






    function get_contactos_area_cvc(){

        $this->db->select(' a.*');
        $this->db->from('cvc_contactos_area_cvc a');

        if(isset($_SESSION['SESSION_CONTACTOS_CVC'])){
            $this->db->where('a.emergencia',$_SESSION['SESSION_CONTACTOS_CVC']);
        }
    
        $this->db->order_by('a.emergencia','asc');  
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        } 
    }

    
    function grupos_contacto_emergencia(){

        $this->db->select('a.emergencia, count(a.id) as cantidad_contactos');
        $this->db->from('cvc_contactos_area_cvc a');

        if(isset($_SESSION['SESSION_CONTACTOS_CVC'])){
            $this->db->where('a.emergencia',$_SESSION['SESSION_CONTACTOS_CVC']);
        }

        $this->db->group_by('a.emergencia');
        $this->db->order_by('a.emergencia','asc'); 
          
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        } 
    }

    




    //tabla para visualizar los contactos de emergencia
    function get_data_load_contacto_emergencia(){

        $this->db->select('a.*');
        $this->db->from('cvc_contactos_area_cvc a');
        $this->db->group_by('a.emergencia');
        $this->db->order_by('a.emergencia','asc'); 
          
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        } 
    }



    function get_data_load_contacto_distribuidor(){

        $this->db->select('a.*');
        $this->db->from('cvc_contactos_distribuidores a');
        $this->db->group_by('a.descripcion');
        $this->db->order_by('a.descripcion','asc'); 
        $this->db->where('a.del',0);
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        } 
    }
    




}