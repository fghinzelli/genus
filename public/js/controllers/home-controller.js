'use strict';
 
angular.module('Home',)
.controller('HomeController', [function ($scope) {
   
}]);

angular.module('Genus')
.controller('SidebarController', ['$scope', '$rootScope', function ($scope, $rootScope) {
    if (!$rootScope.menu) {
        console.log('menu = false');
        $rootScope.isCollapsed = true;
        $rootScope.isColl = true;
        $rootScope.isCad = true;
        $rootScope.menu = true;
    } else {
        console.log('menu = true');
        $rootScope.isCollapsed = $scope.isCollapsed;
        $rootScope.isColl = $scope.isColl;
        $rootScope.isCad = $scope.isCad;
    }
    
}]);

