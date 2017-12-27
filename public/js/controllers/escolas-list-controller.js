'use strict';

angular.module('Home',)
.controller('EscolasListController',
    ['$scope', '$http', '$cookieStore', '$routeParams',
    function ($scope, $http, $cookieStore, $routeParams) {
        
        var serviceBase = 'services/';
        var globals = $cookieStore.get('globals');
        $http.defaults.headers.common['Authorization'] = globals['currentUser']['token'];
        
        
        // MENSAGEM DE ALERTA
        $scope.escolas = [];

    
        // LISTAGEM DE escolas
        $http.get(serviceBase + 'escolas')
        .success(function(escolas) {
            $scope.escolas = escolas;
        })
        .error(function(erro) {
            console.log(erro)
        });

       
    }]);