'use strict';

angular.module('Home',)
.controller('EtapasEscolaListController',
    ['$scope', '$http', '$cookieStore', '$routeParams',
    function ($scope, $http, $cookieStore, $routeParams) {
        
        var serviceBase = 'services/';
        var globals = $cookieStore.get('globals');
        $http.defaults.headers.common['Authorization'] = globals['currentUser']['token'];
        
        $scope.etapasEscola = [];

        // LISTAGEM DE ETAPAS
        $http.get(serviceBase + 'etapas-escola')
        .success(function(etapasEscola) {
            $scope.etapasEscola = etapasEscola;
        })
        .error(function(erro) {
            console.log(erro)
        });
    }]);