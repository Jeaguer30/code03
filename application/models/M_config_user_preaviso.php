<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_config_user_preaviso extends CI_Model
{   

/**************************************************************************************/
/***************************** FUNCIONES TABLA ASISTENCIA *****************************/
/**************************************************************************************/

    function load_select_fecha(){
        $this->db->select('fecha_registro');
        $this->db->from('user_control_detalle'); 
        $this->db->group_by('fecha_registro');    
        $query = $this->db->get();
        return $query->result();
    }

    function get_tbl_user_preaviso(){
        $this->db->select('a.*');
        $this->db->from('tb_usuarios a');      
        $this->db->where('a.estado',1);    
        if (isset($_SESSION['FILTRO_NAME'])) {
            $filtro = $_SESSION['FILTRO_NAME'];
            $this->db->group_start()
                     ->like('a.nombres', $filtro)
                     ->or_like('a.apellidos', $filtro)
                     ->group_end();
        }
        if (isset($_SESSION['FILTRO_CHECK'])) {
            $this->db->where('a.user_carta',$_SESSION['FILTRO_CHECK']);   
           
        }
            
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return 'error';
        }

    } 

    function user_asignados()
    {
        $this->db->select('user_carta');
        $this->db->from('geochasq_bd_sistema_lindley.tb_usuarios');
        $this->db->where('user_carta',1);
        return $this->db->count_all_results();
    }  

/**************************************************************************************/
/*********************************** OTRAS FUNCIONES **********************************/
/**************************************************************************************/

    function update($table,$array,$id){
        $this->db->where('coduser',$id);
        return $this->db->update($table,$array);
    }

    function insert($table,$array){
        return $this->db->insert($table,$array);
    } 

/**************************************************************************************/
/******************************** exportar bloque ctrl ********************************/
/**************************************************************************************/
    function exportar_data_bloque(){
        /*
        Definir las cabeceras del excel
        */
        $string = '<table>';
                        
        $string .= '<tr align="center" style="color:#FFFFFF;">';  

        $string .= '<td style="font-weight:bold;background-color:#1b1b1b;border:1px solid black;vertical-align:middle;" rowspan="1">'.utf8_decode('Nro').'</td>';

        $string .= '<td style="font-weight:bold;background-color:#1b1b1b;border:1px solid black;vertical-align:middle;" rowspan="1">'.utf8_decode('GESTOR').'</td>';

        $string .= '<td style="font-weight:bold;background-color:#1b1b1b;border:1px solid black;vertical-align:middle;" rowspan="1">'.utf8_decode('FECHA REGISTRO').'</td>';

        $string .= '<td style="font-weight:bold;background-color:#1b1b1b;border:1px solid black;vertical-align:middle;" rowspan="1">'.utf8_decode('HORA INGRESO').'</td>';

        $string .= '<td style="font-weight:bold;background-color:#1b1b1b;border:1px solid black;vertical-align:middle;" rowspan="1">'.utf8_decode('RESULTADO').'</td>';

        $string .= '<td style="font-weight:bold;background-color:#1b1b1b;border:1px solid black;vertical-align:middle;" rowspan="1">'.utf8_decode('OBSERVACION ENTRADA').'</td>';
                            
        $string .= '<td style="font-weight:bold;background-color:#1b1b1b;border:1px solid black;vertical-align:middle;" rowspan="1">'.utf8_decode('HORA SALIDA').'</td>';

        $string .= '<td style="font-weight:bold;background-color:#1b1b1b;border:1px solid black;vertical-align:middle;" rowspan="1">'.utf8_decode('RESULTADAO SALIDA').'</td>';

        $string .= '<td style="font-weight:bold;background-color:#1b1b1b;border:1px solid black;vertical-align:middle;" rowspan="1">'.utf8_decode('OBSERVACIONES SALIDA').'</td>';
                    
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

        $query = $this->db->get();
        if($query->num_rows() > 0){
            $resultado = $query->result();
            $contador = 0;
            foreach ($resultado as $key) {
                $contador++;
                $string .= '<tr>';
                $string .= '<td>'.$contador.'</td>';               
                $string .= '<td>'.$key->nombres.'</td>';
                $string .= '<td>'.$key->fecha_registro.'</td>';
                $string .= '<td>'.$key->hora_ingresar.'</td>';
                $string .= '<td>'.$key->des_entrada.'</td>';
                $string .= '<td>'.$key->obs_entrada.'</td>';                    
                $string .= '<td>'.$key->hora_salida.'</td>';
                $string .= '<td>'.$key->des_salida.'</td>';
                $string .= '<td>'.$key->obs_salida.'</td>';
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