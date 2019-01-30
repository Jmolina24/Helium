'use strict';
/**
 * @ngdoc service
 * @name helium.service:listasHttp
 * @description
 * # servicio http para el llamado al web services con todos los procedimientos
 * basico de la aplicacion.
 */
angular.module('helium')
.service('listasHttp', function ($http,$q) {
  return ({
   obtenerSesion: function(empresa,estado){
     var request = $http({
       method:'POST',
       url:"app/model/php/funclistas.php",
       data: {function:'obtenerSesion'}
     });
       return (request.then(handleSuccess,handleError));
    },
   estadoUsuarioSesion: function(estado){
      var request = $http({
        method:'POST',
        url:"app/model/php/login/funclogin.php",
        data: {function:'estadoUsuarioSesion',estado:estado}
      });
        return (request.then(handleSuccess,handleError));
     },
   marcarSesion: function(estado){
       var request = $http({
         method:'POST',
         url:"app/model/php/funclistas.php",
         data: {function:'marcarSesion',estado:estado}
       });
         return (request.then(handleSuccess,handleError));
      },
   listarTipoDocumento: function(){
       var request = $http({
         method:'POST',
         url:"app/model/php/funclistas.php",
         data: {function:'listarTipoDocumento'}
       });
         return (request.then(handleSuccess,handleError));
     },
   listarDepartamentos: function(){
      var request = $http({
        method:'POST',
        url:"app/model/php/funclistas.php",
        data: {function:'listarDepartamento'}
      });
        return (request.then(handleSuccess,handleError));
    },
   listarMunicipios: function(dpto){
       var request = $http({
         method:'POST',
         url:"app/model/php/funclistas.php",
         data: {function:'listarMunicipio',dpto:dpto}
       });
         return (request.then(handleSuccess,handleError));
     },
   listarUsuarios: function(empresa,user,documento,estado){
      var request = $http({
        method:'POST',
        url:"app/model/php/funclistas.php",
        data: {function:'listarUsuario', empresa:empresa, user:user, documento:documento,estado:estado}
      });
        return (request.then(handleSuccess,handleError));
    },
    listarEmpresas: function(nit,estado){
       var request = $http({
         method:'POST',
         url:"app/model/php/funclistas.php",
         data: {function:'listarEmpresa', nit:nit, estado:estado}
       });
         return (request.then(handleSuccess,handleError));
     },
   listarSedes: function(empresa,estado){
      var request = $http({
        method:'POST',
        url:"app/model/php/funclistas.php",
        data: {function:'listarSede', empresa:empresa, estado:estado}
      });
        return (request.then(handleSuccess,handleError));
    },
   listarOficinas: function(empresa,sede,estado){
       var request = $http({
         method:'POST',
         url:"app/model/php/funclistas.php",
         data: {function:'listarOficina', empresa:empresa, sede:sede, estado:estado}
       });
         return (request.then(handleSuccess,handleError));
     },
   listarAreas: function(empresa, sede, oficina, estado){
        var request = $http({
          method:'POST',
          url:"app/model/php/funclistas.php",
          data: {function:'listarArea', empresa:empresa, sede:sede, oficina:oficina, estado:estado}
        });
          return (request.then(handleSuccess,handleError));
      },
   listarCargos: function(empresa){
         var request = $http({
           method:'POST',
           url:"app/model/php/funclistas.php",
           data: {function:'listarCargo', empresa:empresa}
         });
           return (request.then(handleSuccess,handleError));
       },
   listarTerceros: function(empresa){
         var request = $http({
           method:'POST',
           url:"app/model/php/funclistas.php",
           data: {function:'listarTerceros', empresa:empresa}
         });
           return (request.then(handleSuccess,handleError));
       },
   listarRoles: function(rol,estado){
      var request = $http({
        method:'POST',
        url:"app/model/php/funclistas.php",
        data: {function:'listarRol',rol:rol,estado:estado}
      });
        return (request.then(handleSuccess,handleError));
    },
   listarServicios: function(empresa,motivo,estado){
      var request = $http({
        method:'POST',
        url:"app/model/php/funclistas.php",
        data: {function:'listarServicio', empresa:empresa, motivo:motivo, estado:estado}
      });
        return (request.then(handleSuccess,handleError));
    },
   listarMotivos: function(empresa){
     var request = $http({
       method:'POST',
       url:"app/model/php/funclistas.php",
       data: {function:'listarMotivo', empresa:empresa}
     });
       return (request.then(handleSuccess,handleError));
    },
    listarUnidades: function(empresa){
      var request = $http({
        method:'POST',
        url:"app/model/php/funclistas.php",
        data: {function:'listarUnidad', empresa:empresa}
      });
        return (request.then(handleSuccess,handleError));
     },
    listarMensajeria: function(empresa){
        var request = $http({
          method:'POST',
          url:"app/model/php/funclistas.php",
          data: {function:'listarMensajeria', empresa:empresa}
        });
          return (request.then(handleSuccess,handleError));
      },
    listarCategoria: function(empresa,codigo,estado){
        var request = $http({
          method:'POST',
          url:"app/model/php/funclistas.php",
          data: {function:'listarCategoria', empresa:empresa, codigo:codigo, estado:estado}
        });
          return (request.then(handleSuccess,handleError));
      },
      listarOrigen: function(empresa){
          var request = $http({
            method:'POST',
            url:"app/model/php/funclistas.php",
            data: {function:'listarOrigen', empresa:empresa}
          });
            return (request.then(handleSuccess,handleError));
        },
        listarTipoDocumentos: function(empresa,codigo){
            var request = $http({
              method:'POST',
              url:"app/model/php/funclistas.php",
              data: {function:'listarTipoDocumentos', empresa:empresa,codigo:codigo}
            });
              return (request.then(handleSuccess,handleError));
          },
        listarEstadoTipoCorrespondecia: function(empresa,tipocorrespondencia,estadocorrespondencia,estado){
        var request = $http({
          method:'POST',
          url:"app/model/php/funclistas.php",
          data: {function:'listarEstadoTipoCorrespondecias', empresa:empresa,
                                                        tipocorrespondencia:tipocorrespondencia,
                                                        estadocorrespondencia:estadocorrespondencia,
                                                        estado:estado}
        });
          return (request.then(handleSuccess,handleError));
      },
      listarsubmotivo: function(empresa,codigo,motivo,estado){
      var request = $http({
        method:'POST',
        url:"app/model/php/funclistas.php",
        data: {function:'listarSubmotivo',  empresa:empresa,
                                            codigo:codigo,
                                            motivo:motivo,
                                            estado:estado}
      });
        return (request.then(handleSuccess,handleError));
    },
      listarOrigenDocumento: function(empresa,tipocorrespondenciadocumentalid,tipodocumentalid,tipocorrespondenciaid,estado){
      var request = $http({
        method:'POST',
        url:"app/model/php/funclistas.php",
        data: {function:'listarOrigenDocumentos', empresa:empresa,
                                                  tipocorrespondenciadocumentalid:tipocorrespondenciadocumentalid,
                                                  tipodocumentalid:tipodocumentalid,
                                                  tipocorrespondenciaid:tipocorrespondenciaid,
                                                  estado:estado}
      });
        return (request.then(handleSuccess,handleError));
    },
    listarepceciones: function(empresa,usuario,area,origen,estado){
    var request = $http({
      method:'POST',
      url:"app/model/php/funclistas.php",
      data: {function:'listarecepcion',  empresa:empresa,
                                         usuario:usuario,
                                         area:area,
                                         origen:origen,
                                        estado:estado}
    });
      return (request.then(handleSuccess,handleError));
  },
    listarUsuarioArea: function(area,user,documento,estado){
       var request = $http({
         method:'POST',
         url:"app/model/php/funclistas.php",
         data: {function:'listarUsuarioArea', area:area, user:user, documento:documento,estado:estado}
       });
         return (request.then(handleSuccess,handleError));
     },
  });
  function handleSuccess (response){
      return(response);
   }
  function handleError (error){
      if (error ==null){
         return($q.reject(error));
      }else if (error.errorMessage!== undefined){
         return ($q.reject(error.errorMessage));
      }else {
         return($q.reject(error.ExceptionMessage));
      }
   }
});
