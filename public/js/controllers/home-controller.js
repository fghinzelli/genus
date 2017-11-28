'use strict';
 
angular.module('Home')
.controller('HomeController', [function ($scope) {
   
}])
.controller('DashboardController', ['$scope', '$rootScope', function ($scop, $rootScope) {
        document.querySelector('#wrapper').classList.remove('main-content-login');
        document.querySelector('#wrapper').classList.add('main-content');
        $rootScope.showMenus = true;
}]);

angular.module('Home')
.controller('NavController', ['$scope', '$rootScope', function ($scope, $rootScope) {
        $scope.menuResponsivo = false;
        $scope.menuCatequese = true;
        $scope.menuTeologia = true;
        $scope.menuCadastros = false;
        $scope.menuUsuario = true;

        $rootScope.showMenus = true;
}]);   

