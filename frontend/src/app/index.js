;(function() {
  'use strict';

  angular.module('zf2orders', ['ngTouch', 'ngSanitize', 'ngResource', 'ngRoute', 'ui.bootstrap'])
    .config(function ($routeProvider) {
      $routeProvider
        .when('/', {
          templateUrl: 'app/main/main.html',
          controller: 'MainController'
        })
        .when('/items', {
          templateUrl: 'app/items/items.html',
          controller: 'ItemsController'
        })
        .when('/items/create', {
          templateUrl: 'app/items/items.create.html',
          controller: 'ItemsController'
        })
        .when('/customers', {
          templateUrl: 'app/customers/customers.html',
          controller: 'CustomersController'
        })
        .when('/customers/create', {
          templateUrl: 'app/customers/customers.create.html',
          controller: 'CustomersController'
        })
        .otherwise({
          redirectTo: '/'
        });
    })
  ;
})();