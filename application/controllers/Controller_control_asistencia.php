<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Controller_control_asistencia extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('image_lib');
        $this->load->model('Mdl_compartido');
        $this->load->model('Modelo_control_asistencia');
        $this->load->model('M_settings');
        $this->load->model('M_settings_menu');
        date_default_timezone_set('America/Lima');
    }

    public function index(){

     	//Retornamos campo tipo de usuario
         $tipo_user          = $this->Mdl_compartido->retornarcampo($_SESSION['_SESSIONUSER'],'coduser','tb_usuarios','tipo_user');

         //Obtenemos el id del menu
         $header['id_menu']  = $this->Mdl_compartido->retornarcampo('seg_asistencia','ruta','config_sub_menu','id_menu');
         $id_sub_menu        = $this->Mdl_compartido->retornarcampo('seg_asistencia','ruta','config_sub_menu','id');
 
         //Validamos que tenga el permiso
         $permiso = $this->Mdl_compartido->permisos_menu_mejorado('seg_asistencia',$tipo_user);
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
        $this->load->view('seg_usuarios/v_control_asistencia', $data);
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
            $this->Modelo_control_asistencia->insert('user_control_detalle', $array);

            $ar['mensaje_2']='1';
            
        } else {
            $count_f  =  $this->Modelo_control_asistencia->get_fecha_val($slc_fecha_control_add);
            $result   =  $this->Modelo_control_asistencia->get_user_control();
            if ($count_f <= 0) {
                if ($result!='error') {
                    foreach ($result as $key) {
                        $array = array(
                            'fecha_registro' =>$slc_fecha_control_add ,
                            'id_usuario' => $key->coduser,
                            'delete' => 0
                        );
                        $this->Modelo_control_asistencia->insert('user_control_detalle', $array);
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
        $resultado = $this->Modelo_control_asistencia->load_select_fecha();
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
        $resultado = $this->Modelo_control_asistencia->load_select_mes_control();
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
        $resultado = $this->Modelo_control_asistencia->get_user_control();
        $cadena='<option value="">Usuario</option>'; 
        if($resultado!='error'){
            foreach($resultado as $key){
                $cadena.='<option value="'.$key->coduser.'">'.$key->nombres.' '.$key->apellidos.' ('.$key->coduser.')</option>'; 
            }
        }else{
            $cadena.=''; 
        }
        echo $cadena; 
    }

    function aplicar_filter_fecha(){
        $filtro_fecha = $this->input->post('filtro_fecha',true);
        unset($_SESSION['FILTRO_USUARIO']);
        if(!empty($filtro_fecha)){
            $_SESSION['FILTRO_FECHA'] = $filtro_fecha;
            echo 'si';
        }else{
           $_SESSION['FILTRO_FECHA'] = ''; 
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
        unset($_SESSION['FILTRO_USUARIO']);
        unset($_SESSION['FILTRO_MES']);

        if(!empty($fecha_inicio) && !empty($fecha_fin)){
            $_SESSION['FECHA_INICIO'] = $fecha_inicio;
            $_SESSION['FECHA_FIN'] = $fecha_fin;
           
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
 
    function get_tbl_control_asistencia(){       
        
        $res = $this->Modelo_control_asistencia->get_tbl_control_asistencia();

        if ($res != 'error') {
            $cadena = '';
            $t_total = 0;

            foreach ($res as $key) {
                $t_total++;

                $fecha_obj = new DateTime($key->fecha_registro);
                $fecha_obj->setTimezone(new DateTimeZone('America/Lima'));
                $fecha_formateada = $fecha_obj->format('d - F');
                $cadena .= '
                    <tr class="table_list"">
                        <td rowspan="2" style="width: auto; vertical-align: middle;">
                            <div style="text-align:center;" class="">
                                ' . $t_total . '
                            </div>
                        </td> 
                        <td rowspan="2" style="width: auto;vertical-align: middle;">
                            <div style="text-align:center;" >
                                <label id="txt_nombre_ctrl' . $t_total . '">'. $key->nombres . '</label>
                            </div>                           
                        </td>  
                        <td   style="width: auto;vertical-align: middle; text-align:center;">
                            <div>
                                <label>Fecha Registro<label>
                            </div>
                            
                            <div>
                                <label id="txt_fecha_registro_ctrl_' . $t_total . '">'.  $fecha_formateada . '</label>
                            </div>                          
                        </td>
                        
                        <td style="width: auto;">
                            <div style="text-align:center;" >
                                <input value="'.$key->hora_ingresar.'" type="time" class="form-control form-control-sm" id="txt_hora_entrada_ctrl_'. $t_total . '">
                            </div>                             
                        </td>                        
                        <td style="width: auto;">
                            <div style="text-align:center;" >
                                <select class="form-control form-control-sm" id="slc_resultado_entrada_ctrl_'.$t_total . '">';
                                if (!empty($key->des_entrada)) {
                                    $cadena.='
                                    <option value="' . $key->id_resultado_entrada . '" selected>' . $key->des_entrada . '</option>'; 
                                } 
                                    $cadena.='
                                    <option value="" >Seleccione</option>';                      
                                        $res_2 = $this->Modelo_control_asistencia->get_data_resultado('1');   
                                        foreach ($res_2 as $key2) {  
                                            $cadena .= '<option value="' . $key2->id . '">' . $key2->descripcion . '</option>';
                                        }                            
                                $cadena.='
                                </select> 
                                                                            
                            </div>                          
                        </td>
                    
                        <td style="width: auto;">
                            <div style="text-align:center;" >
                                <input value="'.$key->hora_salida.'" type="time" class="form-control form-control-sm" id="txt_hora_salida_ctrl_'. $t_total . '">
                            </div>                         
                        </td>
                        <td style="width: auto;">
                            <div style="text-align:center;" >
                                <select class="form-control form-control-sm" id="slc_resultado_salida_ctrl_'.$t_total . '">';
                                if (!empty($key->des_salida)) {
                                    $cadena.='
                                    <option value="' . $key->id_resultado_salida . '" selected>' . $key->des_salida . '</option>'; 
                                } 
                                $cadena.='
                                    <option value="" >Seleccione</option>'; 
                                    $res_3 = $this->Modelo_control_asistencia->get_data_resultado('0');
                                    foreach ($res_3 as $key3) {                                 
                                        $cadena .= '<option value="' . $key3->id . '">' . $key3->descripcion . '</option>';
                                    }                            
                                $cadena.='
                                </select> 
                                                            
                            </div>                          
                        </td>
                    
                        <td rowspan="2" style="width: auto; vertical-align: middle;">
                            <div style="text-align:center;" id="txt_asig_campania_' . $t_total . '">
                                <button type="button" class="btn btn-sm btn-outline-success" onclick="save_control('.$t_total.','.$key->id.')"><i class="bx bx-save"></i></i></button>
                            </div>                            
                        </td>
                        <td rowspan="2" style="width: auto;vertical-align: middle;">
                            <div style="text-align:center;" id="txt_asig_campania_' . $t_total . '">
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="delete_usuario_ctrl('.$key->id.')"><i class="bx bx-trash"></i></button>                           
                            </div>                            
                        </td>
                    </tr>
                    <tr>
                        <td style=" width: auto; vertical-align: middle; text-align: center;">
                            <div>
                                <label>Fecha Actualización</label><br>
                            </div>
                            <div>
                                <label id="txt_fecha_update_ctrl_' . $t_total . '">'.  $key->fecha_update . '</label>
                            </div>                          
                        </td>
                
                        <td colspan="2" style="width: auto;vertical-align: middle;">
                            <div style="text-align:center;" >
                                <div class="form-floating">
                                    <textarea type="text" class="form-control " placeholder="Leave a comment here" id="txt_obs_entrada_ctrl_'. $t_total . '">'.$key->obs_entrada.'</textarea>
                                    <label for="txt_obs_entrada_ctrl_'. $t_total . '">Observación Entrada</label>
                                </div>
                            </div>                           
                        </td>
                        <td colspan="2" style="width: auto;vertical-align: middle;">
                            <div style="text-align:center;" >
                                <div class="form-floating">
                                    <textarea type="text" class="form-control " placeholder="Leave a comment here" id="txt_obs_salida_ctrl_' . $t_total . '">'.$key->obs_salida.'</textarea>
                                    <label for="txt_obs_salida_ctrl_'. $t_total . '">Observación Salida</label>
                                </div>
                            </div>                           
                        </td>
                    </tr>
                    ';
            }
            
            

            $ar['mensaje'] = 'ok';
            $ar['resultado'] = $cadena;
        } else {
            $ar['mensaje'] = 'ok';
            $ar['resultado'] = '<tr><td colspan="6">Sin registros encontrados</td></tr>';
        }

        echo json_encode($ar);
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
            $id_monitoreo = $this->Modelo_control_asistencia->update('geochasq_bd_sistema_lindley.user_control_detalle',$array,$id); 
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
            'obs_salida'=>$txt_obs_salida_ctrl,
            'fecha_update'=>date('Y-m-d H:i:s'),
            'user_update'=>$_SESSION['_SESSIONUSER']
            
        );

        $result = $this->Modelo_control_asistencia->update('geochasq_bd_sistema_lindley.user_control_detalle',$array,$id); 
        $res = $this->Modelo_control_asistencia->get_fecha_upd($id);
    
        if ($res != 'error') {
            foreach ($res as $key) {
               $ar['fecha_upd'] = $key->fecha_update;
            }
            $ar['mensaje']='ok';
        }else{
            $ar['mensaje']='ok';
        }
        
        echo json_encode($ar);
    }

    function retirar_filtros(){
        unset($_SESSION['FILTRO_USUARIO']);
        unset($_SESSION['FILTRO_FECHA']); 
        unset($_SESSION['FECHA_INICIO']);
        unset($_SESSION['FECHA_FIN']);
        unset($_SESSION['FILTRO_MES']);
    }

/**************************************************************************************/
/********************** FUNCIONES exportar TABLA ASISTENCIA ***************************/
/**************************************************************************************/

    function exportar_bloque(){
        $tabla_bloque_html = $this->Modelo_control_asistencia->exportar_data_bloque();
        $datos['export_bloque'] = $tabla_bloque_html;
        $this->load->view('templates/export_bloque',$datos);
    } 

}

?>
