'use strict';
angular.module('helium')
.controller('inicioController', ['$scope', '$http', 'listasHttp',
function ($scope, $http,listasHttp) {
  // $(function () {
  //     $('#aniimated-thumbnials').lightGallery({
  //         thumbnail: true,
  //         selector: 'a'
  //     });
  // });
  //$(".menulist ul li a").removeClass('itemhover');

$(function () {
  listasHttp.obtenerSesion().then(function(response){
    $scope.nombre = response.data.NOMBRE_USUARIO;
  });
});


}])
