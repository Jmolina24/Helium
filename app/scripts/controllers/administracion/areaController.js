'use strict';
angular.module('helium')
.controller('areaController', ['$scope', '$rootScope', '$http','listasHttp',
function ($scope, $rootScope, $http, listasHttp) {
  $(function() {
    listasHttp.obtenerSesion().then(function(response){
          $scope.empresa = response.data.IDEMPRESA;
          listasHttp.listarSedes($scope.empresa,'1').then(function(response){
            $scope.listarSedes = response.data;
          });
          $scope.listarArea('crear');
    });
  });

  $scope.area = {
    codigo:'',
    sede:'',
    oficina:'',
    sigla:'',
    nombre:''
  }
  //LISTAS
  $scope.listarArea = function(estado){
      if(estado == 'destruir'){swal({title: 'Cargando areas'}); swal.showLoading();}
      listasHttp.listarAreas($scope.empresa,'T','T','T').then(function(response){
          if(response.data.length > 0){
            if(estado == 'destruir'){
              $scope.tablearea.destroy();
            }
            $scope.listarAreas = response.data;
            setTimeout(function () {
              $scope.tablearea = $('#table-area').DataTable({
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
            swal('Helium informa','No hay areas configuradas','warning');
          }
      });
     }
  //FUNCIONES
  $scope.obtenerOficinas =  function(sede){
    listasHttp.listarOficinas($scope.empresa,sede,'T').then(function(response){
          $scope.listarOficinas = response.data;
    });
  }
  $scope.openmodal = function(nombre,data){
    $scope.area = {
      codigo:'',
      sede:'',
      oficina:'',
      sigla:'',
      nombre:''
    }
    if(nombre == 'crear'){
      $scope.titulomodal = 'Crear Area';
      $scope.area.codigo = '0';
      $scope.btnnombremodal = 'CREAR';
      $scope.inactiveuserfield = false;
      $("#modaluiarea").modal('show');
    }else{
      $scope.titulomodal = 'Actualizar Area';
      $scope.btnnombremodal = 'ACTUALIZAR';
      $scope.obtenerOficinas(data.SedeId);
      $scope.area.codigo = data.Codigo;
      $scope.area.nombre = data.Nombre;
      $scope.area.sigla = data.Sigla;
      $scope.sede = data.SedeId;
      $scope.area.sede = data.SedeId;

        $scope.area.oficina = data.OficinaId;

      $("#modaluiarea").modal('show');
    }
   }
  //TRANSACCIONES
  $scope.uiArea = function(){
     swal({
        title: 'Confirmar',
        text: "Esta seguro que desea "+ $scope.btnnombremodal.toLowerCase() +" el area?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar'
     }).then((result) => {
        if (result) {
           var data = JSON.stringify($scope.area);
           $http({
             method: 'POST',
             url: "app/model/php/administracion/funcadministracion.php",
             data: {function: 'uiArea',data:data}
           }).then(function(response) {
              if (response.data.Codigo  == '0') {
                $("#modaluiarea").modal('hide');
                 $scope.listarArea('destruir');
                 swal('Completado',response.data.Mensaje,'success')
              } else {
                 swal('Advertencia',response.data.Mensaje,'warning')
              }
           })
        }
     })
   }
  $scope.cambiarEstadoArea = function(estado,codigo){
   swal({
      title: 'Confirmar',
      text: "Desea cambiar el estado del area?",
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
           data: {function: 'cambiarEstadoArea',estado:estado, codigo:codigo}
         }).then(function(response) {
            if (response.data.Codigo  == '0') {
               swal('Completado',response.data.Mensaje,'success')
               $scope.listarArea('destruir');
            } else {
               swal('Advertencia',response.data.Mensaje,'warning')
            }
         })
      }
   })
  }
}])
