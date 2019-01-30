'use strict';
angular.module('helium')
.controller('sedeController', ['$scope','$http','$rootScope','listasHttp',function ($scope, $http, $rootScope, listasHttp) {
  $(function() {
    $(".phone-inputmask").inputmask("(999) 9999");
    $(".cellphone-inputmask").inputmask("(999) 999-9999");
    listasHttp.obtenerSesion().then(function(response){
          $scope.empresa = response.data.IDEMPRESA;
          $scope.listarSede('crear');
    });
    listasHttp.listarTipoDocumentos().then(function(response){
          $scope.listarTipoDocumentos = response.data;
    });
    listasHttp.listarDepartamentos().then(function(response){
          $scope.listarDepartamentos = response.data;
    });
  });
  //VARIABLES
  $scope.sede = {
    codigo:'',
    nombre:'',
    sigla:'',
    departamento:'',
    municipio:'',
    direccion:'',
    contacto:''
  }
  //LISTAS
  $scope.listarSede = function(estado){
      swal({title: 'Cargando sedes'});
      swal.showLoading();
      listasHttp.listarSedes($scope.empresa,'T').then(function(response){
          if(response.data.length > 0){
            if(estado == 'destruir'){
              $scope.table.destroy();
            }
            $scope.listarSedes = response.data;
            setTimeout(function () {
              $scope.table = $('#table-sede').DataTable({
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
            swal('Helium informa','No hay sedes configuradas','warning');
          }
      });
   }
  $scope.listarMunicipio = function(dpto){
    listasHttp.listarMunicipios(dpto).then(function(response){
          $scope.listarMunicipios = response.data;
    });
  }
  //FUNCIONES
  $scope.openmodal = function(nombre,data){
      $scope.sede = {
        codigo:'',
        nombre:'',
        sigla:'',
        departamento:'',
        municipio:'',
        direccion:'',
        contacto:''
      }
     switch (nombre) {
       case 'crear':
         $scope.titulomodal = 'Crear Sede';
         $scope.sede.codigo = '0';
         $scope.btnnombremodal = 'CREAR';
         $("#modaluisede").modal('show');
         break;
       case 'actualizar':
           $scope.sede.departamento = '';
           $scope.sede.tipodocumentoresponsable = '';
           $scope.titulomodal = 'Actualizar Sede';
           $scope.btnnombremodal = 'ACTUALIZAR';
           $scope.sede.codigo = data.Codigo;
           $scope.sede.nombre = data.Nombre;
           $scope.sede.sigla = data.SiglaComercial;
           $scope.sede.departamento = data.DepartamentoId.toString();
           $scope.listarMunicipio($scope.sede.departamento);
           $scope.sede.direccion = data.Direccion;
           $scope.sede.contacto = data.Telefono;
           $scope.sede.municipio = data.CiudadId.toString();
           $("#modaluisede").modal('show');
         break;
       default:
    }
  }
  //TRANSACCIONES
  $scope.uiSede = function(){
    swal({
       title: 'Confirmar',
       text: "Esta seguro que desea "+ $scope.btnnombremodal.toLowerCase() +" la sede?",
       type: 'question',
       showCancelButton: true,
       confirmButtonColor: '#3085d6',
       cancelButtonColor: '#d33',
       confirmButtonText: 'Confirmar',
       cancelButtonText: 'Cancelar'
    }).then((result) => {
       if (result) {
          var data = JSON.stringify($scope.sede);
          $http({
            method: 'POST',
            url: "app/model/php/administracion/funcadministracion.php",
            data: {function: 'uiSede',data:data}
          }).then(function(response) {
             if (response.data.Codigo  == '0') {
                $("#modaluisede").modal('hide');
                $scope.listarSede('destruir');
                swal('Completado',response.data.Mensaje,'success')
             } else {
                swal('Advertencia',response.data.Mensaje,'warning')
             }
          })
       }
    })
  }
  $scope.cambiarEstadoSede = function(estado,codigo){
    swal({
       title: 'Confirmar',
       text: "Desea cambiar el estado de la sede?",
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
            data: {function: 'cambiarEstadoSede',estado:estado, codigo:codigo}
          }).then(function(response) {
             if (response.data.Codigo  == '0') {
                $scope.listarSede('destruir');
                swal('Completado',response.data.Mensaje,'success')
             } else {
                swal('Advertencia',response.data.Mensaje,'warning')
             }
          })
       }
    })

  }
}])
