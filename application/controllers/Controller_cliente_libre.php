<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Controller_cliente_libre extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('image_lib');
        $this->load->model('Mdl_compartido');
        $this->load->model('Modelo_cliente_libre');
        $this->load->model('M_settings');
        $this->load->model('M_settings_menu');
        date_default_timezone_set('America/Lima');
    }

    public function index(){
        //Retornamos campo tipo de usuario
        $tipo_user          = $this->Mdl_compartido->retornarcampo($_SESSION['_SESSIONUSER'],'coduser','tb_usuarios','tipo_user');
        //Obtenemos el id del menu
        $header['id_menu']  = $this->Mdl_compartido->retornarcampo('seg_cliente_libre','ruta','config_sub_menu','id_menu');
        $id_sub_menu        = $this->Mdl_compartido->retornarcampo('seg_cliente_libre','ruta','config_sub_menu','id');
        //Validamos que tenga el permiso
        $permiso = $this->Mdl_compartido->permisos_menu_mejorado('seg_cliente_libre',$tipo_user);
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
        $this->load->view('vista_cliente_libre', $data);
       // $this->load->view('seg_usuarios/seg_usuarios_modal', $data);
        $this->load->view('layouts/v_footer');

    }

    function load_filtro_estado(){
        $resultado = $this->Modelo_cliente_libre->load_filtro_estado();
        $cadena='<option value=""> Estado</option>'; 
        if($resultado!='error'){
           
            foreach($resultado as $key){
                $cadena.='<option value="'.$key->descripcion.'">'. $key->descripcion.'</option>'; 
            }
        }else{
            $cadena.=''; 
        }
        echo $cadena; 
    }


    function load_filtro_distribuidor(){
        $resultado = $this->Modelo_cliente_libre->load_filtro_distribuidor();
        $cadena='<option value=""> Distribuidor</option>'; 
        if($resultado!='error'){        
            foreach($resultado as $key){
                $cadena.='<option value="'.$key->descripcion.'">'. $key->descripcion.'</option>'; 
            }
        }else{
            $cadena.=''; 
        }
        echo $cadena; 
    }


    function load_filtro_departamento(){
        $resultado = $this->Modelo_cliente_libre->load_filtro_departamento();
        $cadena='<option value=""> Departamento</option>'; 
        if($resultado!='error'){        
            foreach($resultado as $key){
                $cadena.='<option value="'.$key->departamento.'">'. $key->departamento.'</option>'; 
            }
        }else{
            $cadena.=''; 
        }
        echo $cadena; 
    }

    function aplicar_filtro_estado(){
        $dato = $this->input->post('dato',true);
        if($dato==''){
            unset($_SESSION['FILTRO_LIBRE_ESTADO']); 
        }else{
            $_SESSION['FILTRO_LIBRE_ESTADO'] = $dato;
        }
    }


    function aplicar_filtro_cliente(){
        $dato = $this->input->post('dato',true);
        if($dato==''){
            unset($_SESSION['FILTRO_LIBRE_TIPO']); 
        }else{
            $_SESSION['FILTRO_LIBRE_TIPO'] = $dato;
        }
    }

    function aplicar_filtro_distribuidor(){
        $dato = $this->input->post('dato',true);
        if($dato==''){
            unset($_SESSION['FILTRO_LIBRE_DISTRIBUIDOR']); 
        }else{
            $_SESSION['FILTRO_LIBRE_DISTRIBUIDOR'] = $dato;
        }
    }

    function aplicar_filtro_departamento(){
        $dato = $this->input->post('dato',true);
        if($dato==''){
            unset($_SESSION['FILTRO_LIBRE_DEPARTAMENTO']); 
        }else{
            $_SESSION['FILTRO_LIBRE_DEPARTAMENTO'] = $dato;
        }
    }


    /*OBTENER*/
    function get_datos(){
        $id       = trim($this->input->post('id',true));
        $result    = $this->Modelo_cliente_libre->get_datos_table_for_id($id);
        if($result!='error'){
            foreach ($result as $key) { 
                $ar['id'] =$key->id;
                $ar['razon_social'] =$key->razon_social;           
                $ar['ruc']          =$key->ruc;
                $ar['codigo_iscom'] =$key->codigo_iscom;
                $ar['status']       =$key->status;

                //$ar['cuenta_sd']    =$key->cuenta_sd;
                //$ar['mes_deuda']        =$key->mes_deuda;     
                //$ar['nro_dias_pago']    =$key->nro_dias_pago;   
                //$ar['osinergmin']       =$key->osinergmin;                                 
                
                $ar['distribuidor_local']       =$key->distribuidor_local;
                $ar['nro_suministro_distri']    =$key->nro_suministro_distri;                         
                $ar['alimentador']              =$key->alimentador; 

                $ar['pmi']                      =$key->pmi;      
                $ar['direccion_suministro']     =$key->direccion_suministro;            
                $ar['distrito']                 =$key->distrito;  
                $ar['provincia']                =$key->provincia;
                $ar['departamento']             =$key->departamento;
                

            }   
            $ar['mensaje'] = 'ok';
        }else{
            $ar['mensaje'] = 'error';
        }
        echo json_encode($ar);
    }


    /*LISTAR*/
    function listar_registros(){
        if (!empty($_POST))
        {
            $tipo_user = $this->Mdl_compartido->retornarcampo($_SESSION['_SESSIONUSER'],'coduser','tb_usuarios','tipo_user');
            $fetch_data = $this->Modelo_cliente_libre->make_datatables();
            
            $data = array();
            $contador=0; 
            
            foreach($fetch_data as $row)
            {
                $cl = "";     
                //$cl = $row->color;
                $contador++;               
                $sub_array = array();

                // columnas de las tablas
                $sub_array[] = $contador;
                $sub_array[] = '                
                    <div class="col-lg-12 col-center " style="text-align: center;">
                        <button class="btn btn-sm btn-outline-primary waves-effect waves-light"  onclick="get_datos('.$row->id.');"> <i class="mdi mdi-square-edit-outline"></i> </button>   
                        <button class="btn btn-sm btn-outline-danger waves-effect waves-light"  onclick="eliminar('.$row->id.');"> <i class="bx bx-trash"></i> </button>                                            
                    </div>';           

                
                $sub_array[] = $row->razon_social;
                $sub_array[] = $row->status;
                $sub_array[] = $row->ruc;   
                $sub_array[] = $row->codigo_iscom;   

                //$sub_array[] = $row->cuenta_sd; 
                //$sub_array[] = $row->mes_deuda;     
                //$sub_array[] = $row->nro_dias_pago;
                //$sub_array[] = $row->osinergmin; 

                $sub_array[] = $row->distribuidor_local; 
                $sub_array[] = $row->nro_suministro_distri; 
                $sub_array[] = $row->alimentador; 
                $sub_array[] = $row->direccion_suministro; 

                $sub_array[] = $row->distrito;
                $sub_array[] = $row->provincia;
                $sub_array[] = $row->departamento;
                $sub_array[] = $row->f_registro; 
                                                            
                $data[] = $sub_array;
            }
            $output = array(
                "draw"                  =>     intval($_POST["draw"]),
                "recordsTotal"          =>     $this->Modelo_cliente_libre->get_all_data(),
                "recordsFiltered"       =>     $this->Modelo_cliente_libre->get_filtered_data(),
                "data"                  =>     $data
            );
            echo json_encode($output);
        }
    }

    /*AGREGAR*/
    function agregar(){
        $r_social        = trim($this->input->post('r_social',true));
        $ruc             = trim($this->input->post('ruc',true));
        $cod_iscom       = trim($this->input->post('cod_iscom',true));
        $estado          = trim($this->input->post('estado',true));

        //$cuenta_sd       = trim($this->input->post('cuenta_sd',true));
        //$mes_deuda       = trim($this->input->post('mes_deuda',true));
        //$dias_pago       = trim($this->input->post('dias_pago',true));
        //$osig            = trim($this->input->post('osig',true));

        $distrib         = trim($this->input->post('distrib',true));        
        $sumin_dis       = trim($this->input->post('sumin_dis',true));      
        $alimen          = trim($this->input->post('alimen',true));        
        $pmi             = trim($this->input->post('pmi',true));
        $dir_dis         = trim($this->input->post('dir_dis',true));   
        $dis             = trim($this->input->post('dis',true));   
        $pro             = trim($this->input->post('pro',true));   
        $dep             = trim($this->input->post('dep',true));  


        $array = array(           
            'razon_social'          => $r_social,
            'ruc'                   => $ruc,
            'codigo_iscom'          => $cod_iscom,
            'status'                => $estado,
            
            //'cuenta_sd'             => $cuenta_sd,
            //'mes_deuda'             => $mes_deuda,       
            //'nro_dias_pago'         => $dias_pago,       
            //'osinergmin'            => $osig, 

            'distribuidor_local'    => $distrib,           
            'nro_suministro_distri' => $sumin_dis,
            'alimentador'           => $alimen,
            'pmi'                   => $pmi,     
            'direccion_suministro'  => $dir_dis,  
            'distrito'              => $dis,  
            'provincia'             => $pro,  
            'departamento'          => $dep,  
            'f_registro'            => date('Y-m-d H:i:s'),            
            'del'                   => 0
        );
    
        $result = $this->Modelo_cliente_libre->insert('cvc_clientes_libres', $array);
        $ar['mensaje'] = '1';

       echo json_encode($ar);   
    }

    /*ACTUALIZAR*/

    function actualizar(){
        $id             = trim($this->input->post('id',true));
        $r_social        = trim($this->input->post('r_social',true));
        $ruc             = trim($this->input->post('ruc',true));
        $cod_iscom       = trim($this->input->post('cod_iscom',true));
        $estado          = trim($this->input->post('estado',true));

        //$cuenta_sd       = trim($this->input->post('cuenta_sd',true));
        //$mes_deuda       = trim($this->input->post('mes_deuda',true));
        //$dias_pago       = trim($this->input->post('dias_pago',true));
        //$osig            = trim($this->input->post('osig',true));

        $distrib         = trim($this->input->post('distrib',true));        
        $sumin_dis       = trim($this->input->post('sumin_dis',true));      
        $alimen          = trim($this->input->post('alimen',true));        
        $pmi             = trim($this->input->post('pmi',true));
        $dir_dis         = trim($this->input->post('dir_dis',true));   
        $dis             = trim($this->input->post('dis',true));   
        $pro             = trim($this->input->post('pro',true));   
        $dep             = trim($this->input->post('dep',true));  


        $array = array(           
            'razon_social'          => $r_social,
            'ruc'                   => $ruc,
            'codigo_iscom'          => $cod_iscom,
            'status'                => $estado,

            //'cuenta_sd'             => $cuenta_sd,
            //'mes_deuda'             => $mes_deuda,       
            //'nro_dias_pago'         => $dias_pago,       
            //'osinergmin'            => $osig, 

            'distribuidor_local'    => $distrib,           
            'nro_suministro_distri' => $sumin_dis,
            'alimentador'           => $alimen,
            'pmi'                   => $pmi,     
            'direccion_suministro'  => $dir_dis,  
            'distrito'              => $dis,  
            'provincia'             => $pro,  
            'departamento'          => $dep,  
            'f_upd'   => date('Y-m-d H:i:s'),
            'user_upd'   => $_SESSION['_SESSIONUSER']

            
        );
    
        $result = $this->Modelo_cliente_libre->update('cvc_clientes_libres',$array,$id,'id');
        $ar['mensaje'] = '1';

       echo json_encode($ar);   
    }

    /*ELIMINAR*/
    function eliminar(){
        $id = trim($this->input->post('id', true));
        if (empty($id)) {
            echo json_encode(array('success' => false, 'message' => 'Parámetros de entrada no válidos.'));
            return;
        }
        $array = array(
            'del'           => 1,
            'f_del'   => date('Y-m-d H:i:s'),
            'user_del'   => $_SESSION['_SESSIONUSER']
        );

        $result = $this->Modelo_cliente_libre->update('cvc_clientes_libres', $array, $id, 'id');
        if ($result) {
            echo json_encode(array('success' => true, 'message' => 'Registro eliminado correctamente.'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'No se pudo eliminar el registro.'));
        }
    }

    /*RETIRAR FILTROS*/
    function retirar_filtros(){
        unset($_SESSION['FILTRO_LIBRE_ESTADO']);
        unset($_SESSION['FILTRO_LIBRE_DISTRIBUIDOR']);
        unset($_SESSION['FILTRO_LIBRE_DEPARTAMENTO']);
    }
}

?>
