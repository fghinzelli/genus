'use strict';

angular.module('Home',)
.controller('CatequizandosListController',
    ['$scope', '$http', '$cookieStore', '$routeParams',
    function ($scope, $http, $cookieStore, $routeParams) {
        
        var serviceBase = 'services/';
        var globals = $cookieStore.get('globals');
        $http.defaults.headers.common['Authorization'] = globals['currentUser']['token'];
        
        
        // MENSAGEM DE ALERTA
        $scope.catequizandos = [];
        $scope.filtro = '';
        $scope.mensagem = '';
        $scope.showSuccessAlert = true;
        $scope.switchBool = function(value) {
            $scope[value] = !$scope[value];
        };

    
        // LISTAGEM DE CATEQUIZANDOS
        $http.get(serviceBase + 'catequizandos')
        .success(function(catequizandos) {
            $scope.catequizandos = catequizandos;
        })
        .error(function(erro) {
            console.log(erro)
        });

        // DELETE
        $scope.remover = function(catequisando) {
            $http.delete(serviceBase + 'catequizandos/' + catequizando.id)
            .success(function() {
                var indiceDoCatequizando = $scope.catequizandos.indexOf(catequizando);
                $scope.catequizandos.splice(indiceDoCatequizando, 1);
                $scope.mensagem = 'Registro removido com sucesso!';
    
            })
            .error(function(erro) {
                console.log(erro);
                $scope.mensagem = 'Não foi possível apagar o registro';
            });
        };
    }]);