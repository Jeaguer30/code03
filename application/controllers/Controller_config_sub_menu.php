<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Controller_config_sub_menu extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('image_lib');
        $this->load->model('Mdl_compartido');
        $this->load->model('Modelo_config_sub_menu');
        $this->load->model('M_settings');
        $this->load->model('M_settings_menu');
        date_default_timezone_set('America/Lima');
    }

    public function index(){

        //Retornamos campo tipo de usuario
        $tipo_user          = $this->Mdl_compartido->retornarcampo($_SESSION['_SESSIONUSER'],'coduser','tb_usuarios','tipo_user');

        //Obtenemos el id del menu
        $header['id_menu']  = $this->Mdl_compartido->retornarcampo('seg_permisos_menu','ruta','config_sub_menu','id_menu');
        $id_sub_menu        = $this->Mdl_compartido->retornarcampo('seg_permisos_menu','ruta','config_sub_menu','id');

        //Validamos que tenga el permiso
        $permiso = $this->Mdl_compartido->permisos_menu_mejorado('seg_permisos_menu',$tipo_user);
        if (!$permiso){
            redirect('');
        }
        if(!isset($_SESSION['_SESSIONUSER'])){
            redirect('login');
        }

        //Registro de acceso al modulo (tipo de acceso(1 login, 2 acceso modulo) y id sub menu)
        $this->Mdl_compartido->registrar_accesos(2,$id_sub_menu);
            
        //Configuración para obtener el menú y sub menu para los layouts horizontal o verticañ
        $config_menu = $this->M_settings_menu->get_settings_menu($tipo_user);
        $header['config_menu'] = $config_menu;

        $config = $this->M_settings->get_settings();
        $header['config'] = $config;
        $position='horizontal';
        if($config!='error'){
            foreach ($config as $key) {
                $position=$key->layout;
            }
        }
        $this->retirar_filtros();

        $data['datos']='';
        $header['datos_header']='';
        $header['lang']='en';
        $this->load->view('layouts/v_head',$header);
        if($position=='vertical'){
            $this->load->view('layouts/vertical_menu_dinamico',$header);
        }else{
            $this->load->view('layouts/horizontal_menu_dinamico',$header);
        }
        $this->load->view('seg_usuarios/v_config_sub_menu', $data);
        $this->load->view('layouts/v_footer');

    }

/**************************************************************************************/
/***************************** FUNCIONES CARGA SELECT *********************************/
/**************************************************************************************/    

    function load_tipo_user(){
        $resultado = $this->Modelo_config_sub_menu->load_tipo_user();
        $cadena='<option value="">Tipo User</option>'; 
        if($resultado!='error'){
            foreach($resultado as $key){
                $cadena.='<option  name="'.$key->des_tipo_user.'" value="'.$key->tipo_user.'">'.$key->des_tipo_user.'</option>'; 
            }
        }else{
            $cadena.=''; 
        }
        echo $cadena; 
    }

    function load_menu(){
        $id = $this->input->post('id',true);
        $resultado = $this->Modelo_config_sub_menu->load_menu();
        $cadena='<option value="">Selecccione</option>'; 
        if ($id==1) {
            $cadena.='<option value="99">Otros</option>'; 
        }
       
        if($resultado!='error'){
            foreach($resultado as $key){
                $cadena.='<option value="'.$key->id.'">'.$key->descripcion.'</option>'; 
            }
        }else{
            $cadena.=''; 
        }
        echo $cadena; 
    }

    function load_sub_menu(){
        $resultado = $this->Modelo_config_sub_menu->load_sub_menu();
        $cadena='<option value="">Selecccione</option>'; 
        if($resultado!='error'){
            foreach($resultado as $key){
                $cadena.='<option value="'.$key->id.'">'.$key->descripcion.'</option>'; 
            }
        }else{
            $cadena.=''; 
        }
        echo $cadena; 
    }

/**************************************************************************************/
/***************************** FUNCIONES AGREGAR MENU *********************************/
/**************************************************************************************/

    function agregar_add_menu(){
        $txt_sub_menu_add = $this->input->post('txt_sub_menu_add',true);
        $txt_ruta_sub_menu_add = $this->input->post('txt_ruta_sub_menu_add',true);
        $slc_menu_add = $this->input->post('slc_menu_add',true);
        $txt_menu_add = $this->input->post('txt_menu_add',true);
        $txt_icono_add = $this->input->post('txt_icono_add',true);

        if ($slc_menu_add!='99') {

            $array = array(
                'id_menu'       =>  $slc_menu_add,
                'descripcion'   =>  $txt_sub_menu_add,
                'ruta'          =>  $txt_ruta_sub_menu_add
            );
            $this->Modelo_config_sub_menu->insert('config_sub_menu', $array);
            $ar['mensaje']='1';
        } else {

            $array = array(                
                'descripcion'   =>  $txt_menu_add,
                'icono'          =>  $txt_icono_add
            );
            $this->Modelo_config_sub_menu->insert('config_menu', $array);
            $id_des       = $this->Mdl_compartido->retornarcampo($txt_menu_add,'descripcion','config_menu','id'); //var - campo var - tabla - id_retorno

            $array = array(    
                'id_menu'       =>  $id_des,            
                'descripcion'   =>  $txt_sub_menu_add,
                'ruta'          =>  $txt_ruta_sub_menu_add
            );
            $this->Modelo_config_sub_menu->insert('config_sub_menu', $array);
            $ar['mensaje']='2';
        }

        echo json_encode($ar);
     
    }

/**************************************************************************************/
/****************************** APLICAR FILTRO SELECT *********************************/
/**************************************************************************************/ 

    function filter_check()
    {
        $value = $this->input->post('value', true);
        if ($value=='') {
            unset($_SESSION['FILTRO_CHECK']);
        }else {
            $_SESSION['FILTRO_CHECK'] = ($value == '') ? '' : $value;
            echo 'session_CHECK:'.$_SESSION['FILTRO_CHECK'].'------';
        }
        
    }

    function aplicar_filter_tipo_user(){
        $filtro_user = $this->input->post('filtro_user',true);
        unset($_SESSION['FILTRO_CHECK']);
        if(!empty($filtro_user)){
            $_SESSION['FILTRO_USER'] = $filtro_user;
            $resultado = $this->Modelo_config_sub_menu->load_tipo_user_filter($filtro_user);
            $des='';
            foreach ($resultado as $key ) {
               $des = $key->des_tipo_user;
            }
            $ar['descripcion']=$des;
           
        }else{
           
            unset($_SESSION['FILTRO_SUB_MENU']);
            unset($_SESSION['FILTRO_MENU']);
           $_SESSION['FILTRO_USER']=1;
           
           
           $ar['descripcion']='N/A';
        }

        echo json_encode($ar);
    }

    function aplicar_filter_menu(){
        $filtro_menu = $this->input->post('filtro_menu',true);
       
        if(!empty($filtro_menu)){
            $_SESSION['FILTRO_MENU'] = $filtro_menu;
            echo  $_SESSION['FILTRO_MENU'];
        }else{
           unset($_SESSION['FILTRO_MENU']); 
            echo 'nada';
           
        }
    }

    function aplicar_filter_sub_menu(){
        $filtro_sub_menu = $this->input->post('filtro_sub_menu',true);
       
        if(!empty($filtro_sub_menu)){
            $_SESSION['FILTRO_SUB_MENU'] = $filtro_sub_menu;
            echo  $_SESSION['FILTRO_SUB_MENU'];
        }else{
            unset($_SESSION['FILTRO_SUB_MENU'] ); 
            echo 'nada';
           
        }
    }

/**************************************************************************************/
/********************************** GET TABLA *****************************************/
/**************************************************************************************/
function get_tbl_config_sub_menu()
{       
    $res = $this->Modelo_config_sub_menu->get_tbl_config_sub_menu();

    if ($res != 'error') {
        $cadena = '';
        $t_total = 0;            
        foreach ($res as $key) {
            $t_total++;          
            $user = (isset($_SESSION['FILTRO_USER'])) ? $_SESSION['FILTRO_USER'] : '0' ;
            $res_val = $this->Modelo_config_sub_menu->val_permisos_sub_menu('config_permisos_sub_menu', $key->id, $user);             
            $check = ($res_val >= 1) ? 'checked' : '';

            // Filtrar según la sesión de CHECK
            if (isset($_SESSION['FILTRO_CHECK'])) {
                $filtrar = ($_SESSION['FILTRO_CHECK'] == 1) ? $check : !$check;
                if (!$filtrar) continue; // Saltar a la próxima iteración si no cumple con la condición
            }

            $cadena .= '
                <tr class="table_list">
                    <td style="width: auto;">
                        <div style="text-align:center;">' . $t_total . '</div>
                    </td> 
                    <td style="width: auto;">
                        <div style="text-align:center;">
                            <label id="txt_nombre_ctrl' . $t_total . '">'. $key-> des_menu . '</label>
                        </div>                           
                    </td>  
                    <td style="width: auto;">
                        <div style="text-align:center;">
                            <label id="txt_fecha_registro_ctrl_' . $t_total . '">'. $key->des_sub_menu . '</label>
                        </div>                          
                    </td>
                    <td style="width: auto;">
                        <div style="text-align:center;">
                            <div style="text-align:center;">
                                <input ' . $check . ' class="form-check-input" type="checkbox" id="check_permiso_'.$t_total.'" style="transform: scale(1.7);" onchange="add_permisos_sub_menu('.$key->id.','.$user.','.$t_total.');">
                            </div>
                        </div>                          
                    </td> 
                </tr>';
        }  

        $ar['mensaje_3'] = $_SESSION['FILTRO_USER'];       
        $ar['mensaje'] = 'ok';
        $ar['resultado'] = $cadena;
    } else {
        $ar['mensaje'] = 'ok';
        $ar['resultado'] = '<tr><td colspan="6">Sin registros encontrados</td></tr>';
    }

    echo json_encode($ar);
}


/**************************************************************************************/
/****************************** AGREGAR/QUITAR PERMISOS *******************************/
/**************************************************************************************/

    function add_permisos_sub_menu(){

        $check_permiso  = trim($this->input->post('check_permiso',true));
        $id             = trim($this->input->post('id',true));
        $user           = trim($this->input->post('user',true));

        switch ($check_permiso) {
            case '1':
            if ($id!='') {

                $array = array(           
                    'id_sub_menu'       => $id,
                    'id_tipo_usuario'   => $user, 
                    'fecha_alta'        => date('Y-m-d H:i:s'),  
                    'usuario_alta'      => $_SESSION['_SESSIONUSER'],   
                    'estado_alta'       => 0
                );        
                $result = $this->Modelo_config_sub_menu->insert('config_permisos_sub_menu', $array);
                $ar['mensaje']='ok';
            }
            
                break;
            
            case '0':

                if ($id!='') {
                    $array = array(       
                    
                        'fecha_delete'      => date('Y-m-d H:i:s'),  
                        'user_delete'       => $_SESSION['_SESSIONUSER'],   
                        'estado_alta'       => 1
                    );        
                    $result= $this->Modelo_config_sub_menu->update('config_permisos_sub_menu',$array,$id,$user);
                    $ar['mensaje_1']='ok';
                }
                
                break;

            default:
                # code...
                break;
        }

        echo json_encode($ar);


    }

/**************************************************************************************/
/****************************** /QUITAR FILTROS ***************************************/
/**************************************************************************************/

    function retirar_filtros(){
        unset($_SESSION['FILTRO_USER']);
        unset($_SESSION['FILTRO_SUB_MENU']);
        unset($_SESSION['FILTRO_MENU']);
        unset($_SESSION['FILTRO_CHECK']);
        
    }

/**************************************************************************************/
/********************** FUNCIONES exportar TABLA ASISTENCIA ***************************/
/**************************************************************************************/

    function exportar_log_permisos(){
        $tabla_bloque_html = $this->Modelo_config_sub_menu->exportar_data_log();
        $datos['export_bloque'] = $tabla_bloque_html;
        $datos['nombre'] = 'Log_Permisos';
        $this->load->view('templates/export_log',$datos);
    } 

}

?>
