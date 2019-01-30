'use strict';
angular.module('helium')
.controller('origenController', ['$scope', '$rootScope', '$http','listasHttp',
function ($scope, $rootScope, $http, listasHttp) {
  $(function() {
    listasHttp.obtenerSesion().then(function(response){
          $scope.empresa = response.data.IDEMPRESA;
          $scope.listarOrigen('crear');
    });
  });

  $scope.origen = {
    codigo:'',
    sigla:'',
    nombre:''
  }
  //LISTAS
  $scope.listarOrigen = function(estado){
      if(estado == 'destruir'){swal({title: 'Cargando Origenes'}); swal.showLoading();}
      listasHttp.listarOrigen($scope.empresa).then(function(response){
          if(response.data.length > 0){
            if(estado == 'destruir'){
              $scope.tableorigen.destroy();
            }
            $scope.listarorigenes = response.data;
            setTimeout(function () {
              $scope.tableorigen = $('#table-origen').DataTable({
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
            swal('Helium informa','No hay tipos de correspondencia configurados','warning');
          }
      });
     }
  //FUNCIONES
  $scope.openmodal = function(nombre,data){
    $scope.origen = {
      codigo:'',
      sigla:'',
      nombre:''
    }
    if(nombre == 'crear'){
      $scope.titulomodal = 'Crear Origen';
      $scope.origen.codigo = '0';
      $scope.btnnombremodal = 'CREAR';
      $scope.inactiveuserfield = false;
      $("#modaluiorigen").modal('show');
    }else{
      $scope.titulomodal = 'Actualizar Origen';
      $scope.btnnombremodal = 'ACTUALIZAR';
      $scope.origen.codigo = data.Codigo;
      $scope.origen.nombre = data.Nombre;
      $scope.origen.sigla = data.Abreviatura;
      $("#modaluiorigen").modal('show');
    }
   }
  //TRANSACCIONES
  $scope.uiOrigen = function(){
     swal({
        title: 'Confirmar',
        text: "Esta seguro que desea "+ $scope.btnnombremodal.toLowerCase() +" el origen?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar'
     }).then((result) => {
        if (result) {
           var data = JSON.stringify($scope.origen);
           $http({
             method: 'POST',
             url: "app/model/php/administracion/funcadministracion.php",
             data: {function: 'uiOrigen',data:data}
           }).then(function(response) {
              if (response.data.Codigo  == '0') {
                $("#modaluiorigen").modal('hide');
                 $scope.listarOrigen('destruir');
                 swal('Completado',response.data.Mensaje,'success')
              } else {
                 swal('Advertencia',response.data.Mensaje,'warning')
              }
           })
        }
     })
   }
  $scope.cambiarEstadoOrigen = function(estado,codigo){
   swal({
      title: 'Confirmar',
      text: "Desea cambiar el estado del origen?",
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
           data: {function: 'cambiarEstadoOrigen',estado:estado, codigo:codigo}
         }).then(function(response) {
            if (response.data.Codigo  == '0') {
               swal('Completado',response.data.Mensaje,'success')
               $scope.listarOrigen('destruir');
            } else {
               swal('Advertencia',response.data.Mensaje,'warning')
            }
         })
      }
   })
  }
}])
