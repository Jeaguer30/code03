<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class C_config_user_preaviso extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('image_lib');
        $this->load->model('Mdl_compartido');
        $this->load->model('M_config_user_preaviso');
        $this->load->model('M_settings');
        $this->load->model('M_settings_menu');
        date_default_timezone_set('America/Lima');
    }

    public function index(){
        $data['datos']='';
        $header['datos_header']='';
        $header['lang']='en';
        $this->load->view('layouts/v_head',$header);
        if($position=='vertical'){
            $this->load->view('layouts/vertical_menu_dinamico',$header);
        }else{
            $this->load->view('layouts/horizontal_menu_dinamico',$header);
        }
        $this->load->view('seg_usuarios/v_usuarios', $data);
        $this->load->view('layouts/v_footer');
        $this->retirar_filtros();
     

    }


/**************************************************************************************/
/***************************** FUNCIONES TABLA ASISTENCIA *****************************/
/**************************************************************************************/
 
    function get_tbl_user_preaviso(){       
       
        $res = $this->M_config_user_preaviso->get_tbl_user_preaviso();    
        
        if ($res != 'error') {
            $cadena = '';
            $t_total = 0;
    
            foreach ($res as $key) {
                $t_total++;
                $check_1 = ($key->user_carta == 1) ? 'checked' : '';
    
                $cadena .= '
                    <tr class="table_list"">
                        <td style="width: auto;">
                            <div style="text-align:center;" class="">
                                ' . $t_total . '
                            </div>
                        </td> 
                        <td style="width: auto;">
                            <div  >
                                <label   id="txt_nombre_ctrl'.$t_total.'">'.$key->nombres.' '.$key->apellidos.'</lable>
                            </div>                           
                        </td>  
                        <td style="width: auto;">
                            <div style="text-align:center;" >
                                <div style="text-align:center;"><input '.$check_1.' class="form-check-input" type="checkbox" id="check_preaviso_'.$t_total.'" style="transform: scale(1.7);" onchange="upd_user_preaviso('.$key->coduser.','.$t_total.');"></div>
                            </div>                          
                        </td>               
                    </tr>';
            }     
    
            $ar['mensaje'] = 'ok';
            $ar['resultado'] = $cadena;
        } else {
            $ar['mensaje'] = 'ok';
            $ar['resultado'] = '<tr><td colspan="6">Sin registros encontrados</td></tr>';
        }
    
        echo json_encode($ar);
    }

    function upd_user_preaviso(){
        $check_preaviso             = trim($this->input->post('check_preaviso',true));
        $id                = trim($this->input->post('id',true));
      
        $val_user_carta = $this->M_config_user_preaviso->user_asignados();
        $ar['mensaje_1']='';
        $ar['mensaje_2']='';
        if ($check_preaviso == 1) {
            if ($val_user_carta >= 10) {
                $check_preaviso = 0;
                $ar['mensaje_1'] = 'Se supero el limite de usuarios para el preaviso';
            }
        }

        $array = array(           
            'user_carta'    => $check_preaviso
        );
    
        $result=$this->M_config_user_preaviso->update('tb_usuarios',$array,$id);
        if ($result==1) {
            if ($check_preaviso==1) {
                $ar['mensaje_2']='Usuario asignado correctamente'; 
            } else {
                $ar['mensaje_2']='Usuario quitado';
            }
                      
        } else {
            $ar['mensaje_2']='ocurrio un error vuelva a intentarlo';
        }
        
        echo json_encode($ar);

    }

    function filter_tbl_preaviso(){
        $value = $this->input->post('value',true);

        if($value==''){
            unset($_SESSION['FILTRO_NAME']); 
        }else{
            $_SESSION['FILTRO_NAME'] = $value;
        }
        echo 'session:'.$_SESSION['FILTRO_NAME'].'------';
    }
    function filter_check(){
        $value = $this->input->post('value',true);
        if($value==''){
            unset($_SESSION['FILTRO_CHECK']); 
        }else{
            $_SESSION['FILTRO_CHECK'] = $value;
        }
        echo 'session_CHECK:'.$_SESSION['FILTRO_CHECK'].'------';
    }
    
     


/**************************************************************************************/
/********************** FUNCIONES exportar TABLA ASISTENCIA ***************************/
/**************************************************************************************/

    function retirar_filtros(){
        unset($_SESSION['FILTRO_CHECK']);
        unset($_SESSION['FILTRO_NAME']);
        echo 'ok';
    }

    function exportar_bloque(){
        $tabla_bloque_html = $this->Modelo_control_asistencia->exportar_data_bloque();
        $datos['export_bloque'] = $tabla_bloque_html;
        $this->load->view('templates/export_bloque',$datos);
    } 


}

?>
