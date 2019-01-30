'use strict';
angular.module('helium')
.controller('submotivoController', ['$scope', '$rootScope', '$http','listasHttp',
function ($scope, $rootScope, $http, listasHttp) {
  $(function() {
    listasHttp.obtenerSesion().then(function(response){
      $scope.empresa = response.data.IDEMPRESA;
      $scope.listarSubMotivos('crear');
      listasHttp.listarMotivos($scope.empresa).then(function(response){
        $scope.listarMotivo = response.data;
        console.log($scope.listarMotivo);
      });
    });

  });

  $scope.submotivo = {
    codigomotivo:'',
    codigo:'',
    nombre:'',
  }
  //LISTAS
  $scope.listarSubMotivos = function(estado){
    if(estado == 'destruir'){swal({title: 'Cargando motivos'}); swal.showLoading();}
    listasHttp.listarsubmotivo($scope.empresa,'T','T','T').then(function(response){
      if(response.data.length > 0){
        if(estado == 'destruir'){
          $scope.tablesubmotivo.destroy();
        }
        $scope.listarSubMotivo = response.data;
        console.log($scope.listarSubMotivo);
        setTimeout(function () {
          $scope.tablesubmotivo = $('#table-submotivo').DataTable({
            dom: 'Bfrtip',
            responsive: true,
            buttons: [],
            language: {"url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"},
            lengthMenu: [[10, 50,-1], [10, 50,'Todas']],
            order: [[ 0, "asc" ]]
          });
          swal.close();
        }, 500);
      }else{
        swal('Helium informa','No hay submotivos configuradas','warning');
      }
    });
  }

  //FUNCIONES



  $scope.openmodal = function(nombre,data){
    $scope.submotivo = {
      codigomotivo:'',
      codigo:'',
      nombre:'',
    }
    if(nombre == 'crear'){
      $scope.titulomodal = 'Crear Sub Motivos';
      $scope.submotivo.codigo = '0';
      $scope.btnnombremodal = 'CREAR';
      $scope.inactiveuserfield = false;
      $("#modaluisubmotivo").modal('show');
    }else{
      $scope.titulomodal = 'Actualizar Sub Motivos';
      $scope.btnnombremodal = 'ACTUALIZAR';
      $scope.submotivo.codigomotivo = data.MotivoDocumentoId;
      $scope.submotivo.codigo=data.Codigo;
      $scope.submotivo.nombre = data.Nombre;
      $("#modaluisubmotivo").modal('show');
    }
  }
  // //TRANSACCIONES
  $scope.uiMotivo = function(){
     swal({
        title: 'Confirmar',
        text: "Esta seguro que desea "+ $scope.btnnombremodal.toLowerCase() +" el sub motivo?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar'
     }).then((result) => {
        if (result) {
           var data = JSON.stringify($scope.submotivo);
           $http({
             method: 'POST',
             url: "app/model/php/administracion/funcadministracion.php",
             data: {function: 'uiSubEstadoMotivo',data:data}
           }).then(function(response) {
              if (response.data.Codigo  == '0') {
                 $scope.listarSubMotivos('destruir');
                 swal('Completado',response.data.Mensaje,'success')
              } else {
                 swal('Advertencia',response.data.Mensaje,'warning')
              }
           })
        }
     })
   }
   $scope.cambiarEstadoSubMotivo = function(estado,codigo){
     swal({
       title: 'Confirmar',
       text: "Desea cambiar el estado del sub motivo?",
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
           data: {function: 'cambiarEstadoSubMotivo',estado:estado, codigo:codigo}
         }).then(function(response) {
           if (response.data.Codigo  == '0') {
             swal('Completado',response.data.Mensaje,'success')
             $scope.listarSubMotivos('destruir');
           } else {
             swal('Advertencia',response.data.Mensaje,'warning')
           }
         })
       }
     })
   }
}])
