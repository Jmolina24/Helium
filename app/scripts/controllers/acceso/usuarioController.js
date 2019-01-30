'use strict';
angular.module('helium')
.controller('usuarioController', ['$scope', '$http','listasHttp',
function ($scope, $http, listasHttp) {
  $(function() {
    $(".phone-inputmask").inputmask("(999) 9999");
    $(".cellphone-inputmask").inputmask("(999) 999-9999");
    listasHttp.obtenerSesion().then(function(response){
          $scope.empresa = response.data.IDEMPRESA;
          listasHttp.listarCargos($scope.empresa).then(function(response){
                $scope.listarCargos = response.data;
          });
          listasHttp.listarSedes($scope.empresa,'1').then(function(response){
            $scope.listarSedes = response.data;
          });
          $scope.listarUsuario('crear');
    });
    listasHttp.listarTipoDocumento().then(function(response){
          $scope.listarTipoDocumentos = response.data;
    });
    listasHttp.listarRoles(0,'1').then(function(response){
          $scope.listarRoles = response.data;
    });

  });
  //VARIABLES
  $scope.user = {
    codigo:'',
    cargo:'',
    rol:'',
    oficina:'',
    sede:'',
    area:'',
    tipodocumento:'',
    documento:'',
    telefono:'',
    celular:'',
    nombres:'',
    apellidos:'',
    usuario:'',
    pass:'',
    email:''
  }
  $scope.listarUsuario = function(estado){
        swal({title: 'Cargando usuarios'});
        swal.showLoading();
        listasHttp.listarUsuarios($scope.empresa,'T','T','T').then(function(response){
            if(response.data.length > 0){
              if(estado == 'destruir'){
                $scope.table.destroy();
              }
              $scope.listarUsuarios = response.data;
              setTimeout(function () {
                $scope.table = $('#table-usuario').DataTable({
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
              swal('Helium informa','No hay usuarios configurados','warning');
            }
        });
     }
  //FUNCIONES
  $scope.openmodal = function(nombre,data){
     $scope.user = {
       codigo:'',
       cargo:'',
       rol:'',
       oficina:'',
       sede:'',
       area:'',
       tipodocumento:'',
       documento:'',
       telefono:'',
       celular:'',
       nombres:'',
       apellidos:'',
       usuario:'',
       pass:'',
       email:''
     }
     switch (nombre) {
       case 'crear':
         $scope.titulomodal = 'Crear Usuario';
         $scope.user.codigo = '0';
         $scope.btnnombremodal = 'CREAR';
         $scope.inactiveuserfield = false;
         $("#modaluiuser").modal('show');
         break;
       case 'actualizar':
           $scope.titulomodal = 'Actualizar Usuario';
           $scope.btnnombremodal = 'ACTUALIZAR';
           $scope.inactiveuserfield = true;
           $scope.user.sede = data.SedeId;
           $scope.obtenerAreas(data.OficinaId);
           $scope.user.codigo = data.UsersId;
           
           $scope.obtenerOficinas(data.SedeId);
           $scope.user.cargo = data.CargoId.toString();
           $scope.user.tipodocumento = data.TipoDocumentoId.toString();
           $scope.user.rol = data.RolId.toString();
           $scope.user.documento = Number(data.Documento);
           $scope.user.oficina = data.OficinaId;
           $scope.user.telefono = data.Telefono;
           $scope.user.celular = data.Celular;
           $scope.user.nombres = data.Nombres;
           $scope.user.apellidos = data.Apellidos;
           $scope.user.usuario = data.UserAcces;
           $scope.user.pass = data.PasswordAcces;
           $scope.user.area = data.AreaId;
           $scope.user.email = data.Email;
           $("#modaluiuser").modal('show');
         break;
       default:
    }
  }
  $scope.obtenerOficinas =  function(sede){
    listasHttp.listarOficinas($scope.empresa,sede,'T').then(function(response){
      $scope.listarOficinas = response.data;
    });
  }
  $scope.obtenerAreas =  function(oficina){
    listasHttp.listarAreas($scope.empresa,$scope.user.sede,oficina,'T').then(function(response){
      $scope.listarAreas = response.data;
      $scope.user.area = '';
    });
  }
  //TRANSACCIONES
  $scope.uiUser = function(){
    swal({
       title: 'Confirmar',
       text: "Esta seguro que desea "+ $scope.btnnombremodal.toLowerCase() +" el usuario?",
       type: 'question',
       showCancelButton: true,
       confirmButtonColor: '#3085d6',
       cancelButtonColor: '#d33',
       confirmButtonText: 'Confirmar',
       cancelButtonText: 'Cancelar'
    }).then((result) => {
       if (result) {
          var data = JSON.stringify($scope.user);
          $http({
            method: 'POST',
            url: "app/model/php/administracion/funcadministracion.php",
            data: {function: 'uiUser',data:data}
          }).then(function(response) {
             if (response.data.Codigo  == '0') {
                $("#modaluiuser").modal('hide');
                $scope.listarUsuario('destruir');
                swal('Completado',response.data.Mensaje,'success')
             } else {
                swal('Advertencia',response.data.Mensaje,'warning')
             }
          })
       }
    })
  }
  $scope.cambiarEstadoUser = function(estado,codigo){
    swal({
       title: 'Confirmar',
       text: "Desea cambiar el estado del usuario?",
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
            data: {function: 'cambiarEstadoUser',estado:estado, codigo:codigo}
          }).then(function(response) {
             if (response.data.Codigo  == '0') {
                $scope.listarUsuario('destruir');
                swal('Completado',response.data.Mensaje,'success')
             } else {
                swal('Advertencia',response.data.Mensaje,'warning')
             }
          })
       }
    })
   }
}])
