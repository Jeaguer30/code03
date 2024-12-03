<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Modelo_config_sub_menu extends CI_Model
{   
   
/**************************************************************************************/
/********************************** GET TABLA *****************************************/
/**************************************************************************************/

    function get_tbl_config_sub_menu(){
        $this->db->select('a.id,a.descripcion as des_sub_menu ,b.descripcion as  des_menu');
        $this->db->from('config_sub_menu a');      
        $this->db->join('config_menu b',' a.id_menu = b.id','left');       
        
        if (isset($_SESSION['FILTRO_SUB_MENU'])) {
            $this->db->where('a.id',$_SESSION['FILTRO_SUB_MENU']);
        }

        if (isset($_SESSION['FILTRO_MENU'])) {
            $this->db->where('a.id_menu',$_SESSION['FILTRO_MENU']);
        }

        if (isset($_SESSION['FILTRO_USER'])) {
            if ($_SESSION['FILTRO_USER']=='1') {
                $this->db->where('a.id',0);
            }          
        }
        $this->db->order_by('b.descripcion','asc');
        $this->db->order_by('a.descripcion','asc');
      
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        }

    } 

/**************************************************************************************/
/***************************** FUNCIONES CARGA SELECT *********************************/
/**************************************************************************************/ 

    function load_tipo_user(){
        $this->db->select('a.*,b.descripcion as des_tipo_user');
        $this->db->from('tb_usuarios a');  
        $this->db->join('tb_tipouser b','a.tipo_user = b.id','left'); 
        $this->db->group_by('tipo_user');  
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        }  
    }

    function load_tipo_user_filter($tipo_user){
        $this->db->select('a.*,b.descripcion as des_tipo_user');
        $this->db->from('tb_usuarios a');  
        $this->db->join('tb_tipouser b','a.tipo_user = b.id','left'); 
        $this->db->where('a.tipo_user',$tipo_user);  
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        }  
    }

    function load_menu(){
        $this->db->select('*');
        $this->db->from('config_menu');      
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        }  
    }

    function load_sub_menu(){
        $this->db->select('*');
        $this->db->from('config_sub_menu');  
        if (isset($_SESSION['FILTRO_MENU'])) {
            $this->db->where('id_menu',$_SESSION['FILTRO_MENU']);
        }      
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        }  
    }

/**************************************************************************************/
/****************************** AGREGAR/QUITAR PERMISOS *******************************/
/**************************************************************************************/

    function val_permisos_sub_menu($table,$id_sub_menu,$user){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('id_sub_menu',$id_sub_menu);
        $this->db->where('id_tipo_usuario',$user);
        $this->db->where('estado_alta',0);
        return $this->db->count_all_results();
    }  

    function insert($table,$array){
        return $this->db->insert($table,$array);
    }

    function update($table,$array,$id_sub_menu,$id_tipo_user){
        $this->db->where('id_sub_menu',$id_sub_menu);
        $this->db->where('id_tipo_usuario',$id_tipo_user);
        return $this->db->update($table,$array);
    }

/**************************************************************************************/
/********************** FUNCIONES exportar TABLA ASISTENCIA ***************************/
/**************************************************************************************/

    function exportar_data_log(){
        /*
        Definir las cabeceras del excel
        */
        $string = '<table>';
                        
        $string .= '<tr align="center" style="color: #FFFFFF;">';

        $string .= '<td style="font-weight: bold; background-color: #1b1b1b; border: 1px solid black; vertical-align: middle;" rowspan="1">' . utf8_decode('Nro') . '</td>';

        $string .= '<td style="font-weight: bold; background-color: #1b1b1b; border: 1px solid black; vertical-align: middle;" rowspan="1">' . utf8_decode('Tipo de Usuario') . '</td>';
        
        $string .= '<td style="font-weight: bold; background-color: #1b1b1b; border: 1px solid black; vertical-align: middle;" rowspan="1">' . utf8_decode('Menu') . '</td>';

        $string .= '<td style="font-weight: bold; background-color: #1b1b1b; border: 1px solid black; vertical-align: middle;" rowspan="1">' . utf8_decode('Sub Menu') . '</td>';   
        
        $string .= '<td style="font-weight: bold; background-color: #1b1b1b; border: 1px solid black; vertical-align: middle;" rowspan="1">' . utf8_decode('Usuario quien dio permiso') . '</td>';
    
        $string .= '<td style="font-weight: bold; background-color: #1b1b1b; border: 1px solid black; vertical-align: middle;" rowspan="1">' . utf8_decode('Fecha que dio permiso') . '</td>';
        
        $string .= '<td style="font-weight: bold; background-color: #1b1b1b; border: 1px solid black; vertical-align: middle;" rowspan="1">' . utf8_decode('Usuario quien quitó el permiso') . '</td>';

        $string .= '<td style="font-weight: bold; background-color: #1b1b1b; border: 1px solid black; vertical-align: middle;" rowspan="1">' . utf8_decode('Fecha que se quitó el permiso') . '</td>';
        
        $string .= '<td style="font-weight: bold; background-color: #1b1b1b; border: 1px solid black; vertical-align: middle;" rowspan="1">' . utf8_decode('Estado') . '</td>';
               
        $string .= '</tr>';

        $this->db->select('a.fecha_alta,a.estado_alta,a.fecha_delete,b.descripcion as des_sub_menu,c.descripcion as des_tipo_user, d.nombres as n_alta, d.apellidos as a_alta, e.nombres as n_delete, e.apellidos as a_delete,f.descripcion as des_menu');
        $this->db->from('config_permisos_sub_menu a');      
        $this->db->join('config_sub_menu b',' a.id_sub_menu = b.id','left');
        $this->db->join('tb_tipouser c',' a.id_tipo_usuario = c.id','left');       
        $this->db->join('tb_usuarios d',' a.usuario_alta = d.coduser','left');
        $this->db->join('tb_usuarios e',' a.user_delete = e.coduser','left');
        $this->db->join('config_menu f',' b.id_menu = f.id','left');
            
        $this->db->order_by('b.descripcion','asc');
        $this->db->order_by('f.descripcion','asc');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            $resultado = $query->result();
            $contador = 0;
            foreach ($resultado as $key) {

                $contador++;
                $string .= '<tr>';
                $string .= '<td>'.$contador.'</td>';   
                $string .= '<td>'.$key->des_tipo_user.'</td>';  
                $string .= '<td>'.$key->des_menu.'</td>';          
                $string .= '<td>'.$key->des_sub_menu.'</td>';
                 
                $string .= '<td>'.$key->fecha_alta.'</td>';
                $string .= '<td>'.$key->n_alta.' '.$key->a_alta.'</td>';                
                $string .= '<td>'.$key->fecha_delete.'</td>';
                $string .= '<td>'.$key->n_delete.' '.$key->a_delete.'</td>';     
                $string .= '<td>'.($key->estado_alta == 1 ? 'PERMISO DESHABILITADO' : 'PERMISO HABILITADO').'</td>';             
                $string .= '</tr>';

            }
        } else {
            // Agregado un echo para mostrar el mensaje
            echo '<tr><td colspan="8">SIN RESULTADOS</td></tr>';
        }

        $string .= '</table>';
        return $string;
    }

}