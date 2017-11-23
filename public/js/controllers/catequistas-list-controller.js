'use strict';

angular.module('Home',)
.controller('CatequistasListController',
    ['$scope', '$http', '$cookieStore', '$routeParams',
    function ($scope, $http, $cookieStore, $routeParams) {
        
        var serviceBase = 'services/';
        var globals = $cookieStore.get('globals');
        $http.defaults.headers.common['Authorization'] = globals['currentUser']['token'];
        
        
        // MENSAGEM DE ALERTA
        $scope.catequistas = [];
        $scope.filtro = '';
        $scope.mensagem = '';
        $scope.showSuccessAlert = true;
        $scope.switchBool = function(value) {
            $scope[value] = !$scope[value];
        };

    
        // LISTAGEM DE CATEQUISTAS
        $http.get(serviceBase + 'catequistas')
        .success(function(catequistas) {
            $scope.catequistas = catequistas;
        })
        .error(function(erro) {
            console.log(erro)
        });

        // DELETE
        $scope.remover = function(catequista) {
            $http.delete(serviceBase + 'catequistas/' + catequista.id)
            .success(function() {
                var indiceDoCatequista = $scope.catequistas.indexOf(catequista);
                $scope.catequistas.splice(indiceDoCatequista, 1);
                $scope.mensagem = 'Registro removido com sucesso!';
    
            })
            .error(function(erro) {
                console.log(erro);
                $scope.mensagem = 'Não foi possível apagar o registro';
            });
        };
    }]);