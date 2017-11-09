'use strict';
 
angular.module('Home',)
.controller('HomeController', [function ($scope) {
   
}])
.controller('DashboardController', ['$scope', '$rootScope', function ($scop, $rootScope) {
        document.querySelector('#wrapper').style.paddingLeft = '225px';
        $rootScope.showMenus = true;
}]);

angular.module('Genus')
.controller('SidebarController', ['$scope', '$rootScope', function ($scope, $rootScope) {
        $scope.isCollapsed = true;
        $scope.isColl = true;
        $scope.isCad = true;

        //$rootScope.showMenus = true;
}]);    

