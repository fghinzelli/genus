'use strict';
 
angular.module('Home')
.controller('HomeController', [function ($scope) {
   
}])
.controller('SidebarController', ['$scope', function ($scope) {
    $scope.isCollapsed = false;
    $scope.isColl = false;
    $scope.isCad = false;
    console.log('xxxx');
}]);

