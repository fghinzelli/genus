'use strict';

angular.module('Home',)
.controller('DiocesesListController',
    ['$scope', '$http', '$cookieStore', '$routeParams',
    function ($scope, $http, $cookieStore, $routeParams) {
        
        var serviceBase = '/genus/services/';
        var globals = $cookieStore.get('globals');
        $http.defaults.headers.common['Authorization'] = globals['currentUser']['token'];
        
        
        // MENSAGEM DE ALERTA
        $scope.dioceses = [];
        $scope.filtro = '';
        $scope.mensagem = '';
        $scope.showSuccessAlert = true;
        $scope.switchBool = function(value) {
            $scope[value] = !$scope[value];
        };

    
        // LISTAGEM DE DIOCESES
        $http.get(serviceBase + 'dioceses')
        .success(function(dioceses) {
            $scope.dioceses = dioceses;
        })
        .error(function(erro) {
            console.log(erro)
        });

        // DELETE
        $scope.remover = function(diocese) {
            $http.delete(serviceBase + 'dioceses/' + diocese.id)
            .success(function() {
                var indiceDaDiocese = $scope.dioceses.indexOf(dioceses);
                $scope.dioceses.splice(indiceDaDiocese, 1);
                $scope.mensagem = 'Registro removido com sucesso!';
    
            })
            .error(function(erro) {
                console.log(erro);
                $scope.mensagem = 'Não foi possível apagar o registro';
            });
        };
    }]);