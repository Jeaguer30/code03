<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Modelo_control_asistencia extends CI_Model
{   

/**************************************************************************************/
/***************************** FUNCIONES TABLA ASISTENCIA *****************************/
/**************************************************************************************/

    function get_user_control(){
        $this->db->select('*');
        $this->db->from('tb_usuarios');
        $this->db->where('asistencia',0);
        $this->db->where('estado',1);

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

    function load_select_mes_control(){
        $this->db->select('MONTH(fecha_registro) as mes_control ');
        $this->db->from('user_control_detalle'); 
        $this->db->group_by('MONTH(fecha_registro)');    
        $query = $this->db->get();
        return $query->result();
    }

    function load_select_fecha(){
        $this->db->select('fecha_registro');
        $this->db->from('user_control_detalle'); 
        $this->db->group_by('fecha_registro');    
        $query = $this->db->get();
        return $query->result();
    }

    function get_tbl_control_asistencia(){
        $this->db->select('a.*,b.nombres,b.apellidos,c.descripcion as des_entrada,d.descripcion as des_salida');
        $this->db->from('user_control_detalle a');      
        $this->db->join('tb_usuarios b',' a.id_usuario = b.coduser','left');
        $this->db->join('user_control_resultado c',' a.id_resultado_entrada = c.id','left');
        $this->db->join('user_control_resultado d',' a.id_resultado_salida = d.id','left');
        $this->db->where('delete',0);

        if (isset($_SESSION['FILTRO_FECHA'])) {
            $this->db->where('fecha_registro',$_SESSION['FILTRO_FECHA']);
        }

        if (isset($_SESSION['FILTRO_USUARIO'])) {
            $this->db->where('id_usuario',$_SESSION['FILTRO_USUARIO']);
        }

        if (isset($_SESSION['FILTRO_MES'])) {
            $this->db->where('MONTH(fecha_registro)',$_SESSION['FILTRO_MES']);
        }

        if(isset($_SESSION['FECHA_INICIO']) && isset($_SESSION['FECHA_FIN'])){
            $r_ini = $_SESSION['FECHA_INICIO'];
            $r_fin = $_SESSION['FECHA_FIN'];
            $this->db->where('fecha_registro>=',$r_ini);
            $this->db->where('fecha_registro<=',$r_fin);           
        }

        $this->db->order_by('fecha_registro','asc');
         
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        }

    } 

    function get_fecha_upd($id){
        $this->db->select('a.*');
        $this->db->from('user_control_detalle a');      
       
        $this->db->where('id',$id);
       
         
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        }

    } 

    function get_fecha_val($fecha){
        $this->db->select('*');
        $this->db->from('user_control_detalle');
        $this->db->where('fecha_registro',$fecha);
        $this->db->where('delete',0);
        return $this->db->count_all_results();
    }   

    function get_data_resultado($tipo){
        $this->db->select('*');
        $this->db->from('user_control_resultado');  
        $this->db->where('check_entrada',$tipo);        
        $query = $this->db->get();
        return $query->result();
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

        $style_cuerpo       ='height:45px; border:1px solid #ccc; text-align: center;vertical-align:middle;';
        $style_cabecera     ='height:45px; font-weight:bold;background-color:#1b1b1b;border:1px solid white;vertical-align:middle;';

        /*
        Definir las cabeceras del excel
        */
        $string = '<table>';

        $string .= '<tr align="center" style="color:#black;">';
            $string .= '<td style="'.$style_cabecera.' background-color:#FFC000;" colspan="3">'.utf8_decode('INFORMACION GENERAL').'</td>';
            $string .= '<td style="'.$style_cabecera.' background-color:#4472C4;" colspan="3">'.utf8_decode('ENTRADA').'</td>';
            $string .= '<td style="'.$style_cabecera.' background-color:#ED7D31;" colspan="3">'.utf8_decode('SALIDA').'</td>';           
        $string .= '</tr>';
                        
        $string .= '<tr align="center" style="color:#black;">';
            $string .= '<td style="'.$style_cabecera.' background-color:#FFE699;" rowspan="1">'.utf8_decode('Nro').'</td>';
            $string .= '<td style="'.$style_cabecera.' background-color:#FFE699;" rowspan="1">'.utf8_decode('GESTOR').'</td>';
            $string .= '<td style="'.$style_cabecera.' background-color:#FFE699;" rowspan="1">'.utf8_decode('FECHA REGISTRO').'</td>';
            $string .= '<td style="'.$style_cabecera.' background-color:#9BC2E6;" rowspan="1">'.utf8_decode('HORA INGRESO').'</td>';
            $string .= '<td style="'.$style_cabecera.' background-color:#9BC2E6;" rowspan="1">'.utf8_decode('RESULTADO').'</td>';
            $string .= '<td style="'.$style_cabecera.' background-color:#9BC2E6;" rowspan="1">'.utf8_decode('OBSERVACION ENTRADA').'</td>';                            
            $string .= '<td style="'.$style_cabecera.' background-color:#F8CBAD;" rowspan="1">'.utf8_decode('HORA SALIDA').'</td>';
            $string .= '<td style="'.$style_cabecera.' background-color:#F8CBAD;" rowspan="1">'.utf8_decode('RESULTADAO SALIDA').'</td>';
            $string .= '<td style="'.$style_cabecera.' background-color:#F8CBAD;" rowspan="1">'.utf8_decode('OBSERVACIONES SALIDA').'</td>';                    
        $string .= '</tr>';
        $this->db->select('a.*,b.nombres,b.apellidos,c.descripcion as des_entrada,d.descripcion as des_salida');
        $this->db->from('user_control_detalle a');      
        $this->db->join('tb_usuarios b',' a.id_usuario = b.coduser','left');
        $this->db->join('user_control_resultado c',' a.id_resultado_entrada = c.id','left');
        $this->db->join('user_control_resultado d',' a.id_resultado_salida = d.id','left');
        $this->db->where('delete',0);

        if (isset($_SESSION['FILTRO_FECHA'])) {
            $this->db->where('fecha_registro',$_SESSION['FILTRO_FECHA']);
        }

        if (isset($_SESSION['FILTRO_USUARIO'])) {
            $this->db->where('id_usuario',$_SESSION['FILTRO_USUARIO']);
        }

        if (isset($_SESSION['FILTRO_MES'])) {
            $this->db->where('MONTH(fecha_registro)',$_SESSION['FILTRO_MES']);
        }

        if(isset($_SESSION['FECHA_INICIO']) && isset($_SESSION['FECHA_FIN'])){
            $r_ini = $_SESSION['FECHA_INICIO'];
            $r_fin = $_SESSION['FECHA_FIN'];
            $this->db->where('fecha_registro>=',$r_ini);
            $this->db->where('fecha_registro<=',$r_fin);           
        }

        $this->db->order_by('fecha_registro','asc');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            $resultado = $query->result();
            $contador = 0;
            foreach ($resultado as $key) {
                $contador++;
                $string .= '<tr>';
                $string .= '<td style="'.$style_cuerpo.'">'.$contador.'</td>';               
                $string .= '<td style="'.$style_cuerpo.'">'.utf8_decode($key->nombres).'</td>';
                $string .= '<td style="'.$style_cuerpo.'">'.utf8_decode($key->fecha_registro).'</td>';
                $string .= '<td style="'.$style_cuerpo.'">'.utf8_decode($key->hora_ingresar).'</td>';
                $string .= '<td style="'.$style_cuerpo.'">'.utf8_decode($key->des_entrada).'</td>';
                $string .= '<td style="'.$style_cuerpo.'">'.utf8_decode($key->obs_entrada).'</td>';                    
                $string .= '<td style="'.$style_cuerpo.'">'.utf8_decode($key->hora_salida).'</td>';
                $string .= '<td style="'.$style_cuerpo.'">'.utf8_decode($key->des_salida).'</td>';
                $string .= '<td style="'.$style_cuerpo.'">'.utf8_decode($key->obs_salida).'</td>';
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