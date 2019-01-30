(function () {
  'use strict';
  angular.module('helium').directive('dashboard', dashboard);
  dashboard.$inject = ['$rootScope','$compile'];
  function  dashboard($rootScope,$compile){
    return {
      restrict: 'EA',
      templateUrl: 'app/views/dimensiones/dashboard.html',
      replace: true,
      link: function(scope, element) {
        $compile(element.contents())($rootScope);
      },
      controller:'dashboardController'
    };
  }
  angular.module('helium').directive('tiempo', tiempo);
  tiempo.$inject = ['$rootScope','$compile'];
  function  tiempo($rootScope,$compile){
    return {
      restrict: 'EA',
      templateUrl: 'app/views/dimensiones/tiempo.html',
      replace: true,
      link: function(scope, element) {
        $compile(element.contents())($rootScope);
      },
      controller:'tiempoController'
    };
  }
  angular.module('helium').directive('bi', bi);
  bi.$inject = ['$rootScope','$compile'];
  function  bi($rootScope,$compile){
    return {
      restrict: 'EA',
      templateUrl: 'app/views/dimensiones/bi.html',
      replace: true,
      link: function(scope, element) {
        $compile(element.contents())($rootScope);
      },
      controller:'biController'
    };
  }
})();
