'use strict';

angular.module('Home',)
.controller('ParoquiasListController',
    ['$scope', '$http', '$cookieStore', '$routeParams',
    function ($scope, $http, $cookieStore, $routeParams) {
        
        var serviceBase = 'services/';
        var globals = $cookieStore.get('globals');
        $http.defaults.headers.common['Authorization'] = globals['currentUser']['token'];
        
        
        // MENSAGEM DE ALERTA
        $scope.paroquias = [];
        $scope.filtro = '';
        $scope.mensagem = '';
        $scope.showSuccessAlert = true;
        $scope.switchBool = function(value) {
            $scope[value] = !$scope[value];
        };

    
        // LISTAGEM DE PAROQUIAS
        $http.get(serviceBase + 'paroquias')
        .success(function(paroquias) {
            $scope.paroquias = paroquias;
        })
        .error(function(erro) {
            console.log(erro)
        });

        // DELETE
        $scope.remover = function(paroquia) {
            $http.delete(serviceBase + 'paroquias/' + paroquia.id)
            .success(function() {
                var indiceDaParoquia = $scope.paroquias.indexOf(paroquia);
                $scope.paroquias.splice(indiceDaParoquia, 1);
                $scope.mensagem = 'Registro removido com sucesso!';
    
            })
            .error(function(erro) {
                console.log(erro);
                $scope.mensagem = 'Não foi possível apagar o registro';
            });
        };
    }]);