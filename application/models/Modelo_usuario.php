<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Modelo_usuario extends CI_Model
{   
     /* /**/
     function make_datatables(){
        $this->make_query();
        if($_POST["length"] != -1)
        {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    function make_query()
    {         
        $this->db->select('a.*,b.descripcion');
        $this->db->from('tb_usuarios a');
        $this->db->join('tb_tipouser b','a.tipo_user=b.id','left');
        $this->db->where('a.del',0);     
        
        if (isset($_SESSION['FILTRO_TIPO_USER'])) {
            $this->db->where('a.tipo_user',$_SESSION['FILTRO_TIPO_USER']);           
        }

        if (isset($_SESSION['FILTRO_ESTADO'])) {
            $this->db->where('a.estado',$_SESSION['FILTRO_ESTADO']);           
        }

      
        if(isset($_POST["search"]["value"]))
        {
            $busc = $_POST["search"]["value"];
            $this->db->where("(a.nombres like '%".$busc."%' or a.telefono like '%".$busc."%' or a.usuario like '%".$busc."%'  or a.dni like '%".$busc."%')", NULL, FALSE);
        }   
        $this->db->order_by('date(date_insert) desc');      
        
        
    } 

    function get_all_data()
    {
        $this->db->select('*');
        $this->db->from('tb_usuarios ');
        $this->db->where('del',0);
        $this->db->order_by('date(date_insert) desc');
        return $this->db->count_all_results();
    }  
      
    function get_filtered_data(){
        $this->make_query();
        $query = $this->db->get();
        return $query->num_rows();
    }   
    /**/
    
    /*
        -- obtener registros
    */
    function get_datos_table_for_id($coduser){
        $this->db->select('*');
        $this->db->from('tb_usuarios');
        $this->db->where('coduser',$coduser);
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        } 
    }

    function get_data_tipouser($id){
        $this->db->select('*');
        $this->db->from('tb_tipouser');
        $this->db->where('id',$id);
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        } 
    }

    function update($table,$array,$id,$campo){
        $this->db->where($campo,$id);
        return $this->db->update($table,$array);
    }


  
    function get_ultimo_control($table){
        $this->db->select('coduser');
        $this->db->from($table);
        $this->db->order_by('coduser', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        } 
    }


    function eliminar($table,$id){
        return $this->db->delete($table, array('id' => $id));
    }  

    /*
        detalle
    */

    
    function insert($table,$array){
        return $this->db->insert($table,$array);
    }


    function get_select_user(){
        $this->db->select('coduser,nombres,apellidos');
        $this->db->from('tb_usuarios');
        $this->db->where('tipo_user!=',120);
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        } 
    }

    function get_select($table){
        $this->db->select('id,descripcion');
        $this->db->from($table);
        $this->db->where('del',0);
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
    

    function get_datos($table,$id){
        $this->db->select('a.*,b.descripcion as puesto,b.descripcion as area');
        $this->db->from($table.' as a');
        $this->db->join('tb_tipouser as b','a.tipo_user=b.id','inner');
        $this->db->where('a.coduser',$id);
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        } 
    }

    function user_asignados(){
        $this->db->select('user_carta');
        $this->db->from('tb_usuarios');
        $this->db->where('user_carta',1);
        return $this->db->count_all_results();
    }  
    
    function load_select_tipo_user(){
        $this->db->select('*');
        $this->db->from('tb_tipouser');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        } 
    }  


    function get_tbl_tipo_user(){
        $this->db->select('a.*');
        $this->db->from('tb_tipouser a');      
       // $this->db->where('a.estado',1);    
       
        
            
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        }

    } 


         
    
}