<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Controller_historial_acciones extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('image_lib');
        $this->load->model('Mdl_compartido');
        $this->load->model('Modelo_usuario');
        $this->load->model('M_settings');
        date_default_timezone_set('America/Lima');
    }


    /*AGREGAR POR USUARIO*/
    function historial_accion(){
        $vista             = trim($this->input->post('vista',true));
        $array = array(                     
           
            'user'                  => $_SESSION['_SESSIONUSER'],
            'fecha_accion'          => date('Y-m-d H:i:s'),
            'detalle_accion'        => $vista,                  
            'del'           => 0
        );
        $result = $this->Mdl_compartido->insert_table('tb_historial_navegacion_geo', $array);
        echo $result;     
    }

   

 
   
}

?>
