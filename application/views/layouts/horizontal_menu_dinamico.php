
<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="<?php echo base_url();?>agenda" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="<?php echo base_url();?>public/images/chazki.png" alt="" height="24">
                    </span>
                    <span class="logo-lg">
                        <img src="<?php echo base_url();?>public/images/chazki.png" alt="" height="24"> <span class="logo-txt"></span>
                    </span>
                </a>

                <a href="<?php echo base_url();?>agenda" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="<?php echo base_url();?>public/images/chazki.png" alt="" height="24">
                    </span>
                    <span class="logo-lg">
                        <img src="<?php echo base_url();?>public/images/chazki.png" alt="" height="24"> <span class="logo-txt"></span>
                    </span>
                </a>
            </div>
        </div>

        <div class="d-flex">
            <div class="dropdown d-none d-sm-inline-block">
                <button type="button" class="btn header-item" id="mode-setting-btn">
                    <i data-feather="moon" class="icon-lg layout-mode-dark"></i>
                    <i data-feather="sun" class="icon-lg layout-mode-light"></i>
                </button>
            </div>

            <!--<div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="grid" class="icon-lg"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <div class="p-2">
                        <div class="row g-0">
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="<?php //echo base_url();?>public/images/brands/github.png" alt="Github">
                                    <span>GitHub</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="<?php //echo base_url();?>public/images/brands/bitbucket.png" alt="bitbucket">
                                    <span>Bitbucket</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="<?php //echo base_url();?>public/images/brands/dribbble.png" alt="dribbble">
                                    <span>Dribbble</span>
                                </a>
                            </div>
                        </div>

                        <div class="row g-0">
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="<?php //echo base_url();?>public/images/brands/dropbox.png" alt="dropbox">
                                    <span>Dropbox</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="<?php //echo base_url();?>public/images/brands/mail_chimp.png" alt="mail_chimp">
                                    <span>Mail Chimp</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="<?php //echo base_url();?>public/images/brands/slack.png" alt="slack">
                                    <span>Slack</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            -->

            <!--<div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon position-relative" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="bell" class="icon-lg"></i>
                    <span class="badge bg-danger rounded-pill">5</span>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0"> <?php echo $language["Notifications"]; ?> </h6>
                            </div>
                            <div class="col-auto">
                                <a href="#!" class="small text-reset text-decoration-underline"> <?php echo $language["Unread"]; ?> (3)</a>
                            </div>
                        </div>
                    </div>
                    <div data-simplebar style="max-height: 230px;">
                        <a href="#!" class="text-reset notification-item">
                            <div class="d-flex">
                                <img src="<?php echo base_url();?>public/images/users/avatar-3.jpg" class="me-3 rounded-circle avatar-sm" alt="user-pic">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1"><?php echo $language["James_Lemire"]; ?></h6>
                                    <div class="font-size-13 text-muted">
                                        <p class="mb-1"><?php echo $language["It_will_seem_like_simplified_English"]; ?>.</p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span><?php echo $language["1_hours_ago"]; ?></span></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="#!" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="avatar-sm me-3">
                                    <span class="avatar-title bg-primary rounded-circle font-size-16">
                                        <i class="bx bx-cart"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1"><?php echo $language["Your_order_is_placed"]; ?></h6>
                                    <div class="font-size-13 text-muted">
                                        <p class="mb-1"><?php echo $language["If_several_languages_coalesce_the_grammar"]; ?></p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span><?php echo $language["3_min_ago"]; ?></span></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="#!" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="avatar-sm me-3">
                                    <span class="avatar-title bg-success rounded-circle font-size-16">
                                        <i class="bx bx-badge-check"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1"><?php echo $language["Your_item_is_shipped"]; ?></h6>
                                    <div class="font-size-13 text-muted">
                                        <p class="mb-1"><?php echo $language["If_several_languages_coalesce_the_grammar"]; ?></p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span><?php echo $language["3_min_ago"]; ?></span></p>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="#!" class="text-reset notification-item">
                            <div class="d-flex">
                                <img src="<?php echo base_url();?>public/images/users/avatar-6.jpg" class="me-3 rounded-circle avatar-sm" alt="user-pic">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1"><?php echo $language["Salena_Layfield"]; ?></h6>
                                    <div class="font-size-13 text-muted">
                                        <p class="mb-1"><?php echo $language["As_a_skeptical_Cambridge_friend_of_mine_occidental"]; ?>.</p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span><?php echo $language["1_hours_ago"]; ?></span></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="p-2 border-top d-grid">
                        <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                            <i class="mdi mdi-arrow-right-circle me-1"></i> <span><?php echo $language["View_More"]; ?></span>
                        </a>
                    </div>
                </div>
            </div>
            -->

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
                    <a class="dropdown-item" href="<?php echo  base_url();?>perfil"><i class="mdi mdi-face-profile font-size-16 align-middle me-1"></i> <?php echo $language["Profile"]; ?></a>
                    <!--<a class="dropdown-item" href="auth-lock-screen.php"><i class="mdi mdi-lock font-size-16 align-middle me-1"></i> <?php //echo $language["Lock_screen"]; ?></a>-->
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?php echo  base_url();?>logout"><i class="mdi mdi-logout font-size-16 align-middle me-1"></i> <?php echo $language["Logout"]; ?></a>
                </div>
            </div>

        </div>
    </div>
</header>

<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">

                    <!--<li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="<?php echo base_url();?>dashboard" id="topnav-dashboard" role="button">
                            <i data-feather="home"></i><span data-key="t-dashboards">Dashboard</span>
                        </a>
                    </li>-->

                    <!--<li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="<?php echo base_url();?>agenda" id="topnav-dashboard" role="button">
                            <i class="bx bx-calendar-event"></i><span data-key="t-dashboards">Agenda</span>
                        </a>
                    </li>-->                 

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
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-uielement" role="button">
                                        <i class="'.$icono.'"></i>
                                        <span data-key="t-components">'.$des_menu.'</span>
                                        <div class="arrow-down"></div>
                                    </a>
                                    <div class="dropdown-menu mega-dropdown-menu px-2 dropdown-mega-menu-xl" aria-labelledby="topnav-uielement">
                                        <div class="ps-2 p-lg-0">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <div>
                                                        <div class="menu-title">Consultas</div>
                            '; 
                                                        foreach ($config_menu as $key_y) {
                                                            if($id==$key_y->id){
                                                                echo '<a href="'.base_url().''.$key_y->ruta_sub_menu.'" class="dropdown-item" data-key="'.$key_y->ruta_sub_menu.'"> '.$key_y->des_sub_menu.' </a>';    
                                                            }                             
                                                        }
                            echo '
                                                    </div>
                                                </div>                                      
                                            </div>
                                        </div>
                                    </div>
                                </li>   
                            ';
                        }
                    ?>
                </ul>
            </div>
        </nav>
    </div>
</div>