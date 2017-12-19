'use strict';

angular.module('Home',)
.controller('AnosLetivosCatequeseListController',
    ['$scope', '$http', '$cookieStore', '$routeParams',
    function ($scope, $http, $cookieStore, $routeParams) {
        
        var serviceBase = 'services/';
        var globals = $cookieStore.get('globals');
        $http.defaults.headers.common['Authorization'] = globals['currentUser']['token'];
        
        
        // MENSAGEM DE ALERTA
        $scope.anosLetivos = [];
        $scope.filtro = '';
        $scope.mensagem = '';
        $scope.showSuccessAlert = true;
        $scope.switchBool = function(value) {
            $scope[value] = !$scope[value];
        };

    
        // LISTAGEM DE ANOS LETIVOS
        $http.get(serviceBase + 'anos-letivos-catequese')
        .success(function(anosLetivos) {
            $scope.anosLetivos = anosLetivos;
        })
        .error(function(erro) {
            console.log(erro)
        });
    }]);