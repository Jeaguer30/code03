<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Controller_404 extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('image_lib');
        $this->load->model('Mdl_compartido');
        $this->load->model('M_settings');
        $this->load->model('M_settings_menu');
        $this->load->model('M_perfil');
        date_default_timezone_set('America/Lima');
    }

    public function index(){

        //Retornamos campo tipo de usuario
        $tipo_user          = $this->Mdl_compartido->retornarcampo($_SESSION['_SESSIONUSER'],'coduser','tb_usuarios','tipo_user');
        //Obtenemos el id del menu
        $header['id_menu']  = $this->Mdl_compartido->retornarcampo('seg_control_anomalias','ruta','config_sub_menu','id_menu');
        $id_sub_menu        = $this->Mdl_compartido->retornarcampo('seg_control_anomalias','ruta','config_sub_menu','id');
        //Validamos que tenga el permiso
        $permiso = $this->Mdl_compartido->permisos_menu_mejorado('seg_control_anomalias',$tipo_user);
        if (!$permiso){
            redirect('');
        }
        if(!isset($_SESSION['_SESSIONUSER'])){
            redirect('login');
        }
        //Registro de acceso al modulo (tipo de acceso(1 login, 2 acceso modulo) y id sub menu)
       // $this->Mdl_compartido->registrar_accesos(2,$id_sub_menu);

        
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
      
        $data['datos']='';
        $header['datos_header']='';
        $header['lang']='en';
        $this->load->view('layouts/v_head',$header);
        if($position=='vertical'){
            $this->load->view('layouts/vertical_menu_dinamico',$header);
        }else{
            $this->load->view('layouts/horizontal_menu_dinamico',$header);
        }
        $this->load->view('other_pages/pages-404', $data);
        $this->load->view('layouts/v_footer');

    }
  

}

?>
