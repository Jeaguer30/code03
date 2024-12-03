<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class C_perfil extends CI_Controller
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
        $tipo_user          = $this->Mdl_compartido->retornarcampo($_SESSION['_SESSIONUSER'],'coduser','tb_usuarios','tipo_user');      
        $header['id_menu']  = $this->Mdl_compartido->retornarcampo('seg_consulta','ruta','config_sub_menu','id_menu');
        $id_sub_menu        = $this->Mdl_compartido->retornarcampo('gestor_mapa','ruta','config_sub_menu','id');
    
        //Validamos que tenga el permiso
        $permiso = $this->Mdl_compartido->permisos_menu_mejorado('seg_consulta',$tipo_user);
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
     

        //$data['lst_tiposervicio'] = $this->M_tiposervicio->list('tb_tipo_servicio');
        $data['foto'] = $this->Mdl_compartido->retornarcampo($_SESSION['_SESSIONUSER'],'coduser','tb_usuarios','foto');

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
        $this->load->view('v_perfil', $data);
        $this->load->view('layouts/v_footer');

    }

    function actualiza_contrasena(){
        $id_pass_actual = trim($this->input->post('id_pass_actual'));
        $id_pass_new = trim($this->input->post('id_pass_new'));
        $id_confirm_pass_new = trim($this->input->post('id_confirm_pass_new'));       
        $clave_encriptada = $this->encriptar($id_pass_actual);
       
        $txt_clave = $this->Mdl_compartido->retornarcampo($_SESSION['_SESSIONUSER'],'coduser','tb_usuarios','clave');
        
        if ($clave_encriptada==$txt_clave) {            
            $coduser = $_SESSION['_SESSIONUSER']; 
            $pass_new = $this->encriptar($id_pass_new);
            $array = array(
                'clave'=> $pass_new 
            );    
            $result = $this->M_perfil->update('tb_usuarios',$array,$coduser);
          echo '1';
        } else {
            echo '2';
        }
        

       
    }
    function encriptar($clave){
        $clave_encriptada = hash_hmac('sha512', $clave, 'KAJFBD@./*-_15fl221dlkaik2123');
        return $clave_encriptada;
    }


    function grabar(){
        $nombres = trim($this->input->post('nombres'));
        $apellidos = trim($this->input->post('apellidos'));
        $dni = trim($this->input->post('dni'));
        $f_nac = trim($this->input->post('fecha'));
        $correo = trim($this->input->post('correo'));
        $telefono = trim($this->input->post('celular'));
        //$distrito = trim($this->input->post('distrito'));
        $direccion = trim($this->input->post('direccion'));

        $coduser = $_SESSION['_SESSIONUSER']; 
        $array = array(
            'nombres'=>$nombres,
            'apellidos'=>$apellidos,
            'dni'=>$dni,
            'f_nac'=>$f_nac,
            'correo'=>$correo,
            'telefono'=>$telefono,
            //'distrito'=>$distrito,
            'direccion'=>$direccion,
            'f_upd'=>date('Y-m-d H:i:s')
        );

        $result = $this->M_perfil->update('tb_usuarios',$array,$coduser);
        echo $result;
    }

    function get_datos(){
        $coduser = $_SESSION['_SESSIONUSER'];
        $result = $this->M_perfil->get_datos('tb_usuarios',$coduser);
        echo json_encode($result);
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
            $res = $this->M_perfil->update('tb_usuarios',$array,$id);
            if($res){
                    $_SESSION['_SESSIONFOTO'] = $nombre; 
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

}

?>
