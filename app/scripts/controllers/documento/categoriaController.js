'use strict';
angular.module('helium')
.controller('categoriaController', ['$scope', '$rootScope', '$http','listasHttp',
function ($scope, $rootScope, $http, listasHttp) {
  $(function() {
    listasHttp.obtenerSesion().then(function(response){
          $scope.empresa = response.data.IDEMPRESA;
          $scope.listarCategoria('crear');
    });
  });
   //LISTAS
  $scope.listarCategoria = function(estado){
      if(estado == 'destruir'){swal({title: 'Cargando Categoria'}); swal.showLoading();}
      listasHttp.listarCategoria($scope.empresa,'T','T').then(function(response){
          if(response.data.length > 0){
            if(estado == 'destruir'){
              $scope.tablecategoria.destroy();
            }
            $scope.listarCategorias = response.data;
            console.log($scope.listarCategorias);
            setTimeout(function () {
              $scope.tablecategoria = $('#table-categoria').DataTable({
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
            swal('Helium informa','No hay categoria configuradas','warning');
          }
      });
     }

  $scope.categoria = {
	    codigo:'',
	    sigla:'',
	    nombre:''
  }

  //FUNCIONES
  $scope.openmodal = function(nombre,data){
	    $scope.categoria = {
	      codigo:'',
	      nombre:''
	    }
	    if(nombre == 'crear'){
	      $scope.titulomodal = 'Crear Categoria';
	      $scope.categoria.codigo = '0';
	      $scope.btnnombremodal = 'CREAR';
	      $scope.inactiveuserfield = false;
	      $("#modaluicategoria").modal('show');
	    }else{
	      $scope.titulomodal = 'Actualizar Categoria';
	      $scope.btnnombremodal = 'ACTUALIZAR';
	      $scope.categoria.codigo = data.Codigo;
	      $scope.categoria.nombre = data.Nombre;
	      $("#modaluicategoria").modal('show');
	    }
   }
  //TRANSACCIONES
  $scope.uiCategoria = function(){
     swal({
        title: 'Confirmar',
        text: "Esta seguro que desea "+ $scope.btnnombremodal.toLowerCase() +" la categoria?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar'
     }).then((result) => {
        if (result) {
           var data = JSON.stringify($scope.categoria);
           $http({
             method: 'POST',
             url: "app/model/php/administracion/funcadministracion.php",
             data: {function: 'uiCategoria',data:data}
           }).then(function(response) {
              if (response.data.Codigo  == '0') {
                $("#modaluicategoria").modal('hide');
                 $scope.listarCategoria('destruir');
                 swal('Completado',response.data.Mensaje,'success')
              } else {
                 swal('Advertencia',response.data.Mensaje,'warning')
              }
           })
        }
     })
   }
  $scope.cambiarEstadoCategoria = function(estado,codigo){
	   swal({
	      title: 'Confirmar',
	      text: "Desea cambiar el estado de la categoria?",
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
	           data: {function: 'cambiarEstadoCategoria',estado:estado, codigo:codigo}
	         }).then(function(response) {
	            if (response.data.Codigo  == '0') {
	               swal('Completado',response.data.Mensaje,'success')
	               $scope.listarCategoria('destruir');
	            } else {
	               swal('Advertencia',response.data.Mensaje,'warning')
	            }
	         })
	      }
	   })
  }
}])
