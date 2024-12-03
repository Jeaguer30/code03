<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Modelo_control_accesos extends CI_Model
{   

/**************************************************************************************/
/***************************** FUNCIONES TABLA ASISTENCIA *****************************/
/**************************************************************************************/

    function get_user_control(){
        $this->db->select('b.nombres,b.apellidos,a.id_usuario');
        $this->db->from('control_log_accesos a');
        $this->db->join('tb_usuarios b','a.id_usuario = b.coduser ','left');
        $this->db->group_by('a.id_usuario');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        }

    }

    function load_select_mes_control(){
        $this->db->select('MONTH(a.f_log_acceso) AS mes_control');
        $this->db->from('control_log_accesos a');        
        $this->db->group_by('MONTH(a.f_log_acceso)');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        }

    }

/**************************************************************************************/
/***************************** FUNCIONES TABLA ASISTENCIA *****************************/
/**************************************************************************************/

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
        $this->db->select('a.f_log_acceso,b.descripcion as des_tipo_acceso, c.nombres, c.apellidos, d.descripcion as des_sub_menu,e.descripcion as des_menu');
        $this->db->from('control_log_accesos a');      
        $this->db->join('control_log_tipo_accesos b',' a.id_log_tipo_acceso = b.id','left');
        $this->db->join('tb_usuarios c','a.id_usuario = c.coduser','left');
        $this->db->join('config_sub_menu d','a.id_sub_menu = d.id','left');
        $this->db->join('config_menu e','d.id_menu = e.id','left');
       
       
        //$this->db->where('delete',0);
         if (isset($_SESSION['FILTRO_TIPO_ACCESO'])) {
            $this->db->where('a.id_log_tipo_acceso',$_SESSION['FILTRO_TIPO_ACCESO']);
        }

        if (isset($_SESSION['FILTRO_USUARIO'])) {
            $this->db->where('a.id_usuario',$_SESSION['FILTRO_USUARIO']);
        }

        if (isset($_SESSION['FILTRO_MES'])) {
            $this->db->where('MONTH(a.f_log_acceso)',$_SESSION['FILTRO_MES']);
        }


        if(isset($_SESSION['FECHA_INICIO']) && isset($_SESSION['FECHA_FIN'])){
            $r_ini = $_SESSION['FECHA_INICIO'];
            $r_fin = $_SESSION['FECHA_FIN'];
            $this->db->where('DATE(a.f_log_acceso)>=',$r_ini);
            $this->db->where('DATE(a.f_log_acceso)<=',$r_fin);           
        } 

    
        if(isset($_POST["search"]["value"]))
        {
            $busc = $_POST["search"]["value"];
           // $this->db->where("(nombres like '%".$busc."%' or telefono like '%".$busc."%' or usuario like '%".$busc."%'  or dni like '%".$busc."%')", NULL, FALSE);
        }   
          
        $this->db->order_by('a.f_log_acceso','desc');
        $this->db->order_by('e.descripcion','asc');
        $this->db->order_by('d.descripcion','asc');
        
    } 

    function get_all_data()
    {
        $this->db->select('*');
        $this->db->from('control_log_accesos');            
        return $this->db->count_all_results();
    }  
    
    function get_filtered_data(){
        $this->make_query();
        $query = $this->db->get();
        return $query->num_rows();
    }   



  

/**************************************************************************************/
/*********************************** OTRAS FUNCIONES **********************************/
/**************************************************************************************/
    function update($table,$array,$id){
        $this->db->where('id',$id);
        return $this->db->update($table,$array);
    }

    function insert($table,$array){
        return $this->db->insert($table,$array);
    } 

/**************************************************************************************/
/******************************** exportar bloque ctrl ********************************/
/**************************************************************************************/
    function exportar_data_bloque(){
        


        $celda_header='height:45px; font-weight:bold; border:1px solid white; text-align: center; vertical-align:middle;';  
        $celda_body='text-align: center; vertical-align:middle; height:40px;';  
        $celda_body_start='vertical-align:middle; height:40px;'; 

        $string = '<table>';
        $string .= '<tr align="center" style="color:white;">';                                         
        $string .= '</tr>';
        
        $string .= '<tr align="center" style="color:white;">';                    
            $string .= '<td style="background-color:#7A7FDC;'.$celda_header.'" colspan="6">'.utf8_decode('DETALLE DE ACCESOS').'</td>';      
            
        $string .= '</tr>'; 

        $string.='  <tr align="center" style="color:white;">';                    
                $string .= '<td style="background-color:#7A7FDC;'.$celda_header.'" rowspan="1">'.utf8_decode('Nro').'</td>';
                $string .= '<td style="background-color:#7A7FDC;'.$celda_header.'" rowspan="1">'.utf8_decode('TIPO DE ACCESO').'</td>'; 
                $string .= '<td style="background-color:#7A7FDC;'.$celda_header.'" rowspan="1">'.utf8_decode('GESTOR').'</td>'; 
                $string .= '<td style="background-color:#7A7FDC;'.$celda_header.'" rowspan="1">'.utf8_decode('FECHA REGISTRO').'</td>';
                $string .= '<td style="background-color:#7A7FDC;'.$celda_header.'" rowspan="1">'.utf8_decode('MENU').'</td>';         
                $string .= '<td style="background-color:#7A7FDC;'.$celda_header.'" rowspan="1">'.utf8_decode('SUB MENU').'</td>';  

        $string .= '</tr>';




        $this->make_query();

        $query = $this->db->get();
        if($query->num_rows() > 0){
            $resultado = $query->result();
            $contador = 0;
            foreach ($resultado as $key) {
                $contador++;
                $string .= '<tr>';
                    $string .= '<td  style="'.$celda_body.'">'.$contador.'</td>';               
                    $string .= '<td  style="'.$celda_body.'">'.utf8_decode($key->des_tipo_acceso).'</td>';
                    $string .= '<td  style="'.$celda_body.'">'.utf8_decode($key->nombres).' '.utf8_decode($key->apellidos).'</td>';
                    $string .= '<td  style="'.$celda_body.'">'.$key->f_log_acceso.'</td>';                                    
                    $string .= '<td  style="'.$celda_body.'">'.utf8_decode($key->des_menu).'</td>';
                    $string .= '<td style="'.$celda_body.'">'.utf8_decode($key->des_sub_menu).'</td>';
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