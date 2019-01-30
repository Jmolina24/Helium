<?php
  session_start();
  if (isset($_SESSION['NOMBRE_USUARIO'])) {
      header("Location: app.php");
  }
?>
<html dir="ltr" ng-app="helium">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="app\assets\images\logos\icono2.png">
    <title>Helium</title>
   
    <!-- Custom CSS -->
    <link href="app/dist/css/style.min.css" rel="stylesheet">
    <!-- sweet alert -->
    <link rel="stylesheet" href="app/plugins/sweetalert/sweetalert.css">
    
</head>

<body ng-controller="loginController">
    <div class="main-wrapper">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>

        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center bg-dark">
            <div class="auth-box bg-dark border-top border-secondary">
                <div id="loginform">
                    <div class="text-center p-t-20 p-b-20">
                        <span class="db"><img src="app/assets/images/logos/oie_transparent.png" alt="logo" style="height: 50px;"></span>
                        
                    </div>
                    <!-- Form -->
                    <form class="form-horizontal m-t-20" ng-submit="validarUser()" id="loginform">
                        <div class="row p-b-30">
                            <div class="col-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-success text-white" id="basic-addon1"><i class="ti-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control form-control-lg" ng-model="login.usuario" placeholder="Usuario" aria-label="Username" aria-describedby="basic-addon1" required="">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-warning text-white" id="basic-addon2"><i class="ti-lock"></i></span>
                                    </div>
                                    <input type="password" class="form-control form-control-lg" ng-model="login.clave" placeholder="Contraseña" aria-label="Password" aria-describedby="basic-addon1" required="">
                                </div>
                            </div>
                        </div>
                        <div class="row border-top border-secondary">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="p-t-20" style="    text-align: center;">
                                        <!-- <button class="btn btn-info" id="to-recover" type="button"><i class="fa fa-lock m-r-5"></i> Olvidaste tu contraseña?</button> -->
                                        <!-- <button  class="btn btn-success float-right" type="submit">Ingresar</button> -->
                                        <button  class="btn btn-success float-center" type="submit">Ingresar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="recoverform">
                    <div class="text-center">
                        <span class="text-white">Ingresa tu e-mail abajo y te enviaremos un correo para recuperar tu contraseña.</span>
                    </div>
                    <div class="row m-t-20">
                        <!-- Form -->
                        <form class="col-12" action="index.html">
                            <!-- email -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-danger text-white" id="basic-addon1"><i class="ti-email"></i></span>
                                </div>
                                <input type="text" class="form-control form-control-lg" placeholder="Email" aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                            <!-- pwd -->
                            <div class="row m-t-20 p-t-20 border-top border-secondary">
                                <div class="col-12">
                                    <a class="btn btn-success" href="#" id="to-login" name="action">Regresar al login</a>
                                    <button class="btn btn-info float-right" type="button" name="action">Recuperar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="app/assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.4/angular.min.js" charset="utf-8"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="app/assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="app/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="app/scripts/controllers/login/loginController.js"></script>
    <script src="app/plugins/sweetalert/sweetalert.min.js"></script>
</body>

</html>
