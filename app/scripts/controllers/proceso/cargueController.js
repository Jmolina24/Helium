$(function() {
  listasHttp.obtenerSesion().then(function(response){
    $scope.empresa = response.data.IDEMPRESA;
      listasHttp.listarOficinas($scope.empresa,'T','T').then(function(response){
        $scope.listarOficinas = response.data;
        //console.log($scope.listarOficinas);
      });
      listasHttp.listarOrigen($scope.empresa).then(function(response){
          $scope.LisTipoOrigen = response.data;
        })
        listasHttp.listarCategoria($scope.empresa,'T','T').then(function(response){
          $scope.LisCategoria=response.data;
        })
        listasHttp.listarUnidades($scope.empresa).then(function(response){
            $scope.LisUnidadMedida=response.data;
        })
      listasHttp.listarOficinas($scope.empresa,'T','T').then(function(response){
            $scope.LisSedeOficina=response.data;
        })
        listasHttp.listarTipoDocumentos($scope.empresa,'T').then(function(response){
          $scope.LisTipoCorrespondencia=response.data;
        })
        listasHttp.listarAreas($scope.empresa,'T','T','T').then(function(response){
          $scope.LisArea=response.data;
        })
        $scope.listarCorrespendicia('crear');
  });
});

//Capturo El IdSede Y Pasarselo A La Funcion Obtengo Area
$scope.ConseguirArea = function(array,dato){
    for (var i = 0; i < array.length; i++) {
      if (dato==array[i].Codigo) {
        $scope.datos=array[i];
        break;
    }
  }
  return $scope.datos;
}

// Recibe Los Datos y Realiza La Consulta
$scope.ObtengoArea= function(idsede){
  var datos = $scope.ConseguirArea($scope.LisSedeOficina,idsede);
  listasHttp.listarAreas($scope.empresa,datos.SedeId,'T','T').then(function(response){
  $scope.LisArea=response.data;
  })
}
//Recibo El Dato Del Area y Obtengo El Usuario
$scope.ObtengoUsuarioArea =function(idarea){
  listasHttp.listarUsuarioArea(idarea,'T','T','T').then(function(response){
  $scope.UsuarioArea=response.data;
  console.log($scope.UsuarioArea);
  })
}

$scope.recepcion= {
  origen:'',
  oficina:'',
  area:'',
  tipocorrespondencia:'',
  categoria:'',
  unidadmedida:'',
  cantidad:'',
  asunto:'',
  observacion:''
}

$scope.listarCorrespendicia = function(estado){
  if(estado == 'destruir'){swal({title: 'Cargando areas'}); swal.showLoading();}
  listasHttp.listarepceciones($scope.empresa,'T','T').then(function(response){
    if(response.data.length > 0){
      if(estado == 'destruir'){
        $scope.tablerecepcion.destroy();
      }
      $scope.listar= response.data;
      setTimeout(function () {
        $scope.tablerecepcion = $('#table-recepcion').DataTable({
          dom: 'Bfrtip',
          responsive: true,
          buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
          language: {"url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"},
          lengthMenu: [[10, 50,-1], [10, 50,'Todas']],
          order: [[ 0, "asc" ]]
        });
        swal.close();
      }, 500);
    }else{
      swal('Helium informa','No hay correspondencia','warning');
    }
  });
}

/*Datapicker Fecha*/
//jQuery('.mydatepicker').datepicker();
jQuery('.mydatepicker').datepicker({
  format: 'mm/dd/yyyy',
  startDate: '-3d'
});
jQuery('#datepicker-autoclose').datepicker({
  autoclose: true,
  todayHighlight: true
});


$scope.OcultarRemitenteInterno=true;
$scope.OcultarRemitenteExterno=true;
$scope.OcultarCorrespondecia=true;
$scope.OcultarRemitenteInterno2=true;
$scope.OcultarRemitenteExterno2=true;
$scope.OcultarCorrespondecia2=true;
$scope.TipoDeTramiteExterno=true;

$scope.obtenerDatos=function(origen){
  switch (origen) {
    case '':
    $scope.OcultarCorrespondecia=true
    $scope.OcultarRemitenteInterno=true;
    $scope.OcultarRemitenteExterno=true;
    $scope.TipoDeTramiteExterno=true;
    break;
    case '1':
    $scope.OcultarCorrespondecia=false
    $scope.OcultarRemitenteInterno=false;
    $scope.OcultarRemitenteExterno=true;
    $scope.TipoDeTramiteExterno=true;
    break;
    case '2':
    $scope.OcultarCorrespondecia=true;
    $scope.OcultarRemitenteInterno=true;
    $scope.OcultarRemitenteExterno=false;
    $scope.TipoDeTramiteExterno=false;
    break;
    default:
  }
}
$scope.obtenerDatos2=function(origen2){
  switch (origen2) {
    case '':
    $scope.OcultarCorrespondecia2=true
    $scope.OcultarRemitenteInterno2=true;
    $scope.OcultarRemitenteExterno2=true;
    break;
    case '1':
    $scope.OcultarCorrespondecia2=false
    $scope.OcultarRemitenteInterno2=false;
    $scope.OcultarRemitenteExterno2=true;
    break;
    case '2':
    $scope.OcultarCorrespondecia2=true;
    $scope.OcultarRemitenteInterno2=true;
    $scope.OcultarRemitenteExterno2=false;
    break;
    default:
  }
}
$scope.openmodal = function(nombre,data){
  $scope.recepcion= {
    origen:'',
    oficina:'',
    area:'',
    tipocorrespondencia:'',
    categoria:'',
    unidadmedida:'',
    cantidad:'',
    asunto:'',
    observacion:''
  }
  if(nombre == 'crear'){
    $scope.titulomodal = 'Crear Correspondencia';
    $scope.btnnombremodal = 'CREAR';
    $scope.inactiveuserfield = false;
    $("#modaluirecepcion").modal('show');
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

    $("#modaluirecepcion").modal('show');
  }
}

$scope.tabs =  function(id,n){
    $('.tab_status').removeClass("tab-current");
    $('#'+id).addClass("tab-current");
    $('.content_status').removeClass("content-current");
    $('#section-underline-'+n).addClass("content-current");
  }
