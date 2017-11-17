'use strict';
 
angular.module('Home')
.controller('HomeController', [function ($scope) {
   
}])
.controller('DashboardController', ['$scope', '$rootScope', function ($scop, $rootScope) {
        //document.querySelector('#wrapper').style.paddingLeft = '225px';
        document.querySelector('#wrapper').classList.add('main-content');
        $rootScope.showMenus = true;
}]);

angular.module('Home')
.controller('NavController', ['$scope', '$rootScope', function ($scope, $rootScope) {
        $scope.menuResponsivo = false;
        $scope.menuCatequese = false;
        $scope.menuTeologia = true;
        $scope.menuCadastros = true;
        $scope.menuUsuario = true;

        $rootScope.showMenus = true;
}]);   

