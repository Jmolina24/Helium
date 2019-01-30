'use strict';
angular.module('helium',[])
.config(function($locationProvider) {
  $locationProvider.html5Mode({
    enabled: true,
    requireBase: false
  });
})
.controller('loginController', ['$scope', '$http',
function ($scope, $http) {
  $('[data-toggle="tooltip"]').tooltip();
  $(".preloader").fadeOut();
  // ==============================================================
  // Login and Recover Password
  // ==============================================================
  $('#to-recover').on("click", function() {
      $("#loginform").slideUp();
      $("#recoverform").fadeIn();
  });
  $('#to-login').click(function(){
      $("#recoverform").hide();
      $("#loginform").fadeIn();
  });
  $scope.login = {
     usuario:'',
     clave:'',
     email:''
  };
  $scope.validarUser =  function(){
    $http({
          method:'POST',
          url:"app/model/php/login/funclogin.php",
          data: {function:'autenticar', user:$scope.login.usuario, pass:$scope.login.clave}
       }).then(function(response){
          $scope.respuestaLogin = response.data["0"];
          if($scope.respuestaLogin.codigo == '0'){
            $scope.ingresar();
          }else{
            $scope.inactiveconfiguracion = true;
            swal ('Helium informa',$scope.respuestaLogin.EmpresaId,'warning');
          }
       })
  }
  $scope.ingresar =  function(){
    $http({
          method:'POST',
          url:"app/model/php/login/funclogin.php",
          data: {function:'obtieneSesion', empresa:$scope.respuestaLogin.EmpresaId,user:$scope.respuestaLogin.UsersId,documento:'T',estado:'T'}
       }).then(function(response){
          $scope.infoSesion = response.data;
          var data = JSON.stringify($scope.infoSesion["0"]);
          //listasHttp.estadoUsuarioSesion(false).then(function(response){});
          //listasHttp.marcarSesion(0).then(function(response){});
          $http({
                method:'POST',
                url:"app/model/php/login/funclogin.php",
                data: {function:'creaSesion', data:data}//,sede:$scope.login.sede,oficina:$scope.login.oficina,modulo:$scope.login.modulo}
             }).then(function(response){
                if(response.data == '1'){
                    location.href="app.php#!/Inicio";
                    $scope.$apply();
                }
             })
       })
  }
}])
