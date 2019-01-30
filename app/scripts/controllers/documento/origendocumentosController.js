'use strict';
angular.module('helium')
.controller('origendocumentosController', ['$scope', '$rootScope', '$http','listasHttp',
function ($scope, $rootScope, $http, listasHttp) {
  $(function() {
    listasHttp.obtenerSesion().then(function(response){
          $scope.empresa = response.data.IDEMPRESA;
          $scope.listarOrigendocumento('crear');
          listasHttp.listarOrigen($scope.empresa).then(function(response){
              $scope.listarorigenes = response.data;
          });
          listasHttp.listarTipoDocumentos($scope.empresa,'T').then(function(response){
            $scope.listarDocumentos = response.data;
          });
    });

  });

  $scope.origendoc = {
    codigo:'',
    sigla:'',
    nombre:''
  }
  //LISTAS
  $scope.listarOrigendocumento = function(estado){
      if(estado == 'destruir'){swal({title: 'Cargando Origen de Documentos'}); swal.showLoading();}
      listasHttp.listarOrigenDocumento($scope.empresa,'T','T','T','T').then(function(response){
          if(response.data.length > 0){
            if(estado == 'destruir'){
              $scope.tableorigen.destroy();
            }
            $scope.listarorigenedocumentos = response.data;
            setTimeout(function () {
              $scope.tableorigen = $('#table-origendocumento').DataTable({
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
            swal('Helium informa','No hay origen de documentos configurados.','warning');
          }
      });
     }
  //FUNCIONES
  $scope.openmodal = function(nombre,data){
    $scope.origendoc = {
      codigo:'',
      documento:'',
      origen:''
    }
    if(nombre == 'crear'){
      $scope.titulomodal = 'Crear Origen de Documento';
      $scope.origendoc.codigo = '0';
      $scope.btnnombremodal = 'CREAR';
      $scope.inactiveuserfield = false;
      $("#modaluiorigendocumento").modal('show');
    }else{
      $scope.titulomodal = 'Actualizar Origen de Documento';
      $scope.btnnombremodal = 'ACTUALIZAR';
      $scope.origendoc.codigo = data.Codigo;
      $scope.origendoc.documento = data.TipoDocumentalId.toString();
      $scope.origendoc.origen = data.TipoCorrespondenciaId.toString();
      $("#modaluiorigendocumento").modal('show');
    }
   }
  //TRANSACCIONES
  $scope.uiOrigenDocumento = function(){
     swal({
        title: 'Confirmar',
        text: "Esta seguro que desea "+ $scope.btnnombremodal.toLowerCase() +" el origen del documento?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar'
     }).then((result) => {
        if (result) {
           var data = JSON.stringify($scope.origendoc);
           $http({
             method: 'POST',
             url: "app/model/php/administracion/funcadministracion.php",
             data: {function: 'uiOrigenDocumento',data:data}
           }).then(function(response) {
              if (response.data.Codigo  == '0') {
                $("#modaluiorigendocumento").modal('hide');
                 $scope.listarOrigendocumento('destruir');
                 swal('Completado',response.data.Mensaje,'success')
              } else {
                 swal('Advertencia',response.data.Mensaje,'warning')
              }
           })
        }
     })
   }
  $scope.cambiarEstadoOrigenDocumento = function(estado,codigo){
   swal({
      title: 'Confirmar',
      text: "Desea cambiar el estado del origen de documento?",
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
           data: {function: 'cambiarEstadoOrigenDocumento',estado:estado, codigo:codigo}
         }).then(function(response) {
            if (response.data.Codigo  == '0') {
               swal('Completado',response.data.Mensaje,'success')
               $scope.listarOrigendocumento('destruir');
            } else {
               swal('Advertencia',response.data.Mensaje,'warning')
            }
         })
      }
   })
  }
}])
