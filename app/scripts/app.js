'use strict';

/**
 * @ngdoc overview
 * @name helium
 * @description
 * # GenesisApp
 *
 * Main module of the application.
 */
angular
  .module('helium', [
      'ui.router'
    ])
  .factory('comunication', function() {
    return {
      message: 'vacio',
      getMessage: function() {
        return this.message;
      },
      setMessage: function(msg) {
        this.message = msg;
      }
    };
  })
  .config(function ($stateProvider, $urlRouterProvider,$locationProvider) {
    $locationProvider.html5Mode(false);
    $urlRouterProvider.otherwise('/');
    $stateProvider
    .state('helium', {
      url: "/",
      abstract: true,
      template: '<ui-view/>'
    })
    .state('helium.inicio', {
      url:'Inicio',
      template: '<div inicio></div>'
    })
    .state('helium.empresa', {
      url:'Empresa',
      template: '<div empresa></div>',
      data: {'helium':'Helium'}
    })
    .state('helium.sede', {
      url:'Sede',
      template: '<div sede></div>',
      data: {'helium':'Helium'}
    })
    .state('helium.oficina', {
      url:'Oficina',
      template: '<div oficina></div>',
      data: {'helium':'Helium'}
    })
    .state('helium.area', {
      url:'Area',
      template: '<div area></div>',
      data: {'helium':'Helium'}
    })
    .state('helium.cargo', {
      url:'Cargo',
      template: '<div cargo></div>',
      data: {'helium':'Helium'}
    })
    .state('helium.mensajeria', {
      url:'Mensajeria',
      template: '<div mensajeria></div>',
      data: {'helium':'Helium'}
    })
    .state('helium.unidadmedida', {
      url:'UnidadMedida',
      template: '<div unidadmedida></div>',
      data: {'helium':'Helium'}
    })
    .state('helium.terceros', {
      url:'Terceros',
      template: '<div terceros></div>',
      data: {'helium':'Helium'}
    })
    .state('helium.rol', {
      url:'Rol',
      template: '<div rol></div>',
      data: {'helium':'Helium'}
    })
    .state('helium.usuario', {
      url:'Usuario',
      template: '<div usuario></div>',
      data: {'helium':'Helium'}
    })
    .state('helium.categoria', {
      url:'Categorias',
      template: '<div categoria></div>',
      data: {'helium':'Helium'}
    })
    .state('helium.estadodocumento', {
      url:'EstadoDocumento',
      template: '<div estadodocumento></div>',
      data: {'helium':'Helium'}
    })
    .state('helium.origen', {
      url:'Origen',
      template: '<div origen></div>',
      data: {'helium':'Helium'}
    })
    .state('helium.tipodocumento', {
      url:'TipoDocumentos',
      template: '<div tipodocumento></div>',
      data: {'helium':'Helium'}
    })
    .state('helium.origendocumentos', {
      url:'OrigenDocumentos',
      template: '<div origendocumentos></div>',
      data: {'helium':'Helium'}
    })
    .state('helium.motivo', {
      url:'Motivo',
      template: '<div motivo></div>',
      data: {'helium':'Helium'}
    })
    .state('helium.submotivo', {
      url:'Submotivo',
      template: '<div submotivo></div>',
      data: {'helium':'Helium'}
    })
    .state('helium.recepcion', {
      url:'Recepcion',
      template: '<div recepcion></div>',
      data: {'helium':'Helium'}
    })
    .state('helium.cargue', {
      url:'Cargue',
      template: '<div cargue></div>',
      data: {'helium':'Helium'}
    })
    .state('helium.entrega', {
      url:'Entrega',
      template: '<div entrega></div>',
      data: {'helium':'Helium'}
    })
    .state('helium.retencion', {
      url:'Retencion',
      template: '<div retencion></div>',
      data: {'helium':'Helium'}
    })
    .state('helium.dashboard', {
      url:'Dashboard',
      template: '<div dashboard></div>',
      data: {'helium':'Helium'}
    })
    .state('helium.tiempo', {
      url:'Tiempo',
      template: '<div tiempo></div>',
      data: {'helium':'Helium'}
    })
    .state('helium.bi', {
      url:'Bi',
      template: '<div bi></div>',
      data: {'helium':'Helium'}
    })

  });
