'use strict';
 
angular.module('Home',)
.controller('HomeController', [function ($scope) {
   
}]);

angular.module('Genus')
.controller('SidebarController', ['$scope', function ($scope) {
        $scope.isCollapsed = true;
        $scope.isColl = true;
        $scope.isCad = true;
}]);

