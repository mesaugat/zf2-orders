;(function() {
  'use strict';

  angular.module('zf2orders')
    .factory('ItemsFactory', ['$http', 'CONSTANT',
    function ($scope, CONSTANT) {

    return {
      fetchItems: function(params) {
        if (params) {
          return $http.get(CONSTANT.ITEMS_URL, {
            params: params
          });
        } else {
          return $http.get(CONSTANT.ITEMS_URL);
        }
      }
    };
  }]);
})();