(function () {
  'use strict';
  angular.module('helium').directive('nombersOnly', function () {
    return {
        require: 'ngModel',
        link: function (scope, element, attr, ngModelCtrl) {
            function fromUser(text) {
                if (text) {
                    var transformedInput = text.replace(/[^0-9]/g, '');

                    if (transformedInput !== text) {
                        ngModelCtrl.$setViewValue(transformedInput);
                        ngModelCtrl.$render();
                    }
                    return transformedInput;
                }
                return undefined;
            }
            ngModelCtrl.$parsers.push(fromUser);
        }
    };
  });
  angular.module('helium').directive('tooltip', function(){
    return {
            restrict: 'A',
            link: function(scope, element, attrs){
                $(element).hover(function(){
                    // on mouseenter
                    $(element).tooltip('show');
                }, function(){
                    // on mouseleave
                    $(element).tooltip('hide');
                });
            }
        };
    });
  angular.module('helium').directive('active', function(){
    return {
            restrict: 'A',
            link: function(scope, element, attrs){
                $(element).hover(function(){
                     var a = $(".colortheme").css("color");
                     $(element).css({'color':a});
                }, function(){
                    // on mouseleave
                    $(element).css({"color":"#747474"});
                });
                $(element).click(function(){
                    $(".menulist ul li a").removeClass('itemhover');
                    $(element).addClass('itemhover');
                });
            }
        };
    });
  angular.module('helium').directive('inicio', inicio);
    inicio.$inject = ['$rootScope','$compile'];
    function  inicio($rootScope,$compile){
      return {
        restrict: 'EA',
        templateUrl: 'app/views/inicio/inicio.html',
        replace: true,
        link: function(scope, element) {
          $compile(element.contents())($rootScope);
        },
        controller:'inicioController'
      };
    }
})();
