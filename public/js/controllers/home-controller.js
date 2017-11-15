'use strict';
 
angular.module('Home')
.controller('HomeController', [function ($scope) {
   
}])
.controller('DashboardController', ['$scope', '$rootScope', function ($scop, $rootScope) {
        document.querySelector('#wrapper').style.paddingLeft = '225px';
        $rootScope.showMenus = true;
}]);

angular.module('Home')
.controller('SidebarController', ['$scope', '$rootScope', function ($scope, $rootScope) {
        $scope.isCollapsed = false;
        $scope.isColl = true;
        $scope.isCad = true;

        $rootScope.showMenus = true;
}]);   

angular.module('Home').
controller('CollapseDemoCtrl', function ($scope) {
  $scope.isNavCollapsed = true;
  $scope.isCollapsed = false;
  $scope.isCollapsedHorizontal = false;
});
