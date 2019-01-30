(function () {
  'use strict';
  angular.module('helium').directive('recepcion', recepcion);
  recepcion.$inject = ['$rootScope','$compile'];
  function  recepcion($rootScope,$compile){
    return {
      restrict: 'EA',
      templateUrl: 'app/views/proceso/recepcion.html',
      replace: true,
      link: function(scope, element) {
        $compile(element.contents())($rootScope);
      },
      controller:'recepcionController'
    };
  }
  angular.module('helium').directive('cargue', cargue);
  cargue.$inject = ['$rootScope','$compile'];
  function  cargue($rootScope,$compile){
    return {
      restrict: 'EA',
      templateUrl: 'app/views/proceso/cargue.html',
      replace: true,
      link: function(scope, element) {
        $compile(element.contents())($rootScope);
      },
      controller:'cargueController'
    };
  }
  angular.module('helium').directive('entrega', entrega);
  entrega.$inject = ['$rootScope','$compile'];
  function  entrega($rootScope,$compile){
    return {
      restrict: 'EA',
      templateUrl: 'app/views/proceso/entrega.html',
      replace: true,
      link: function(scope, element) {
        $compile(element.contents())($rootScope);
      },
      controller:'entregaController'
    };
  }
  angular.module('helium').directive('retencion', retencion);
  retencion.$inject = ['$rootScope','$compile'];
  function  retencion($rootScope,$compile){
    return {
      restrict: 'EA',
      templateUrl: 'app/views/proceso/retencion.html',
      replace: true,
      link: function(scope, element) {
        $compile(element.contents())($rootScope);
      },
      controller:'retencionController'
    };
  }
})();
