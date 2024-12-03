<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Modelo_permisos_dash extends CI_Model
{ 
    
    
/**************************************************************************************/
/******************************* FUNCIONES GET FILTROS ********************************/
/**************************************************************************************/
function load_slc_sub_region_add($region){
    $this->db->select('a.descripcion');
    $this->db->from('geochasq_bd_sistema_lindley.dashboard_sub_region a');   
    $this->db->join('geochasq_bd_sistema_lindley.dashboard_region b','a.id_region=b.id','left');  
    if (!empty($region)) {
        $this->db->where_in('b.descripcion',$region);
    } else {
        # code...
    }
           
    $this->db->order_by('a.id');
    $query = $this->db->get();
    if($query->num_rows()>0){
        return $query->result(); 
    }else{
        return 'error';
    } 
}

function load_slc_cda_add($region,$sub_region){
    $this->db->select('b.descripcion');
    $this->db->from('geochasq_bd_sistema_lindley.dashboard_sub_region a');         
    $this->db->join('geochasq_bd_sistema_lindley.dashboard_cda b','a.id=b.id_sub_region','left');   
    $this->db->join('geochasq_bd_sistema_lindley.dashboard_region c','a.id_region=c.id','left');  
    if (!empty($region)) {
        $this->db->where_in('c.descripcion',$region);
    } else {
        # code...
    }
    if (!empty($sub_region)) {
        $this->db->where_in('a.descripcion',$sub_region);
    } else {
        # code...
    }

    $this->db->order_by('b.id');
    $query = $this->db->get();
    if($query->num_rows()>0){
        return $query->result(); 
    }else{
        return 'error';
    } 
}

function get_datos($usuario){
    $this->db->select('a.id_usuario,a.region,a.sub_region,a.cda,c.id as id_nivel,b.nombres,b.apellidos');
    $this->db->from('dashboard_consulta a');      
    $this->db->join('tb_usuarios b',' a.id_usuario = b.coduser','left');
    $this->db->join('dashboard_tipo_consulta c','a.id_tipo_acceso = c.id','left');
    $this->db->where ('a.id_usuario',$usuario);
    $query = $this->db->get();
    if($query->num_rows()>0){
        return $query->result(); 
    }else{
        return 'error';
    } 
}

/**************************************************************************************/
/******************************* FUNCIONES GET FILTROS ********************************/
/**************************************************************************************/

    function get_user_control(){

        $this->db->select('b.nombres,b.apellidos,a.id_usuario');
        $this->db->from('dashboard_consulta a');
        $this->db->join('tb_usuarios b','a.id_usuario = b.coduser ','left');
        $this->db->group_by('a.id_usuario');
        $this->db->order_by('b.nombres','asc');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        }
    }

    function get_user_add(){
        $this->db->select('a.*');
        $this->db->from('tb_usuarios a');       
        $this->db->where_in('a.tipo_user',array(25,30,35,40,60));
        $this->db->order_by('a.nombres','asc');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        }
    }

    function get_nivel_acceso(){
        $this->db->select('*');
        $this->db->from('dashboard_tipo_consulta');     
       
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        }

    }

    function get_filtros($tabla){
        $this->db->select('*');
        $this->db->from($tabla);       
        $this->db->order_by('id');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        }
    }

    function get_filtros_where($tabla,$data,$campo){
        $this->db->select('*');
        $this->db->from($tabla);   
        $this->db->where($campo,$data);      
        $this->db->order_by('id');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        }
    }

    function get_filtros_sub_region(){
        $this->db->select('a.descripcion');
        $this->db->from('geochasq_bd_sistema_lindley.dashboard_sub_region a');   
        $this->db->join('geochasq_bd_sistema_lindley.dashboard_region b','a.id_region=b.id','left');  
        if (isset( $_SESSION['FILTRO_REGION'])) {
            $this->db->where('b.descripcion', $_SESSION['FILTRO_REGION']);   
        }          
        $this->db->order_by('a.id');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        } 
    }

    function get_filtros_cda(){
        $this->db->select('b.descripcion');
        $this->db->from('geochasq_bd_sistema_lindley.dashboard_sub_region a');         
        $this->db->join('geochasq_bd_sistema_lindley.dashboard_cda b','a.id=b.id_sub_region','left');   
        $this->db->join('geochasq_bd_sistema_lindley.dashboard_region c','a.id_region=c.id','left');  
        if (isset( $_SESSION['FILTRO_REGION'])) {
            $this->db->where('c.descripcion', $_SESSION['FILTRO_REGION']);   
        } 
        if (isset( $_SESSION['FILTRO_SUB_REGION'])) {
            $this->db->where('a.descripcion', $_SESSION['FILTRO_SUB_REGION']);   
        } 

        $this->db->order_by('b.id');
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        } 
    }

/**************************************************************************************/
/***************************** FUNCIONES TABLA PERMISOS *****************************/
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
        $this->db->select('a.region,a.sub_region,a.cda,c.descripcion,b.nombres,b.apellidos');
        $this->db->from('dashboard_consulta a');      
        $this->db->join('tb_usuarios b',' a.id_usuario = b.coduser','left');
        $this->db->join('dashboard_tipo_consulta c','a.id_tipo_acceso = c.id','left');  

        if (isset( $_SESSION['FILTRO_USUARIO'])) {
            $this->db->where('a.id_usuario', $_SESSION['FILTRO_USUARIO']);   
        } 
        
        if (isset( $_SESSION['FILTRO_REGION'])) {
            $this->db->where('a.region', $_SESSION['FILTRO_REGION']);   
        } 

        if (isset( $_SESSION['FILTRO_SUB_REGION'])) {
            $this->db->where('a.sub_region', $_SESSION['FILTRO_SUB_REGION']);   
        } 

        if (isset( $_SESSION['FILTRO_NIVEL_ACCESO'])) {
            $this->db->where('a.id_tipo_acceso', $_SESSION['FILTRO_NIVEL_ACCESO']);   
        }

        if(isset($_POST["search"]["value"]))
        {
            $busc = $_POST["search"]["value"];
            $this->db->where("(b.usuario like '%".$busc."%' or b.coduser like '%".$busc."%' or b.nombres like '%".$busc."%' or b.apellidos like '%".$busc."%' or a.region like '%".$busc."%'  or a.sub_region like '%".$busc."%')", NULL, FALSE);
        }   
  
    } 

    function get_all_data()
    {
        $this->db->select('*');
        $this->db->from('dashboard_consulta');            
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

    function delete($table,$cod){       
        $this->db->where('id_usuario',$cod);
        return $this->db->delete($table);
    }

    function insert_registro($table,$array){
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