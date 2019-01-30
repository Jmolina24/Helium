'use strict';
angular.module('helium')
.controller('oficinaController', ['$scope', '$http','listasHttp',function ($scope, $http, listasHttp) {
  $(function() {
    $(".phone-inputmask").inputmask("(999) 9999");
    $(".cellphone-inputmask").inputmask("(999) 999-9999");
    listasHttp.obtenerSesion().then(function(response){
          $scope.empresa = response.data.IDEMPRESA;
          $scope.sede = response.data.SEDE;
          listasHttp.listarSedes($scope.empresa,'1').then(function(response){
              if(response.data.length > 0){
                $scope.listarSedes = response.data;
              }else{
                swal('Helium informa','No hay sedes configuradas','warning');
              }
          });
          $scope.listarOficina('crear');
    });
    listasHttp.listarDepartamentos().then(function(response){
          $scope.listarDepartamentos = response.data;
    });
    listasHttp.listarTipoDocumentos().then(function(response){
          $scope.listarTipoDocumentos = response.data;
    });
    });
    //VARIABLES
    $scope.oficina = {
      codigo:'',
      sede:'',
      nombre:'',
      sigla:'',
      departamento:'',
      municipio:'',
      direccion:'',
      contacto:''
    }
    //LISTAS
    $scope.listarOficina = function(estado){
        swal({title: 'Cargando oficinas'});
        swal.showLoading();
        listasHttp.listarOficinas($scope.empresa,'T','T').then(function(response){
            if(response.data.length > 0){
              if(estado == 'destruir'){
                $scope.table.destroy();
              }
              $scope.listarOficinas = response.data;
              setTimeout(function () {
                $scope.table = $('#table-oficina').DataTable({
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
              swal('Helium informa','No hay oficinas configuradas','warning');
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
        $scope.oficina = {
          codigo:'',
          sede:'',
          nombre:'',
          sigla:'',
          departamento:'',
          municipio:'',
          direccion:'',
          contacto:''
        }
        switch (nombre) {
          case 'crear':
            $scope.titulomodal = 'Crear Oficina';
            $scope.oficina.codigo = '0';
            $scope.btnnombremodal = 'CREAR';
            $("#modaluioficina").modal('show');
            break;
          case 'actualizar':
            $scope.titulomodal = 'Actualizar Oficina';
            $scope.oficina.codigo = data.Codigo;
            $('#sede').val(data.SedeId);
            $scope.oficina.nombre = data.Nombre;
            $scope.oficina.sigla = data.SiglaComercial;
            $scope.oficina.departamento = data.DepartamentoId.toString();
            $scope.listarMunicipio($scope.oficina.departamento);
            $scope.oficina.direccion = data.Direccion;
            $scope.oficina.contacto = data.Telefono;
            $scope.oficina.municipio = data.CiudadId.toString();
            $scope.oficina.sede = data.SedeId;
            $scope.btnnombremodal = 'ACTUALIZAR';
            $("#modaluioficina").modal('show');
            break;
          default:
       }
     }
    //TRANSACCIONES
    $scope.uiOficina = function(){
      swal({
            title: 'Confirmar',
            text: "Esta seguro que desea "+ $scope.btnnombremodal.toLowerCase() +" la oficina?",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancelar'
         }).then((result) => {
            if (result) {
               var data = JSON.stringify($scope.oficina);
               $http({
                 method: 'POST',
                 url: "app/model/php/administracion/funcadministracion.php",
                 data: {function: 'uiOficina',data:data}
               }).then(function(response) {
                  if (response.data.Codigo  == '0') {
                     $("#modaluioficina").modal('hide');
                     $scope.listarOficina('destruir');
                     swal('Completado',response.data.Mensaje,'success')
                  } else {
                     swal('Advertencia',response.data.Mensaje,'warning')
                  }
               })
            }
         })
       }
    $scope.cambiarEstadoOficina = function(estado,codigo){
       swal({
          title: 'Confirmar',
          text: "Desea cambiar el estado de la oficina?",
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
               data: {function: 'cambiarEstadoOficina',estado:estado, codigo:codigo}
             }).then(function(response) {
                if (response.data.Codigo  == '0') {
                   $scope.listarOficina('destruir');
                   swal('Completado',response.data.Mensaje,'success')
                } else {
                   swal('Advertencia',response.data.Mensaje,'warning')
                }
             })
          }
       })
     }
}])
