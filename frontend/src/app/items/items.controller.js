;(function() {
  'use strict';

  angular.module('zf2orders')
    .controller('ItemsController', ['$scope', '$location', 'ItemsFactory',
      function ($scope, $location, ItemsFactory) {
      
      ItemsFactory.fetchAll().success(function(data) {
      	$scope.items = data;
      });

      $scope.remove = function(index) {
        if (confirm("Are you sure you want to delete?")) {
          var id = $scope.items.data[index].id;

          ItemsFactory.remove(id)
            .success(function(data) {
              ItemsFactory.fetchAll().success(function(data) {
                $scope.items = data;
              });
            })
            .error(function(data) {
              alert("Oooops! Some error occured.");
            });
        }
      }

  }]);

  angular.module('zf2orders')
    .controller('ItemsCreateController', ['$scope', '$routeParams', '$location', 'ItemsFactory', 
      function ($scope, $routeParams, $location, ItemsFactory) {
      
      $scope.form = {};

      $scope.save = function() {
        ItemsFactory.create($scope.form)
          .success(function(data) {
            $location.path('#/items');
          })
          .error(function(data) {
            alert("Oooops! Some error occured.");
          });
      };
  }]);

	angular.module('zf2orders')
    .controller('ItemsEditController', ['$scope', '$routeParams', '$location', 'ItemsFactory', 
      function ($scope, $routeParams, $location, ItemsFactory) {
      
      $scope.form = {};

      ItemsFactory.fetch($routeParams.id).success(function(data) {
        $scope.form = data;
      });

      $scope.save = function() {
        ItemsFactory.update($scope.form)
          .success(function(data) {
            $location.path('#/items');
          })
          .error(function(data) {
            alert("Oooops! Some error occured.");
          });
      };
  }]);
})();