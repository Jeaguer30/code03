    </div>

        <div class="right-bar">
            <div data-simplebar class="h-100">
                <div class="rightbar-title d-flex align-items-center bg-dark p-3">

                    <h5 class="m-0 me-2 text-white">Personalizar Sistema</h5>

                    <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
                        <i class="mdi mdi-close noti-icon"></i>
                    </a>
                </div>

                <!-- Settings -->
                <hr class="m-0" />

                <div class="p-4">
                    <h6 class="mb-3">Layout</h6>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout" id="layout-vertical" value="vertical">
                        <label class="form-check-label" for="layout-vertical">Vertical</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout" id="layout-horizontal" value="horizontal">
                        <label class="form-check-label" for="layout-horizontal">Horizontal</label>
                    </div>

                    <h6 class="mt-4 mb-3 pt-2">Modo de diseño</h6>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-mode" id="layout-mode-light" value="light">
                        <label class="form-check-label" for="layout-mode-light">Ligero</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-mode" id="layout-mode-dark" value="dark">
                        <label class="form-check-label" for="layout-mode-dark">Oscuro</label>
                    </div>

                    <h6 class="mt-4 mb-3 pt-2">Ancho de diseño</h6>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-width" id="layout-width-fuild" value="fluid">
                        <label class="form-check-label" for="layout-width-fuild">Fluid</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-width" id="layout-width-boxed" value="boxed">
                        <label class="form-check-label" for="layout-width-boxed">En Caja</label>
                    </div>

                    <h6 class="mt-4 mb-3 pt-2">Posición de diseño</h6>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-position" id="layout-position-fixed" value="fixed" >
                        <label class="form-check-label" for="layout-position-fixed">Fijo</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-position" id="layout-position-scrollable" value="scrollable">
                        <label class="form-check-label" for="layout-position-scrollable">Desplazable</label>
                    </div>

                    <h6 class="mt-4 mb-3 pt-2">Color de la barra superior</h6>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="topbar-color" id="topbar-color-light" value="light" >
                        <label class="form-check-label" for="topbar-color-light">Ligero</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="topbar-color" id="topbar-color-dark" value="dark">
                        <label class="form-check-label" for="topbar-color-dark">Oscuro</label>
                    </div>

                    <h6 class="mt-4 mb-3 pt-2 sidebar-setting">Tamaño de la barra lateral</h6>

                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-size" id="sidebar-size-default" value="default" >
                        <label class="form-check-label" for="sidebar-size-default">Defecto</label>
                    </div>
                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-size" id="sidebar-size-compact" value="compact" >
                        <label class="form-check-label" for="sidebar-size-compact">Compacto</label>
                    </div>
                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-size" id="sidebar-size-small" value="small" >
                        <label class="form-check-label" for="sidebar-size-small">Pequeña (Vista de icono)</label>
                    </div>

                    <h6 class="mt-4 mb-3 pt-2 sidebar-setting">Color de la barra lateral</h6>

                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-color" id="sidebar-color-light" value="light" >
                        <label class="form-check-label" for="sidebar-color-light">Ligero</label>
                    </div>
                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-color" id="sidebar-color-dark" value="dark" >
                        <label class="form-check-label" for="sidebar-color-dark">Oscuro</label>
                    </div>
                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-color" id="sidebar-color-brand" value="brand" >
                        <label class="form-check-label" for="sidebar-color-brand">Brand</label>
                    </div>

                    <h6 class="mt-4 mb-3 pt-2">Dirección</h6>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-direction" id="layout-direction-ltr" value="ltr">
                        <label class="form-check-label" for="layout-direction-ltr">LTR</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="layout-direction" id="layout-direction-rtl" value="rtl">
                        <label class="form-check-label" for="layout-direction-rtl">RTL</label>
                    </div>

                </div>

            </div> <!-- end slimscroll-menu-->
        </div>


        <style>
            .custom-backdrop {
                background-color: rgba(13, 163, 175, 0.5) !important; 
            }
        </style>

        <div class="modal fade" id="modal_session" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered " role="document">
                <div class="modal-content" style="border-radius: 15px;">
                    <div class="modal-body" style="margin:auto">
                        <div class="row" style="margin:auto">
                            <div class="col-lg-6" style="margin:auto">
                                <img src="<?php echo base_url();?>public/img/sesion.png" alt="Imagen de Sesión" style="max-width: 100%; margin: auto;">
                            </div>
                            <div class="col-lg-6">
                                <h3 style="color: #0DA3AF;">Ups!</h3>
                                <h5 style="color: #0DA3AF;">Tu sesión ha expirado.</h5>
                                <p>Tu sesión ha expirado, no te preocupes, inicia sesión nuevamente.</p>
                                <button onclick="redirigir_login();" type="button" class="btn btn-outline" style="background: #0DA3AF; color: white;">Iniciar Sesión</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      

        <script>
           
            function redirigir_login() {
                window.location.href = 'https://geochasqui.com/sistema_geo/'; // Esto redirigirá a la página de inicio de sesión utilizando base_url()
            }
        </script>


        </script>

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>        
                
        
        <!-- JAVASCRIPT -->
        <script src="<?php echo base_url();?>public/libs/jquery/jquery.min.js"></script>
        <script src="<?php echo base_url();?>public/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo base_url();?>public/libs/metismenu/metisMenu.min.js"></script>
        <script src="<?php echo base_url();?>public/libs/simplebar/simplebar.min.js"></script>
        <script src="<?php echo base_url();?>public/libs/node-waves/waves.min.js"></script>
        <script src="<?php echo base_url();?>public/libs/feather-icons/feather.min.js"></script>
        <!-- pace js -->
        <script src="<?php echo base_url();?>public/libs/pace-js/pace.min.js"></script>

        <!-- apexcharts -->
        <script src="<?php echo base_url();?>public/libs/apexcharts/apexcharts.min.js"></script>

        <!-- Plugins js-->
        <script src="<?php echo base_url();?>public/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="<?php echo base_url();?>public/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js"></script>
        <!-- dashboard init -->
        <script src="<?php echo base_url();?>public/js/pages/dashboard.init.js"></script>

        <!-- Required datatable js -->
        <script src="<?php echo base_url();?>public/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url();?>public/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        <!-- Buttons examples -->
        <script src="<?php echo base_url();?>public/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="<?php echo base_url();?>public/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
        <script src="<?php echo base_url();?>public/libs/jszip/jszip.min.js"></script>
        <script src="<?php echo base_url();?>public/libs/pdfmake/build/pdfmake.min.js"></script>
        <script src="<?php echo base_url();?>public/libs/pdfmake/build/vfs_fonts.js"></script>
        <script src="<?php echo base_url();?>public/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="<?php echo base_url();?>public/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="<?php echo base_url();?>public/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>

        <!-- Responsive examples -->
        <script src="<?php echo base_url();?>public/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="<?php echo base_url();?>public/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

        <!-- Datatable init js -->
        <script src="<?php echo base_url();?>public/js/pages/datatables.init.js"></script>

        
        <script src="<?php echo base_url();?>public/libs/alertifyjs/build/alertify.min.js"></script>
        <!-- <script src="<?php echo base_url();?>public/js/pages/notification.init.js"></script> -->

        <!-- Responsive Table js -->
        <script src="<?php echo base_url();?>public/libs/admin-resources/rwd-table/rwd-table.min.js"></script>

        <!-- Init js -->
        <script src="<?php echo base_url();?>public/js/pages/table-responsive.init.js"></script>

        <!-- <script src="<?php echo base_url();?>public/libs/@fullcalendar/core/main.min.js"></script>
        <script src="<?php echo base_url();?>public/libs/@fullcalendar/bootstrap/main.min.js"></script>
        <script src="<?php echo base_url();?>public/libs/@fullcalendar/daygrid/main.min.js"></script>
        <script src="<?php echo base_url();?>public/libs/@fullcalendar/timegrid/main.min.js"></script>
        <script src="<?php echo base_url();?>public/libs/@fullcalendar/interaction/main.min.js"></script> -->

        <!-- Calendar init -->
        <!-- <script src="<?php echo base_url();?>public/js/pages/calendar.init.js"></script> -->

        <!-- Sweet Alerts js -->
        <script src="<?php echo base_url();?>public/libs/sweetalert2/sweetalert2.min.js"></script>

        <!-- Sweet alert init js-->
        <!-- <script src="<?php echo base_url();?>public/js/pages/sweetalert.init.js"></script> -->
        
        <!-- choices js -->
        <!-- <script src="<?php echo base_url();?>public/libs/choices.js/public/assets/scripts/choices.min.js"></script> -->

        <!-- color picker js -->
        <!-- <script src="<?php echo base_url();?>public/libs/@simonwep/pickr/pickr.min.js"></script>
        <script src="<?php echo base_url();?>public/libs/@simonwep/pickr/pickr.es5.min.js"></script> -->

        <!-- datepicker js -->
        <script src="<?php echo base_url();?>public/libs/flatpickr/flatpickr.min.js"></script>  

        <!-- init js -->
        <!-- <script src="<?php echo base_url();?>public/js/pages/form-advanced.init.js"></script> -->

        <script src="<?php echo base_url();?>public/js/app.js"></script>


        <!-- dropzone js -->
        <script src="<?php echo base_url();?>public/libs/dropzone/min/dropzone.min.js"></script>

        <script>

            /*
                Para notificacion
            */
            function notificacion(titulo,texto,icono){
                Swal.fire(
                    {
                        title: titulo,
                        text: texto,
                        icon: icono,
                        confirmButtonColor: '#5156be'
                    }
                )
           }
           /*
            Para alerta de inputs
           */

            /*setInterval(() => {
                $('#alert-danger').fadeOut();
            }, 3000); */               

          function alerta(tipo,id_input,id_lbl,msj){
            switch (tipo) {
                case 'success':
                    $('#'+id_input).css('border','1px solid read');
                    $('#'+id_lbl).css('color','red');
                    $('#'+id_lbl).text(msj);
                    break;
                case 'error':
                    $('#'+id_input).css('border','1px solid read');
                    $('#'+id_lbl).css('color','red');
                    $('#'+id_lbl).text(msj);                    
                    break;            
                default:
                    $('#'+id_input).css('border','1px solid #ced4da');
                    $('#'+id_lbl).css('color','white');
                    $('#'+id_lbl).text('');                                        
                    break;
            }
          }

        </script>
    </body>
</html>