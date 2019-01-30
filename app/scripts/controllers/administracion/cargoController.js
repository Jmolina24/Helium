'use strict';
angular.module('helium')
.controller('cargoController', ['$scope', '$rootScope', '$http','listasHttp',
function ($scope, $rootScope, $http, listasHttp) {
  $(function() {
    listasHttp.obtenerSesion().then(function(response){
          $scope.empresa = response.data.IDEMPRESA;
          $scope.listarCargo('crear');
    });
  });

  $scope.cargo = {
    codigo:'',
    nombre:''
  }
  //LISTAS
  $scope.listarCargo = function(estado){
        if(estado == 'destruir'){swal({title: 'Cargando cargos'}); swal.showLoading();}
        listasHttp.listarCargos($scope.empresa).then(function(response){
            if(response.data.length > 0){
              if(estado == 'destruir'){
                $scope.tablecargo.destroy();
              }
              $scope.listarCargos = response.data;
              setTimeout(function () {
                $scope.tablecargo = $('#table-cargo').DataTable({
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
              swal('Helium informa','No hay cargos configuradas','warning');
            }
        });
     }
  //FUNCIONES
  $scope.openmodal = function(nombre,data){
    $scope.cargo = {
      codigo:'',
      nombre:''
    }
    if(nombre == 'crear'){
      $scope.titulomodal = 'Crear Cargo';
      $scope.cargo.codigo = '0';
      $scope.btnnombremodal = 'CREAR';
      $scope.inactiveuserfield = false;
      $("#modaluicargo").modal('show');
    }else{
      $scope.titulomodal = 'Actualizar Cargo';
      $scope.btnnombremodal = 'ACTUALIZAR';
      $scope.cargo.codigo = data.Codigo;
      $scope.cargo.nombre = data.Nombre;
      $("#modaluicargo").modal('show');
    }
   }
  //TRANSACCIONES
  $scope.uiCargo = function(){
     swal({
        title: 'Confirmar',
        text: "Esta seguro que desea "+ $scope.btnnombremodal.toLowerCase() +" el cargo?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar'
     }).then((result) => {
        if (result) {
           var data = JSON.stringify($scope.cargo);
           $http({
             method: 'POST',
             url: "app/model/php/administracion/funcadministracion.php",
             data: {function: 'uiCargo',data:data}
           }).then(function(response) {
              if (response.data.Codigo  == '0') {
                 $("#modaluicargo").modal('hide');
                 $scope.listarCargo('destruir');
                 swal('Completado',response.data.Mensaje,'success')
              } else {
                 swal('Advertencia',response.data.Mensaje,'warning')
              }
           })
        }
     })
   }
  $scope.cambiarEstadoCargo = function(estado,codigo){
   swal({
      title: 'Confirmar',
      text: "Desea cambiar el estado del cargo?",
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
           data: {function: 'cambiarEstadoCargo',estado:estado, codigo:codigo}
         }).then(function(response) {
            if (response.data.Codigo  == '0') {
               $scope.listarCargo('destruir');
               $scope.$apply();
               swal('Completado',response.data.Mensaje,'success')
            } else {
               swal('Advertencia',response.data.Mensaje,'warning')
            }
         })
      }
   })
  }
}])
