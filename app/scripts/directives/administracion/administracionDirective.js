(function () {
  'use strict';
  angular.module('helium').directive('empresa', empresa);
  empresa.$inject = ['$rootScope','$compile'];
  function  empresa($rootScope,$compile){
    return {
      restrict: 'EA',
      templateUrl: 'app/views/administracion/empresa.html',
      replace: true,
      link: function(scope, element) {
        $compile(element.contents())($rootScope);
      },
      controller:'empresaController'
    };
  }
  angular.module('helium').directive('sede', sede);
  sede.$inject = ['$rootScope','$compile'];
  function  sede($rootScope,$compile){
    return {
      restrict: 'EA',
      templateUrl: 'app/views/administracion/sede.html',
      replace: true,
      link: function(scope, element) {
        $compile(element.contents())($rootScope);
      },
      controller:'sedeController'
    };
  }
  angular.module('helium').directive('oficina', oficina);
  oficina.$inject = ['$rootScope','$compile'];
  function  oficina($rootScope,$compile){
    return {
      restrict: 'EA',
      templateUrl: 'app/views/administracion/oficina.html',
      replace: true,
      link: function(scope, element) {
        $compile(element.contents())($rootScope);
      },
      controller:'oficinaController'
    };
  }
  angular.module('helium').directive('area', area);
  area.$inject = ['$rootScope','$compile'];
  function  area($rootScope,$compile){
    return {
      restrict: 'EA',
      templateUrl: 'app/views/administracion/area.html',
      replace: true,
      link: function(scope, element) {
        $compile(element.contents())($rootScope);
      },
      controller:'areaController'
    };
  }
  angular.module('helium').directive('cargo', cargo);
  cargo.$inject = ['$rootScope','$compile'];
  function  cargo($rootScope,$compile){
    return {
      restrict: 'EA',
      templateUrl: 'app/views/administracion/cargo.html',
      replace: true,
      link: function(scope, element) {
        $compile(element.contents())($rootScope);
      },
      controller:'cargoController'
    };
  }
  angular.module('helium').directive('mensajeria', mensajeria);
  mensajeria.$inject = ['$rootScope','$compile'];
  function  mensajeria($rootScope,$compile){
    return {
      restrict: 'EA',
      templateUrl: 'app/views/administracion/mensajeria.html',
      replace: true,
      link: function(scope, element) {
        $compile(element.contents())($rootScope);
      },
      controller:'mensajeriaController'
    };
  }
  angular.module('helium').directive('unidadmedida', unidadmedida);
  unidadmedida.$inject = ['$rootScope','$compile'];
  function  unidadmedida($rootScope,$compile){
    return {
      restrict: 'EA',
      templateUrl: 'app/views/administracion/unidadmedida.html',
      replace: true,
      link: function(scope, element) {
        $compile(element.contents())($rootScope);
      },
      controller:'unidadmedidaController'
    };
  }
  angular.module('helium').directive('terceros', terceros);
  terceros.$inject = ['$rootScope','$compile'];
  function  terceros($rootScope,$compile){
    return {
      restrict: 'EA',
      templateUrl: 'app/views/administracion/terceros.html',
      replace: true,
      link: function(scope, element) {
        $compile(element.contents())($rootScope);
      },
      controller:'tercerosController'
    };
  }
})();
