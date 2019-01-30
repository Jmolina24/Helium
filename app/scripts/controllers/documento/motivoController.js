'use strict';
angular.module('helium')
.controller('motivoController', ['$scope', '$rootScope', '$http','listasHttp',
function ($scope, $rootScope, $http, listasHttp) {
  $(function() {
    listasHttp.obtenerSesion().then(function(response){
          $scope.empresa = response.data.IDEMPRESA;
          $scope.listarMotivo('crear');
    });
  });

  $scope.motivo = {
    codigo:'',
    nombre:''
  }
  //LISTAS
  $scope.listarMotivo = function(estado){
      if(estado == 'destruir'){swal({title: 'Cargando motivos'}); swal.showLoading();}
      listasHttp.listarMotivos($scope.empresa).then(function(response){
          if(response.data.length > 0){
            if(estado == 'destruir'){
              $scope.tablemotivo.destroy();
            }
            $scope.listarMotivos = response.data;
            setTimeout(function () {
              $scope.tablemotivo = $('#table-motivo').DataTable({
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
            swal('Helium informa','No hay motivos configuradas','warning');
          }
      });
     }
  //FUNCIONES
  $scope.openmodal = function(nombre,data){
    $scope.motivo = {
      codigo:'',
      nombre:''
    }
    if(nombre == 'crear'){
      $scope.titulomodal = 'Crear Motivos';
      $scope.motivo.codigo = '0';
      $scope.btnnombremodal = 'CREAR';
      $scope.inactiveuserfield = false;
      $("#modaluimotivo").modal('show');
    }else{
      $scope.titulomodal = 'Actualizar Motivos';
      $scope.btnnombremodal = 'ACTUALIZAR';
      $scope.motivo.codigo = data.Codigo;
      $scope.motivo.nombre = data.Nombre;
      $("#modaluimotivo").modal('show');
    }
   }
  //TRANSACCIONES
  $scope.uiMotivo = function(){
     swal({
        title: 'Confirmar',
        text: "Esta seguro que desea "+ $scope.btnnombremodal.toLowerCase() +" el motivo?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar'
     }).then((result) => {
        if (result) {
           var data = JSON.stringify($scope.motivo);
           $http({
             method: 'POST',
             url: "app/model/php/administracion/funcadministracion.php",
             data: {function: 'uiMotivo',data:data}
           }).then(function(response) {
              if (response.data.Codigo  == '0') {
                $("#modaluimotivo").modal('hide');
                 $scope.listarMotivo('destruir');
                 swal('Completado',response.data.Mensaje,'success')
              } else {
                 swal('Advertencia',response.data.Mensaje,'warning')
              }
           })
        }
     })
   }
  $scope.cambiarEstadoMotivo = function(estado,codigo){
   swal({
      title: 'Confirmar',
      text: "Desea cambiar el estado del motivo?",
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
           data: {function: 'cambiarEstadoMotivo',estado:estado, codigo:codigo}
         }).then(function(response) {
            if (response.data.Codigo  == '0') {
               swal('Completado',response.data.Mensaje,'success')
               $scope.listarMotivo('destruir');
            } else {
               swal('Advertencia',response.data.Mensaje,'warning')
            }
         })
      }
   })
  }
}])
