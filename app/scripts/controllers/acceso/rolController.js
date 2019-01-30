'use strict';
angular.module('helium')
.controller('rolController', ['$scope', '$rootScope', '$http','listasHttp','comunication',
function ($scope, $rootScope, $http, listasHttp, comunication) {
  $(function() {
    listasHttp.obtenerSesion().then(function(response){
          $scope.empresa = response.data.IDEMPRESA;
          $scope.listarRol('crear');
          listasHttp.listarServicios($scope.empresa,'T','1').then(function(response){
            $scope.listarServicios = response.data;
          });
    });
  });

    //VARIABLES
    $scope.rol = {
      codigo:'',
      nombre:'',
      json:''
    }
    //LISTAS
    $scope.listarRol = function(estado){
         swal({title: 'Cargando Roles'});
         swal.showLoading();
         listasHttp.listarRoles(0,'T').then(function(response){
           if(response.data.length > 0){
             if(estado == 'destruir'){
               $scope.tablerol.destroy();
             }
             $scope.listarRoles = response.data;
             setTimeout(function () {
               $scope.tablerol = $('#table-rol').DataTable({
                   dom: 'Bfrtip',
                   responsive: true,
                   buttons: [],
                   language: {"url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"},
                   lengthMenu: [[10, 50,-1], [10, 50,'Todas']],
                   order: [[ 0, "desc" ]]
               });
               swal.close();
             }, 500);
           }else{
             swal('Helium informa','No hay roles configuradas','warning');
           }
         });
      }
    //FUNCIONES
    $scope.openmodal = function(nombre,data){
      $scope.rol = {
        codigo:'',
        nombre:'',
        json:''
      }
          if(nombre == 'crear'){
            // $http({
            //   method: 'POST',
            //   url: "app/model/php/funclistas.php",
            //   data: {function: 'obtenerMenuEmpresa'}
            // }).then(function(response) {
            //    $scope.jsonmenu = JSON.parse(response.data["0"].Menu);
            //    $scope.titulomodal = 'Crear Roles';
            //    $scope.btnnombremodal = 'CREAR';
            //    $scope.inactiveuserfield = false;
            //    $("#modaluirol").modal('show');
            // })
            $http({
                method: 'GET',
                url: "app/json/menu.json",
                params: {}
              }).then(function(response) {
                $scope.jsonmenu = response.data;
                $scope.titulomodal = 'Crear Roles';
                $scope.btnnombremodal = 'CREAR';
                $scope.inactiveuserfield = false;
                $("#modaluirol").modal('show');
              })
          }else{
            $scope.titulomodal = 'Actualizar Roles';
            $scope.btnnombremodal = 'ACTUALIZAR';
            $scope.rol.codigo = data.Codigo;
            $scope.jsonmenu = JSON.parse(data.menu);
            $scope.rol.nombre = data.Nombre;
            $("#modaluirol").modal('show');
          }
     }
    //TRANSACCIONES
    $scope.uiRol = function(){
      swal({
         title: 'Confirmar',
         text: "Esta seguro que desea "+ $scope.btnnombremodal.toLowerCase() +" el rol?",
         type: 'question',
         showCancelButton: true,
         confirmButtonColor: '#3085d6',
         cancelButtonColor: '#d33',
         confirmButtonText: 'Confirmar',
         cancelButtonText: 'Cancelar'
      }).then((result) => {
         if (result) {
            var cod = $scope.rol.codigo;
            for (var i = 0; i < $scope.jsonmenu.modulos.length; i++) {
              var estado = false;
              for (var j = 0; j < $scope.jsonmenu.modulos[i].opciones.length; j++) {
                if($scope.jsonmenu.modulos[i].opciones[j].estado == true){
                  estado = true;
                  break;
                }
              }
              if(estado == false){
                $scope.jsonmenu.modulos[i].estado = false;
              }else{
                $scope.jsonmenu.modulos[i].estado = true;
              }
            }
            $scope.rol.json = JSON.stringify($scope.jsonmenu);
            var data = JSON.stringify($scope.rol);
            $http({
              method: 'POST',
              url: "app/model/php/administracion/funcadministracion.php",
              data: {function: 'uiRol',data:data}
            }).then(function(response) {
               if (response.data.Codigo  == '0') {
                  $("#modaluirol").modal('hide');
                  $scope.listarRol('destruir');
                  $scope.sendEvent(cod);
                  swal('Completado',response.data.Mensaje,'success')
               } else {
                  swal('Advertencia',response.data.Mensaje,'warning')
               }
            })
         }
      })
     }
    $scope.cambiarEstadoRol = function(estado,codigo){
      swal({
         title: 'Confirmar',
         text: "Desea cambiar el estado del rol?",
         type: 'question',
         showCancelButton: true,
         confirmButtonColor: '#3085d6',
         cancelButtonColor: '#d33',
         confirmButtonText: 'Confirmar',
         cancelButtonText: 'Cancelar'
      }).then((result) => {
         if (result) {
            if(estado == 'Activo'){estado = '0';}else{estado = '1';}
            $http({
              method: 'POST',
              url: "app/model/php/administracion/funcadministracion.php",
              data: {function: 'cambiarEstadoRol',estado:estado,rol:codigo}
            }).then(function(response) {
               if (response.data.Codigo  == '0') {
                  $scope.listarRol('destruir');
                  swal('Completado',response.data.Mensaje,'success')
               } else {
                  swal('Advertencia',response.data.Mensaje,'warning')
               }
            })
         }
      })}
    $scope.sendEvent = function(cod) {
      $rootScope.$emit('actualizarMenu', cod);
    }
  }])
