<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Controller_formulario_pruebas extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //$this->load->library('image_lib');
        $this->load->model('Mdl_compartido');  
        $this->load->model('M_settings');
        $this->load->model('M_settings_menu');
        $this->load->model('Modelo_formulario_pruebas');
        date_default_timezone_set('America/Lima');
    }

    public function index(){

        /* ingreso Marcador*/
        //get
        $_SESSION['_SESSION_UNIQUE_ID'] = $_GET['uniqueid'];     
        $_SESSION['_SESSION_USER_ID'] = $_GET['user'];   
        $_SESSION['_SESSION_PHONE_NUMBER'] = $_GET['phone_number'];


        //enviar esto 05/11/2024
        $data['unique_id_obtenido'] = $_GET['uniqueid'];




        $id_unico =     $this->Mdl_compartido->retornarcampo( $_SESSION['_SESSION_UNIQUE_ID'],'uniqueid','cvc_call','uniqueid'); 
        
        // condicion es unico , no es vacio , no es cero
        if($_SESSION['_SESSION_UNIQUE_ID'] != $id_unico && $_SESSION['_SESSION_UNIQUE_ID'] != "" && $_SESSION['_SESSION_UNIQUE_ID'] != 0){
            
            $id_call = $this->Modelo_formulario_pruebas->insert_call('cvc_call', array('uniqueid' => $_SESSION['_SESSION_UNIQUE_ID'],  'f_add' => date('Y-m-d H:i:s'), 'user_add'  => $_SESSION['_SESSIONUSER'], 'user_marcador'  => $_SESSION['_SESSION_USER_ID'], 'celular'  => $_SESSION['_SESSION_PHONE_NUMBER']  ));
           
            // creaer session id_call
            $_SESSION['_SESSION_CALL_ID'] =  $id_call; 
       
        }
       

        /* configiruracion de la vista */
        $tipo_user          = $this->Mdl_compartido->retornarcampo($_SESSION['_SESSIONUSER'],'coduser','tb_usuarios','tipo_user');
        $header['id_menu']  = $this->Mdl_compartido->retornarcampo('seg_formulario_pruebas','ruta','config_sub_menu','id_menu');
        $id_sub_menu        = $this->Mdl_compartido->retornarcampo('seg_formulario_pruebas','ruta','config_sub_menu','id');
    

        //Validamos que tenga el permiso
        $permiso = $this->Mdl_compartido->permisos_menu_mejorado('seg_formulario_pruebas',$tipo_user);
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
        //$this->restablecer_filtros();
        $this->retirar_filtros();

        $data['datos']='';
        $header['datos_header']='';
        $header['lang']='en';
        $this->load->view('layouts/v_head',$header);
        if($position=='vertical'){
            //$this->load->view('layouts/vertical_menu_dinamico',$header);
        }else{
           // $this->load->view('layouts/horizontal_menu_dinamico',$header);
        }
    
        $this->load->view('vista_formulario_pruebas', $data);
        $this->load->view('layouts/v_footer');

    }

    /*05/11/2024 */
    function valida_uniqueid(){
        $uniqueid                  = trim($this->input->post('dato',true));
        if($uniqueid==''){        
            $uniqueid =   $this->Modelo_formulario_pruebas->obtener_uniqueid($_SESSION['_SESSION_USER_ID'],$_SESSION['_SESSION_PHONE_NUMBER']);
            //Armamos link nuevo
            $uniqueid = 'https://geochasqui.com/sistema_cvc/seg_formulario_pruebas?user='.$_SESSION['_SESSION_USER_ID'].'&phone_number='.$_SESSION['_SESSION_PHONE_NUMBER'].'&uniqueid='.$uniqueid;
        }else{
            $uniqueid='ok';
        }

        echo $uniqueid; 

    }
    /*FIN 05/11/2024 */


    function actualizar(){     
        $id                  = trim($this->input->post('id',true));
        $resumen             = trim($this->input->post('text_resumen_sol',true));
        $id_estado_solicitud = trim($this->input->post('txt_estado_sol',true));
        $f_upd               = date('Y-m-d H:i:s');

        $array = array(
            'resumen_breve'     => $resumen,
            'id_estado_solicitud'=>$id_estado_solicitud,
            'f_upd'             => $f_upd,
            'user_upd'          => $_SESSION['_SESSIONUSER']
        );
        $result = $this->Modelo_formulario_pruebas->update('cvc_solicitudes',$array,$id,'id');    
        echo $result;
    }



    function armar_selects($arr,$id_registro,$id_registro2,$campo){
        $cadena='<option value=""> Seleccione </option>';
        foreach ($arr as $key) {
            if($key->id==$id_registro){
                $cadena.='<option selected value="'.$key->id.'">'.$key->descripcion.'</option>';            
            }else{
                if($campo!='0'){
                    if($key->$campo==$id_registro2){
                        $cadena.='<option  value="'.$key->id.'">'.$key->descripcion.'</option>';
                    }
                }else{
                    $cadena.='<option  value="'.$key->id.'">'.$key->descripcion.'</option>';
                }

            }
        }
        return $cadena; 
    }

    function set_border_left($id_estado){
        $cd = '';
        switch ($id_estado) {
            case 1:
                $cd = ' style="border-left: 3px solid #4caf50;" '; 
                break;
            case 2:
                $cd = ' style="border-left: 3px solid #efc400;" '; 
                break;
            case 3:
                $cd = ' style="border-left: 3px solid #00bcd4;" ';                 
                break;       
            case 4:
                $cd = ' style="border-left: 3px solid red;" ';                 
                break;                                
            default:
                break;
        }
        return $cd;
    }

    function set_bg($id_estado){
        $cd = '';
        switch ($id_estado) {
            case 1:
                $cd = ' bg-soft-success'; 
                break;
            case 2:
                $cd = ' bg-soft-warning'; 
                break;
            case 3:
                $cd = ' bg-soft-info';                 
                break;       
            case 4:
                $cd = ' bg-soft-danger';                 
                break;                                
            default:
                break;
        }
        return $cd;
    }

    function get_registros(){

        /*Para Páginación*/
        $limite     = 5;
        /*Donde te ubicas*/
        $ubica      = 0; 
        //(session_paginacion___-1)*2 
        if(isset($_SESSION['SESSION_SOL_PAG'])){
            $paginacion = ($_SESSION['SESSION_SOL_PAG']-1)*$limite; 
            $ubica = $_SESSION['SESSION_SOL_PAG']; 
        }else{
            $paginacion=0;     
        }
        

        //Armamos la paginación 
        $result_pag = $this->Modelo_formulario_pruebas->get_total_registros_pag('cvc_solicitudes a');
        
        //Dividimos entre el limite
        $total_bot = ceil($result_pag/$limite); 

        $cad_bot_pag=''; 
        $tipo_filtro = "'"."paginacion"."'";
        for ($i=0; $i <$total_bot ; $i++) { 
            $t = $i+1; 
            //ubica
            if($ubica==$t){
                $cad_bot_pag .= '<button type="button" class="btn btn-danger" onclick="activar_filtro('.$tipo_filtro.','.$t.');">'.$t.'</button>'; 
            }else{
                $cad_bot_pag .= '<button type="button" class="btn btn-secondary" onclick="activar_filtro('.$tipo_filtro.','.$t.');">'.$t.'</button>'; 
            }
        }
        $ar['paginacion'] = $cad_bot_pag; 
        $ar['total_botones'] = $total_bot; 
        $ar['total_items'] = $result_pag; 
        $ar['nro_limite'] = $limite; 
        $ar['nro_paginacion'] = $paginacion; 

        //Obtenemos los datos para el select
        $result     = $this->Modelo_formulario_pruebas->get_registros('cvc_solicitudes a',$limite,$paginacion);

        $r_estado_solicitud = $this->Modelo_formulario_pruebas->get_select('cvc_estado_solicitud');

 

        $resultados =0; 
        $cadena='';
        if($result!='error'){
            foreach ($result as $key) {
                $resultados++; 
                $color      = $this->set_border_left($key->id_estado_solicitud);
                $bg      = $this->set_bg($key->id_estado_solicitud);


                $sel_area       = '';
                $sel_cargo      = '';
                $sel_contrato   = '';
                $sel_frecuencia = '';

                
                $sel_estado_solicitud = $this->armar_selects($r_estado_solicitud,$key->id_estado_solicitud,0,'0');

                $cadena.='
                <div class="card p-2" '.$color.'>
                    <div class="card-body">
                        <div>
                            <div class="py-3">
                                <div class="row align-items-center">
                                    <div class="col-lg-2">
                                        <div class="row">

                                            <div class="col-md-12">
                                                <div>
                                                    <h5 class="font-size-11">Nro Ticket: '.$key->id.'</h5>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div>
                                                    <h5 class="font-size-11">Teloperador: '.$key->nombres.'</h5>
                                                </div>
                                            </div>                                            

                                            <div class="col-md-12">
                                                <div>
                                                    <h5 class="font-size-14">Cliente</h5>
                                                    <span>'.$key->razon_social.'</span>
                                                </div>
                                            </div>

                                            <div class="col-md-12 ">
                                                <div>
                                                    <span>Ruc: '.$key->ruc.'</span>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div>
                                                    <span>Cod Iscom: '.$key->codigo_iscom.'</span>
                                                </div>
                                            </div>

                                            <div class="col-md-12 mt-2">
                                                <h5 class="font-size-14">Estado</h5>
                                            </div>

                                            <div class="col-md-12">
                                                <div>
                                                    <select class="form-control form-control-sm '.$bg.'" id="txt_estado_sol_'.$key->id.'">
                                                        '.$sel_estado_solicitud.'
                                                    </select>
                                                </div>
                                            </div>                                                                                                        
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div id="panel_detalle_'.$key->id.'" style="display:block">
                                            <div class="row">

                                                <div class="col-md-3">
                                                    <div>
                                                        <h5 class="font-size-13">Fecha</h5>
                                                        <input type="datetime" disabled class="form-control form-control-sm" id="txt_fecha_reg_'.$key->id.'" value="'.$key->f_registro.'">
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div>
                                                        <h5 class="font-size-13">Distribuidor</h5>
                                                        <input type="text" disabled class="form-control form-control-sm" id="txt_dis_sol_'.$key->id.'"  value="'.$key->distribuidor_local.'" >
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div>
                                                        <h5 class="font-size-13">Nro Suministro</h5>
                                                        <input type="text" disabled class="form-control form-control-sm" id="txt_dis_sol_'.$key->id.'"  value="'.$key->nro_suministro_distri.'" >
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div>
                                                        <h5 class="font-size-13">Alimentador</h5>
                                                        <input type="text" disabled class="form-control form-control-sm" id="txt_dis_sol_'.$key->id.'"  value="'.$key->alimentador.'" >
                                                    </div>
                                                </div>     
                                                
                                                <div class="col-md-2">
                                                    <div>
                                                        <h5 class="font-size-13">PMI</h5>
                                                        <input type="text" disabled class="form-control form-control-sm" id="txt_dis_sol_'.$key->id.'"  value="'.$key->pmi.'" >
                                                    </div>
                                                </div>                                                     
                                                
                                                <div class="col-md-9">
                                                    <div>
                                                        <h5 class="font-size-13">Dirección</h5>
                                                        <input type="text" disabled class="form-control form-control-sm"  id="txt_dir_sol_'.$key->id.'"  value="'.$key->direccion_suministro.'">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-3">
                                                    <div>
                                                        <h5 class="font-size-13">Departamento</h5>
                                                        <input type="text" disabled class="form-control form-control-sm"  id="txt_dep_sol_'.$key->id.'"  value="'.$key->departamento.'/'.$key->provincia.'/'.$key->distrito.'">
                                                    </div>
                                                </div>  

                                                
                                                <div class="col-md-12 pt-3">
                                                    <h5 class="font-size-13">Resumen Breve :</h5>
                                                    <div>
                                                        <textarea class="form-control" id="text_resumen_sol_'.$key->id.'"> '.$key->resumen_breve.' </textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-center">
                                        <button style="display:none;" id="btn_regresar_'.$key->id.'" class="btn btn-sm btn-secondary waves-effect waves-light mb-1 form-control"  onclick="regresar('.$key->id.');"> <i class="mdi mdi-keyboard-backspace"></i> Regresar</button>
                                        <button id="btn_actualizar_'.$key->id.'" class="btn btn-sm btn-info waves-effect waves-light mb-1 form-control"  onclick="actualizar('.$key->id.');"> <i class="mdi mdi-square-edit-outline"></i> Actualizar</button>
                                        <button class="btn btn-sm btn-info waves-effect waves-light mb-1 form-control"  onclick="ver_contactos('.$key->id.');"><i class="mdi mdi-spider-web"></i> Contactos</button>
                                        <button class="btn btn-sm btn-info waves-effect waves-light mb-1  form-control" onclick="ver_seguimientos('.$key->id.');"><i class="mdi mdi-spider-web"></i> Seguimiento</button>
                                        <button class="btn btn-sm btn-danger waves-effect waves-light mb-1  form-control" onclick="eliminar('."'".'solicitud'."',".$key->id.',0);"><i class="mdi mdi-trash-can"></i> Eliminar</button>
                                    </div>

                                    <div class="col-lg-12 mt-3">
                                        <div id="panel_respon_'.$key->id.'" style="display:none;padding: 10px;background: #fafafa;">
                                            <label>REGISTRAR CONTACTOS: </label>
                                            <div class="d-flex justify-content-center">
                                                <input type="text"  class="form-control form-control-sm" placeholder="Nombres del contacto." id="txt_sol_contacto_'.$key->id.'">
                                                <input type="text"  class="form-control form-control-sm" placeholder="Numero Celular." id="txt_sol_celular_'.$key->id.'">
                                                <button class="btn btn-sm btn-secondary" onclick="agregar('."'".'contacto'."'".','.$key->id.')"> Agregar</button>
                                            </div>
                                            <label class="mt-2">LISTADO</label>
                                            <div class="d-flex flex-column justify-content-center" id="lista_respon_'.$key->id.'">
                                            </div>
                                        </div> 
                                        
                                        <div id="panel_reque_'.$key->id.'" style="display:none;padding: 10px;background: #fafafa;">
                                            <label>SEGUIMIENTOS: </label>
                                            <div class="d-flex justify-content-center">
                                                <input type="text"  class="form-control form-control-sm" placeholder="Ingrese detalle del seguimiento realizado." id="txt_des_reque_'.$key->id.'">
                                                <button class="btn btn-sm btn-secondary" onclick="agregar('."'".'seguimiento'."'".','.$key->id.')"> Agregar</button>
                                            </div>
                                            <label class="mt-2">LISTADO</label>
                                            <div class="d-flex flex-column justify-content-center" id="lista_reque_'.$key->id.'">
                                            
                                            </div>
                                        </div>                                 
                                    </div>
                                </div>
                            </div>
                        </div>                                
                    </div>
                </div>                   
                
                ';
            }

            //Viendo total de resultados
            $ar['viendo'] = 'Viendo '.$resultados.' de '.$result_pag.' resultados';
            
        }else{
            $cadena.='
                <div class="card p-2">
                    <div class="card-body">
                        <label>No encontraron resultados en el filtro aplicado.</label>
                    </div>
                </div>
            ';
        }
        $ar['registros'] = $cadena; 
        //echo $cadena; 
        echo json_encode($ar);
    }

    function insert(){
        $id_usuario          = $_SESSION['_SESSIONUSER']; 
        $id_cliente          = trim($this->input->post('id',true)); 
        $f_registro          = date('Y-m-d H:i:s');
        $array = array(
            'id_usuario'            => $id_usuario,
            'id_cliente'            => $id_cliente,
            'id_estado_solicitud'   => 2,
            'f_registro'            => $f_registro
        );
        $result = $this->Modelo_formulario_pruebas->insert('cvc_solicitudes',$array);
        echo $result;
    }

    function insert_registros(){
        $tipo       = trim($this->input->post('tipo',true));
        $id_sol       = trim($this->input->post('id',true));
        $des       = trim($this->input->post('des',true));
       // $per       = trim($this->input->post('per',true));
       // $mot       = trim($this->input->post('mot',true));
        $cel       = trim($this->input->post('cel',true));

        switch ($tipo) {
            case 'contacto':
                $array = array(
                    'descripcion'            => $des,
                    'celular'            => $cel,
                    'id_solicitud'          => $id_sol,
                    'f_registro'          => date('Y-m-d H:i:s')
                );
                $result = $this->Modelo_formulario_pruebas->insert('cvc_contactos',$array);
                break;
            case 'seguimiento':
                $array = array(
                    'descripcion'      => $des,
                    'id_call'          => $_SESSION['_SESSION_CALL_ID'],              
                    'id_solicitud'     => $id_sol,
                    'id_usuario'       => $_SESSION['_SESSIONUSER'],
                    'f_registro'       => date('Y-m-d H:i:s')
                    // 'motivo_llamada'         => $mot,
                     // 'persona_llamada'        => $per,
                );
                $result = $this->Modelo_formulario_pruebas->insert('cvc_seguimientos',$array);
                break;                
            default:
                break;
        }
        echo $result;
    }

    /*Obtener datos de select según el id seleccionado*/
    function get_datos_select_x_id(){
        $tipo       = trim($this->input->post('tipo',true));
        $id_sol       = trim($this->input->post('id_sol',true));
        $id_seleccion       = trim($this->input->post('id_seleccion',true));
        $table=''; 
        switch ($tipo) {
            case 'cargos':
                $table='cargo';
                break;
            default:
                break;
        }

        $result    = $this->Modelo_formulario_pruebas->get_select_x_id($table,$id_seleccion,'id_area');

        $cadena='<option value="">Seleccione</option>'; 
        if($result!='error'){
            foreach ($result as $key) {
                $cadena.='
                <option value="'.$key->id.'">'.$key->descripcion.'</option>
                '; 
            }
        }else{
            $cadena= '<option value="">Sin Registros</option>';
        }
        echo $cadena;
    }

    function get_registros_adicional(){
        $tipo       = trim($this->input->post('tipo',true));
        $id_sol       = trim($this->input->post('id_sol',true));

        $table=''; 
        switch ($tipo) {
            case 'seguimiento':
                $table='cvc_seguimientos a';
                $table2='tb_usuarios b';
                $table3='cvc_call c';
                $table4='cvc_call_motivo d';
                $table5='cvc_call_salientes e';
                $result    = $this->Modelo_formulario_pruebas->get_select_x_id_join($table,$id_sol,'id_solicitud',$table2,$table3,$table4,$table5 );
                break;
            case 'contacto':
                $table='cvc_contactos';
                $result    = $this->Modelo_formulario_pruebas->get_select_x_id($table,$id_sol,'id_solicitud');
                break;
            default:
                break;
        }

     

        $cadena=''; 
        if($result!='error'){
            foreach ($result as $key) {
                switch ($tipo) {
                    case 'seguimiento':

                        $r_motivo = $this->Modelo_formulario_pruebas->get_select('cvc_call_motivo');
                        $sel_motivo_call = $this->armar_selects($r_motivo,$key->id_motivo,0,'0');

                        if($key->id_tipo_llamada== 1){ //entrante
                            $bg_call = 'bg-primary';
                            $icon_call = 'bx-phone-incoming';
                            $tit = 'LLamada Entrante';
                            $campo = 'Cliente :';
                            $contacto = $key->nombres_cliente;
                            
                            
                        }else{
                            $bg_call = 'bg-danger';
                            $icon_call = 'bx-phone-outgoing';                         
                            $tit = 'LLamada Saliente';
                            $campo = 'Saliente: ';
                            $contacto = $key->des_saliente;
                        }


                        $cadena.='
                                <li class="activity-list activity-border">
                                    <div class="activity-icon avatar-md " title="'.$tit.'">
                                        <span class="avatar-title '.$bg_call.' rounded-circle">
                                        <i class="bx '.$icon_call.' font-size-20"></i>
                                
                                        </span>
                                    </div>
                                    <div class="timeline-list-item">
                                        <div class="d-flex">   
                                            <div class="col-3">                                              
                                                <div class="font-size-13"><b>'.$campo.'</b>  '.$contacto.' </div>
                                                <div class="font-size-13"><b>Teléfono: </b>  '.$key->celular.' </div>       
                                                <div class="font-size-13"><b>Teleoperador: </b>  '.$key->nombres.' </div>        
                                                <div class="font-size-13"><b>Fecha: </b>  '.$key->f_registro.' </div>                         
                                                 
                                                                                                                   
                                            </div>

                                            <div class="col-7">
                                                                                            
                                                <textarea class="form-control" id="text_resumen_seg_'.$key->id.'"> '.$key->descripcion.' </textarea>                                                                                                                                           
                                            </div>
                                                                                 
                                            <div class="col-2 text-end">   
                                                <h6 class="mb-1">Opciones</h6>                              
                                                <div class=" text-end">
                                                    <button type="button" class="btn btn-primary waves-effect waves-light" title="Guardar seguimiento" onclick="action('."'".'upd_seguimiento'."'".','.$key->id.')" >
                                                        <i class="bx bx-save font-size-16 align-middle me-1"></i>Grabar
                                                    </button>                                                                                                   
                                                    <button type="button" class="btn btn-danger waves-effect waves-light" title="Eliminar seguimiento" onclick="eliminar('."'".$tipo."'".','.$key->id_solicitud.','.$key->id.')">
                                                        <i class="bx bx-trash font-size-16 align-middle"></i>                                                       
                                                    </button>
                                                </div>                                     
                                            </div>


                                        </div>
                                    </div> 
                                </li>                          
                        '; 
                        break;
                    case 'contacto':
                        $cadena.='
                            <div class="row mb-2">
                                <div class="col-lg-2">
                                    <p class="card-title-desc me-auto bd-highlight">'.$key->descripcion.'</p>
                                </div>
                                <div class="col-lg-2">
                                    <p class="card-title-desc me-auto bd-highlight">'.$key->celular.'</p>
                                </div>      
                                <div class="col-lg-2">
                                    <button class="btn btn-sm btn-danger btn-rounded bd-highlight m-1" onclick="eliminar('."'".$tipo."'".','.$key->id_solicitud.','.$key->id.')"><i class="mdi mdi-close"></i></button>
                                </div>                                                                                                
                            </div>                
                        '; 
                        break;
                    default:
                        break;
                }
            }
        }else{
            $cadena= 'Sin Registros';
        }
        echo $cadena;
    }

    function eliminar(){
        $tipo       = trim($this->input->post('tipo',true));
        $id_reg       = trim($this->input->post('id_reg',true));
        $id_sol       = trim($this->input->post('id_sol',true));
        
        $table=''; 
        switch ($tipo) {
            case 'seguimiento':
                $table='cvc_seguimientos';
                $result    = $this->Modelo_formulario_pruebas->eliminar($table,$id_reg);
                break;
            case 'contacto':
                $table='cvc_contactos';
                $result    = $this->Modelo_formulario_pruebas->eliminar($table,$id_reg);
                break; 
            case 'solicitud':
                $table='responsabilidades';
                $array = array(
                    'del'       => 1,
                    'f_del'     => date('Y-m-d H:i:s'),
                    'user_del'  => $_SESSION['_SESSIONUSER']
                );
                $result = $this->Modelo_formulario_pruebas->update('cvc_solicitudes',$array,$id_sol,'id');
                break;                            
            default:
                break;
        }

        echo $result;
    }
    
    public function subir_foto(){
        $id = $_SESSION['_SESSIONUSER'];
        $valida='';
        $config=[
            'upload_path'=>"./public/images/tag",
            'allowed_types'=>'png|jpg|jpeg',
            'file_name'=> ''.$id.'_'
        ];
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('file')){
            $data=array("upload_data"=>$this->upload->data());
            $nombre=$data['upload_data']['file_name'];
            $array = array(
                'foto'=>$nombre
            );
            $res = $this->Modelo_formulario_pruebas->update('tb_usuarios',$array,$id);
            if($res){
                    $valida='si';
            }else{
                    $valida='no';
            }         
        }else{
            $nombre="sinimagen.jpg";
            //.$this->upload->display_errors();;
        }        

        $ar['valida'] = $valida;
        $ar['imagen'] = $nombre;
        $dato_json   = json_encode($ar);
        echo $dato_json;                
    }

    /*
        Get Indicadores
    */
    function get_indicadores(){
        $r_indicadores = $this->Modelo_formulario_pruebas->get_totales_indicador('cvc_solicitudes','cvc_estado_solicitud');
        $activo     =0;
        $en_espera  =0;
        $completado =0;
        $cancelado  =0;

        if($r_indicadores!='error'){
            foreach ($r_indicadores as $key) {
                switch ($key->id_estado_solicitud) {
                    case 1:
                        $activo=$key->total;
                        break;
                    case 2:
                        $en_espera=$key->total;
                        break;
                    case 3:
                        $completado=$key->total;
                        break;
                    case 4:
                        $cancelado=$key->total;
                        break;                                                                        
                    default:
                        break;
                }
            }
        }
        $ar['activo']       = $activo; 
        $ar['en_espera']    = $en_espera; 
        $ar['completado']   = $completado; 
        $ar['cancelado']    = $cancelado; 
        echo json_encode($ar);
    }

    /*
        FILTROS DE CONSULTA
    */
    function get_select_filtros(){
        $r_estado_solicitud = $this->Modelo_formulario_pruebas->get_select('cvc_estado_solicitud');
        //$r_tipo_contrato    = $this->Modelo_formulario_pruebas->get_select('tipo_contrato');
        //$r_tipo_frecuencia  = $this->Modelo_formulario_pruebas->get_select('tipo_frecuencia');
        $r_solicitud  = $this->Modelo_formulario_pruebas->get_filtro_mes('cvc_solicitudes');

        $estado =''; 
        if(isset($_SESSION['SESSION_SOL_ESTADO'])){
            $estado=$_SESSION['SESSION_SOL_ESTADO'];
        }

       

        $mes =''; 
        if(isset($_SESSION['SESSION_SOL_MES'])){
            $estado=$_SESSION['SESSION_SOL_MES'];
        }

        
        $c_estado_solicitud = '<option value="">Estado Solicitud</option>';
        if($r_estado_solicitud!='error'){
            foreach ($r_estado_solicitud as $key) {
                if($estado==$key->id){
                    $c_estado_solicitud .= '<option selected value="'.$key->id.'">'.$key->descripcion.'</option>';
                }else{
                    $c_estado_solicitud .= '<option value="'.$key->id.'">'.$key->descripcion.'</option>';
                }
            }
        }
        $ar['estado_solicitud'] = $c_estado_solicitud; 

    
        $c_solicitud = '<option value="">Mes solicitud</option>';
        if($r_solicitud!='error'){
            foreach ($r_solicitud as $key) {
                if($mes==$key->mes){
                    $c_solicitud .= '<option selected value="'.$key->mes.'">'.$key->descripcion.'</option>';
                }else{
                    $c_solicitud .= '<option value="'.$key->mes.'">'.$key->descripcion.'</option>';
                }

            }
        }
        $ar['mes_solicitud'] = $c_solicitud; 

        echo json_encode($ar);

    }   

    /*
        RETIRAR FILTROS
    */
    function retirar_filtros(){
        unset($_SESSION['SESSION_SOL_ESTADO']);       
        unset($_SESSION['SESSION_DATO_BUSCAR']);   

        unset($_SESSION['_SESSION_CODIGO_CLIENTE']);  
        unset($_SESSION['_SESSION_CODIGO_CLIENTE1']);  
        unset($_SESSION['_SESSION_CODIGO_CLIENTE3']);  
        unset($_SESSION['SESSION_CONTACTOS_CVC']);  
        unset($_SESSION['SESSION_CONTACTO_DISTRIBUIDOR_CVC']);  
        
        unset($_SESSION['_SESSION_CODIGO_ISCOM_1']);  
        unset($_SESSION['_SESSION_CODIGO_ISCOM_2']);  
        

        
        unset($_SESSION['SESSION_ESTADO_SEGUIMIENTO']); 
        //unset($_SESSION['SESSION_SOL_FRECUENCIA']); 
        unset($_SESSION['SESSION_SOL_MES']); 
    }

    /*
        PARA FILTROS
    */
    function activar_filtro(){
        $tipo   = $this->input->post('tipo');
        $dato   = $this->input->post('dato');

        switch ($tipo) {
            case 'buscador':
                if($dato==''){
                    unset($_SESSION['SESSION_DATO_BUSCAR']); 
                }else{
                    $_SESSION['SESSION_DATO_BUSCAR']=$dato; 
                }
                break;
 
            case 'paginacion':
                if($dato==''){
                    unset($_SESSION['SESSION_SOL_PAG']); 
                }else{
                    $_SESSION['SESSION_SOL_PAG']=$dato; 
                }
                break;

            case 'estado_solicitud':
                if($dato==''){
                    unset($_SESSION['SESSION_SOL_ESTADO']); 
                }else{
                    $_SESSION['SESSION_SOL_ESTADO']=$dato; 
                }
                break;

            case 'estado_solicitud_seguimiento':
                if($dato==''){
                    unset($_SESSION['SESSION_ESTADO_SEGUIMIENTO']); 
                }else{
                    $_SESSION['SESSION_ESTADO_SEGUIMIENTO']=$dato; 
                }
                break;

            
            case 'mes':
                if($dato==''){
                    unset($_SESSION['SESSION_SOL_MES']); 
                }else{
                    $_SESSION['SESSION_SOL_MES']=$dato; 
                }                  
                break;           
                
            default:
                break;
        }
    }

    function activar_filtro_seguimiento(){    
        $dato   = $this->input->post('dato');
        if($dato==''){
            unset($_SESSION['SESSION_ESTADO_SEGUIMIENTO']); 
        }else{
            $_SESSION['SESSION_ESTADO_SEGUIMIENTO']=$dato; 
        }
        
    }


    function activar_filtro_contactos_area_cvc(){    
        $dato   = $this->input->post('dato');
        if($dato==''){
            unset($_SESSION['SESSION_CONTACTOS_CVC']); 
        }else{
            $_SESSION['SESSION_CONTACTOS_CVC']=$dato; 
        }
        
    }


    function activar_filtro_distribuidores_cvc(){    
        $dato   = $this->input->post('dato');
        if($dato==''){
            unset($_SESSION['SESSION_CONTACTO_DISTRIBUIDOR_CVC']); 
        }else{
            $_SESSION['SESSION_CONTACTO_DISTRIBUIDOR_CVC']=$dato; 
        }
        
    }


    /*
        PARA BUSCADOR
    */

    function buscar_registro(){
        $dato       = trim($this->input->post('dato',true));

        $t = "'"."solicitud"."'";
        $table='cvc_clientes_libres';
        $result    = $this->Modelo_formulario_pruebas->get_registros_condicion($table,$dato);

        $cadena=''; 
        if($result!='error'){

             $cadena.='<div class="text-end">
                            <button class="btn btn-sm bg-danger text-white" onclick="limpiar_buscador();">limpiar</button>
                        </div>
             ';

            foreach ($result as $key) {
                if($key->id_tipo_cliente == 1 ){
                    $tipo_cliente ='Cliente Regular';
                }else{
                    $tipo_cliente ='Cliente Libre';
                }

                $cadena.='
                    <div class="col-lg-12 mt-2" style="padding: 10px;border: 1px solid #d8d8d8; border-radius: 10px; border-left: 3px solid #fa5151;">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="col-lg-12"><span class="fw-bold">Cliente:</span><span  class="text-danger"> '.$tipo_cliente.'</span></div>
                                <div class="col-lg-12"><span class="fw-bold">R Social:</span><span> '.$key->razon_social.'</span></div>
                                <div class="col-lg-12"><span class="fw-bold">Status:</span><span> '.$key->status.'</span></div>
                                <div class="col-lg-12"><span class="fw-bold">Ruc:</span><span> '.$key->ruc.'</span></div>
                                <div class="col-lg-12"><span class="fw-bold">ISCOM:</span><span> '.$key->codigo_iscom.'</span></div>
                            </div>

                            <div class="col-lg-4">
                                <div class="col-lg-12"><span class="fw-bold">Distribuidor Local:</span><span> '.$key->distribuidor_local.'</span></div>
                                <div class="col-lg-12"><span class="fw-bold">N° Suministro Dis.:</span><span> '.$key->nro_suministro_distri.'</span></div>
                                <div class="col-lg-12"><span class="fw-bold">Alimentador:</span><span> '.$key->alimentador.'</span></div>
                                <div class="col-lg-12"><span class="fw-bold">PMI:</span><span>'.$key->pmi.'</span></div>
                            </div>

                            <div class="col-lg-4">
                                <div class="col-lg-12"><span class="fw-bold">Dir. Suministro:</span><span>'.$key->direccion_suministro.'</span></div>
                                <div class="col-lg-12"><span class="fw-bold">Distrito:</span><span> '.$key->distrito.'</span></div>
                                <div class="col-lg-12"><span class="fw-bold">Provincia:</span><span> '.$key->provincia.'</span></div>
                                <div class="col-lg-12"><span class="fw-bold">Departamento:</span><span> '.$key->departamento.'</span></div>
                            </div>
                            

                        </div>
                    </div>               
                '; 
            }
        }else{
            $cadena= 'Sin Registros';
        }
        echo $cadena;
    }



    

    /*
        GET DATOS DE LLAMADAS
    */


    function validar_solicitud_seguimiento() {
        $id = trim($this->input->post('id', true));


         //obtener id_cliente 
        $id2 =     $this->Mdl_compartido->retornarcampo( $id,'codigo_iscom','cvc_clientes_libres','id'); 

        $_SESSION['_SESSION_CODIGO_CLIENTE'] = $id2; 
        $count = $this->Modelo_formulario_pruebas->validar_seguimiento('cvc_solicitudes', $id2);
    
        echo json_encode($count);
    }

    function add_solicitud(){
        $id       = trim($this->input->post('id',true));
        $nom      = trim($this->input->post('nom',true));
        $tip       = trim($this->input->post('tip',true));


        if($tip == 1){


            $dato_iscom_cliente =     $this->Mdl_compartido->retornarcampo( $id,'codigo_iscom','cvc_clientes_libres','codigo_iscom'); 

            if($dato_iscom_cliente !=  $id  ){
            
                // regsitrar al cliente
                $array_cliente = array(            
                    'razon_social'     =>$nom,          
                    'codigo_iscom'     =>$id,   
                    'id_tipo_cliente'     =>1,        
                    'f_registro'       => date('Y-m-d H:i:s')
                );
                $id_regular = $this->Modelo_formulario_pruebas->insert_call('cvc_clientes_libres',$array_cliente);

                $array_call1 = array(
                    'codigo_cliente'          =>$id_regular                       
                );
                $result = $this->Modelo_formulario_pruebas->update('cvc_call',$array_call1,$_SESSION['_SESSION_CALL_ID'],'id');

            }

            //ASIGNAR EL CODIGO DEL CLIENTE 
            $codigo_id =  $id_regular;

        }else{
            $codigo_id = $_SESSION['_SESSION_CODIGO_CLIENTE'];

        }
        




        //validamos duplicado de id_call

        $dato_call =     $this->Mdl_compartido->retornarcampo( $_SESSION['_SESSION_CALL_ID'],'id_call','cvc_solicitudes','id_call'); 

        if($_SESSION['_SESSION_CALL_ID'] != $dato_call ){
          
            $array_insert = array(            
                'id_call'             => $_SESSION['_SESSION_CALL_ID'], 
                'id_cliente'          =>$codigo_id,    
                'id_estado_solicitud' =>2,           
                'f_registro'          => date('Y-m-d H:i:s'),
                'id_usuario'          => $_SESSION['_SESSIONUSER']
            );
            $result = $this->Modelo_formulario_pruebas->insert('cvc_solicitudes',$array_insert);

        }else{
            $result = 0;
        }



        
        
        echo $result;
    }

    function get_datos_call(){
        // $id       = trim($this->input->post('id',true));
        
        //$result    = $this->Modelo_formulario_pruebas->get_data_x_uniq('cvc_call',$id);
        $result    = $this->Modelo_formulario_pruebas->get_data_x_uniq('cvc_call',$_SESSION['_SESSION_UNIQUE_ID']);
        if($result!='error'){
            foreach ($result as $key) { 
                //$ar['uniqueid']         =$_SESSION['_SESSION_UNIQUE_ID'];
                $ar['id']               =$key->id;
                $ar['uniqueid']         =$key->uniqueid;
                $ar['nombres_cliente']  =$key->nombres_cliente;           
                $ar['parentesco']       =$key->parentesco;
                $ar['contacto_saliente']=$key->contacto_saliente;
                $ar['id_motivo']        =$key->id_motivo;
                $ar['celular']          =$key->celular;
                $ar['codigo_cliente']   =$key->codigo_iscom;
                $ar['id_tipo_cliente']  =$key->id_tipo_cliente;
                $ar['id_tipo_llamada']  =$key->id_tipo_llamada;
                                
            }   
            $ar['mensaje'] = 'ok';
        }else{
            $ar['mensaje'] = 'error';
        }
        echo json_encode($ar);
    }
    
    function action_uniqueid_call(){
        
        $unid       = trim($this->input->post('unid',true));
        $nom        = trim($this->input->post('nom',true));
        $pare       = trim($this->input->post('pare',true));
        $motivo     = trim($this->input->post('motivo',true));
        $cod        = trim($this->input->post('cod',true));
        $sal        = trim($this->input->post('sal',true));
        $tipo       = trim($this->input->post('tipo',true));
        $llam       = trim($this->input->post('llam',true));
        $f_reg       = date('Y-m-d H:i:s');

        //variable, campo, tabla , retornar
        $id_unique = $this->Mdl_compartido->retornarcampo($unid,'uniqueid','cvc_call','uniqueid'); 

        //obtener id_cliente 
        $codigo_cliente =     $this->Mdl_compartido->retornarcampo( $cod,'codigo_iscom','cvc_clientes_libres','id'); 

        if($id_unique== $unid){

            $array_upd = array(
                'uniqueid'          =>$unid,
                'nombres_cliente'   =>$nom,
                'contacto_saliente' =>$sal,
                'parentesco'        =>$pare,
                'id_motivo'         =>$motivo,
                'codigo_cliente'    =>$codigo_cliente,
                'codigo_iscom'      =>$cod,
                'id_tipo_cliente'   =>$tipo,
                'id_tipo_llamada'   =>$llam,
                'f_upd'             =>$f_reg,
                'user_upd'          =>$_SESSION['_SESSIONUSER']
            );
            $result = $this->Modelo_formulario_pruebas->update('cvc_call',$array_upd,$unid,'uniqueid');


        }else{

            $array_insert = array(
                'uniqueid'          => $unid,
                'nombres_cliente'   =>$nom,
                'parentesco'        => $pare,
                'contacto_saliente' =>$sal,
                'id_motivo'         =>$motivo,
                'codigo_cliente'     =>$codigo_cliente,
                'id_tipo_cliente'   =>$tipo,
    
                'f_add'             => $f_reg,
                'user_add'          => $_SESSION['_SESSIONUSER']
            );
            $result = $this->Modelo_formulario_pruebas->insert('cvc_call',$array_insert);
        }
        
        echo $result;
    }

    function load_motivo_call(){
        $id       = trim($this->input->post('id',true));

        $resultado = $this->Modelo_formulario_pruebas->get_data_load('cvc_call_motivo');
        $cadena='<option value=""> Motivo de llamada</option>'; 
        if($resultado!='error'){        
            foreach($resultado as $key){       
                if($id==$key->id){
                    $cadena .= '<option selected value="'.$key->id.'">'.$key->descripcion.'</option>';
                }else{
                    $cadena .= '<option value="'.$key->id.'">'.$key->descripcion.'</option>';
                }

            }
        }else{
            $cadena.=''; 
        }
        echo $cadena; 
    }



    function load_emergencia(){
        //$id       = trim($this->input->post('id',true));

        $resultado = $this->Modelo_formulario_pruebas->get_data_load_contacto_emergencia('cvc_contactos_area_cvc');
        $cadena='<option value="">Contactos del área CVC</option>'; 
        if($resultado!='error'){        
            foreach($resultado as $key){       
                //if($id==$key->id){
                 //   $cadena .= '<option selected value="'.$key->id.'">'.$key->descripcion.'</option>';
                //}else{
                    $cadena .= '<option value="'.$key->emergencia.'">'.$key->emergencia.'</option>';
                //}

            }
        }else{
            $cadena.=''; 
        }
        echo $cadena; 
    }



    function load_distribuidores_cvc(){
        //$id       = trim($this->input->post('id',true));

        $resultado = $this->Modelo_formulario_pruebas->get_data_load_contacto_distribuidor('cvc_contactos_distribuidores');
        $cadena='<option value="">Lista de distribuidores </option>'; 
        if($resultado!='error'){        
            foreach($resultado as $key){       
                //if($id==$key->id){
                 //   $cadena .= '<option selected value="'.$key->id.'">'.$key->descripcion.'</option>';
                //}else{
                    $cadena .= '<option value="'.$key->descripcion.'">'.$key->descripcion.'</option>';
                //}

            }
        }else{
            $cadena.=''; 
        }
        echo $cadena; 
    }



    function get_registros_call(){

       // $id_cliente       = trim($this->input->post('id',true));

        /*Para Páginación*/
        $limite     = 5;
        /*Donde te ubicas*/
        $ubica      = 0; 
        //(session_paginacion___-1)*2 
        if(isset($_SESSION['SESSION_SOL_PAG'])){
            $paginacion = ($_SESSION['SESSION_SOL_PAG']-1)*$limite; 
            $ubica = $_SESSION['SESSION_SOL_PAG']; 
        }else{
            $paginacion=0;     
        }
        

        //Armamos la paginación 
        $result_pag = $this->Modelo_formulario_pruebas->get_total_registros_pag('cvc_solicitudes a');
        
        //Dividimos entre el limite
        $total_bot = ceil($result_pag/$limite); 

        $cad_bot_pag=''; 
        $tipo_filtro = "'"."paginacion"."'";
        for ($i=0; $i <$total_bot ; $i++) { 
            $t = $i+1; 
            //ubica
            if($ubica==$t){
                $cad_bot_pag .= '<button type="button" class="btn btn-danger" onclick="activar_filtro('.$tipo_filtro.','.$t.');">'.$t.'</button>'; 
            }else{
                $cad_bot_pag .= '<button type="button" class="btn btn-secondary" onclick="activar_filtro('.$tipo_filtro.','.$t.');">'.$t.'</button>'; 
            }
        }
        $ar['paginacion'] = $cad_bot_pag; 
        $ar['total_botones'] = $total_bot; 
        $ar['total_items'] = $result_pag; 
        $ar['nro_limite'] = $limite; 
        $ar['nro_paginacion'] = $paginacion; 

        //Obtenemos los datos para el select
        $result     = $this->Modelo_formulario_pruebas->get_registros_call('cvc_solicitudes a',$limite,$paginacion);

        $r_estado_solicitud = $this->Modelo_formulario_pruebas->get_select('cvc_estado_solicitud');
        $r_motivo = $this->Modelo_formulario_pruebas->get_select('cvc_call_motivo');

 

        $resultados =0; 
        $cadena='';
        if($result!='error'){
            foreach ($result as $key) {
                $resultados++; 
                $color      = $this->set_border_left($key->id_estado_solicitud);
                $bg      = $this->set_bg($key->id_estado_solicitud);


                $sel_area       = '';
                $sel_cargo      = '';
                $sel_contrato   = '';
                $sel_frecuencia = '';

                
                $sel_estado_solicitud = $this->armar_selects($r_estado_solicitud,$key->id_estado_solicitud,0,'0');
                $sel_motivo = $this->armar_selects($r_motivo,$key->id_motivo,0,'0');

                


                $cadena.='
                <div class="card p-2" '.$color.'>
                    <div class="card-body">
                        <div>
                            <div class="py-3">
                                <div class="row align-items-center">
                                    <div class="col-lg-3">
                                        <div class="row">

                                            <div class="col-md-12">
                                                <div>                             
                                                    <span class="badge rounded-pill text-dark '.$bg.'"> Nro Ticket: '.$key->id.'</span> -  call '.$key->id_call.'                                                  
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div>
                                                    <h5 class="font-size-11">Teloperador: '.$key->nombres.'</h5>
                                                </div>
                                            </div>                                            

                                            <div class="col-md-12">
                                                <div>
                                                    <b> Cliente :</b> <span>'.$key->razon_social.'</span>                                                
                                                </div> 
                                            </div>

                                            <div class="col-md-12 ">
                                                <div>
                                                    <span>Ruc: '.$key->ruc.'</span>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div>
                                                    <span>Cod Iscom: '.$key->codigo_iscom.'</span>
                                                </div>
                                            </div>
                                     

                                            <div class="col-md-12 mt-2">
                                                <h5 class="font-size-14">Motivo de llamada</h5>
                                            </div>

                                            <div class="col-md-12">
                                                <div>
                                                    
                                                    <select class="form-control form-control-sm" id="txt_motivo_'.$key->id.'"  onchange="upd_motivo_llamada('.$key->id_call.','.$key->id.' );">
                                                        '.$sel_motivo.'
                                                    </select>
                                                </div>
                                            </div> 
                                           

                                            <div class="col-md-12 mt-2">
                                                <h5 class="font-size-14">Estado</h5>
                                            </div>

                                            <div class="col-md-12">
                                                <div>
                                                    <select class="form-control form-control-sm '.$bg.'" id="txt_estado_sol_'.$key->id.'">
                                                        '.$sel_estado_solicitud.'
                                                    </select>
                                                </div>
                                            </div>                                                                                                        
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div id="panel_detalle_'.$key->id.'" style="display:block">
                                            <div class="row">

                                                <div class="col-md-3">
                                                    <div>
                                                        <h5 class="font-size-13">Fecha</h5>
                                                        <input type="datetime" disabled class="form-control form-control-sm" id="txt_fecha_reg_'.$key->id.'" value="'.$key->f_registro.'">
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div>
                                                        <h5 class="font-size-13">Distribuidor</h5>
                                                        <input type="text" disabled class="form-control form-control-sm" id="txt_dis_sol_'.$key->id.'"  value="'.$key->distribuidor_local.'" >
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div>
                                                        <h5 class="font-size-13">Nro Suministro</h5>
                                                        <input type="text" disabled class="form-control form-control-sm" id="txt_dis_sol_'.$key->id.'"  value="'.$key->nro_suministro_distri.'" >
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div>
                                                        <h5 class="font-size-13">Alimentador</h5>
                                                        <input type="text" disabled class="form-control form-control-sm" id="txt_dis_sol_'.$key->id.'"  value="'.$key->alimentador.'" >
                                                    </div>
                                                </div>     
                                                
                                                <div class="col-md-2">
                                                    <div>
                                                        <h5 class="font-size-13">PMI</h5>
                                                        <input type="text" disabled class="form-control form-control-sm" id="txt_dis_sol_'.$key->id.'"  value="'.$key->pmi.'" >
                                                    </div>
                                                </div>                                                     
                                                
                                                <div class="col-md-12">
                                                    <div>
                                                        <h5 class="font-size-13">Dirección</h5>
                                                        <input type="text" disabled class="form-control form-control-sm"  id="txt_dir_sol_'.$key->id.'"  value="'.$key->direccion_suministro.'">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-7">
                                                    <div>
                                                        <h5 class="font-size-13">Departamento</h5>
                                                        <input type="text" disabled class="form-control form-control-sm"  id="txt_dep_sol_'.$key->id.'"  value="'.$key->departamento.'/'.$key->provincia.'/'.$key->distrito.'">
                                                    </div>
                                                </div>  

                                                <div class="col-md-3">
                                                    <div>
                                                        <h5 class="font-size-13">Contacto</h5>
                                                        <input type="text" disabled class="form-control form-control-sm"  value="'.$key->contacto.'">
                                                    </div>
                                                </div> 
                                                <div class="col-md-2">
                                                    <div>
                                                        <h5 class="font-size-13">Teléfono</h5>
                                                        <input type="text" disabled class="form-control form-control-sm"   value="'.$key->telefono.'">
                                                    </div>
                                                </div> 

                                                
                                                <div class="col-md-12 pt-3">
                                                    <h5 class="font-size-13">Resumen Breve :</h5>
                                                    <div>
                                                        <textarea class="form-control" id="text_resumen_sol_'.$key->id.'"> '.$key->resumen_breve.' </textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-center">
                                        <button style="display:none;" id="btn_regresar_'.$key->id.'" class="btn btn-secondary waves-effect waves-light mb-2 form-control"  onclick="regresar('.$key->id.');"> <i class="mdi mdi-keyboard-backspace"></i> Regresar</button>
                                        <button id="btn_actualizar_'.$key->id.'" class="btn btn-info waves-effect waves-light mb-2 form-control"  onclick="actualizar('.$key->id.');"> <i class="mdi mdi-square-edit-outline"></i> Actualizar</button>
                                        <button class="btn btn-info waves-effect waves-light mb-2 form-control"  onclick="ver_contactos('.$key->id.');"><i class="mdi mdi-spider-web"></i> Contactos</button>
                                        <button class="btn btn-info waves-effect waves-light mb-3  form-control" onclick="ver_seguimientos('.$key->id.');"><i class="mdi mdi-spider-web"></i> Seguimiento</button>
                                        <button class="btn btn-danger waves-effect waves-light mb-2  form-control" onclick="eliminar('."'".'solicitud'."',".$key->id.',0);"><i class="mdi mdi-trash-can"></i> Eliminar</button>
                                    </div>

                                    <div class="col-lg-12 mt-3">
                                        <div id="panel_respon_'.$key->id.'" style="display:none;padding: 10px;background: #fafafa;">
                                            <label>REGISTRAR CONTACTOS: </label>
                                            <div class="d-flex justify-content-center">
                                                <input type="text"  class="form-control form-control-sm" placeholder="Nombres del contacto." id="txt_sol_contacto_'.$key->id.'">
                                                <input type="text"  class="form-control form-control-sm" placeholder="Numero Celular." id="txt_sol_celular_'.$key->id.'">
                                                <button class="btn btn-sm btn-secondary" onclick="agregar('."'".'contacto'."'".','.$key->id.')"> Agregar</button>
                                            </div>
                                            <label class="mt-2">LISTADO</label>
                                            <div class="d-flex flex-column justify-content-center" id="lista_respon_'.$key->id.'">
                                            
                                            </div>
                                        </div> 
                                        
                                        <div id="panel_reque_'.$key->id.'" style="display:none;padding: 10px;background: #fafafa;">                                        
                                            <div class="d-flex justify-content-center">
                                                <textarea class="form-control me-2" id="txt_des_reque_'.$key->id.'" style="display:none;"> ...</textarea>                                                 
                                                <button class="btn btn-primary" onclick="agregar('."'".'seguimiento'."'".','.$key->id.')"> Nuevo Seguimiento</button>
                                            </div>
                                                                               
                                                <div class="col-xl-12 mt-3">
                                                    <div class="card mb-3">
                                                        <div class="card-header align-items-center d-flex">
                                                            <h4 class="card-title mb-0 flex-grow-1">Listado de Seguimientos</h4>                                                                                                        
                                                        </div>

                                                        <div class="card-body px-0">
                                                            <div class="px-3" data-simplebar="init" style="max-height: 352px;"><div class="simplebar-wrapper" style="margin: 0px -16px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: -17px; bottom: 0px;"><div class="simplebar-content-wrapper" style="height: auto; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 0px 16px;">
                                                                <ul class="list-unstyled activity-wid mb-0" id="lista_reque_'.$key->id.'">
                                                                                                                            
                                                                </ul>
                                                            </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 438px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 282px; transform: translate3d(0px, 0px, 0px); display: block;"></div></div></div>    
                                                        </div>                                 
                                                    </div>                            
                                                </div>
                                            
                                        </div>                                 
                                    </div>
                                </div>
                            </div>
                        </div>                                
                    </div>
                </div>                   
                
                ';
            }

            //Viendo total de resultados
            $ar['viendo'] = 'Viendo '.$resultados.' de '.$result_pag.' resultados';
            
        }else{
            $cadena.='
                <div class="card p-2">
                    <div class="card-body">
                        <label>No encontraron resultados en el filtro aplicado.</label>
                    </div>
                </div>
            ';
        }
        $ar['registros'] = $cadena; 
        //echo $cadena; 
        echo json_encode($ar);
    }



    function upd_registros(){
        $tipo       = trim($this->input->post('tipo',true));
        $id       = trim($this->input->post('id',true));
        $des       = trim($this->input->post('des',true));       

        switch ($tipo) {
            case 'upd_seguimiento':
                $array = array(
                    'descripcion'            => $des,                                 
                    'id_usuario'          => $_SESSION['_SESSIONUSER'],
                    'f_registro'          => date('Y-m-d H:i:s')
                );
                //$result = $this->Modelo_formulario_pruebas->insert('cvc_seguimientos',$array);
                $result = $this->Modelo_formulario_pruebas->update('cvc_seguimientos',$array,$id,'id');
                break;                
            default:
                break;
        }
        echo $result;
    }



    
    
    public function get_distribuidores() {
        // Obtener el código de cliente desde la solicitud AJAX
        //$codigo_cliente = $this->input->post('codigo_cliente');
    
        // Si se proporciona un código de cliente, establecerlo en la sesión
        /*if (!empty($codigo_cliente)) {
            $_SESSION['_SESSION_CODIGO_CLIENTE1'] = $codigo_cliente;
        }*/
    
        // Obtener las solicitudes utilizando el modelo
        $result = $this->Modelo_formulario_pruebas->get_distribuidores();
    
        $cadena = '';
        if ($result != 'error') {
            foreach ($result as $key) {
               
                $cadena .= '
                <tr>                 
                    <td>' . $key->descripcion . '</td>
                    <td>' . $key->area . '</td>
                    <td>' . $key->telefono . '</td>
                    <td>' . $key->correo . '</td>
                </tr>
                    
                ';
            }
        } else {
            $cadena = 'Sin Distribuidores';
        }
    
        echo $cadena;
    }

    public function get_contactos_area_cvc() {
        // Obtener los contactos utilizando el modelo
        $result = $this->Modelo_formulario_pruebas->get_contactos_area_cvc();
        $cadena = '';
    
        if ($result != 'error') {
            // Obtener los grupos de contacto y sus cantidades
            $result2 = $this->Modelo_formulario_pruebas->grupos_contacto_emergencia();
            $grupos = [];
            foreach ($result2 as $key2) {
                $grupos[$key2->emergencia] = $key2->cantidad_contactos;
            }
    
            $currentGrupo = '';
            foreach ($result as $key) {
                // Solo se muestra el grupo en la primera fila de cada grupo
                if ($currentGrupo != $key->emergencia) {
                    $currentGrupo = $key->emergencia;
                    $cantidadContactos = $grupos[$currentGrupo];
                    $cadena .= '<tr class="text-start font-size-12">';
                    $cadena .= '<td rowspan="' . $cantidadContactos . '" class="align-middle">' . $currentGrupo . '</td>';
                } else {
                    $cadena .= '<tr class="text-start font-size-12">';
                }
    
                // Agregar contacto, correo y celular en cada fila

                if($key->pintar ==1){
                    $cadena .= '
                        <td class="bg-warning">' . $key->contacto . '</td>
                        <td class="bg-warning">' . $key->correo . '</td>
                        <td class="bg-warning">' . $key->celular . '</td>
                        <td class="bg-warning">' . $key->turno. '</td>
                        
                    </tr>';
                }else{
                    $cadena .= '
                        <td>' . $key->contacto . '</td>
                        <td>' . $key->correo . '</td>
                        <td>' . $key->celular . '</td>
                        <td>' . $key->turno. '</td>
                    </tr>';
                }
                
            }
        } else {
            $cadena = 'Sin Contactos';
        }
    
        echo $cadena;
    }
    

    public function get_distribuidores_cvc() {
        // Obtener los contactos utilizando el modelo
        $result = $this->Modelo_formulario_pruebas->get_solicitudes_cvc();
        $cadena = '';
    
        if ($result != 'error') {
            // Obtener los grupos de contacto y sus cantidades
            $result2 = $this->Modelo_formulario_pruebas->grupos_contacto_solicitud();
            $grupos = [];
            foreach ($result2 as $key2) {
                $grupos[$key2->descripcion] = $key2->cantidad_contactos;
            }
    
            $currentGrupo = '';
            foreach ($result as $key) {
                // Solo se muestra el grupo en la primera fila de cada grupo
                if ($currentGrupo != $key->descripcion) {
                    $currentGrupo = $key->descripcion;
                    $cantidadContactos = $grupos[$currentGrupo];
                    $cadena .= '<tr class="text-start font-size-12">';
                    $cadena .= '<td rowspan="' . $cantidadContactos . '" class="align-middle">' . $currentGrupo . '</td>';
                } else {
                    $cadena .= '<tr class="text-start font-size-12">';
                }
    
                // Agregar contacto, correo y celular en cada fila

                //if($key->pintar ==1){
                    $cadena .= '
                        <td>' . $key->area . '</td>
                        <td>' . $key->telefono . '</td>                                         
                    </tr>';
                /*}else{
                    $cadena .= '
                        <td>' . $key->area . '</td>
                        <td>' . $key->telefono . '</td>
                        
                    </tr>';
                }*/
                
            }
        } else {
            $cadena = 'Sin Distribuidores';
        }
    
        echo $cadena;
    }


    public function get_correos_distribuidores_cvc() {
        // Obtener los contactos utilizando el modelo
        $result = $this->Modelo_formulario_pruebas->get_correos_distribuidor_cvc();
        $cadena = '';
    
        if ($result != 'error') {
            // Obtener los grupos de contacto y sus cantidades
            $result2 = $this->Modelo_formulario_pruebas->grupos_correos_distribuidor_cvc();
            $grupos = [];
            foreach ($result2 as $key2) {
                $grupos[$key2->descripcion] = $key2->cantidad_contactos;
            }
    
            $currentGrupo = '';
            foreach ($result as $key) {
                // Solo se muestra el grupo en la primera fila de cada grupo
                if ($currentGrupo != $key->descripcion) {
                    $currentGrupo = $key->descripcion;
                    $cantidadContactos = $grupos[$currentGrupo];
                    $cadena .= '<tr class="text-start font-size-12">';
                    $cadena .= '<td rowspan="' . $cantidadContactos . '" class="align-middle">' . $currentGrupo . '</td>';
                } else {
                    $cadena .= '<tr class="text-start font-size-12">';
                }
    
                // Agregar contacto, correo y celular en cada fila

                //if($key->pintar ==1){
                    $cadena .= '
                        <td>' . $key->correo . '</td>
                                                        
                    </tr>';
                /*}else{
                    $cadena .= '
                        <td>' . $key->area . '</td>
                        <td>' . $key->telefono . '</td>
                        
                    </tr>';
                }*/
                
            }
        } else {
            $cadena = 'Sin correos Distribuidores';
        }
    
        echo $cadena;
    }



    // CONSULTAR CON EL CODIGO ISCOM

    public function get_clientes() {
        $codigo_cliente = $this->input->post('codigo_cliente'); //codigo iscom


        //obtener id_cliente 
        // $codigo_cliente2 =     $this->Mdl_compartido->retornarcampo( $codigo_cliente,'codigo_iscom','cvc_clientes_libres','codigo_iscom'); 
        
        //if ($codigo_cliente ="") {
            //$_SESSION['_SESSION_CODIGO_CLIENTE3'] = $codigo_cliente2;
            $_SESSION['_SESSION_CODIGO_CLIENTE3'] = $codigo_cliente;
        //}
        

        $result = $this->Modelo_formulario_pruebas->get_clientes();

        $cadena = '';
        if ($result && $result !== 'error') {
            foreach ($result as $key) {

                if($key->id_tipo_cliente == 1 ){
                    $tipo_cliente ='Cliente Regular';
                }else{
                    $tipo_cliente ='Cliente Libre';
                }


                $cadena .= '
                    <a class="list-group-item list-group-item">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm flex-shrink-0 me-3">
                                <div class="avatar-title bg-soft-light text-light rounded-circle font-size-24">
                                    <i class="bx bxs-bank"></i>
                                </div>
                            </div>

                            <div class="flex-grow-1">
                                <div>
                                    <h5 class="font-size-14 mb-1">' . $tipo_cliente . '</h5>
                                    <p class="font-size-13 text-muted mb-0">' . $key->razon_social . '</p>
                                    <p class="font-size-13 text-muted mb-0"> <b>Codigo: </b> ' . $key->codigo_iscom . '</p>
                                </div>
                            </div>

                            <div class="flex-grow-1">
                                <div>                           
                                    <p class="font-size-13 text-muted mb-0"> <b>Distribuidora: </b>  ' . $key->distribuidor_local . '</p>
                                    <p class="font-size-13 text-muted mb-0"> <b>N° Suministro: </b>  ' . $key->nro_suministro_distri . '</p>
                                    <p class="font-size-13 text-muted mb-0"> <b>Alimentador: </b> ' . $key->alimentador . '</p>
                                </div>
                            </div>

                            <div class="flex-end">
                                <div>
                                    <p class="font-size-13 text-muted mb-0"> <b>Departamento: </b>' . $key->departamento . '</p>                              
                                    <p class="font-size-13 text-muted mb-0"> <b>Provincia: </b>' . $key->provincia . '</p>
                                    <p class="font-size-13 text-muted mb-0"> <b>Distrito: </b>' . $key->distrito . '</p>
                                </div>
                            </div>        
                        </div>
                    </a>
                ';
            }
        } else {
            $cadena = '
                    <a href="#" class="list-group-item list-group-item-action">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm flex-shrink-0 me-3">
                                <div class="avatar-title bg-soft-light text-light rounded-circle font-size-24">
                                    <i class="bx bxs-bank"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div>
                                    <h5 class="font-size-14 mb-1">Sin registros</h5>
                                    <p class="font-size-13 text-muted mb-0"> ... </p>
                                </div>
                            </div>
                            
                        </div>
                    </a>
            ';
        }

        echo $cadena;
    }
   
    public function get_solicitudes() {
        // Obtener el código de cliente desde la solicitud AJAX
        $codigo_cliente = $this->input->post('codigo_cliente');

        $codigo_cliente2 =     $this->Mdl_compartido->retornarcampo( $codigo_cliente,'codigo_iscom','cvc_clientes_libres','id'); 
        if (!empty($codigo_cliente)) {
            $_SESSION['_SESSION_CODIGO_CLIENTE1'] = $codigo_cliente2;
        }

        /*$codigo_cliente = $this->input->post('codigo_cliente'); //codigo iscom
        $_SESSION['_SESSION_CODIGO_ISCOM'] = $codigo_cliente;*/
    
        // Obtener las solicitudes utilizando el modelo
        $result = $this->Modelo_formulario_pruebas->get_solicitudes();

        $cadena = '';
        if ($result != 'error') {
            foreach ($result as $key) {
                $bg = $key->id_estado_solicitud == 2 ? 'bg-warning' :
                      ($key->id_estado_solicitud == 3 ? 'bg-info' :
                      ($key->id_estado_solicitud == 4 ? 'bg-danger' : 'bg-light'));
    
                $cadena .= '
                    <li class="activity-list activity-border">
                        <div class="activity-icon avatar-md">
                            <span class="avatar-title rounded-circle ' . $bg . '">  <i class="bx bx-chevron-down-circle font-size-18" ></i> </span>
                        </div>
                        <div class="timeline-list-item">
                            <div class="d-flex">

                                <div class="flex-grow-1  me-4">                           
                                    <span class="font-size-14 mb-1"> <b>Nro de Ticket: </b>  <span class="badge rounded-pill font-size-12 ' . $bg . '"> N° ' . $key->id   . '</span> </span>                              
                                    <p class="font-size-13 text-muted mb-0"> <b>Cliente: </b>  ' . $key->nombres_cliente . '</p>     
                                    <p class="font-size-13 text-muted mb-0"> <b>Parentesco: </b>  ' . $key->parentesco . '</p>                                        
                                </div>

                                <div class="flex-grow-1">
                                    <div>           
                                        <p class="font-size-13 text-muted mb-0"> <b>Estado: </b>  ' . $key->estado_solicitud . '</p>          
                                        <p class="font-size-13 text-muted mb-0"> <b>Motivo_llamada: </b>  ' . $key->motivo_llamada . '</p>   
                                        <p class="font-size-13 text-muted mb-0"> <b>Celular: </b>  ' . $key->celular . '</p>
                                                                          
                                    </div>
                                </div>

                                <div class="flex-end">
                                    <div>                                                                 
                                        <p class="font-size-13 text-muted mb-0"> <b>Fecha: </b>' . $key->f_registro . '</p>
                                        <p class="font-size-13 text-muted mb-0"> <b>Teleoperador: </b>' . $key->nombres . '</p>
                                        <p class="font-size-13 text-muted mb-0"> <b>Codigo: </b>' . $key->codigo_iscom . '</p>
                                    </div>
                                </div>   
                            </div>
                        </div>
                    </li>
                ';
            }
        } else {
            $cadena = '';
        }
    
        echo $cadena;
    }

    public function get_distribuidores_telefonos() {

        $codigo_cliente = $this->input->post('codigo_cliente'); //codigo iscom
        $_SESSION['_SESSION_CODIGO_ISCOM_1'] = $codigo_cliente;

        $result = $this->Modelo_formulario_pruebas->get_distribuidores_telefonos();
        $cadena = '';
        if ($result && $result !== 'error') {
            foreach ($result as $key) {

                $cadena .= '
                    <a class="list-group-item list-group-item">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm flex-shrink-0 me-3">
                                <div class="avatar-title bg-soft-light text-light rounded-circle font-size-24">
                                    <i class="bx bxs-phone"></i> 
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div>
                                    <h5 class="font-size-14 mb-1">' . $key->descripcion . '</h5>                            
                                </div>
                            </div>                
                            <div class="flex-end">
                                <div>
                                    <p class="font-size-13 text-muted mb-0"> <b>' . $key->area . ': </b> ' . $key->telefono . '</p>                                                        
                                </div>
                            </div>    
                        </div>
                    </a>
                ';
            }
        } else {
            $cadena = '';
        }

        echo $cadena;
    }

    public function get_distribuidores_correos() {

        $codigo_cliente = $this->input->post('codigo_cliente'); //codigo iscom
        $_SESSION['_SESSION_CODIGO_ISCOM_2'] = $codigo_cliente;

        //$codigo_cliente = $this->input->post('codigo_cliente'); //codigo iscom

        $result = $this->Modelo_formulario_pruebas->get_distribuidores_correos();

        $cadena = '';
        if ($result && $result !== 'error') {
            foreach ($result as $key) {
                $cadena .= '
                    <a class="list-group-item list-group-item">
                        <div class="d-flex align-items-center"> 
                            <div class="">
                                <div>                            
                                    <p class="font-size-13 text-muted mb-0"> <i class="bx bx-envelope me-2"></i> ' . $key->correo . '</p>                            
                                </div>
                            </div>     
                        </div>
                    </a>
                ';         
            }

        } else {
            $cadena = '                
            ';
        }

        echo $cadena;
    }




    //upd motivo de llamada

    function upd_motivo_llamada(){
        $id       = trim($this->input->post('id',true)); //id
        $id_motivo  = trim($this->input->post('id_motivo',true));  //motivo
              
        $array = array(                             
            'id_motivo' => $id_motivo
        );

        $result = $this->Modelo_formulario_pruebas->update('cvc_call',$array,$id,'id');
               
        echo $result;
    }


    function upd_motivo_llamada_call(){
        $id       = trim($this->input->post('id',true)); //id
        $id_motivo  = trim($this->input->post('id_motivo',true));  //motivo
              
        $array = array(                             
            'id_motivo' => $id_motivo
        );

        $result = $this->Modelo_formulario_pruebas->update('cvc_call',$array,$id,'id');
               
        echo $result;
    }





}

?>
