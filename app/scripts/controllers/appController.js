'use strict';
angular.module('helium')
.controller('appController', ['$scope', '$http', '$rootScope','listasHttp', function ($scope, $http, $rootScope, listasHttp) {
  $(function() {
      $scope.obtenerSesion();
      setTimeout(function () {
        "use strict";
        var url = window.location + "";
        var path = url.replace(window.location.protocol + "//" + window.location.host + "/", "");
        var element = $('ul#sidebarnav a').filter(function() {
            return this.href === url || this.href === path;
        });
        element.parentsUntil(".sidebar-nav").each(function (index){
            if($(this).is("li") && $(this).children("a").length !== 0)
            {
                $(this).children("a").addClass("active");
            }
            else if($(this).is("ul")){
                $(this).addClass('in');
            }
        });
        element.addClass("active");
        if(path == "helium/app.php#/Inicio" || path == "helium/app.php#/"){
            $('#home').addClass("selecteditem");
          }else{
            $('.sidebar-link.has-arrow.waves-effect.waves-dark.linktop.active').addClass("selecteditem");
          }
        $('#sidebarnav a').on('click', function (e) {
                if($(this).hasClass("has-arrow") || $(this)[0].id == "home"){
                  $('#sidebarnav a').removeClass("selecteditem");
                  $(this).addClass("selecteditem");
                }
                if (!$(this).hasClass("active")) {
                    // hide any open menus and remove all other classes
                    $("ul", $(this).parents("ul:first")).removeClass("in");
                    $("a", $(this).parents("ul:first")).removeClass("active");

                    // open our new menu and add the open class
                    $(this).next("ul").addClass("in");
                    $(this).addClass("active");

                }
                else if ($(this).hasClass("active")) {
                    $(this).removeClass("active");
                    $(this).parents("ul:first").removeClass("active");
                    $(this).next("ul").removeClass("in");
                }
        })
        $('#sidebarnav >li >a.has-arrow').on('click', function (e) {
            e.preventDefault();
        });
      }, 1000);
  });
  $scope.obtenerSesion =  function(){
    listasHttp.obtenerSesion().then(function(response){
          $scope.empresa = response.data.IDEMPRESA;
          $scope.Rol = response.data.CODROL;
          $scope.obtenermenu();
    });
  }
  $scope.obtenermenu =  function(){
    listasHttp.listarRoles($scope.Rol,'T').then(function(response){
        $scope.menus = JSON.parse(response.data["0"].menu);
    });
  }
  $rootScope.$on('actualizarMenu', function(event, args) {
      if(args == $scope.Rol){
        $scope.obtenermenu();
      }
  });
  $scope.cerrarSesion = function(){
    $http({
        method: 'GET',
        url: "app/model/php/login/cerrarsesion.php",
        params: {}
      }).then(function(response) {
        location.href="app/model/php/login/cerrarsesion.php";
        $scope.$apply();
      })
  }
}])
