(function () {
  'use strict';
  angular.module('helium').directive('categoria', categoria);
  categoria.$inject = ['$rootScope','$compile'];
  function  categoria($rootScope,$compile){
    return {
      restrict: 'EA',
      templateUrl: 'app/views/documento/categoria.html',
      replace: true,
      link: function(scope, element) {
        $compile(element.contents())($rootScope);
      },
      controller:'categoriaController'
    };
  }
  angular.module('helium').directive('estadodocumento', estadodocumento);
  estadodocumento.$inject = ['$rootScope','$compile'];
  function  estadodocumento($rootScope,$compile){
    return {
      restrict: 'EA',
      templateUrl: 'app/views/documento/estadodocumento.html',
      replace: true,
      link: function(scope, element) {
        $compile(element.contents())($rootScope);
      },
      controller:'estadodocumentoController'
    };
  }
  angular.module('helium').directive('origen', origen);
  origen.$inject = ['$rootScope','$compile'];
  function  origen($rootScope,$compile){
    return {
      restrict: 'EA',
      templateUrl: 'app/views/documento/origen.html',
      replace: true,
      link: function(scope, element) {
        $compile(element.contents())($rootScope);
      },
      controller:'origenController'
    };
  }
  angular.module('helium').directive('tipodocumento', tipodocumento);
  tipodocumento.$inject = ['$rootScope','$compile'];
  function  tipodocumento($rootScope,$compile){
    return {
      restrict: 'EA',
      templateUrl: 'app/views/documento/tipodocumento.html',
      replace: true,
      link: function(scope, element) {
        $compile(element.contents())($rootScope);
      },
      controller:'tipodocumentoController'
    };
  }
  angular.module('helium').directive('origendocumentos', origendocumentos);
  origendocumentos.$inject = ['$rootScope','$compile'];
  function  origendocumentos($rootScope,$compile){
    return {
      restrict: 'EA',
      templateUrl: 'app/views/documento/origendocumentos.html',
      replace: true,
      link: function(scope, element) {
        $compile(element.contents())($rootScope);
      },
      controller:'origendocumentosController'
    };
  }
  angular.module('helium').directive('motivo', motivo);
  motivo.$inject = ['$rootScope','$compile'];
  function  motivo($rootScope,$compile){
    return {
      restrict: 'EA',
      templateUrl: 'app/views/documento/motivo.html',
      replace: true,
      link: function(scope, element) {
        $compile(element.contents())($rootScope);
      },
      controller:'motivoController'
    };
  }
  angular.module('helium').directive('submotivo', submotivo);
  submotivo.$inject = ['$rootScope','$compile'];
  function  submotivo($rootScope,$compile){
    return {
      restrict: 'EA',
      templateUrl: 'app/views/documento/submotivo.html',
      replace: true,
      link: function(scope, element) {
        $compile(element.contents())($rootScope);
      },
      controller:'submotivoController'
    };
  }
})();
