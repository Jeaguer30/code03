<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Controller_usuario extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('image_lib');
        $this->load->model('Mdl_compartido');
        $this->load->model('Modelo_usuario');
        $this->load->model('M_settings');
        $this->load->model('M_settings_menu');
        date_default_timezone_set('America/Lima');
    }

    public function index(){

        //Retornamos campo tipo de usuario
        $tipo_user          = $this->Mdl_compartido->retornarcampo($_SESSION['_SESSIONUSER'],'coduser','tb_usuarios','tipo_user');
        //Obtenemos el id del menu
        $header['id_menu']  = $this->Mdl_compartido->retornarcampo('seg_usuarios','ruta','config_sub_menu','id_menu');
        $id_sub_menu        = $this->Mdl_compartido->retornarcampo('seg_usuarios','ruta','config_sub_menu','id');
        //Validamos que tenga el permiso
        $permiso = $this->Mdl_compartido->permisos_menu_mejorado('seg_usuarios',$tipo_user);
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
        $this->load->view('seg_usuarios/v_usuarios', $data);
        $this->load->view('seg_usuarios/seg_usuarios_modal', $data);
        $this->load->view('layouts/v_footer');

    }

    function aplicar_filter_tipo_user(){
        $tipo_user = $this->input->post('tipo_user',true);
        if($tipo_user==''){
            unset($_SESSION['FILTRO_TIPO_USER']); 
        }else{
            $_SESSION['FILTRO_TIPO_USER'] = $tipo_user;
        }
    }

    function load_select_tipo_user(){
        $resultado = $this->Modelo_usuario->load_select_tipo_user();
        $cadena='<option value="">Tipo de Usuario</option>'; 
        if($resultado!='error'){
           
            foreach($resultado as $key){
                $cadena.='<option value="'.$key->id.'">'. $key->descripcion.'</option>'; 
            }
        }else{
            $cadena.=''; 
        }
        echo $cadena; 
    }

    function aplicar_filter_estado(){
        $tipo_user = $this->input->post('tipo_user',true);
        if($tipo_user==''){
            unset($_SESSION['FILTRO_ESTADO']); 
        }else{
            $_SESSION['FILTRO_ESTADO'] = $tipo_user;
        }
    }


    /*OBTENER USURIO*/
    function get_datos(){
        $coduser       = trim($this->input->post('coduser',true));
        $result    = $this->Modelo_usuario->get_datos_table_for_id($coduser);
        if($result!='error'){
            foreach ($result as $key) {  
                $ar['coduser']=$key->coduser;           
                $ar['nombres']=$key->nombres;
                $ar['apellidos']=$key->apellidos;
                $ar['dni']=$key->dni;
                $ar['estado']=$key->estado;
                $ar['email']=$key->correo;     
                $ar['clave']=$key->clave;   
                $ar['tipo_user']=$key->tipo_user;                                 
                $ar['telefono']=$key->telefono;
                $ar['f_nacimiento']=$key->f_nac;                         
                $ar['direccion']=$key->direccion;             
                $ar['observacion']=$key->observacion;            
                $ar['clave']=$key->clave;  
                $ar['usuario']=$key->usuario;
                $ar['user_carta']=$key->user_carta;
            }   
            $ar['mensaje'] = 'ok';
        }else{
            $ar['mensaje'] = 'error';
        }
        echo json_encode($ar);
    }


    function get_data_tipouser(){
        $id       = trim($this->input->post('id',true));
        $result    = $this->Modelo_usuario->get_data_tipouser($id);
        if($result!='error'){
            foreach ($result as $key) {  
                $ar['id']=$key->id;           
                $ar['descripcion']=$key->descripcion;
                $ar['area']=$key->area;
               
            }   
            $ar['mensaje'] = 'ok';
        }else{
            $ar['mensaje'] = 'error';
        }
        echo json_encode($ar);
    }


    /*LISTAR USUARIOS*/
    function listar_registros(){
        if (!empty($_POST))
        {
            $tipo_user = $this->Mdl_compartido->retornarcampo($_SESSION['_SESSIONUSER'],'coduser','tb_usuarios','tipo_user');
            $fetch_data = $this->Modelo_usuario->make_datatables();
            
            $data = array();
            $contador=0; 
            
            foreach($fetch_data as $row)
            {
                $cl= "";           
                //$cl = $row->color;
                $contador++;               
                $sub_array = array();
                // columnas de las tablas
                $sub_array[] = $contador;
                $sub_array[] = '                
                    <div class="col-lg-12 col-center " style="text-align: center;">
                        <button class="btn btn-sm btn-outline-primary waves-effect waves-light"  onclick="get_datos('.$row->coduser.');"> <i class="mdi mdi-square-edit-outline"></i> </button>   
                        <button class="btn btn-sm btn-outline-danger waves-effect waves-light"  onclick="eliminar('.$row->coduser.');"> <i class="bx bx-trash"></i> </button>                                            
                    </div>';           

                    //estado
                    if ($row->estado == 1) {
                        $estado = 'ACTIVO';                            
                    } else {
                        $estado = 'DESACTIVADO';                
                    }
                
                $sub_array[] = '                             
                    <div class="">
                        <label style=""><i style="color:'.$cl.'"  ></i> '.$row->descripcion.'</label>
                    </div>';

                $sub_array[] = $row->nombres;
                $sub_array[] = $row->apellidos;   
                $sub_array[] = $row->usuario;   
                $sub_array[] = $row->dni; 
                $sub_array[] = $row->telefono;     
                $sub_array[] = $row->f_nac;
                $sub_array[] = $estado; 
                                                            
                $data[] = $sub_array;
            }
            $output = array(
                "draw"                  =>     intval($_POST["draw"]),
                "recordsTotal"          =>     $this->Modelo_usuario->get_all_data(),
                "recordsFiltered"       =>     $this->Modelo_usuario->get_filtered_data(),
                "data"                  =>     $data
            );
            echo json_encode($output);
        }
    }

    /*AGREGAR POR USUARIO*/
    function agregar_usuario(){
        $actualizar             = trim($this->input->post('actualizar',true));
        $coduser                = trim($this->input->post('coduser',true));
        $txt_nombres            = trim($this->input->post('txt_nombres',true));
        $txt_apellidos          = trim($this->input->post('txt_apellidos',true));
        $txt_dni                = trim($this->input->post('txt_dni',true));
        $txt_estado             = trim($this->input->post('txt_estado',true));
        $txt_email              = trim($this->input->post('txt_email',true));
        $txt_movil              = trim($this->input->post('txt_movil',true));        
        $txt_f_nac              = trim($this->input->post('txt_f_nac',true));      
        $txt_tipo_user          = trim($this->input->post('txt_tipo_user',true));        
        $txt_direccion          = trim($this->input->post('txt_direccion',true));
        $txt_observacion        = trim($this->input->post('txt_observacion',true));   
        $txt_clave              = trim($this->input->post('txt_clave',true));   
        $txt_usuario_a          = trim($this->input->post('txt_usuario_a',true));   
        $id_check_preaviso          = trim($this->input->post('id_check_preaviso',true));  

        $val_user_carta = $this->Modelo_usuario->user_asignados();


        $ar['mensaje']='';
        if ($id_check_preaviso == 1) {
            if ($val_user_carta >= 10) {
                $id_check_preaviso = 0;
                $ar['mensaje'] = 'Se supero el limite de usuarios para el preaviso';
            }
        }

        // Encriptar la contraseña
        $clave_encriptada = hash_hmac('sha512', $txt_clave, 'KAJFBD@./*-_15fl221dlkaik2123');
        $txt_clave = $clave_encriptada;

        $array = array(           
            'nombres'       => $txt_nombres,
            'apellidos'     => $txt_apellidos,
            'dni'           => $txt_dni,
            'usuario'       => $txt_usuario_a,
            'correo'        => $txt_email,
            'telefono'      => $txt_movil,           
            'f_nac'         => $txt_f_nac, 
            'estado'        => $txt_estado,           
            'direccion'     => $txt_direccion,
            'observacion'   => $txt_observacion,
            'clave'         => $txt_clave,         
            'foto'          => '185_7.jpg',
            'date_insert'   => date('Y-m-d H:i:s'),
            'tipo_user'     => $txt_tipo_user,          
            'del'           => 0,
            'user_carta'    => $id_check_preaviso
        );
    
        $result = $this->Modelo_usuario->insert('tb_usuarios', $array);

        $ultimo = $this->Modelo_usuario->get_ultimo_control('tb_usuarios');
        if ($ultimo != 'error') {
            $ultimo_registro = $ultimo[0]->coduser;        
        } else {         
            // Manejar el error aquí si es necesario
        }

        $array_settings = array (
            'id_usuario'        => $ultimo_registro,
            'layout'            => 'vertical',
            'layout_mode'       => 'light',
            'layout_width'      => 'fluid',
            'layout_position'   => 'false',
            'topbar_color'      => 'light',   
            'sidebar_size'      => 'sm',
            'sidebar_color'     => 'light'  
        );

       $this->Modelo_usuario->insert('settings', $array_settings);


        //insert 2
        $array_usuarioxdepartamento = array (
            'id_usuario'        => $ultimo_registro,
            'id_departamento'   => 14,
            'estado'            => 1,        
            'fecha_alta'        => date('Y-m-d H:i:s'),          
            'user_registro'     => $_SESSION['_SESSIONUSER']  
        );

        $this->Modelo_usuario->insert('tb_usuariosxdepartamento', $array_usuarioxdepartamento);

       echo json_encode($ar);   
    }

    /*ACTUALIZAR POR USUARIO*/
    function actualizar_usuario(){      
        $txt_coduser            = trim($this->input->post('txt_coduser',true));
        $txt_nombres            = trim($this->input->post('txt_nombres',true));
        $txt_apellidos          = trim($this->input->post('txt_apellidos',true));
        $txt_dni                = trim($this->input->post('txt_dni',true));
        $txt_estado             = trim($this->input->post('txt_estado',true));
        $txt_email              = trim($this->input->post('txt_email',true));
        $txt_movil              = trim($this->input->post('txt_movil',true));        
        $txt_f_nac              = trim($this->input->post('txt_f_nac',true));      
        $txt_tipo_user          = trim($this->input->post('txt_tipo_user',true));        
        $txt_direccion          = trim($this->input->post('txt_direccion',true));
        $txt_observacion        = trim($this->input->post('txt_observacion',true));
        $txt_clave              = trim($this->input->post('txt_clave',true));
        $txt_usuario_e          = trim($this->input->post('txt_usuario_e',true));
        $status                 = trim($this->input->post('status',true));
        
        if (!empty($txt_clave) && $txt_clave != 'sistemas123' ) {
            // Encriptar la contraseña
            $clave_encriptada = hash_hmac('sha512', $txt_clave, 'KAJFBD@./*-_15fl221dlkaik2123');
            $txt_clave = $clave_encriptada;
        }

        $val_user_carta = $this->Modelo_usuario->user_asignados();
        $ar['mensaje']='';
        if ($status == 1) {
            if ($val_user_carta >= 10) {
                $status = 0;
                $ar['mensaje'] = 'Se supero el limite de usuarios para el preaviso -upd';
            }
        }

        $array = array(           
            'nombres'            => $txt_nombres,
            'apellidos'          => $txt_apellidos,
            'dni'                => $txt_dni,
            'usuario'            => $txt_usuario_e,
            'correo'             => $txt_email,
            'telefono'           => $txt_movil,           
            'f_nac'              => $txt_f_nac,            
            'direccion'          => $txt_direccion,
            'observacion'        => $txt_observacion,           
            'estado'             => $txt_estado,           
            'foto'               => '185_7.jpg',
            'f_upd'              => date('Y-m-d H:i:s'),
            'tipo_user'          => $txt_tipo_user,  
            'user_carta'         => $status        
         
        );

        if (!empty($txt_clave) && $txt_clave != 'sistemas123') {
            $array['clave'] = $txt_clave;
        }
        
        $this->Modelo_usuario->update('tb_usuarios',$array,$txt_coduser,'coduser');
                                        
        echo json_encode($ar);
    }



    function actualizar_tipo_usuario(){      
        $id           = trim($this->input->post('id',true));
        $des          = trim($this->input->post('des',true));
        $area         = trim($this->input->post('area',true));
      
        $array = array(           
            'descripcion'      => $des,
            'area'     => $area
        );
        $this->Modelo_usuario->update('tb_tipouser',$array,$id,'id'); 
        
        $ar['mensaje'] = '1';
        echo json_encode($ar);
    }

    
    /*ELIMINAR POR USUARIO*/
    function eliminar(){
        $coduser = trim($this->input->post('coduser', true));
        if (empty($coduser)) {
            echo json_encode(array('success' => false, 'message' => 'Parámetros de entrada no válidos.'));
            return;
        }
        $array = array(
            'del'           => 1,
            'date_delete'   => date('Y-m-d H:i:s'),
            'user_delete'   => $_SESSION['_SESSIONUSER']
        );

        $result = $this->Modelo_usuario->update('tb_usuarios', $array, $coduser, 'coduser');
        if ($result) {
            echo json_encode(array('success' => true, 'message' => 'Registro eliminado correctamente.'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'No se pudo eliminar el registro.'));
        }
    }

    /*   RETIRAR FILTROS    */
    function val_session(){
        if(isset($_SESSION['_SESSIONUSER'])){            
            echo '1';
        }else{
            redirect('login');
            echo '2';
        }
    }

    function retirar_filtros(){
        unset($_SESSION['FILTRO_TIPO_USER']);
        unset($_SESSION['FILTRO_ESTADO']);
    }




    function get_tbl_tipo_user(){       
       
        $res = $this->Modelo_usuario->get_tbl_tipo_user();    
        
        if ($res != 'error') {
            $cadena = '';
        
            foreach ($res as $key) {             
                $cadena .= '
                    <tr class="table_list" >

                        <td>
                            <div style="text-align:center;" class="">'.$key->id.'</div>
                        </td> 

                        <td>
                            <div tyle="text-align:center;" ><label id="txt_nombre_ctrl" >'.$key->descripcion.'</label> </div>                           
                        </td>  

                        <td>
                            <div style="text-align:center;" > <label  id="txt_nombre_ctrl" >'.$key->area.'</label> </div>                          
                        </td>    

                        <td >
                            <div style="text-align:center;" >                
                                <button class="btn btn-sm btn-outline-primary waves-effect waves-light" onclick="get_data_tipouser( '.$key->id.');"> <i class="mdi mdi-square-edit-outline"></i> </button>                                                                  
                                <!-- <button class="btn btn-sm btn-outline-danger waves-effect waves-light" onclick="eliminar( '.$key->id.');"> <i class="bx bx-trash"></i> </button>         -->
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
   
}

?>
