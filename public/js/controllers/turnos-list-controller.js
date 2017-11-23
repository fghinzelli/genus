'use strict';

angular.module('Home',)
.controller('TurnosListController',
    ['$scope', '$http', '$cookieStore', '$routeParams',
    function ($scope, $http, $cookieStore, $routeParams) {
        
        var serviceBase = 'services/';
        var globals = $cookieStore.get('globals');
        $http.defaults.headers.common['Authorization'] = globals['currentUser']['token'];
        
        
        // MENSAGEM DE ALERTA
        $scope.turnos = [];
        $scope.filtro = '';
        $scope.mensagem = '';
        $scope.showSuccessAlert = true;
        $scope.switchBool = function(value) {
            $scope[value] = !$scope[value];
        };

    
        // LISTAGEM DE TURNOS
        $http.get(serviceBase + 'turnos')
        .success(function(turnos) {
            $scope.turnos = turnos;
        })
        .error(function(erro) {
            console.log(erro)
        });
    }]);