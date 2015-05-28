;(function() {
  'use strict';

  angular.module('zf2orders')
    .constant('CONSTANT', (function() {
    
    var baseUrl = window.location.href.split('#')[0];
    var apiUrl = baseUrl + "api/v1/";

    return {
      'BASE_URL': baseUrl,
      'API_URL': baseUrl + "api/v1",
      'ITEMS_URL': apiUrl + "items",
      'CUSTOMERS_URL': apiUrl + "customers"
    };
  })());
})();