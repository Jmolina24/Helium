'use strict';
angular.module('helium')
.controller('mensajeriaController', ['$scope', '$http','listasHttp',function ($scope, $http, listasHttp) {
  $(function() {
      $(".phone-inputmask").inputmask("(999) 9999");
      $(".cellphone-inputmask").inputmask("(999) 999-9999");
      listasHttp.obtenerSesion().then(function(response){
        $scope.empresa = response.data.IDEMPRESA;
        $scope.listarMensajeria('crear');
      });
    });
    //VARIABLES
    $scope.mensajeria = {
      codigo:'',
      nombre:'',
      url:'',
      logo:''
    }
    //LISTAS
    $scope.listarMensajeria = function(estado){
        swal({title: 'Cargando empresas de mensajeria'});
        swal.showLoading();
        listasHttp.listarMensajeria($scope.empresa).then(function(response){
            if(response.data.length > 0){
              if(estado == 'destruir'){
                $scope.table.destroy();
              }
              $scope.listarMensajerias = response.data;
              setTimeout(function () {
                $scope.table = $('#table-mensajeria').DataTable({
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
              swal('Helium informa','No hay empresas de mensajeria configuradas','warning');
            }
        });
     }
     $scope.url = '';
    $scope.abrirLink = function(url){
      $('#framemensajeria').attr('src', url)
      $("#modallink").modal('show');
     }
    //FUNCIONES
    $scope.openmodal = function(nombre,data){
        $scope.mensajeria = {
          codigo:'',
          nombre:'',
          url:'',
          logo:''
        }
        switch (nombre) {
          case 'crear':
            $scope.titulomodal = 'Crear Empresa de Mensajeria';
            $scope.mensajeria.codigo = '0';
            $scope.btnnombremodal = 'CREAR';
            $("#modaluimensajeria").modal('show');
            break;
          case 'actualizar':
            $scope.titulomodal = 'Actualizar Empresa de Mensajeria';
            $scope.mensajeria.codigo = data.Codigo;
            $scope.mensajeria.nombre = data.Nombre;
            $scope.mensajeria.url = data.UrlConsulta;
            $scope.mensajeria.logo = data.Logo;
            $scope.btnnombremodal = 'ACTUALIZAR';
            $("#modaluimensajeria").modal('show');
            break;
          default:
       }
     }
    //TRANSACCIONES
    $scope.uiMensajeria = function(){
      swal({
            title: 'Confirmar',
            text: "Esta seguro que desea "+ $scope.btnnombremodal.toLowerCase() +" la empresa de mensajeria?",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancelar'
         }).then((result) => {
            if (result) {
               var data = JSON.stringify($scope.mensajeria);
               $http({
                 method: 'POST',
                 url: "app/model/php/administracion/funcadministracion.php",
                 data: {function: 'uiMensajeria',data:data}
               }).then(function(response) {
                  if (response.data.Codigo  == '0') {
                     $("#modaluimensajeria").modal('hide');
                     $scope.listarMensajeria('destruir');
                     swal('Completado',response.data.Mensaje,'success')
                  } else {
                     swal('Advertencia',response.data.Mensaje,'warning')
                  }
               })
            }
         })
       }
    $scope.cambiarEstadoMensajeria = function(estado,codigo){
       swal({
          title: 'Confirmar',
          text: "Desea cambiar el estado de la empresa de mensajeria?",
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
               data: {function: 'cambiarEstadoMensajeria',estado:estado, codigo:codigo}
             }).then(function(response) {
                if (response.data.Codigo  == '0') {
                   $scope.listarMensajeria('destruir');
                   swal('Completado',response.data.Mensaje,'success')
                } else {
                   swal('Advertencia',response.data.Mensaje,'warning')
                }
             })
          }
       })
     }
}])
