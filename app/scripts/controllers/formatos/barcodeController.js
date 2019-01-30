'use strict';
angular.module('helium',[])
.config(function($locationProvider) {
  $locationProvider.html5Mode({
    enabled: true,
    requireBase: false
  });
})
.controller('barcodeController', ['$scope', '$http','$location',
function ($scope, $http, $location) {

  $(function() {
    setTimeout(function () {
      $("#barcode").barcode(
        $scope.radicado, // Valor del codigo de barras
        "ean8", // tipo (cadena)
        {barWidth:4, barHeight:40}
     );
     $("#barcode2").barcode(
       $scope.radicado, // Valor del codigo de barras
       "ean8", // tipo (cadena)
       {barWidth:4, barHeight:40}
    );
    }, 100);
  });
  $scope.radicado = $location.search().radicado;
  $scope.fecha = $location.search().fecha;
}])
