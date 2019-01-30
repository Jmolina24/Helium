'use strict';
angular.module('helium')
.controller('tipodocumentoController', ['$scope', '$rootScope', '$http','listasHttp',
function ($scope, $rootScope, $http, listasHttp) {
  $(function() {
    listasHttp.obtenerSesion().then(function(response){
          $scope.empresa = response.data.IDEMPRESA;
          $scope.listarTipoDocumento('crear');
    });
  });

  $scope.tipodocumento = {
    codigo:'',
    sigla:'',
    nombre:''
  }
  //LISTAS
  $scope.listarTipoDocumento = function(estado){
      if(estado == 'destruir'){swal({title: 'Cargando Tipo de documentos'}); swal.showLoading();}
      listasHttp.listarTipoDocumentos($scope.empresa,'T').then(function(response){
          if(response.data.length > 0){
            if(estado == 'destruir'){
              $scope.tableorigen.destroy();
            }
            $scope.listarDocumentos = response.data;
            setTimeout(function () {
              $scope.tableorigen = $('#table-tipodocumento').DataTable({
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
    $scope.tipodocumento = {
      codigo:'',
      sigla:'',
      nombre:''
    }
    if(nombre == 'crear'){
      $scope.titulomodal = 'Crear Area';
      $scope.tipodocumento.codigo = '0';
      $scope.btnnombremodal = 'CREAR';
      $scope.inactiveuserfield = false;
      $("#modaluitipodocumento").modal('show');
    }else{
      $scope.titulomodal = 'Actualizar Area';
      $scope.btnnombremodal = 'ACTUALIZAR';
      $scope.tipodocumento.codigo = data.Codigo;
      $scope.tipodocumento.nombre = data.Nombre;
      $scope.tipodocumento.sigla = data.Abreviatura;
      $("#modaluitipodocumento").modal('show');
    }
   }
  //TRANSACCIONES
  $scope.uiTipoDocumento = function(){
     swal({
        title: 'Confirmar',
        text: "Esta seguro que desea "+ $scope.btnnombremodal.toLowerCase() +" el tipo de documento?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar'
     }).then((result) => {
        if (result) {
           var data = JSON.stringify($scope.tipodocumento);
           $http({
             method: 'POST',
             url: "app/model/php/administracion/funcadministracion.php",
             data: {function: 'uiTipoDocumento',data:data}
           }).then(function(response) {
              if (response.data.Codigo  == '0') {
                $("#modaluitipodocumento").modal('hide');
                 $scope.listarTipoDocumento('destruir');
                 swal('Completado',response.data.Mensaje,'success')
              } else {
                 swal('Advertencia',response.data.Mensaje,'warning')
              }
           })
        }
     })
   }
  $scope.cambiarEstadoTipoDocumento = function(estado,codigo){
   swal({
      title: 'Confirmar',
      text: "Desea cambiar el estado del tipo de documento?",
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
           data: {function: 'cambiarEstadotipoDocumento',estado:estado, codigo:codigo}
         }).then(function(response) {
            if (response.data.Codigo  == '0') {
               swal('Completado',response.data.Mensaje,'success')
               $scope.listarTipoDocumento('destruir');
            } else {
               swal('Advertencia',response.data.Mensaje,'warning')
            }
         })
      }
   })
  }
}])
