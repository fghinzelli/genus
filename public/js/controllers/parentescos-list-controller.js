'use strict';

angular.module('Home',)
.controller('ParentescoListController',
    ['$scope', '$http', '$cookieStore', '$routeParams',
    function ($scope, $http, $cookieStore, $routeParams) {
        
        var serviceBase = 'services/';
        var globals = $cookieStore.get('globals');
        $http.defaults.headers.common['Authorization'] = globals['currentUser']['token'];
        
        $scope.parentescos = [];

    
        // LISTAGEM DE parentescos
        $http.get(serviceBase + 'parentescos')
        .success(function(parentescos) {
            $scope.parentescos = parentescos;
        })
        .error(function(erro) {
            console.log(erro)
        });

       
    }]);