<?php
  session_start();
  if (!isset($_SESSION['NOMBRE_USUARIO'])) {
      header("Location: index.php");
  }
?>
<!DOCTYPE html>
<html dir="ltr" lang="en" ng-app="helium">
  <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- Tell the browser to be responsive to screen width -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- Favicon icon -->
      <link rel="icon" type="image/png" sizes="16x16" href="app/assets/images/logos/logohelium2.png">
      <title>Helium</title>
      <link rel="stylesheet" type="text/css" href="app/assets/libs/select2/dist/css/select2.min.css">

      <!-- datapicker -->
      <link rel="stylesheet" type="text/css" href="app/assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
      <!-- sweet alert -->
      <link rel="stylesheet" href="app/plugins/sweetalert/sweetalert.css">
      <!-- Table css -->
      <link href="app/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
      <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"> -->
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
      <!-- Custom CSS -->
      <link href="app/assets/libs/flot/css/float-chart.css" rel="stylesheet">
      <!-- Custom CSS -->
      <link href="app/dist/css/style.min.css" rel="stylesheet">
      <!-- color -->
      <link rel="stylesheet" href="app/dist/css/color.css">
      <!-- helpers -->
      <link rel="stylesheet" href="app/styles/helpers.css">
      <link rel="stylesheet" href="app/styles/modalfullscream.css">
      <link rel="stylesheet" href="app/styles/tabs.css">

      <style media="screen">
        .selecteditem{
          background:#27a9e3;
          opacity:1 !important;
        }
        </style>
  </head>
  <body>
      <div class="preloader">
          <div class="lds-ripple">
              <div class="lds-pos"></div>
              <div class="lds-pos"></div>
          </div>
      </div>
      <div id="main-wrapper">
        <div ng-controller="appController">
          <header class="topbar bg-red" data-navbarbg="skin5" >
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin5">
                
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <a class="navbar-brand" href="index.html" style="margin-top: 1px;">
                        <!-- Logo icon -->
                        <b class="logo-icon p-l-10">
                            <img src="app/assets/images/logos/logo.png" alt="logo" class="light-logo" style="height: 36px;"/>
                        </b>
                        <span class="logo-text">
                             <img src="app/assets/images/logos/helium2.png" alt="Helium" class="light-logo" />
                        </span>
                    </a>
                    <div class="divider"></div>
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5" style="margin-top: -1px">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-left mr-auto">
                        <li class="nav-item d-none d-md-block"><a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>
                        <!-- Search -->
                        <li class="nav-item search-box"> <a class="nav-link waves-effect waves-dark" href="javascript:void(0)"><i class="ti-search"></i></a>
                            <form class="app-search position-absolute">
                                <input type="text" class="form-control" placeholder="Search &amp; enter"> <a class="srh-btn"><i class="ti-close"></i></a>
                            </form>
                        </li>
                    </ul>
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-right">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-bell font-24"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown" aria-labelledby="2">
                                <ul class="list-style-none">
                                    <li>
                                        <div class="">
                                             <!-- Message -->
                                            <a href="javascript:void(0)" class="link border-top">
                                                <div class="d-flex no-block align-items-center p-10">
                                                    <span class="btn btn-success btn-circle"><i class="ti-calendar"></i></span>
                                                    <div class="m-l-10">
                                                        <h5 class="m-b-0">Documento Recibido</h5>
                                                        <!-- <span class="mail-desc">Just a reminer that event</span> -->
                                                    </div>
                                                </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="javascript:void(0)" class="link border-top">
                                                <div class="d-flex no-block align-items-center p-10">
                                                    <span class="btn btn-info btn-circle"><i class="ti-settings"></i></span>
                                                    <div class="m-l-10">
                                                        <h5 class="m-b-0">Configuración</h5>
                                                        <!-- <span class="mail-desc">You can customize this template</span> -->
                                                    </div>
                                                </div>
                                            </a>
                                            
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="app/assets/images/users/1.jpg" alt="user" class="rounded-circle" width="31"></a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated">
                                <a class="dropdown-item" href="javascript:void(0)">
                                    <i class="ti-user m-r-5 m-l-5"></i><?php echo $_SESSION['NOMBRE_USUARIO'];?>
                                </a>
                                <!-- <a class="dropdown-item" href="javascript:void(0)"><i class="ti-user m-r-5 m-l-5"></i> Perfil</a>
                                <a class="dropdown-item" href="javascript:void(0)"><i class="ti-wallet m-r-5 m-l-5"></i> Log</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:void(0)"><i class="ti-settings m-r-5 m-l-5"></i> Configuracion</a> -->
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:void(0)" ng-click="cerrarSesion()"><i class="fa fa-power-off m-r-5 m-l-5"></i> Cerrar Sesion</a>
                                <div class="dropdown-divider"></div>
                                <div align="center">
                                  <a class="" style="color: #f1964f;" href="javascript:void(0)">&copy; 2018 <b>helium</b> version 1.0.0</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
          <aside class="left-sidebar" data-sidebarbg="skin5">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav" class="p-t-30">
                        <li class="sidebar-item">
                          <a id="home" class="sidebar-link waves-effect waves-dark sidebar-link" ui-sref="helium.inicio" aria-expanded="false">
                            <i class="mdi mdi-home"></i>
                            <span class="hide-menu">Inicio</span>
                          </a>
                        </li>
                        <li class="sidebar-item"  ng-repeat="menu in menus.modulos | orderBy:'titulo'" ng-show="menu.estado">
                          <a class="sidebar-link has-arrow waves-effect waves-dark linktop" href="javascript:void(0)" aria-expanded="false">
                            <i class="{{menu.icono}}"></i>
                            <span class="hide-menu">{{menu.titulo}}</span>
                          </a>
                          <ul aria-expanded="false" class="collapse first-level">
                              <li class="sidebar-item" ng-repeat="opcion in menu.opciones  | orderBy:'titulo'" ng-show="opcion.estado">
                                <a ui-sref="{{opcion.url}}" style="margin-left: 14px;" class="sidebar-link">
                                  <i style="{{opcion.style}}" class="{{opcion.icono}}"></i><span class="hide-menu"> {{opcion.titulo}}</span>
                                </a>
                              </li>
                          </ul>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        </div>
        <div class="page-wrapper">
          <div class="container-fluid">
            <div ui-view>
              <div inicio></div>
            </div>
          </div>
        </div>
      </div>
      <script src="app/assets/libs/jquery/dist/jquery.min.js"></script>
      <script src="app/plugins/angularjs/angular.js" charset="utf-8"></script>
      <script src="app/plugins/angularjs/angular-ui-route.js" charset="utf-8"></script>
      <script src="app/plugins/sweetalert/sweetalert.min.js"></script>

      <script src="app/assets/extra-libs/DataTables/datatables.min.js"></script>
      <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
      <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
      <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
      <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>

      <script src="app/assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
      <!-- Controladores & Directivas-->
      <script src="app/scripts/app.js" charset="utf-8"></script>
      <script src="app/scripts/directives/appDirective.js" charset="utf-8"></script>
      <script src="app/scripts/services/listasHttp.js" charset="utf-8"></script>
      <script src="app/scripts/controllers/appController.js" charset="utf-8"></script>

      <script src="app/scripts/directives/administracion/administracionDirective.js" charset="utf-8"></script>
      <script src="app/scripts/directives/acceso/accesoDirective.js" charset="utf-8"></script>
      <script src="app/scripts/directives/documento/documentoDirective.js" charset="utf-8"></script>
      <script src="app/scripts/directives/proceso/procesoDirective.js" charset="utf-8"></script>
      <script src="app/scripts/directives/dimensiones/dimensionesDirective.js" charset="utf-8"></script>
      <script src="app/scripts/controllers/inicioController.js" charset="utf-8"></script>



      <!-- administracion -->
      <script src="app/scripts/controllers/administracion/empresaController.js" charset="utf-8"></script>
      <script src="app/scripts/controllers/administracion/sedeController.js" charset="utf-8"></script>
      <script src="app/scripts/controllers/administracion/oficinaController.js" charset="utf-8"></script>
      <script src="app/scripts/controllers/administracion/areaController.js" charset="utf-8"></script>
      <script src="app/scripts/controllers/administracion/cargoController.js" charset="utf-8"></script>
      <script src="app/scripts/controllers/administracion/mensajeriaController.js" charset="utf-8"></script>
      <script src="app/scripts/controllers/administracion/unidadmedidaController.js" charset="utf-8"></script>
      <script src="app/scripts/controllers/administracion/tercerosController.js" charset="utf-8"></script>
      <!-- acceso -->
      <script src="app/scripts/controllers/acceso/usuarioController.js" charset="utf-8"></script>
      <script src="app/scripts/controllers/acceso/rolController.js" charset="utf-8"></script>
      <!-- documento -->
      <script src="app/scripts/controllers/documento/categoriaController.js" charset="utf-8"></script>
      <script src="app/scripts/controllers/documento/origenController.js" charset="utf-8"></script>
      <script src="app/scripts/controllers/documento/estadodocumentoController.js" charset="utf-8"></script>
      <script src="app/scripts/controllers/documento/tipodocumentoController.js" charset="utf-8"></script>
      <script src="app/scripts/controllers/documento/origendocumentosController.js" charset="utf-8"></script>
      <script src="app/scripts/controllers/documento/motivoController.js" charset="utf-8"></script>
      <script src="app/scripts/controllers/documento/submotivoController.js" charset="utf-8"></script>

      <!-- proceso -->
      <script src="app/scripts/controllers/proceso/recepcionController.js" charset="utf-8"></script>
      <script src="app/scripts/controllers/proceso/entregaController.js" charset="utf-8"></script>

      <!-- Bootstrap tether Core JavaScript -->
      <script src="app/assets/libs/select2/dist/js/select2.full.min.js"></script>
      <script src="app/assets/libs/popper.js/dist/umd/popper.min.js"></script>
      <script src="app/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
      <script src="app/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
      <script src="app/assets/extra-libs/sparkline/sparkline.js"></script>
      <script src="app/assets/libs/inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
      <script src="app/dist/js/pages/mask/mask.init.js"></script>
      <!--Wave Effects -->
      <script src="app/dist/js/waves.js"></script>
      <!--Menu sidebar -->
      <!-- <script src="app/dist/js/sidebarmenu.js"></script> -->
      <!--Custom JavaScript -->
      <script src="app/dist/js/custom.min.js"></script>
      <!-- <script src="app/assets/libs/flot/excanvas.js"></script>
      <script src="app/assets/libs/flot/jquery.flot.js"></script>
      <script src="app/assets/libs/flot/jquery.flot.pie.js"></script>
      <script src="app/assets/libs/flot/jquery.flot.time.js"></script>
      <script src="app/assets/libs/flot/jquery.flot.stack.js"></script>
      <script src="app/assets/libs/flot/jquery.flot.crosshair.js"></script>
      <script src="app/assets/libs/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
      <script src="app/dist/js/pages/chart/chart-page-init.js"></script> -->
      <!-- sweet Alert -->
<script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
  </body>
</html>
