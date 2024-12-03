<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Controller_validar_session extends CI_Controller
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


    }

    public function validar_session(){

        if(!isset($_SESSION['_SESSIONUSER'])){
            $ar['mensaje']='error';
        }else {
            $ar['mensaje']='ok';
        }

        echo json_encode($ar);
    }

    public function delete_session(){
        unset($_SESSION['_SESSIONUSER']);
    }
  

}

?>
