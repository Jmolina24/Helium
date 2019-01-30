(function () {
  'use strict';
    angular.module('helium').directive('rol', rol);
    rol.$inject = ['$rootScope','$compile'];
      function  rol($rootScope,$compile){
        return {
          restrict: 'EA',
          templateUrl: 'app/views/acceso/rol.html',
          replace: true,
          link: function(scope, element) {
            $compile(element.contents())($rootScope);
          },
          controller:'rolController'
        };
      }
    angular.module('helium').directive('usuario', usuario);
    usuario.$inject = ['$rootScope','$compile'];
      function  usuario($rootScope,$compile){
        return {
          restrict: 'EA',
          templateUrl: 'app/views/acceso/usuario.html',
          replace: true,
          link: function(scope, element) {
            $compile(element.contents())($rootScope);
          },
          controller:'usuarioController'
        };
      }
})();
