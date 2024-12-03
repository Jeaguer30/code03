<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_settings_menu extends CI_Model
{   
    function get_settings_menu($tipo_user){
        $this->db->select('a.id,a.descripcion as des_menu,a.icono as icono_menu,b.descripcion as des_sub_menu,b.ruta as ruta_sub_menu,a.id as id_menu');
        $this->db->from('config_permisos_sub_menu c');
        $this->db->join('config_sub_menu b','c.id_sub_menu=b.id','left'); 
        $this->db->join('config_menu a','b.id_menu=a.id','left'); 
        $this->db->where('c.id_tipo_usuario',$tipo_user);
        $this->db->where('c.estado_alta',0);
        $this->db->where('a.en_menu',1);
        $this->db->order_by('a.id','asc');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        } 
    }
}