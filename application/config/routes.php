<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Login';
$route['404_override'] = 'Controller_404';

$route['translate_uri_dashes'] = FALSE;

$route['login'] = 'Login/login';
$route['recuperar'] = 'Login/recuperar_view';
$route['recuperar_action'] = 'Login/recover';
$route['cambiar_clave/(:any)'] = 'Login/confirmar_view/$1';
$route['confirmar'] = 'Login/confirmar_action';
$route['logout'] = 'Login/logout';
$route['perfil'] = 'C_perfil';




/**************************************************************************************/
/****************************** SISTEMA CVC MENU **************************************/
/**************************************************************************************/




    //GESTION DE USUARIOS 
    $route['seg_usuarios'] = 'Controller_usuario';
    $route['seg_asistencia'] = 'Controller_control_asistencia';
    $route['seg_permisos_menu'] = 'Controller_config_sub_menu';
    $route['seg_log_accesos'] = 'Controller_control_accessos';
    $route['seg_control_anomalias'] = 'Controller_control_anomalias';
    $route['seg_control_memos'] = 'Controller_control_memos';




    //DESARROLLO 
    $route['seg_solicitud'] = 'Controller_solicitud';
    $route['seg_cliente_libre'] = 'Controller_cliente_libre'; 
    $route['seg_distribuidor'] = 'Controller_distribuidor'; 
    $route['seg_plantilla'] = 'Controller_plantilla'; //llamar controlador 1
    $route['seg_distribuidor_correos'] = 'Controller_distribuidor_correos'; 

    $route['seg_auditoria'] = 'Controller_auditoria';
    $route['seg_accesos_cvc'] = 'Controller_accesos_cvc';


    $route['seg_contacto'] = 'Controller_contactos'; 
    $route['seg_dashboard'] = 'Controller_dashboard';
    $route['seg_dashboard_prueba'] = 'Controller_dashboard_prueba';
    $route['seg_informe'] = 'Controller_informe';
    $route['seg_formulario2'] = 'Controller_solicitud2';
    $route['seg_formulario'] = 'Controller_formulario';
    $route['seg_formulario_pruebas'] = 'Controller_formulario_pruebas';

/**************************************************************************************/
/*************************** FIN SISTEMA GEO MENU *************************************/
/**************************************************************************************/


//Para clientes
$route['seg_cliente'] = 'Controller_cliente_lindley';

//para exportar preavisos
$route['exportar_geo'] = 'Controller_exportar_geo';


/*008072022*/
$route['tipo_servicio'] = 'C_tiposervicio';
$route['calificacion'] = 'C_calificacion';
$route['criterio'] = 'C_criterio';
$route['criterioxservicio'] = 'C_criterioxservicio';
$route['campania'] = 'C_campania';
$route['usuarioxcampania'] = 'C_usuarioxcampania';
$route['usuarioxcampania_integra'] = 'C_usuarioxcampania_integra';
$route['actividad'] = 'C_actividad';
$route['monitoreo'] = 'C_monitoreo';
$route['monitoreo_integra'] = 'C_monitoreo_integra';
$route['monitoreo/generar_pdf/(:any)'] = 'C_pruebas/generar_pdf/$1';

$route['informe_integra'] = 'C_inf_integra';

$route['pruebas'] = 'C_pruebas';
$route['pruebas/generar_pdf/(:any)'] = 'C_pruebas/generar_pdf/$1';



//Para audios control
$route['campania_audios'] = 'C_campania_audios';
$route['usuarioxcampania_audio'] = 'C_usuarioxcampania_audio';
$route['monitoreo_audios'] = 'C_monitoreo_audios';
$route['usuario_audios'] = 'C_usuario_audios';
$route['informe_audios'] = 'C_inf_audios';


$route['usuario_monitoreo'] = 'C_usuario_monitoreo';
$route['usuario_integra'] = 'C_usuario_integra';

/*
 - data
*/

$route['modulo_evento'] = 'Modulo_evento';
$route['modulo_evento/ver'] = 'Modulo_evento/ver';


/*MQS*/
$route['mod_repuestos'] = 'Mod_repuestos';
$route['mod_marcas'] = 'Mod_marcas';
$route['mod_descuento'] = 'Mod_descuento';
/**/


$route['panel'] = 'Voucher';


$route['voucher'] = 'Voucher';
$route['consulta'] = 'Consulta';

$route['voucher/nuevo'] = 'Voucher/nuevo_view';

$route['paciente/editar/(:any)'] = 'Paciente/editar_view/$1';
$route['historial'] = 'Historial';
$route['historial/nuevo'] = 'Historial/nuevo_view';
$route['historial/cita/(:any)'] = 'Historial/cita_view/$1';
$route['historial/gestionar_cita/(:any)'] = 'Historial/gestionar_view/$1';

/******************0***************************/
// $route['voucher']='';
/******************1***************************/
$route['voucher/generar'] = 'Voucher/generar_voucher';
/******************2***************************/
$route['voucher/agregar_web'] = 'Voucher/nuevo_action_web';
/*********************************************/



// EXCEL
$route['excel'] = 'Excel';
$route['excel/listar_excel'] = 'Excel/listar_excel';
$route['excel/nuevo'] = 'Excel/nuevo_view';
$route['excel/agregar'] = 'Excel/nuevo_action';
$route['excel/ver/(:any)'] = 'Excel/mostrar_view/$1';
$route['excel/eliminar/(:any)'] = 'Excel/eliminar_action/$1';
// 



$route['voucher/agregar'] = 'Voucher/nuevo_action';



$route['voucher/listar_voucher'] = 'Voucher/listar_voucher';

$route['voucher/precios'] = 'Voucher/precios';
// 
$route['voucher/precios_web'] = 'Voucher/precios_web';
// 
$route['voucher/resultpass'] = 'Voucher/resultpass';
$route['voucher/editar/(:any)'] = 'Voucher/editar_view/$1';
$route['voucher/actualizar'] = 'Voucher/editar_action';
$route['voucher/ver/(:any)'] = 'Voucher/mostrar_view/$1';
$route['voucher/exp_seleccionados'] = 'Voucher/export_seleccionados';
$route['voucher/exp_rango'] = 'Voucher/export_rango';
$route['voucher/imprimir/(:any)'] = 'Voucher/imprimit_voucher/$1';
$route['voucher/eliminar/(:any)'] = 'Voucher/eliminar_action/$1';


$route['pasajeros'] = 'Pasajeros';
$route['pasajeros/editar/(:any)'] = 'Pasajeros/editar_view/$1';
$route['pasajeros/actualizar'] = 'Pasajeros/editar_action';
$route['pasajeros/listar_pasajeros'] = 'Pasajeros/listar_pasajeros';
$route['pasajeros/exp_seleccionados'] = 'Pasajeros/export_seleccionados';
$route['pasajeros/exp_rango'] = 'Pasajeros/export_rango';
$route['pasajeros/eliminar/(:any)'] = 'Pasajeros/eliminar_action/$1';

$route['agencias'] = 'Agencias';
$route['agencias/nuevo'] = 'Agencias/nuevo_view';
$route['agencias/agregar'] = 'Agencias/nuevo_action';
$route['agencias/editar/(:any)'] = 'Agencias/editar_view/$1';
$route['agencias/actualizar'] = 'Agencias/editar_action';
$route['agencias/listar_agencias'] = 'Agencias/listar_agencias';
$route['agencias/exp_seleccionados'] = 'Agencias/export_seleccionados';
$route['agencias/exp_rango'] = 'Agencias/export_rango';
$route['agencias/eliminar/(:any)'] = 'Agencias/eliminar_action/$1';

$route['counters'] = 'Counters';
$route['counters/nuevo'] = 'Counters/nuevo_view';
$route['counters/agregar'] = 'Counters/nuevo_action';
$route['counters/editar/(:any)'] = 'Counters/editar_view/$1';
$route['counters/actualizar'] = 'Counters/editar_action';
$route['counters/listar_counters'] = 'Counters/listar_counters';
$route['counters/exp_seleccionados'] = 'Counters/export_seleccionados';
$route['counters/exp_rango'] = 'Counters/export_rango';
$route['counters/eliminar/(:any)'] = 'Counters/eliminar_action/$1';

$route['promotores'] = 'Promotores';
$route['promotores/nuevo'] = 'Promotores/nuevo_view';
$route['promotores/agregar'] = 'Promotores/nuevo_action';
$route['promotores/editar/(:any)'] = 'Promotores/editar_view/$1';
$route['promotores/actualizar'] = 'Promotores/editar_action';
$route['promotores/listar_promotores'] = 'Promotores/listar_promotores';
$route['promotores/exp_seleccionados'] = 'Promotores/export_seleccionados';
$route['promotores/exp_rango'] = 'Promotores/export_rango';
$route['promotores/eliminar/(:any)'] = 'Promotores/eliminar_action/$1';

$route['planes'] = 'Planes';
$route['planes/nuevo'] = 'Planes/nuevo_view';
$route['planes/agregar'] = 'Planes/nuevo_action';
$route['planes/editar/(:any)'] = 'Planes/editar_view/$1';
$route['planes/actualizar'] = 'Planes/editar_action';
$route['planes/listar_planes'] = 'Planes/listar_planes';
$route['planes/eliminar/(:any)'] = 'Planes/eliminar_action/$1';
$route['planes/precios/(:num)'] = 'Precios/index/$1';
$route['planes/precios/listar_precios/(:num)'] = 'Precios/listar_precios/$1';
$route['planes/precios/nuevo/(:num)'] = 'Precios/nuevo_view/$1';
$route['planes/precios/agregar'] = 'Precios/nuevo_action';
$route['planes/precios/editar/(:any)'] = 'Precios/editar_view/$1';
$route['planes/precios/actualizar'] = 'Precios/editar_action';
$route['planes/precios/eliminar/(:any)'] = 'Precios/eliminar_action/$1';

$route['cobranza'] = 'Cobranza';
$route['cobranza/listar_cobranza'] = 'Cobranza/listar_cobranza';
$route['cobranza/nuevo'] = 'Cobranza/nuevo_view';
$route['cobranza/agregar'] = 'Cobranza/nuevo_action';
$route['cobranza/voucher'] = 'Cobranza/getvou';
$route['cobranza/imprimir/(:any)'] = 'Cobranza/imprimir_view/$1';
$route['cobranza/eliminar/(:any)'] = 'Cobranza/eliminar_action/$1';

$route['beneficios'] = 'Beneficios';
$route['beneficios/nuevo'] = 'Beneficios/nuevo_view';
$route['beneficios/agregar'] = 'Beneficios/nuevo_action';
$route['beneficios/editar/(:any)'] = 'Beneficios/editar_view/$1';
$route['beneficios/actualizar'] = 'Beneficios/editar_action';
$route['beneficios/listar_beneficios'] = 'Beneficios/listar_beneficios';
$route['beneficios/eliminar/(:any)'] = 'Beneficios/eliminar_action/$1';

$route['servicios'] = 'Servicios';
$route['servicios/nuevo'] = 'Servicios/nuevo_view';
$route['servicios/agregar'] = 'Servicios/nuevo_action';
$route['servicios/editar/(:any)'] = 'Servicios/editar_view/$1';
$route['servicios/actualizar'] = 'Servicios/editar_action';
$route['servicios/listar_servicios'] = 'Servicios/listar_servicios';
$route['servicios/eliminar/(:any)'] = 'Servicios/eliminar_action/$1';



/*Recepcion*/
$route['asistencia']='Asistencia';
$route['registrar']='Asistencia/registrar';
$route['registrar_salida']='Asistencia/salida';

$route['settings']='Settings';
$route['settings']='Settings/activar_session_vertical';
$route['settings']='Settings/activar_session_horizontal';

$route['system_link']='C_system_link';
$route['system_link/recursos']='C_system_link/recursos';

$route['control_monitoreo']='C_control_monitoreo';
$route['control_servicio']='C_control_servicio';

$route['informes_amicar']='C_inf_amicar';


//Para control de audio
$route['control_audio_marcador'] = 'C_control_audio';
