;(function() {
  'use strict';

  angular.module('zf2orders')
    .controller('ItemsController', ['$scope', 'ItemsFactory', function ($scope, ItemsFactory) {
      ItemsFactory.fetchAll().success(function(data) {
      	$scope.items = data;
      });

  }]);

  angular.module('zf2orders')
    .controller('ItemsCreateController', function ($scope) {
      
      $scope.form = {};
  });

	angular.module('zf2orders')
    .controller('ItemsEditController', ['$scope', '$routeParams', 'ItemsFactory', 
      function ($scope, $routeParams, ItemsFactory) {
      
      $scope.form = {};

      ItemsFactory.fetch($routeParams.id).success(function(data) {
        $scope.form = data;
      });
  }]);
})();