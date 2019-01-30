'use strict';
angular.module('helium')
.controller('estadodocumentoController', ['$scope', '$rootScope', '$http','listasHttp',
function ($scope, $rootScope, $http, listasHttp) {
  $(function() {
    listasHttp.obtenerSesion().then(function(response){
      $scope.empresa = response.data.IDEMPRESA;
      $scope.listarEstadoTipoCorrespondecias('crear');
      listasHttp.listarOrigenDocumento($scope.empresa,'T','T','T','T').then(function(response){
        $scope.listarorigenedocumentos = response.data;
        //console.log($scope.listarorigenedocumentos);
      });
    });

  });


  $scope.tipos = {
    nombretipo:'',
    documento:'',
    secuencia:'',
    codigo:''
  }

  //LISTAS
  $scope.listarEstadoTipoCorrespondecias = function(estado){
    if(estado == 'destruir'){swal({title: 'Cargando Tipo De Documento'}); swal.showLoading();}
    listasHttp.listarEstadoTipoCorrespondecia($scope.empresa,'T','T','T').then(function(response){
      if(response.data.length > 0){
        if(estado == 'destruir'){
          $scope.tabletipodocumento.destroy();
        }
        $scope.listarTipoDocumento = response.data;
        //console.log($scope.listarTipoDocumento);
        setTimeout(function () {
          $scope.tabletipodocumento = $('#table-tipo-documento').DataTable({
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
        swal('Helium informa','No hay estados de documentos configurados.','warning');
      }
    });
  }


  //FUNCIONES
  $scope.openmodal = function(nombre,data){
    $scope.tipos = {
      nombretipo:'',
      documento:'',
      secuencia:'',
      codigo:''
    }
    if(nombre == 'crear'){
      $scope.titulomodal = 'Crear Tipo De Correspondecia';
      $scope.tipos.codigo = '0';
      $scope.btnnombremodal = 'CREAR';
      $scope.inactiveuserfield = false;
      $("#modaluiestadotipodocumento").modal('show');
    }else{
      $scope.titulomodal = 'Actualizar El Estado De La Correspondecia';
      $scope.btnnombremodal = 'ACTUALIZAR';
      $scope.tipos.nombretipo= data.Nombre;
      $scope.tipos.documento= data.TipoCorrespondenciaDocumentalId.toString();
      //console.log($scope.tipos.documento);
      $scope.tipos.secuencia=data.Secuencia;
      $scope.tipos.codigo=data.Codigo;
      $("#modaluiestadotipodocumento").modal('show');
    }
  }


  //TRANSACCIONES

  $scope.uiTipoCorrespondencia = function(){
    swal({
      title: 'Confirmar',
      text: "Esta seguro que desea "+ $scope.btnnombremodal.toLowerCase() +" el  Tipo Correspondecia?",
      type: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Confirmar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result) {
        var data = JSON.stringify($scope.tipos);
        console.log(data);
        $http({
          method: 'POST',
          url: "app/model/php/administracion/funcadministracion.php",
          data: {function: 'uiEstadoTipoCorrespondencia',data:data}
        }).then(function(response) {
          if (response.data.Codigo  == '0') {
            $("#modaluiestadotipodocumento").modal('hide');
            $scope.listarEstadoTipoCorrespondecias('destruir');
            swal('Completado',response.data.Mensaje,'success')
          } else {
            swal('Advertencia',response.data.Mensaje,'warning')
          }
        })
      }
    })
  }


  $scope.cambiarEstadoTipoCorrespondencia = function(codigo,estado){
    swal({
      title: 'Confirmar',
      text: "Desea cambiar el estado De La Correspondecia?",
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
          data: {function: 'cambiarEstadoTipoCorrespondencia',estado:estado, codigo:codigo}
        }).then(function(response) {
          if (response.data.Codigo  == '0') {
            swal('Completado',response.data.Mensaje,'success')
            $scope.listarEstadoTipoCorrespondecias('destruir');
          } else {
            swal('Advertencia',response.data.Mensaje,'warning')
          }
        })
      }
    })
  }


}])
