<!DOCTYPE html>
<html dir="ltr" ng-app="helium">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>Radicado</title>
    <link href="../../dist/css/style.min.css" rel="stylesheet">

</head>

<body ng-controller="barcodeController">
    <div class="main-wrapper" style="display: flex;">
        <div class="col s6">
         <div class="text-right">
            <h5 style="margin-bottom: 0px;">Al contestar cite:</h5>
            <h5 style="margin-bottom: 0px;">Radicado No {{radicado}}</h5>
            <h5 style="margin-bottom: 23px;">Fecha de radicación {{fecha}}</h5>
          </div>
          <div class="text-right" id="barcode"></div>
        </div>
        <div class="col s6">
           <div class="text-right">
            <h5 style="margin-bottom: 0px;">Al contestar cite:</h5>
            <h5 style="margin-bottom: 0px;">Radicado No {{radicado}}</h5>
            <h5 style="margin-bottom: 23px;">Fecha de radicación {{fecha}}</h5>
          </div> 
          <div class="text-right" id="barcode2"></div>
        </div>
     
      
    </div>
    <script src="../../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.4/angular.min.js" charset="utf-8"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../../assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="../../assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../../scripts/controllers/formatos/barcodeController.js"></script>
    <script src="../../plugins/sweetalert/sweetalert.min.js"></script>
    <script src="../../plugins/barcode/jquery-barcode.min.js"></script>
    <script type="text/javascript" src="../../plugins/barcode/jquery-barcode.js"></script>
</body>
</html>
