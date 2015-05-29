;(function() {
  'use strict';

  angular.module('zf2orders')
    .factory('ItemsFactory', ['$http', 'CONSTANT',
    function ($http, CONSTANT) {

    return {
      fetchAll: function(params) {
        if (params) {
          return $http.get(CONSTANT.ITEMS_URL, {
            params: params
          });
        } else {
          return $http.get(CONSTANT.ITEMS_URL);
        }
      },

      fetch: function(id) {
        return $http.get(CONSTANT.ITEMS_URL + '/' + id);
      }
    };
  }]);
})();