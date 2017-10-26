'use strict';
 
angular.module('Authentication')
 
.controller('LoginController',
    ['$scope', '$rootScope', '$location', 'AuthenticationService',
    function ($scope, $rootScope, $location, AuthenticationService) {
        // reset login status
        AuthenticationService.ClearCredentials();
 
        $scope.login = function () {
            $scope.dataLoading = true;
            AuthenticationService.Login($scope.username, $scope.password, function(response) {
                if(!response.error) {
                    AuthenticationService.SetCredentials($scope.username, response.token);
                    $location.path('/');
                } else {
                    $scope.error = response.error;
                    $scope.dataLoading = false;
                }
            });
        };
    }]);