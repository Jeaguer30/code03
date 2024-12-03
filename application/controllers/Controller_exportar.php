<?php 
defined('BASEPATH') OR exit('No direct script access allowed');


require_once("file_all/pdf/dompdf/autoload.inc.php");
use Dompdf\Dompdf;
use Dompdf\Options;


class Controller_exportar extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('image_lib');
        $this->load->model('Mdl_compartido');
        $this->load->model('Modelo_exportar');
        $this->load->model('M_settings');
        date_default_timezone_set('America/Lima');
    }

    public function index(){      
        //................
    }


    /*
    public function generar_pdf_fin_contrato($codigo){
        $html = $this->Modelo_exportar->generar_pdf_fin_contrato($codigo);
        //$html ='<h1>Hola mundo</h1>'; 
        $pdf = new Dompdf();
        $pdf->set_paper("A4", "portrait");
        $pdf->load_html(utf8_encode($html));
        $pdf->render();
        $pdf->stream($codigo.'_Carta_Notarial_SL.pdf');

    }*/

    
        
   


    /*------------------- EXCEL ------------------------*/
    /*--------------------------------------------------*/


  


    function exportar_control_visita1(){
        $tabla_guia_html = $this->Modelo_exportar->exportar_data_make_query1();
        $datos['export_control_visita'] = $tabla_guia_html;
        $datos['nombre'] = 'CVC_Solicitudes';  
        $this->load->view('templates/export_control_visita', $datos);
    }


    /*------------------- PDF ------------------------*/
    /*--------------------------------------------------*/


    public function generar_pdf_solicitudes(){
        $html = $this->Modelo_exportar->generar_excel_solicitudes();
        $pdf = new Dompdf();
        $pdf->set_paper("A4", "portrait");
        $pdf->load_html(utf8_encode($html));
        $pdf->render();
        $pdf->stream($codigo.'_CVC_Solicitudes.pdf');
    }
   
}

?>
