'use strict';
angular.module('helium')
.controller('unidadmedidaController', ['$scope', '$rootScope', '$http','listasHttp',
function ($scope, $rootScope, $http, listasHttp) {
  $(function() {
    listasHttp.obtenerSesion().then(function(response){
          $scope.empresa = response.data.IDEMPRESA;
          $scope.listarUnidad('crear');
    });
  });

  $scope.unidad = {
    codigo:'',
    sigla:'',
    nombre:''
  }
  //LISTAS
  $scope.listarUnidad = function(estado){
      if(estado == 'destruir'){swal({title: 'Cargando unidades'}); swal.showLoading();}
      listasHttp.listarUnidades($scope.empresa).then(function(response){
          if(response.data.length > 0){
            if(estado == 'destruir'){
              $scope.tableunidad.destroy();
            }
            $scope.listarUnidades = response.data;
            setTimeout(function () {
              $scope.tableunidad = $('#table-unidad').DataTable({
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
            swal('Helium informa','No hay unidades configuradas','warning');
          }
      });
     }
  //FUNCIONES
  $scope.openmodal = function(nombre,data){
    $scope.unidad = {
      codigo:'',
      sigla:'',
      nombre:''
    }
    if(nombre == 'crear'){
      $scope.titulomodal = 'Crear Unidad';
      $scope.unidad.codigo = '0';
      $scope.btnnombremodal = 'CREAR';
      $scope.inactiveuserfield = false;
      $("#modaluiunidad").modal('show');
    }else{
      $scope.titulomodal = 'Actualizar Unidad';
      $scope.btnnombremodal = 'ACTUALIZAR';
      $scope.unidad.codigo = data.Codigo;
      $scope.unidad.nombre = data.Nombre;
      $scope.unidad.sigla = data.Sigla;
      $("#modaluiunidad").modal('show');
    }
   }
  //TRANSACCIONES
  $scope.uiUnidad = function(){
     swal({
        title: 'Confirmar',
        text: "Esta seguro que desea "+ $scope.btnnombremodal.toLowerCase() +" la unidad?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar'
     }).then((result) => {
        if (result) {
           var data = JSON.stringify($scope.unidad);
           $http({
             method: 'POST',
             url: "app/model/php/administracion/funcadministracion.php",
             data: {function: 'uiUnidad',data:data}
           }).then(function(response) {
              if (response.data.Codigo  == '0') {
                $("#modaluiunidad").modal('hide');
                 $scope.listarUnidad('destruir');
                 swal('Completado',response.data.Mensaje,'success')
              } else {
                 swal('Advertencia',response.data.Mensaje,'warning')
              }
           })
        }
     })
   }
  $scope.cambiarEstadoUnidad = function(estado,codigo){
   swal({
      title: 'Confirmar',
      text: "Desea cambiar el estado de la unidad?",
      type: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Confirmar',
      cancelButtonText: 'Cancelar'
   }).then((result) => {
      if (result) {
         if(estado == 'Activa'){estado = '0';}else{estado = '1';}
         $http({
           method: 'POST',
           url: "app/model/php/administracion/funcadministracion.php",
           data: {function: 'cambiarEstadoUnidad',estado:estado, codigo:codigo}
         }).then(function(response) {
            if (response.data.Codigo  == '0') {
               swal('Completado',response.data.Mensaje,'success')
               $scope.listarUnidad('destruir');
            } else {
               swal('Advertencia',response.data.Mensaje,'warning')
            }
         })
      }
   })
  }
}])
