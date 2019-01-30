'use strict';
angular.module('helium')
  .controller('recepcionController', ['$scope', '$rootScope', '$http', '$window', 'listasHttp',
    function ($scope, $rootScope, $http, $window, listasHttp) {
      $(function () {
        // We can attach the `fileselect` event to all file inputs on the page
        $(document).on('change', ':file', function () {
          var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
          input.trigger('fileselect', [numFiles, label]);
        });

        // We can watch for our custom `fileselect` event like this
        $(document).ready(function () {
          $(':file').on('fileselect', function (event, numFiles, label) {
            var input = $(this).parents('.input-group').find(':text'),
              log = numFiles > 1 ? numFiles + ' files selected' : label;
            if (input.length) {
              input.val(log);
            } else {
              if (log) alert(log);
            }
          });
        });

        listasHttp.obtenerSesion().then(function (response) {
          $scope.empresa = response.data.IDEMPRESA;
          listasHttp.listarOficinas($scope.empresa, 'T', 'T').then(function (response) {
            $scope.listarOficinas = response.data;
          });
          listasHttp.listarOrigen($scope.empresa).then(function (response) {
            $scope.LisTipoOrigen = response.data;
            console.log($scope.LisTipoOrigen);
          })
          listasHttp.listarCategoria($scope.empresa, 'T', 'T').then(function (response) {
            $scope.LisCategoria = response.data;
          })
          listasHttp.listarUnidades($scope.empresa).then(function (response) {
            $scope.LisUnidadMedida = response.data;
          })
          listasHttp.listarOficinas($scope.empresa, 'T', 'T').then(function (response) {
            $scope.LisSedeOficina = response.data;
            $scope.LisSedeOficinaDest = response.data;
          })
          listasHttp.listarTipoDocumentos($scope.empresa, 'T').then(function (response) {
            $scope.LisTipoCorrespondencia = response.data;
          })
          listasHttp.listarAreas($scope.empresa, 'T', 'T', 'T').then(function (response) {
            $scope.LisArea = response.data;
          })
          listasHttp.listarMensajeria($scope.empresa).then(function (response) {
            $scope.LisMensajeria = response.data;
          })
          listasHttp.listarOrigenDocumento($scope.empresa, 'T', 'T', 'T', 'T').then(function (response) {
            $scope.listarorigenes = response.data;
            console.log($scope.listarorigenes);
          })
          listasHttp.listarTerceros($scope.empresa).then(function (response) {
            $scope.Entidad = response.data;
          })
          $scope.listarCorrespendiciaEntrada('crear');
          $scope.listarCorrespendiciaSalida('crear');
        });
        jQuery('.mydatepicker').datepicker();
        jQuery('#datepicker-autoclose').datepicker({
          autoclose: true,
          todayHighlight: true
        });
      });
      // VARIABLES
      $scope.recepcion = {
        fecha: '',
        origen: '',
        oficina: '',
        area: '',
        numeroguia: '',
        entidad: '',
        empresamensajeria: '',
        tipocorrespondencia: '',
        categoria: '',
        unidadmedida: '',
        cantidad: '',
        asunto: '',
        observacion: '',
        tipotramite: '',
        entidad: '',
        nombre: '',
        //Destinatario
        origendest: '',
        oficinadest: '',
        areadest: '',
        remitenteinternodest: '',
        tipotramitedest: '',
        entidaddest: '',
        nombredest: '',
        empresamensajeriadest: '',
        numeroguiadest: ''
      }
      $scope.OcultarCorrespondecia = true;
      $scope.OcultarRemitenteInterno = true;
      $scope.TipoDeTramiteExterno = true;
      $scope.EntidadDelTramite = true;
      $scope.EntidadDelTramitePN = true;
      $scope.OcultarInformacionCorrespondencia = true;
      $scope.OcultarInformacionDestinatario = true;
      $scope.OcultarCorrespondeciaDestinatario = true;
      $scope.OcultarRemitenteInternoDestinatario = true;
      $scope.TipoDeTramiteExternoDestinatario = true;
      $scope.EntidadDelTramiteDestinatario = true;
      $scope.EntidadDelTramiteDestinatarioPN = true;

      $scope.DestinoOcultar = true;

      $scope.OcultarCargue = true;


      // LISTAS
      $scope.listarCorrespendiciaEntrada = function (estado) {
        if (estado == 'destruir') { swal({ title: 'Cargando correspondencia' }); swal.showLoading(); }
        listasHttp.listarepceciones($scope.empresa, 'T', 'T', 'E', 'T').then(function (response) {
          if (response.data.length > 0) {
            if (estado == 'destruir') {
              $scope.tableentrada.destroy()
            }
            $scope.listarEntrada = response.data;
            setTimeout(function () {
              $scope.tableentrada = $('#table-entrada').DataTable({
                dom: 'Bfrtip',
                responsive: true,
                buttons: ['copy', 'csv', 'excel', 'pdf'],
                language: { "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json" },
                lengthMenu: [[10, 50, -1], [10, 50, 'Todas']],
                order: [[0, "asc"]]
              });
              swal.close();
            }, 500);
          } else {
            swal('Helium informa', 'No hay correspondencia de entrada', 'warning');
          }
        });
      }
      $scope.listarCorrespendiciaSalida = function (estado) {
        if (estado == 'destruir') { swal({ title: 'Cargando correspondencia' }); swal.showLoading(); }
        listasHttp.listarepceciones($scope.empresa, 'T', 'T', 'I', 'T').then(function (response) {
          if (response.data.length > 0) {
            if (estado == 'destruir') {
              $scope.tablesalida.destroy();
            }
            $scope.listarSalida = response.data;
            console.log($scope.listarSalida);
            setTimeout(function () {
              $scope.tablesalida = $('#table-salida').DataTable({
                dom: 'Bfrtip',
                responsive: true,
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                language: { "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json" },
                lengthMenu: [[10, 50, -1], [10, 50, 'Todas']],
                order: [[0, "asc"]]
              });
              swal.close();
            }, 500);
          } else {
            swal('Helium informa', 'No hay correspondencia de salida', 'warning');
          }
        });
      }
      $scope.ObtengoArea = function (idsede) {
        var datos = $scope.ConseguirArea($scope.LisSedeOficina, idsede);
        listasHttp.listarAreas($scope.empresa, datos.SedeId, 'T', 'T').then(function (response) {
          $scope.recepcion.area = '';
          $scope.recepcion.remitenteinterno = '';
          $scope.LisArea = response.data;
        })
      }

      // $scope.ObtengoOrigenDocumental=function(){
      //   listasHttp.listarOrigenDocumento($scope.empresa,'T','T','T','T').then(function(response){
      //     $scope.datos=response.data;
      //     for (var i = 0; i < $scope.datos.length; i++) {
      //       if ($scope.empresa==$scope.datos.Codigo) {
      //         $scope.datos=array[i];
      //         break;
      //       }
      //     }
      //   }

      // }

      $scope.ObtengoUsuarioArea = function (idarea) {
        $scope.recepcion.remitenteinterno = '';
        listasHttp.listarUsuarioArea(idarea, 'T', 'T', 'T').then(function (response) {
          $scope.UsuarioArea = response.data;
        })
      }
      // Recibe Los Datos y Realiza La Consulta (Destinatario)
      $scope.ObtengoAreaDestinatario = function (idsede) {
        var datos = $scope.ConseguirAreaDestinatario($scope.LisSedeOficinaDest, idsede);
        listasHttp.listarAreas($scope.empresa, datos.SedeId, 'T', 'T').then(function (response) {
          $scope.recepcion.areadest = '';
          $scope.recepcion.remitenteinternodest = '';
          $scope.LisAreaDest = response.data;
        })
      }
      //Recibo El Dato Del Area y Obtengo El Usuario (Destinatario)
      $scope.ObtengoUsuarioAreaDestinatario = function (idarea) {
        $scope.recepcion.remitenteinternodest = '';
        listasHttp.listarUsuarioArea(idarea, 'T', 'T', 'T').then(function (response) {
          $scope.UsuarioAreaDestinatario = response.data;
        })
      }
      // //Recibo El Dato Del Area y Obtengo El Usuario
      // $scope.ObtengoUsuarioAreaDestinatario =function(idarea){
      //   $scope.recepcion.remitenteinterno='';
      //   listasHttp.listarUsuarioArea(idarea,'T','T','T').then(function(response){
      //     $scope.UsuarioAreaDestinatario=response.data;
      //   })
      // }
      // FUNCIONES
      $scope.array = [];
      $scope.ConseguirArea = function (array, dato) {
        for (var i = 0; i < array.length; i++) {
          if (dato == array[i].Codigo) {
            $scope.datos = array[i];
            break;
          }
        }
        return $scope.datos;
      }
      $scope.CambiarTipoTramite = function (tipo) {
        switch (tipo) {
          case '':
            $scope.EntidadDelTramite = true;
            break;
          case 'E':
            $scope.EntidadDelTramitePN = false;
            $scope.EntidadDelTramite = false;
            $scope.recepcion.nombre = '';
            $scope.recepcion.entidad = '';
            $scope.recepcion.empresamensajeria = '';
            $scope.recepcion.numeroguia = '';
            break;
          case 'PN':
            $scope.EntidadDelTramite = false;
            $scope.EntidadDelTramitePN = true;
            $scope.recepcion.entidad = '';
            $scope.recepcion.empresamensajeria = '';
            $scope.recepcion.numeroguia = '';
            break;
          default:
        }
      }
      $scope.obtenerDatos = function (origen) {
        $scope.array = [];
        $scope.origen = origen;
        for (var i = 0; i < $scope.listarorigenes.length; i++) {
          if ($scope.origen == $scope.listarorigenes[i].TipoCorrespondenciaId) {
            $scope.array.push({
              "codigo": $scope.listarorigenes[i].Codigo,
              "nombre": $scope.listarorigenes[i].NombreDocumental,
              "origen": $scope.listarorigenes[i].NombreCorrespondencia
            });
            console.log($scope.array);
            //break;          
          }
        }

        $scope.ObtenerValidacionOrigen(origen);
            switch (origen) {
              case '':
                $scope.OcultarCorrespondecia = true
                $scope.OcultarRemitenteInterno = true;
                $scope.OcultarRemitenteExterno = true;
                $scope.TipoDeTramiteExterno = true;
                $scope.OcultarInformacionCorrespondencia = true;
                $scope.OcultarInformacionDestinatario = true;
                $scope.EntidadDelTramitePN = true;
                $scope.EntidadDelTramite = true;
                break;
              case '1':
                $scope.OcultarCorrespondecia = false
                $scope.OcultarRemitenteInterno = false;
                $scope.OcultarRemitenteExterno = true;
                $scope.TipoDeTramiteExterno = true;
                $scope.OcultarInformacionCorrespondencia = false;
                $scope.OcultarInformacionDestinatario = false;
                $scope.EntidadDelTramitePN = true;
                $scope.EntidadDelTramite = true;
                $scope.recepcion.oficina = '';
                $scope.recepcion.area = '';
                $scope.recepcion.remitenteinterno = '';
                break;
              case '2':
                $scope.OcultarCorrespondecia = true;
                $scope.OcultarRemitenteInterno = true;
                $scope.OcultarRemitenteExterno = false;
                $scope.TipoDeTramiteExterno = false;
                $scope.OcultarInformacionCorrespondencia = false;
                $scope.OcultarInformacionDestinatario = false;
                $scope.recepcion.tipotramite = '';
                $scope.recepcion.entidad = '';
                $scope.recepcion.nombre = '';
                $scope.recepcion.empresamensajeria = '';
                $scope.recepcion.numeroguia = '';
                break;
              default:
            }
      }

      $scope.ObtenerValidacionOrigen = function (origenDestinatario) {
        $scope.valido = origenDestinatario;
        switch (origenDestinatario) {
          case '':
            $scope.OcultarCorrespondeciaDestinatario = true
            $scope.OcultarRemitenteInternoDestinatario = true;
            $scope.TipoDeTramiteExternoDestinatario = true;
            $scope.EntidadDelTramiteDestinatario = true;
            $scope.EntidadDelTramiteDestinatarioPN = true;
            break;
          case '1':
            $scope.OcultarCorrespondeciaDestinatario = true;
            $scope.OcultarRemitenteInternoDestinatario = true;
            $scope.TipoDeTramiteExternoDestinatario = true;
            $scope.recepcion.tipotramitedest = '';
            $scope.recepcion.entidaddest = '';
            $scope.recepcion.nombre = '';
            $scope.DestinoOcultar = false;

            break;
          case '2':
            $scope.OcultarCorrespondeciaDestinatario = false
            $scope.OcultarRemitenteInternoDestinatario = false;
            $scope.TipoDeTramiteExternoDestinatario = true;
            $scope.EntidadDelTramiteDestinatario = true;
            $scope.EntidadDelTramiteDestinatarioPN = true;
            $scope.recepcion.oficinadest = '';
            $scope.recepcion.areadest = '';
            $scope.recepcion.remitenteinternodest = '';
            $scope.DestinoOcultar = true;
            break;
          default:
        }

      }

      //Destinatario
      $scope.ConseguirAreaDestinatario = function (array, dato) {
        for (var i = 0; i < array.length; i++) {
          if (dato == array[i].Codigo) {
            $scope.datos = array[i];
            break;
          }
        }
        return $scope.datos;
      }
      $scope.obtenerDatosDestinatario = function (origenDestinatario) {
        switch (origenDestinatario) {
          case '':
            $scope.OcultarCorrespondeciaDestinatario = true
            $scope.OcultarRemitenteInternoDestinatario = true;
            $scope.TipoDeTramiteExternoDestinatario = true;
            $scope.EntidadDelTramiteDestinatario = true;
            $scope.EntidadDelTramiteDestinatarioPN = true;
            break;
          case '1':
            $scope.OcultarCorrespondeciaDestinatario = false
            $scope.OcultarRemitenteInternoDestinatario = false;
            $scope.TipoDeTramiteExternoDestinatario = true;
            $scope.EntidadDelTramiteDestinatario = true;
            $scope.EntidadDelTramiteDestinatarioPN = true;
            $scope.recepcion.oficinadest = '';
            $scope.recepcion.areadest = '';
            $scope.recepcion.remitenteinternodest = '';

            break;
          case '2':
            $scope.OcultarCorrespondeciaDestinatario = true;
            $scope.OcultarRemitenteInternoDestinatario = true;
            $scope.TipoDeTramiteExternoDestinatario = false;
            $scope.recepcion.tipotramitedest = '';
            $scope.recepcion.entidaddest = '';
            $scope.recepcion.nombre = '';

            break;
          default:
        }

      }
      $scope.CambiarTipoTramiteDestinatario = function (tipoDestinatario) {
        switch (tipoDestinatario) {

          case '':
            $scope.EntidadDelTramiteDestinatario = true;

            break;

          case 'E':
            $scope.EntidadDelTramiteDestinatario = false;
            $scope.EntidadDelTramiteDestinatarioPN = false;
            $scope.recepcion.nombredest = '';
            $scope.recepcion.entidaddest = '';
            $scope.recepcion.empresamensajeriadest = '';
            $scope.recepcion.numeroguiadest = '';
            break;

          case 'PN':
            $scope.EntidadDelTramiteDestinatario = false;
            $scope.EntidadDelTramiteDestinatarioPN = true;
            $scope.recepcion.entidaddest = '';
            $scope.recepcion.nombredest = '';
            $scope.recepcion.empresamensajeriadest = '';
            $scope.recepcion.numeroguiadest = '';
            break;
          default:

        }
      }
      $scope.openmodal = function (nombre, data) {
        $scope.OcultarCorrespondecia = true;
        $scope.OcultarRemitenteInterno = true;
        $scope.TipoDeTramiteExterno = true;
        $scope.EntidadDelTramite = true;
        $scope.EntidadDelTramitePN = true;
        $scope.OcultarInformacionCorrespondencia = true;
        $scope.OcultarInformacionDestinatario = true;
        $scope.OcultarCorrespondeciaDestinatario = true;
        $scope.OcultarRemitenteInternoDestinatario = true;
        $scope.TipoDeTramiteExternoDestinatario = true;
        $scope.EntidadDelTramiteDestinatario = true;
        $scope.EntidadDelTramiteDestinatarioPN = true;
        $scope.recepcion = {
          fecha: '',
          origen: '',
          oficina: '',
          area: '',
          numeroguia: '',
          entidad: '',
          empresamensajeria: '',
          tipocorrespondencia: '',
          categoria: '',
          unidadmedida: '',
          cantidad: '',
          asunto: '',
          observacion: '',
          tipotramite: '',
          entidad: '',
          nombre: '',
          //Destinatario
          origendest: '',
          oficinadest: '',
          areadest: '',
          remitenteinternodest: '',
          tipotramitedest: '',
          entidaddest: '',
          nombredest: '',
          empresamensajeriadest: '',
          numeroguiadest: ''

        }
        if (nombre == 'crear') {
          $scope.titulomodal = 'Crear Correspondencia';
          $scope.btnnombremodal = 'CREAR';
          $scope.inactiveuserfield = false;
          $("#modaluirecepcion").modal('show');
        } else {
          $scope.detalle = data;
          if ($scope.deta=='2'){
            $scope.Mostrar=true;
          } else {
            $scope.Mostrar=false;
          }
          
          $("#modaluidetalle").modal('show');
        }
      }
      $scope.tabs = function (id, n) {
        $scope.deta=n;
        $('.tab_status').removeClass("tab-current");
        $('#' + id).addClass("tab-current");
        $('.content_status').removeClass("content-current");
        $('#section-underline-' + n).addClass("content-current");
      }
      $scope.openBarCode = function (codigo, fecha) {
        $window.open('app/views/formatos/barcode.php?radicado=' + codigo +
          '&fecha=' + fecha,
          '_blank', "width=730,height=140");
      }
      //TRANSACCIONES
      $scope.uiReceopcion = function () {
        if ($scope.recepcion.fecha == '' || $scope.recepcion.fecha == null || $scope.recepcion.fecha == undefined) {
          swal('Informacion', 'Debe Digitar La Fecha De La Correspondencia', 'info');
        }
        else if ($scope.recepcion.origen == '' || $scope.recepcion.origen == null || $scope.recepcion.origen == undefined) {
          swal('Informacion', 'Debe Seleccionar El Origen', 'info');
        }
        else if ($scope.recepcion.origen == '1' && $scope.recepcion.oficina == '') {
          swal('Informacion', 'Debe Seleccionar La Oficina', 'info');
        }
        else if ($scope.recepcion.origen == '1' && $scope.recepcion.area == '') {
          swal('Informacion', 'Debe Seleccionar El Area', 'info');
        }
        else if ($scope.recepcion.origen == '1' && $scope.recepcion.remitenteinterno == '') {
          swal('Informacion', 'Debe Seleccionar El Area', 'info');
        }
        else if ($scope.recepcion.origen == '2' && $scope.recepcion.tipotramite == '') {
          swal('Informacion', 'Debe Seleccionar El Tipo De Tramite', 'info');
        } else if ($scope.recepcion.origen == '2' && $scope.recepcion.tipotramite == 'PN' && $scope.recepcion.nombre == '') {
          swal('Informacion', 'Debe Digitar El Nombre Del Remitente', 'info');
        } else if ($scope.recepcion.origen == '2' && $scope.recepcion.tipotramite == 'PN' && $scope.recepcion.empresamensajeria == '') {
          swal('Informacion', 'Debe Seleccionar La Empresa De Mensajeria', 'info');
        } else if ($scope.recepcion.origen == '2' && $scope.recepcion.tipotramite == 'PN' && $scope.recepcion.numeroguia == '') {
          swal('Informacion', 'Debe Digitar El Numero De Guia', 'info');
        } else if ($scope.recepcion.origen == '2' && $scope.recepcion.tipotramite == 'E' && $scope.recepcion.entidad == '') {
          swal('Informacion', 'Debe Seleccionar La Entidad', 'info');
        }
        else if ($scope.recepcion.origen == '2' && $scope.recepcion.tipotramite == 'E' && $scope.recepcion.nombre == '') {
          swal('Informacion', 'Debe Digitar El Nombre Del Remitente', 'info');
        } else if ($scope.recepcion.origen == '2' && $scope.recepcion.tipotramite == 'E' && $scope.recepcion.empresamensajeria == '') {
          swal('Informacion', 'Debe Seleccionar La Empresa De Mensajeria', 'info');
        } else if ($scope.recepcion.origen == '2' && $scope.recepcion.tipotramite == 'E' && $scope.recepcion.numeroguia == '') {
          swal('Informacion', 'Debe Digitar El Numero De Guia', 'info');
        } else if ($scope.recepcion.tipocorrespondencia == '' || $scope.recepcion.tipocorrespondencia == null) {
          swal('Informacion', 'Debe Seleccionar El Tipo De Correspondencia', 'info');
        } else if ($scope.recepcion.categoria == '' || $scope.recepcion.categoria == null) {
          swal('Informacion', 'Debe Seleccionar La Categoria', 'info');
        } else if ($scope.recepcion.unidadmedida == '' || $scope.recepcion.unidadmedida == null) {
          swal('Informacion', 'Debe Seleccionar La Unidad De Medida', 'info');
        } else if ($scope.recepcion.cantidad == '' || $scope.recepcion.cantidad == null || $scope.recepcion.cantidad == undefined) {
          swal('Informacion', 'Debe Digitar La Cantidad', 'info');
        } else if ($scope.recepcion.asunto == '' || $scope.recepcion.asunto == null || $scope.recepcion.asunto == undefined) {
          swal('Informacion', 'Debe Digitar El Asunto', 'info')
        } else if ($scope.recepcion.observacion == '' || $scope.recepcion.observacion == null || $scope.recepcion.observacion == undefined) {
          swal('Informacion', 'Debe Digitar Una Observacion', 'info')
        }
        else if ($scope.recepcion.origendest == '1' && $scope.recepcion.oficinadest == '') {
          swal('Informacion', 'Debe Completar Los Campos Requeridos', 'info');
        }
        else if ($scope.recepcion.origendest == '1' && $scope.recepcion.areadest == '') {
          swal('Informacion', 'Debe Completar Los Campos Requeridos', 'info');
        }
        else if ($scope.recepcion.origendest == '1' && $scope.recepcion.remitenteinternodest == '') {
          swal('Informacion', 'Debe Completar Los Campos Requeridos', 'info');
        }
        else if ($scope.recepcion.origendest == '2' && $scope.recepcion.tipotramitedest == '') {
          swal('Informacion', 'Debe Seleccionar El Tipo De Tramite', 'info');
        } else if ($scope.recepcion.origendest == '2' && $scope.recepcion.tipotramitedest == 'PN' && $scope.recepcion.nombredest == '') {
          swal('Informacion', 'Debe Digitar El Nombre Del Destinatario', 'info');
        } else if ($scope.recepcion.origendest == '2' && $scope.recepcion.tipotramitedest == 'PN' && $scope.recepcion.empresamensajeriadest == '') {
          swal('Informacion', 'Debe Seleccionar La Empresa De Mensajeria', 'info');
        } else if ($scope.recepcion.origendest == '2' && $scope.recepcion.tipotramitedest == 'PN' && $scope.recepcion.numeroguiadest == '') {
          swal('Informacion', 'Debe Digitar El Numero De Guia', 'info');
        } else if ($scope.recepcion.origendest == '2' && $scope.recepcion.tipotramitedest == 'E' && $scope.recepcion.entidaddest == '') {
          swal('Informacion', 'Debe Seleccionar La Entidad', 'info');
        }
        else if ($scope.recepcion.origendest == '2' && $scope.recepcion.tipotramitedest == 'E' && $scope.recepcion.nombredest == '') {
          swal('Informacion', 'Debe Digitar El Nombre Del Destinatario', 'info');
        } else if ($scope.recepcion.origendest == '2' && $scope.recepcion.tipotramitedest == 'E' && $scope.recepcion.empresamensajeriadest == '') {
          swal('Informacion', 'Debe Seleccionar La Empresa De Mensajeria', 'info');
        } else if ($scope.recepcion.origendest == '2' && $scope.recepcion.tipotramitedest == 'E' && $scope.recepcion.numeroguiadest == '') {
          swal('Informacion', 'Debe Digitar El Numero De Guia', 'info');
        } else {
          swal({
            title: 'Confirmar',
            text: "Esta seguro que desea " + $scope.btnnombremodal.toLowerCase() + " la correspondencia?",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancelar'
          }).then((result) => {
            if (result) {
              var data = JSON.stringify($scope.recepcion);
              console.log(data);
              $http({
                method: 'POST',
                url: "app/model/php/procesos/funrecepcion.php",
                data: { function: 'uiCorrespondencia', data: data }
              }).then(function (response) {
                if (response.data.Codigo == '0') {
                  //$("#modaluirecepcion").modal('show');
                    $("#modaluirecepcion").modal('hide');
                  $scope.listarCorrespendiciaEntrada('destruir');
//                  $scope.listarUnidad('destruir');
                  swal('Completado', response.data.Mensaje, 'success')
                } else {
                  swal('Advertencia', response.data.Mensaje, 'warning')
                }
              })
            }
          })
        }
      }

      $scope.info=[];
      $scope.AbrirModalSubirDocumento=function(id,rad){
        $scope.CorrespondenciaId=id;
        $scope.radicado=rad;
        $("#modalsubirdocumento").modal('show');
      }


      // $scope.SubirDocumento=function(){
      //   var adjunto = $("#adjunto");
      //   $http({
      //     method: 'POST',
      //     url: "app/model/php/procesos/funrecepcion.php",
      //     data: { function: 'subirftp', data: $scope.Documento }
      //   }).then(function (response) {
      //     console.log(response);
      //   })
      // }

      $scope.SubirDocumento = function () {
        var adjunto = $("#adjunto");
        swal({
           title: 'Confirmar',
           text: "¿Confirma un nuevo adjunto",
           type: 'question',
           showCancelButton: true,
           confirmButtonColor: '#3085d6',
           cancelButtonColor: '#d33',
           confirmButtonText: 'Continuar',
           cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result) {
            swal({ title: 'Subiendo Soporte' }); swal.showLoading();
            var FR= new FileReader();
            FR.addEventListener("load", function(e) {
               $scope.adjuntoafiliado = e.target.result;
               var name = document.getElementById('adjunto').files[0].name;
               $scope.adjuntoafiliadoext= name.split('.').pop();  
               $http({
                method: 'POST',
                url: "app/model/php/procesos/funrecepcion.php",
                data: { function: 'subirftp', data:$scope.adjuntoafiliado, radicado:$scope.radicado }
               }).then(function(response){                 
                  if (response.data.length == '0') {
                    swal('Mensaje','Error subiendo adjunto','error')                    
                  }else{
                    swal.close();
                    $scope.url=response.data;
                    $("#modalsubirdocumento").modal('hide');                    
                    $http({
                      method: 'POST',
                      url: "app/model/php/procesos/funrecepcion.php",
                      data: { function: 'uiUrl', correspondencia:$scope.CorrespondenciaId, url:$scope.url}
                    }).then(function(response){ 
                      if(response.data.Codigo == '0'){
                        swal('Completado',response.data.Mensaje,'success');  
                      }else{
                        swal('Importante',response.data.Mensaje,'warning');
                      }
                    }); 
                  }
               });                                                                     
            });
            FR.readAsDataURL(adjunto[0].files[0] );
         }

        })
     }
  }])
