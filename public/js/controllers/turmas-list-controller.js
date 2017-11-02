'use strict';

angular.module('Home',)
.controller('TurmasListController',
    ['$scope', '$http', '$cookieStore', '$routeParams',
    function ($scope, $http, $cookieStore, $routeParams) {
        
        var serviceBase = '/genus/services/';
        var globals = $cookieStore.get('globals');
        $http.defaults.headers.common['Authorization'] = globals['currentUser']['token'];
        
        
        // MENSAGEM DE ALERTA
        $scope.turmas = [];
        $scope.filtro = '';
        $scope.mensagem = '';
        $scope.showSuccessAlert = true;
        $scope.switchBool = function(value) {
            $scope[value] = !$scope[value];
        };

    
        // LISTAGEM DE TURMAS
        $http.get(serviceBase + 'turmas')
        .success(function(turmas) {
            $scope.turmas = turmas;
        })
        .error(function(erro) {
            console.log(erro)
        });

        // DELETE
        $scope.remover = function(pessoa) {
            $http.delete(serviceBase + 'turmas/' + turma.id)
            .success(function() {
                var indiceDoTurma = $scope.turmas.indexOf(turma);
                $scope.turmas.splice(indiceDoTurma, 1);
                $scope.mensagem = 'Registro removido com sucesso!';
    
            })
            .error(function(erro) {
                console.log(erro);
                $scope.mensagem = 'Não foi possível apagar o registro';
            });
        };
    }]);