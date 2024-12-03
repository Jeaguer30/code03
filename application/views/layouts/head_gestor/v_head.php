<!DOCTYPE html>
<html lang="en">
    <style>
        .loader-container {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(249, 249, 249, 0.5); /* Fondo semitransparente */
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0; /* Inicialmente oculto */
            pointer-events: none; /* Para que no se pueda interactuar con el fondo */
            transition: opacity 0.3s ease; /* Transición de opacidad */
        }

        .loader {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: inline-block;
            border-top: 4px solid #FFF;
            border-right: 4px solid transparent;
            box-sizing: border-box;
            animation: rotation 1s linear infinite;
        }

        .loader::after {
            content: '';
            box-sizing: border-box;
            position: absolute;
            left: 0;
            top: 0;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            border-left: 4px solid #FF3D00;
            border-bottom: 4px solid transparent;
            animation: rotation 0.5s linear infinite reverse;
        }

        @keyframes rotation {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    <div class="loader-container" id="loader-container">
        <div class="loader"></div>
    </div>
    <head>

        <title> . : : Geo-Chasqui : : .</title>
        <meta charset="utf-8"/>
        <meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="" name="description"/>
        <meta content="Themesbrand" name="author"/>
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?php echo base_url();?>public/images/chazki_.png">

        <!-- plugin css -->
        <link href="<?php echo base_url();?>public/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />

        <!-- preloader css -->
        <link rel="stylesheet" href="<?php echo base_url();?>public/css/preloader.min.css" type="text/css" />

        <!-- Bootstrap Css -->
        <link href="<?php echo base_url();?>public/css/bootstrap2.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        
        <!-- Icons Css -->
        <link href="<?php echo base_url();?>public/css/icons.min.css" rel="stylesheet" type="text/css" />

        <!-- App Css-->
        <link href="<?php echo base_url();?>public/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

        <!-- App Css-->
        <link href="<?php echo base_url();?>public/css/estilos_personalizados.css" id="app-style" rel="stylesheet" type="text/css" />
        
        <!-- alertifyjs Css -->
        <link href="<?php echo base_url();?>public/libs/alertifyjs/build/css/alertify.min.css" rel="stylesheet" type="text/css" />

    </head>

    <?php 
        $layout='';
        $layout_mode ='';
        $layout_width = '';
        $layout_position = '';
        $topbar_color = '';
        $sidebar_size = '';
        $sidebar_color = '';
        
        foreach ($config as $key) {
            $layout=$key->layout;
            $layout_mode = $key->layout_mode;
            $layout_width = $key->layout_width;
            $layout_position = $key->layout_position;
            $topbar_color = $key->topbar_color;
            $sidebar_size = $key->sidebar_size;
            $sidebar_color = $key->sidebar_color;

        }


        if($layout=='vertical'){
            echo '
                <body class="bg_fondo" data-layout-mode="'.$layout_mode.'" data-layout-size="'.$layout_width.'" data-sidebar-size="'.$sidebar_size.'"  data-layout-scrollable="'.$layout_position.'" data-topbar="'.$topbar_color.'" data-sidebar="'.$sidebar_color.'">
            ';
        }else{
            echo '
                <body class="bg_fondo" f="'.$layout.'" data-layout="horizontal" data-layout-mode="'.$layout_mode.'" data-layout-size="'.$layout_width.'" data-layout-scrollable="'.$layout_position.'" data-topbar="'.$topbar_color.'" data-sidebar="'.$sidebar_color.'" data-sidebar-size="'.$sidebar_size.'" >
            ';
        }
    ?>
        <!-- Begin page -->
        <div id="layout-wrapper" hub="<?php echo  $sidebar_size;?>">

<script>
    function val_errores(jqXHR, textStatus, errorThrown){
        if (jqXHR.status === 0) {
            alert('Sin conexión: Verifica tu Internet.');
        } else if (jqXHR.status == 400) {
            alert('Solicitud incorrecta [400]');
        } else if (jqXHR.status == 401) {
            alert('No autorizado [401]');
        } else if (jqXHR.status == 403) {
            alert('Prohibido [403]');
        } else if (jqXHR.status == 404) {
            alert('Página solicitada no encontrada [404]');
        } else if (jqXHR.status == 408) {
            alert('Tiempo de espera de la solicitud agotado [408]');
        } else if (jqXHR.status == 429) {
            alert('Demasiadas solicitudes [429]');
        } else if (jqXHR.status == 500) {
            alert('Error interno del servidor [500]');
        } else if (jqXHR.status == 502) {
            alert('Puerta de enlace incorrecta [502]');
        } else if (jqXHR.status == 503) {
            alert('Servicio no disponible [503]');
        } else if (jqXHR.status == 504) {
            alert('Tiempo de espera de la puerta de enlace agotado [504]');
        } else if (textStatus === 'parsererror') {
            alert('Falló el parseo de JSON solicitado.');
        } else if (textStatus === 'timeout') {
            alert('Error de tiempo de espera.');
        } else if (textStatus === 'abort') {
            alert('Solicitud AJAX abortada.');
        } else {
            alert('Error desconocido');
            console.error('Error no detectado: ' + jqXHR.responseText);
        }
        $('#loader-container').css('opacity', '0');
    }
</script>
