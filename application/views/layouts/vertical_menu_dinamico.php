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



<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="<?php echo base_url();?>seg_solicitud" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="<?php echo base_url();?>public/img/cvc_log.png" alt="" height="24">
                    </span>
                    <span class="logo-lg">
                        <img src="<?php echo base_url();?>public/img/cvc_log.png" alt="" height="26">  <span style="color:#2A37A4; font-size:14px;  font-weight: bold;"> .:: CVC ENERGIA ::. </span> <span class="logo-txt"></span>
                    </span>
                </a>
 
                <a href="<?php echo base_url();?>seg_solicitud" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="<?php echo base_url();?>public/img/cvc_log.png" alt="" height="24">
                    </span>
                    <span class="logo-lg">
                        <img src="<?php echo base_url();?>public/img/cvc_log.png" alt="" height="24"> <span style="color:white; font-size:14px;  font-weight: bold;"> .:: CVC ENERGIA ::. </span> <span class="logo-txt"></span>
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <!-- App Search-->
            <!--<form class="app-search d-none d-lg-block">
                <div class="position-relative">
                    <input type="text" class="form-control" placeholder="<?php //echo $language["Search"]; ?>">
                    <button class="btn btn-primary" type="button"><i class="bx bx-search-alt align-middle"></i></button>
                </div>
            </form>-->
        </div>

        <div class="d-flex">


            <div class="dropdown d-none d-sm-inline-block">
                <button type="button" class="btn header-item" id="mode-setting-btn">
                    <i data-feather="moon" class="icon-lg layout-mode-dark "></i>
                    <i data-feather="sun" class="icon-lg layout-mode-light"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item right-bar-toggle me-2">
                    <i data-feather="settings" class="icon-lg"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item bg-soft-light border-start border-end" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" id="img_foto_2" src="<?php echo base_url();?>public/images/tag/<?php echo $_SESSION['_SESSIONFOTO'];?>" alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1 fw-medium"><?php echo $_SESSION['_SESSIONUSERNOMBRE']; ?>.</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="<?php echo  base_url();?>perfil"><i class="mdi mdi-face-profile font-size-16 align-middle me-1"></i>Mi Perfíl</a>
                    <!--<a class="dropdown-item" href="auth-lock-screen.php"><i class="mdi mdi-lock font-size-16 align-middle me-1"></i> <?php //echo $language["Lock_screen"]; ?></a>-->
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?php echo  base_url();?>logout"><i class="mdi mdi-logout font-size-16 align-middle me-1"></i> Cerrar Sesión </a>
                </div>
            </div>

        </div>
    </div>
</header>

<!-- ========== Left Sidebar Start ========== -->
<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">

                <!--CONFIG GENERAL PARA ACTIVACIÓN DE MENUS SEGÚN OPCIONES-->
                <?php 
                    //ARMAMOS EL MENU DE ACUERDO A LOS ACCESOS
                    $array_menu = array(); 

                    foreach ($config_menu as $key_x) {
                        array_push($array_menu,$key_x->id.'&'.$key_x->des_menu.'&'.$key_x->icono_menu); 
                    }
                    $array_menu_index = array_unique($array_menu); 

                    foreach ($array_menu_index as $key_x => $value) {
                        $a = explode('&',$value);
                        $id         = $a[0];
                        $des_menu   = $a[1];
                        $icono      = $a[2];
                        echo '
                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <i class="'.$icono.'"></i>
                                <span data-key="t-monitoreo">'.$des_menu.'</span>
                            </a>
                        ';
                        foreach ($config_menu as $key_y) {
                            if($id==$key_y->id){
                                $class= ''; 
                                if($key_y->id_menu==$id_menu){
                                    $class= 'mm-collapse mm-show'; 
                                }

                                echo '
                                    <ul class="sub-menu '.$class.'" aria-expanded="true">
                                        <li><a href="'.base_url().$key_y->ruta_sub_menu.'" data-key="'.$key_y->ruta_sub_menu.'">'.$key_y->des_sub_menu.'</a></li>
                                    </ul>
                                ';
                            }
                        }
                        echo '
                        </li>                                
                        ';
                    }
                ?>

            <!--<div class="card sidebar-alert border-0 text-center mx-4 mb-0 mt-5">
                <div class="card-body">
                    <img src="assets/images/giftbox.png" alt="">
                    <div class="mt-4">
                        <h5 class="alertcard-title font-size-16">Solicita Soporte</h5>
                        <p class="font-size-13">¡Tuviste algún inconveniente? Envianos un mensaje al correo mreynoso@multiservicioscall.com con los detalles del inconveniente.</p>
                        <a href="#!" class="btn btn-primary mt-2">¡Enviar mensaje!</a>
                    </div>
                </div>
            </div>-->
        </div>
        <!-- Sidebar -->
    </div>
</div>

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
        $('#loader-container').css({
                        'opacity': '0',
                        'pointer-events': 'none'
                    });
    }
</script>
<!-- Left Sidebar End -->