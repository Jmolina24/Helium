'use strict';
angular.module('helium')
.controller('tercerosController', ['$scope', '$rootScope', '$http','listasHttp',
function ($scope, $rootScope, $http, listasHttp) {
  $(function() {
    listasHttp.obtenerSesion().then(function(response){
          $scope.empresa = response.data.IDEMPRESA;
          $scope.listarTercero('crear');
    });
    listasHttp.listarDepartamentos().then(function(response){
          $scope.listarDepartamentos = response.data;
    });
  });

  $scope.tercero = {
    codigo:'',
    municipio:'',
    departamento:'',
    nombre:''
  }
  //LISTAS
  $scope.listarTercero = function(estado){
      if(estado == 'destruir'){swal({title: 'Cargando terceros'}); swal.showLoading();}
      listasHttp.listarTerceros($scope.empresa).then(function(response){
          if(response.data.length > 0){
            if(estado == 'destruir'){
              $scope.tabletercero.destroy();
            }
            $scope.listarterceros = response.data;
            setTimeout(function () {
              $scope.tabletercero = $('#table-tercero').DataTable({
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
            swal('Helium informa','No hay terceros configurados','warning');
          }
      });
     }
  //FUNCIONES
  $scope.openmodal = function(nombre,data){
    $scope.tercero = {
      codigo:'',
      municipio:'',
      departamento:'',
      nombre:''
    }
    if(nombre == 'crear'){
      $scope.titulomodal = 'Crear Tercero';
      $scope.tercero.codigo = '0';
      $scope.btnnombremodal = 'CREAR';
      $scope.inactiveuserfield = false;
      $("#modaluitercero").modal('show');
    }else{
      $scope.titulomodal = 'Actualizar Tercero';
      $scope.btnnombremodal = 'ACTUALIZAR';
      $scope.tercero.departamento = data.DepartamentoId.toString();
      $scope.listarMunicipio($scope.tercero.departamento);
      $scope.tercero.codigo = data.Codigo;
      $scope.tercero.nombre = data.Nombre;
      $scope.tercero.municipio = data.CiudadId.toString();
      $("#modaluitercero").modal('show');
    }
   }
   $scope.listarMunicipio = function(dpto){
     listasHttp.listarMunicipios(dpto).then(function(response){
           $scope.listarMunicipios = response.data;
     });
   }
  //TRANSACCIONES
  $scope.uiTercero = function(){
     swal({
        title: 'Confirmar',
        text: "Esta seguro que desea "+ $scope.btnnombremodal.toLowerCase() +" el tercero?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar'
     }).then((result) => {
        if (result) {
           var data = JSON.stringify($scope.tercero);
           $http({
             method: 'POST',
             url: "app/model/php/administracion/funcadministracion.php",
             data: {function: 'uiTercero',data:data}
           }).then(function(response) {
              if (response.data.Codigo  == '0') {
                $("#modaluitercero").modal('hide');
                 $scope.listarTercero('destruir');
                 swal('Completado',response.data.Mensaje,'success')
              } else {
                 swal('Advertencia',response.data.Mensaje,'warning')
              }
           })
        }
     })
   }
  $scope.cambiarEstadoTercero = function(estado,codigo){
   swal({
      title: 'Confirmar',
      text: "Desea cambiar el estado del tercero?",
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
           data: {function: 'cambiarEstadoTercero',estado:estado, codigo:codigo}
         }).then(function(response) {
            if (response.data.Codigo  == '0') {
               swal('Completado',response.data.Mensaje,'success')
               $scope.listarTercero('destruir');
            } else {
               swal('Advertencia',response.data.Mensaje,'warning')
            }
         })
      }
   })
  }
}])
