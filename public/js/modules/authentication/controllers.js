'use strict';
 
angular.module('Authentication')
 .controller('LoginController',
    ['$scope', '$rootScope', '$location', 'AuthenticationService',
    function ($scope, $rootScope, $location, AuthenticationService) {
        // reset login status
        AuthenticationService.ClearCredentials();
 
        // Oculta o menu
        $rootScope.showMenus = false;
        document.querySelector('#wrapper').classList.remove('main-content');
        document.querySelector('#wrapper').classList.add('main-content-login');

        $scope.login = function () {
            $scope.dataLoading = true;
            AuthenticationService.Login($scope.username, $scope.password, function(response) {
                if(!response.error) {
                    AuthenticationService.SetCredentials($scope.username, response.token);
                    $location.path('/');
                } else {
                    $scope.error = response.error['message'];
                    $scope.dataLoading = false;
                }
            });
        };
    }]);