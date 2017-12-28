'use strict';

angular.module('Home',)
.controller('SituacoesInscricaoListController',
    ['$scope', '$http', '$cookieStore', '$routeParams',
    function ($scope, $http, $cookieStore, $routeParams) {
        
        var serviceBase = 'services/';
        var globals = $cookieStore.get('globals');
        $http.defaults.headers.common['Authorization'] = globals['currentUser']['token'];
        
        $scope.situacoesInscricao = [];

        // LISTAGEM DE ETAPAS
        $http.get(serviceBase + 'situacoes-inscricao')
        .success(function(situacoesInscricao) {
            $scope.situacoesInscricao = situacoesInscricao;
        })
        .error(function(erro) {
            console.log(erro)
        });
    }]);