<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Controller_control_accessos extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('image_lib');
        $this->load->model('Mdl_compartido');
        $this->load->model('Modelo_control_accesos');
        $this->load->model('M_settings');
        $this->load->model('M_settings_menu');
        date_default_timezone_set('America/Lima');
    }

    public function index(){

        //Retornamos campo tipo de usuario
        $tipo_user          = $this->Mdl_compartido->retornarcampo($_SESSION['_SESSIONUSER'],'coduser','tb_usuarios','tipo_user');
        //Obtenemos el id del menu
        $header['id_menu']  = $this->Mdl_compartido->retornarcampo('seg_log_accesos','ruta','config_sub_menu','id_menu');
        $id_sub_menu        = $this->Mdl_compartido->retornarcampo('seg_log_accesos','ruta','config_sub_menu','id');
        //Validamos que tenga el permiso
        $permiso = $this->Mdl_compartido->permisos_menu_mejorado('seg_log_accesos',$tipo_user);
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
        $this->load->view('seg_usuarios/v_control_accesos', $data);
        $this->load->view('layouts/v_footer');

    }

/**************************************************************************************/
/***************************** FUNCIONES TABLA ASISTENCIA *****************************/
/**************************************************************************************/

    function add_user_control() {

        unset($_SESSION['FILTRO_USUARIO']);
        $cb_agregar_x_usuario       =          trim($this->input->post('cb_agregar_x_usuario',true));       
        $slc_fecha_control_add      =          trim($this->input->post('slc_fecha_control_add',true));
        $slc_usuario_control        =          trim($this->input->post('slc_usuario_control',true));
        if($slc_fecha_control_add==''){
            unset($_SESSION['FILTRO_FECHA']); 
        }else{
            $_SESSION['FILTRO_FECHA'] = $slc_fecha_control_add;
        }
        if ($cb_agregar_x_usuario == 1) {

            $array = array(
                'fecha_registro'    =>  $slc_fecha_control_add,
                'id_usuario'        =>  $slc_usuario_control,
                'delete'            =>  0
            );
            $this->Modelo_control_accesos->insert('user_control_detalle', $array);

            $ar['mensaje_2']='1';
            
        } else {
            $count_f  =  $this->Modelo_control_accesos->get_fecha_val($slc_fecha_control_add);
            $result   =  $this->Modelo_control_accesos->get_user_control();
            if ($count_f <= 0) {
                if ($result!='error') {
                    foreach ($result as $key) {
                        $array = array(
                            'fecha_registro' =>$slc_fecha_control_add ,
                            'id_usuario' => $key->coduser,
                            'delete' => 0
                        );
                        $this->Modelo_control_accesos->insert('user_control_detalle', $array);
                    }
                    $ar['mensaje']='ok';   
                } else {
                    $ar['mensaje']='error';
                }
                $ar['mensaje_1']='ok'; 
            } else {
                $ar['mensaje_1']='error'; 
            }

            $ar['mensaje_2']='2';
        }
        

        

        echo json_encode($ar);     
    }

    function load_select_fecha(){
        $resultado = $this->Modelo_control_accesos->load_select_fecha();
        $cadena='<option value="">fecha control</option>'; 
        if($resultado!='error'){
            foreach($resultado as $key){
                $cadena.='<option value="'.$key->fecha_registro.'">'.$key->fecha_registro.'</option>'; 
            }
        }else{
            $cadena.=''; 
        }
        echo $cadena; 
    }

    function load_select_mes_control(){
        $resultado = $this->Modelo_control_accesos->load_select_mes_control();
        $cadena='<option value="">Mes control</option>'; 
        if($resultado!='error'){
            foreach($resultado as $key){
                $mes='';
                switch ($key->mes_control) {
                    case 1:
                        $mes='ENERO';
                        break;  
                    case 2:
                        $mes='FEBRERO';
                        break; 
                    case 3:
                        $mes='MARZO';
                        break; 
                    case 4:
                        $mes='ABRIL';
                        break; 
                    case 5:
                        $mes='MAYO';
                        break; 
                    case 6:
                        $mes='JUNIO';
                        break; 
                    case 7:
                        $mes='JULIO';
                        break; 
                    case 8:
                        $mes='AGOSTO';
                        break; 
                    case 9:
                        $mes='SEPTIEMBRE';
                        break;
                    case 10:
                        $mes='OCTUBRE';
                        break; 
                    case 11:
                        $mes='NOVIEMBRE';
                        break; 
                    case 12:
                        $mes='DICIEMBRE';
                            break;                  
                    default:
                        $mes='ERROR';
                        break;
                }
                $cadena.='<option value="'.$key->mes_control.'">'.$mes.'</option>'; 
            }
        }else{
            $cadena.=''; 
        }
        echo $cadena; 
    }

    function load_usuario_add(){
        $resultado = $this->Modelo_control_accesos->get_user_control();
        $cadena='<option value="">Usuario</option>'; 
        if($resultado!='error'){
            foreach($resultado as $key){
                $cadena.='<option value="'.$key->id_usuario.'">'.$key->nombres.' '.$key->apellidos.'</option>'; 
            }
        }else{
            $cadena.=''; 
        }
        echo $cadena; 
    }

    function aplicar_filter_tipo_acceso(){
        $tipo_acceso = $this->input->post('tipo_acceso',true);
        unset($_SESSION['FILTRO_TIPO_ACCESO']);
        if(!empty($tipo_acceso)){
            $_SESSION['FILTRO_TIPO_ACCESO'] = $tipo_acceso;
            echo 'si';
        }else{
           $_SESSION['FILTRO_TIPO_ACCESO'] = ''; 
            echo 'nada';
           
        }
    }

    function aplicar_filter_mes(){
        $filtro_mes = $this->input->post('filtro_mes',true);
        unset($_SESSION['FILTRO_USUARIO']);
        unset($_SESSION['FECHA_INICIO']);
        unset($_SESSION['FECHA_FIN']);
        if(!empty($filtro_mes)){
            $_SESSION['FILTRO_MES'] = $filtro_mes;            
           
        }else{
           $_SESSION['FILTRO_MES'] = ''; 
          
           
        }
        echo ('fecha_inicio:'.$_SESSION['FECHA_INICIO']);
    }

    function filter_rango_fechas(){
        $fecha_inicio = $this->input->post('fecha_inicio',true);
        $fecha_fin = $this->input->post('fecha_fin',true);
      
        if(!empty($fecha_inicio) && !empty($fecha_fin)){

            $_SESSION['FECHA_INICIO'] = $fecha_inicio;
            $_SESSION['FECHA_FIN'] = $fecha_fin;
           echo $_SESSION['FECHA_INICIO'];
           echo $_SESSION['FECHA_FIN'];
        }else{
            unset($_SESSION['FECHA_INICIO']);
            unset($_SESSION['FECHA_FIN']); 
        }
    }

    function aplicar_filter_usuario(){
        $filtro_usuario = $this->input->post('filtro_usuario',true);
        if($filtro_usuario==''){
            unset($_SESSION['FILTRO_USUARIO']); 
        }else{
            $_SESSION['FILTRO_USUARIO'] = $filtro_usuario;
        }
    }

    

/**************************************************************************************/
/***************************** FUNCIONES TABLA ASISTENCIA *****************************/
/**************************************************************************************/
    function listar_registros(){
        if (!empty($_POST))
        {        
            $fetch_data = $this->Modelo_control_accesos->make_datatables();          
            $data = array();
            $contador=0; 
            
            foreach($fetch_data as $row)
            {
                $cl ="";      
                //$cl = $row->color;
                $contador++;               
                $sub_array = array();
                // columnas de las tablas
                $sub_array[] = $contador;  
                $sub_array[] = $row->des_tipo_acceso;
                $sub_array[] = $row->nombres.''.$row->apellidos;   
                $sub_array[] = $row->f_log_acceso;                   
                $sub_array[] = $row->des_menu;
                $sub_array[] = $row->des_sub_menu; 
                                                            
                $data[] = $sub_array;
            }
            $output = array(
                "draw"                  =>     intval($_POST["draw"]),
                "recordsTotal"          =>     $this->Modelo_control_accesos->get_all_data(),
                "recordsFiltered"       =>     $this->Modelo_control_accesos->get_filtered_data(),
                "data"                  =>     $data
            );
            echo json_encode($output);
        }
    }

   
/**************************************************************************************/
/********************** FUNCIONES OPCIONES TABLA ASISTENCIA ***************************/
/**************************************************************************************/

    function delete_usuario_ctrl(){
        $id= $this->input->post('id',true); 

        if ($id!=""){
            $array = array(  
                'delete'=>1                           
            );       
            $id_monitoreo = $this->Modelo_control_accesos->update('user_control_detalle',$array,$id); 
            echo '1';
        }else{
            echo '2';
        }

    }

    function grabar_progamacion(){
        $id                             =          trim($this->input->post('id',true));
        $txt_hora_entrada_ctrl          =          trim($this->input->post('txt_hora_entrada_ctrl',true));
        $slc_resultado_entrada_ctrl     =          trim($this->input->post('slc_resultado_entrada_ctrl',true));       
        $txt_obs_entrada_ctrl           =          trim($this->input->post('txt_obs_entrada_ctrl',true));
        $txt_hora_salida_ctrl           =          trim($this->input->post('txt_hora_salida_ctrl',true));
        $slc_resultado_salida_ctrl      =          trim($this->input->post('slc_resultado_salida_ctrl',true));
        $txt_obs_salida_ctrl            =          trim($this->input->post('txt_obs_salida_ctrl',true));
    
        $array = array(
            
            'hora_ingresar'=>$txt_hora_entrada_ctrl,
            'id_resultado_entrada'=>$slc_resultado_entrada_ctrl,
            'obs_entrada'=>$txt_obs_entrada_ctrl,
            'hora_salida'=>$txt_hora_salida_ctrl,
            'id_resultado_salida'=>$slc_resultado_salida_ctrl,
            'obs_salida'=>$txt_obs_salida_ctrl
            
        );

        $result = $this->Modelo_control_accesos->update('user_control_detalle',$array,$id); 
        
    }

    function retirar_filtros(){    
        unset($_SESSION['FILTRO_TIPO_ACCESO']);
        unset($_SESSION['FECHA_INICIO']);
        unset($_SESSION['FECHA_FIN']);
    }

/**************************************************************************************/
/********************** FUNCIONES exportar TABLA ASISTENCIA ***************************/
/**************************************************************************************/

    function exportar_bloque(){
        $tabla_bloque_html = $this->Modelo_control_accesos->exportar_data_bloque();
        $datos['export_bloque'] = $tabla_bloque_html;
        $this->load->view('templates/export_bloque',$datos);
    } 

}

?>
