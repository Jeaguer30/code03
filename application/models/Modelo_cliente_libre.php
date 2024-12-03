<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Modelo_cliente_libre extends CI_Model
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
        $this->db->select('a.*');
        $this->db->from('cvc_clientes_libres a');
        //$this->db->join('tb_tipouser b','a.tipo_user=b.id','left');
        $this->db->where('a.del',0);     
        
        if (isset($_SESSION['FILTRO_LIBRE_ESTADO'])) {
            $this->db->where('a.status',$_SESSION['FILTRO_LIBRE_ESTADO']);           
        }

        if (isset($_SESSION['FILTRO_LIBRE_TIPO'])) {
            $this->db->where('a.id_tipo_cliente',$_SESSION['FILTRO_LIBRE_TIPO']);           
        }

        if (isset($_SESSION['FILTRO_LIBRE_DISTRIBUIDOR'])) {
            $this->db->where('a.distribuidor_local',$_SESSION['FILTRO_LIBRE_DISTRIBUIDOR']);           
        }

        if (isset($_SESSION['FILTRO_LIBRE_DEPARTAMENTO'])) {
            $this->db->where('a.departamento',$_SESSION['FILTRO_LIBRE_DEPARTAMENTO']);           
        }

      
        if(isset($_POST["search"]["value"]))
        {
            $busc = $_POST["search"]["value"];
            $this->db->where("(a.razon_social like '%".$busc."%' or a.ruc like '%".$busc."%'  or a.distribuidor_local like '%".$busc."%' or a.nro_suministro_distri like '%".$busc."%')", NULL, FALSE);
        }   
        $this->db->order_by('date(a.f_registro) desc');      
        
        
    } 

    function get_all_data()
    {
        $this->db->select('*');
        $this->db->from('cvc_clientes_libres ');
        $this->db->where('del',0);
        $this->db->order_by('date(f.registro) desc');
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
    function get_datos_table_for_id($id){
        $this->db->select('*');
        $this->db->from('cvc_clientes_libres');
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

    function eliminar($table,$id){
        return $this->db->delete($table, array('id' => $id));
    }  

    /*
        detalle
    */

    
    function insert($table,$array){
        return $this->db->insert($table,$array);
    }

    function load_filtro_estado(){
        $this->db->select('*');
        $this->db->from('cvc_estado_clientes_libres');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        } 
    }  

    function load_filtro_distribuidor(){
        $this->db->select('*');
        $this->db->from('cvc_distribuidores');
        $this->db->where('estado',0);
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        } 
    }  

    function load_filtro_departamento(){
        $this->db->select('*');
        $this->db->from('tb_ubigeo_departamento');
       // $this->db->where('estado',0);
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        } 
    }  
    
}